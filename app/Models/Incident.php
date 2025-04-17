<?php

namespace App\Models;

use App\States\Incident\IncidentState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\ModelStates\HasStates;

/**
 * @property IncidentState $status
 * @property int $code
 */
class Incident extends Model implements HasMedia
{
    use HasStates;
    use InteractsWithMedia;

    protected $fillable = [
        'code',
        'attention_type',
        'attention_date',
        'company_id',
        'priority',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => IncidentState::class,
            'attention_date' => 'date',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
