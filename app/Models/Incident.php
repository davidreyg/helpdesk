<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    /** @use HasFactory<\Database\Factories\IncidentFactory> */
    use HasFactory;

    protected $fillable = ['code', 'attention_type', 'incident_type', 'priority', 'description'];
}
