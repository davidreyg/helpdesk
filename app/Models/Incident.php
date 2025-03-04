<?php

namespace App\Models;

use App\States\Incident\IncidentState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\ModelStates\HasStates;

class Incident extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\IncidentFactory> */
    use HasFactory;
    use HasStates, InteractsWithMedia;

    protected $fillable = ['code', 'attention_type', 'company_id', 'priority', 'description', 'status'];

    protected function casts(): array
    {
        return [
            'status' => IncidentState::class,
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
