<?php

namespace App\Actions;

use App\Enums\ReportTypeEnum;
use App\Settings\AppearanceSettings;
use Gotenberg\Exceptions\GotenbergApiErrored;
use Gotenberg\Gotenberg;
use Gotenberg\Modules\ChromiumPdf;
use Gotenberg\Stream;
use Lorisleiva\Actions\Concerns\AsAction;

class PdfGenerator
{
    use AsAction;

    private ?string $header = null;

    private string $filename;

    private string $marginTop;

    private string $marginBottom;

    private string $marginLeft;

    private string $marginRight;

    private ChromiumPdf $gotenberg;

    public function __construct()
    {
        $this->gotenberg = Gotenberg::chromium('http://gotenberg:3000')
            ->pdf();
    }

    public function landscape(): PdfGenerator
    {
        $this->gotenberg->landscape();

        return $this;
    }

    public function handle(ReportTypeEnum $tipoReporte, object $data)
    {
        $FILENAME = $this->getFilename() . '_' . now()->format('d_m_Y') . '.pdf';
        $html = view(
            'components.layouts.pdf',
            [
                'current' => $tipoReporte->value,
                'datos' => $data,
                'filename' => $FILENAME,
                'watermarkImageBase64' => $this->logo(),
                'fontFamily' => app(AppearanceSettings::class)->font->name,
            ]
        )->render();
        $request = $this->gotenberg
            ->header(Stream::string('header.html', $this->getHeader()))
            ->footer(Stream::string('footer.html', $this->footer()))
            ->paperSize(8.27, 11.7)
            // ->landscape()
            ->margins($this->getMarginTop(), $this->getMarginBottom(), $this->getMarginLeft(), $this->getMarginRight())
            ->printBackground()
            ->preferCssPageSize()
            ->assets(Stream::path(public_path(vite('resources/css/filament/admin/theme.css', hotServer: false, relative: true)), 'pdf.css'))
            ->html(Stream::string('pdf.html', $html));

        try {
            $response = Gotenberg::send($request);

            return response(
                $response->getBody()->getContents(),
                200,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => "inline; filename={$FILENAME}",
                ]
            );

        } catch (GotenbergApiErrored $gotenbergApiErrored) {
            $gotenbergApiErrored->getResponse();
            echo $gotenbergApiErrored->getTraceAsString();

            throw new \Exception($gotenbergApiErrored->getMessage(), $gotenbergApiErrored->getCode(), $gotenbergApiErrored);
        }
    }

    public function header(string $view): static
    {
        // FIXME: Quitamos esto por la reestructuracion
        // $establecimiento = auth()->user()->load('establecimiento')->establecimiento->nombre;
        $this->header = view($view, ['logoBase64' => $this->logo()])->render();

        return $this;
    }

    public function filename(string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function marginTop(string $marginTop): static
    {
        $this->marginTop = $marginTop;

        return $this;
    }

    public function marginBottom(string $marginBottom): static
    {
        $this->marginBottom = $marginBottom;

        return $this;
    }

    public function marginLeft(string $marginLeft): static
    {
        $this->marginLeft = $marginLeft;

        return $this;
    }

    public function marginRight(string $marginRight): static
    {
        $this->marginRight = $marginRight;

        return $this;
    }

    public function getHeader(): ?string
    {
        // Verifica si el header ya está inicializado, si no, lo inicializa.
        if ($this->header === null || $this->header === '' || $this->header === '0') {
            $this->header('components.pdf.header');
        }

        return $this->header;
    }

    public function getFilename(): string
    {
        // Verifica si el header ya está inicializado, si no, lo inicializa.
        if (! isset($this->filename) || ($this->filename === '' || $this->filename === '0')) {
            $this->filename = 'DocumentoPdf';
        }

        return $this->filename;
    }

    public function getMarginTop(): string
    {
        // Verifica si el header ya está inicializado, si no, lo inicializa.
        if (! isset($this->marginTop) || ($this->marginTop === '' || $this->marginTop === '0')) {
            $this->marginTop = '90px';
        }

        return $this->marginTop;
    }

    public function getMarginBottom(): string
    {
        // Verifica si el header ya está inicializado, si no, lo inicializa.
        if (! isset($this->marginBottom) || ($this->marginBottom === '' || $this->marginBottom === '0')) {
            $this->marginBottom = '50px';
        }

        return $this->marginBottom;
    }

    public function getMarginLeft(): string
    {
        // Verifica si el header ya está inicializado, si no, lo inicializa.
        if (! isset($this->marginLeft) || ($this->marginLeft === '' || $this->marginLeft === '0')) {
            $this->marginLeft = '30px';
        }

        return $this->marginLeft;
    }

    public function getMarginRight(): string
    {
        // Verifica si el header ya está inicializado, si no, lo inicializa.
        if (! isset($this->marginRight) || ($this->marginRight === '' || $this->marginRight === '0')) {
            $this->marginRight = '30px';
        }

        return $this->marginRight;
    }

    private function logo(): string
    {
        $logoPath = public_path('images/logo.jpg'); // Ruta a la imagen en el sistema de archivos
        $logoData = base64_encode(file_get_contents($logoPath));

        return "data:image/jpg;base64,{$logoData}";
    }

    private function footer()
    {
        return view('components.pdf.footer')->render();
    }
}
