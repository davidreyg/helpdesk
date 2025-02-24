<?php

namespace App\Models;

use App\States\Incident\IncidentState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates;

class Incident extends Model
{
    /** @use HasFactory<\Database\Factories\IncidentFactory> */
    use HasFactory;
    use HasStates;

    protected $fillable = ['code', 'attention_type', 'incident_type', 'priority', 'description', 'status'];

    protected function casts(): array
    {
        return [
            'status' => IncidentState::class,
        ];
    }
}
