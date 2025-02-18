<?php

namespace App\Actions;

use App\Enums\ReportTypeEnum;
use App\Enums\Setting\ReportType;
use Gotenberg\Exceptions\GotenbergApiErrored;
use Gotenberg\Gotenberg;
use Gotenberg\Modules\ChromiumPdf;
use Gotenberg\Stream;
use Lorisleiva\Actions\Concerns\AsAction;

class PdfGenerator
{
    use AsAction;
    private string $logo;
    private float $width;
    private float $height;
    private ?string $header;
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
        $html = view('components.layouts.pdf', ['current' => $tipoReporte->value, 'datos' => $data, 'filename' => $FILENAME])->render();
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
                    'Content-Disposition' => "inline; filename=$FILENAME",
                ]
            );

        } catch (GotenbergApiErrored $e) {
            $e->getResponse();
            echo $e->getTraceAsString();
            throw new \Exception($e->getMessage());
        }
    }

    public function header(string $view)
    {
        //FIXME: Quitamos esto por la reestructuracion
        // $establecimiento = auth()->user()->load('establecimiento')->establecimiento->nombre;
        $this->header = view(isset($view) ? $view : 'components.pdf.header', ['logoBase64' => $this->logo()])->render();
        return $this;
    }

    public function filename(string $filename)
    {
        $this->filename = $filename;
        return $this;
    }
    public function marginTop(string $marginTop)
    {
        $this->marginTop = $marginTop;
        return $this;
    }
    public function marginBottom(string $marginBottom)
    {
        $this->marginBottom = $marginBottom;
        return $this;
    }
    public function marginLeft(string $marginLeft)
    {
        $this->marginLeft = $marginLeft;
        return $this;
    }
    public function marginRight(string $marginRight)
    {
        $this->marginRight = $marginRight;
        return $this;
    }

    public function getHeader()
    {
        // Verifica si el header ya está inicializado, si no, lo inicializa.
        if (empty($this->header)) {
            $this->header('components.pdf.header');
        }
        return $this->header;
    }

    public function getFilename()
    {
        // Verifica si el header ya está inicializado, si no, lo inicializa.
        if (empty($this->filename)) {
            $this->filename = 'DocumentoPdf';
        }
        return $this->filename;
    }

    public function getMarginTop()
    {
        // Verifica si el header ya está inicializado, si no, lo inicializa.
        if (empty($this->marginTop)) {
            $this->marginTop = '90px';
        }
        return $this->marginTop;
    }
    public function getMarginBottom()
    {
        // Verifica si el header ya está inicializado, si no, lo inicializa.
        if (empty($this->marginBottom)) {
            $this->marginBottom = '50px';
        }
        return $this->marginBottom;
    }
    public function getMarginLeft()
    {
        // Verifica si el header ya está inicializado, si no, lo inicializa.
        if (empty($this->marginLeft)) {
            $this->marginLeft = '30px';
        }
        return $this->marginLeft;
    }
    public function getMarginRight()
    {
        // Verifica si el header ya está inicializado, si no, lo inicializa.
        if (empty($this->marginRight)) {
            $this->marginRight = '30px';
        }
        return $this->marginRight;
    }


    private function logo(): string
    {
        $logoPath = public_path('images/logo.jpg'); // Ruta a la imagen en el sistema de archivos
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoBase64 = "data:image/jpg;base64,$logoData";
        return $logoBase64;
    }

    private function footer()
    {
        return view('components.pdf.footer')->render();
    }
}
