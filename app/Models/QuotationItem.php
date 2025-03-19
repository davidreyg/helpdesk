<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Utilities\CurrencyConverter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Pivot;

class QuotationItem extends Pivot
{
    protected $fillable = [
        'quantity',
        'description',
        'unit',
        'price',
        'product',
        'brand',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->quantity * CurrencyConverter::prepareForAccessor($this->price, $this->quotation->currency->value)
        );
    }


    protected function casts(): array
    {
        return [
            'price' => MoneyCast::class,
        ];
    }
}
