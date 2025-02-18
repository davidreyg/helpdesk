<?php

namespace App\Models;

use App\Enums\CurrencyEnum;
use App\Enums\PaymentTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = [
        'code',
        'currency',
        'notes',
        'payment_type',
        'customer_id',
    ];

    protected function casts(): array
    {
        return [
            'currency' => CurrencyEnum::class,
            'payment_type' => PaymentTypeEnum::class,
        ];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class);
    }
}
