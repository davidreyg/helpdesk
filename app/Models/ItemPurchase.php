<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Utilities\CurrencyConverter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property Purchase $purchase
 * @property int $total
 */
class ItemPurchase extends Pivot
{
    protected $fillable = [
        'quantity',
        'description',
        'price',
        'product',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn (): int => $this->quantity * CurrencyConverter::prepareForAccessor("{$this->price}", $this->purchase->currency->value)
        );
    }

    protected function casts(): array
    {
        return [
            'price' => MoneyCast::class,
        ];
    }
}
