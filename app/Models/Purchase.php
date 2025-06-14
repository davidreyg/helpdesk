<?php

namespace App\Models;

use App\Enums\CurrencyEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property CurrencyEnum $currency
 * @property string $code
 * @property \Illuminate\Database\Eloquent\Collection<int,ItemPurchase> $itemPurchases
 * @property int $subTotal
 * @property float $igv
 * @property float $total
 */
class Purchase extends Model
{
    protected $fillable = [
        'supplier_name',
        'issue',
        'reference',
        'attention',
        'number',
        'currency',
        'company_id',
    ];

    public static function generateNextNumber(): int
    {
        return (static::query()->max('number') ?? 0) + 1;
    }

    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn (): string => 'COM-' . str_pad($this->number . '', 7, '0', STR_PAD_LEFT)
        );
    }

    protected function subTotal(): Attribute
    {
        return Attribute::make(
            get: fn (): int => $this->itemPurchases->sum(fn ($item) => $item->total),
        );
    }

    protected function igv(): Attribute
    {
        return Attribute::make(
            get: fn (): float => $this->subTotal * 0.18
        );
    }

    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn (): float => $this->subTotal + $this->igv
        );
    }

    protected function casts(): array
    {
        return [
            'currency' => CurrencyEnum::class,
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function itemPurchases()
    {
        return $this->hasMany(ItemPurchase::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($purchase): void {
            $purchase->number = static::generateNextNumber();
        });
    }
}
