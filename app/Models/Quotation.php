<?php

namespace App\Models;

use App\Enums\CurrencyEnum;
use App\Enums\PaymentTypeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

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
    ];

    public static function generateNextNumber(): int
    {
        return (static::max('number') ?? 0) + 1;
    }

    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn() => 'COT-' . str_pad($this->number, 7, '0', STR_PAD_LEFT)
        );
    }

    protected function subTotal(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->quotationItems->sum(fn($item) => $item->total),
        );
    }

    protected function igv(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->subTotal * 0.18
        );
    }

    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->subTotal + $this->igv
        );
    }

    protected function casts(): array
    {
        return [
            'currency' => CurrencyEnum::class,
            'payment_type' => PaymentTypeEnum::class,
            'extra_conditions' => 'array',
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

        static::creating(function ($quotation) {
            $quotation->number = static::generateNextNumber();
        });
    }
}
