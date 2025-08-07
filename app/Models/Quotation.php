<?php

namespace App\Models;

use App\Enums\CurrencyEnum;
use App\Enums\DiscountTypeEnum;
use App\Enums\PaymentTypeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property CurrencyEnum $currency
 * @property string $code
 * @property \Illuminate\Database\Eloquent\Collection<int,QuotationItem> $quotationItems
 * @property int $subTotal
 * @property float $igv
 * @property float $total
 */
class Quotation extends Model
{
    protected $fillable = [
        'requester_name',
        'number',
        'currency',
        'notes',
        'payment_type',
        'project',
        'extra_conditions',
        'company_id',
        'has_discount',
        'discount_type',
        'discount_amount',
        'discount_value',
    ];

    public static function generateNextNumber(): int
    {
        return (static::query()->max('number') ?? 0) + 1;
    }

    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn (): string => 'COT-' . str_pad($this->number . '', 7, '0', STR_PAD_LEFT)
        );
    }

    protected function subTotal(): Attribute
    {
        return Attribute::make(
            get: fn (): int => $this->quotationItems->sum(fn ($item) => $item->total),
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
            'payment_type' => PaymentTypeEnum::class,
            'extra_conditions' => 'array',
            'has_discount' => 'boolean',
            'discount_type' => DiscountTypeEnum::class,
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($quotation): void {
            $quotation->number = static::generateNextNumber();
        });
    }
}
