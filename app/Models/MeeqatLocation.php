<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MeeqatLocation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name_en',
        'name_ar',
        'name_ur',
        'description',
        'description_ur',
        'latitude',
        'longitude',
        'for_pilgrims_from',
        'color',
        'icon',
        'image',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function distanceLogs(): HasMany
    {
        return $this->hasMany(MeeqatDistanceLog::class, 'nearest_meeqat_id');
    }

    public function getCoordinatesAttribute(): array
    {
        return ['lat' => $this->latitude, 'lng' => $this->longitude];
    }

    public function getGoogleMapsUrlAttribute(): string
    {
        return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
    }

    public function getAppleMapsUrlAttribute(): string
    {
        return "https://maps.apple.com/?q={$this->latitude},{$this->longitude}";
    }

    public function getWazeUrlAttribute(): string
    {
        return "https://waze.com/ul?ll={$this->latitude},{$this->longitude}&navigate=yes";
    }

    public function getShortNameAttribute(): string
    {
        return trim(explode('(', $this->name_en)[0]) ?? $this->name_en;
    }

    public function getBgColorClassAttribute(): string
    {
        return 'bg-primary-500/20 border-primary-500/30 text-primary-400';
    }
}