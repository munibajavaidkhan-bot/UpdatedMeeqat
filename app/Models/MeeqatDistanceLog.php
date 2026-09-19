<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeeqatDistanceLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'session_id',
        'user_latitude',
        'user_longitude',
        'user_country',
        'user_city',
        'nearest_meeqat_id',
        'nearest_distance_km',
        'all_distances',
        'detection_method',
        'ip_address',
    ];

    protected $casts = [
        'user_latitude'       => 'float',
        'user_longitude'      => 'float',
        'nearest_distance_km' => 'float',
        'all_distances'       => 'array',
        'created_at'          => 'datetime',
    ];

    // =========================================
    // RELATIONSHIPS
    // =========================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function nearestMeeqat(): BelongsTo
    {
        return $this->belongsTo(MeeqatLocation::class, 'nearest_meeqat_id');
    }

    // =========================================
    // ACCESSORS
    // =========================================

    public function getDistanceFormattedAttribute(): string
    {
        if ($this->nearest_distance_km >= 1000) {
            return number_format($this->nearest_distance_km / 1000, 1) . ' thousand km';
        }
        return number_format($this->nearest_distance_km, 1) . ' km';
    }
}