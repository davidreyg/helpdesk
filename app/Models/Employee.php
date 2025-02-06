<?php

namespace App\Models;

use App\Enums\DocumentTypeEnum;
use App\Enums\GenderEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'phone' => 'integer',
            'birth_date' => 'date',
            'document_type' => DocumentTypeEnum::class,
            'gender' => GenderEnum::class,
        ];
    }
}
