<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChaddarCalculation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'session_id',
        'height_cm',
        'style',
        'calculated_meters',
        'size_label',
        'notes',
        'ip_address',
    ];

    protected $casts = [
        'height_cm'         => 'float',
        'calculated_meters' => 'float',
        'created_at'        => 'datetime',
    ];

    // =========================================
    // RELATIONSHIPS
    // =========================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // =========================================
    // ACCESSORS
    // =========================================

    public function getStyleLabelAttribute(): string
    {
        return $this->style === 'full' ? 'Full Body' : 'Shoulder Style';
    }

    public function getHeightFeetAttribute(): string
    {
        $totalInches = $this->height_cm / 2.54;
        $feet   = floor($totalInches / 12);
        $inches = round(fmod($totalInches, 12));
        return "{$feet}'{$inches}\"";
    }
}