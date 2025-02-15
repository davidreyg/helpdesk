<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Relations\Pivot;

class QuotationItem extends Pivot
{
    protected $fillable = [
        'quantity',
        'description',
        'unit',
        'price',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    protected function casts(): array
    {
        return [
            'price' => MoneyCast::class,
        ];
    }
}
