<?php

namespace App\Models;

use App\Enums\DocumentTypeEnum;
use App\Enums\GenderEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $fullName
 */
class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    protected $fillable = [
        'names',
        'paternal_surname',
        'maternal_surname',
        'email',
        'phone',
        'birth_date',
        'document_type',
        'document_number',
        'gender',
        'address',
        'company_id',
    ];

    protected function casts(): array
    {
        return [
            'phone' => 'integer',
            'birth_date' => 'date',
            'document_type' => DocumentTypeEnum::class,
            'gender' => GenderEnum::class,
        ];
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (): string => "$this->names $this->paternal_surname $this->maternal_surname"
        );
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
