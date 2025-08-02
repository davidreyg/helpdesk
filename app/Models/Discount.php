<?php

namespace App\Models;

use App\Enums\DiscountTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'amount', 'value', 'description', 'quotation_id'];

    protected function casts(): array
    {
        return [
            'type' => DiscountTypeEnum::class,
        ];
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
