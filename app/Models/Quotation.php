<?php

namespace App\Models;

use App\Enums\CurrencyEnum;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = [
        'code',
        'currency',
        'notes',
        'customer_id',
    ];

    protected function casts(): array
    {
        return [
            'currency' => CurrencyEnum::class,
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
