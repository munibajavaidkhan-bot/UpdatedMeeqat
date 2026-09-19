<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ChaddarSizeRule extends Model
{
    protected $fillable = [
        'style',
        'height_min_cm',
        'height_max_cm',
        'fabric_meters',
        'size_label',
        'description',
        'is_active',
    ];

    protected $casts = [
        'height_min_cm' => 'float',
        'height_max_cm' => 'float',
        'fabric_meters' => 'float',
        'is_active'     => 'boolean',
    ];

    // =========================================
    // SCOPES
    // =========================================

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeByStyle(Builder $query, string $style): Builder
    {
        return $query->where('style', $style);
    }

    // =========================================
    // HELPERS
    // =========================================

    public function getStyleLabelAttribute(): string
    {
        return $this->style === 'full' ? 'Full Body' : 'Shoulder Style';
    }

    public function getHeightRangeAttribute(): string
    {
        return "{$this->height_min_cm}cm — {$this->height_max_cm}cm";
    }

    public function getSizeBadgeColorAttribute(): string
    {
        return match($this->size_label) {
            'XS'    => 'bg-slate-500/20 text-slate-400 border-slate-500/30',
            'S'     => 'bg-blue-500/20 text-blue-400 border-blue-500/30',
            'M'     => 'bg-primary-500/20 text-primary-400 border-primary-500/30',
            'L'     => 'bg-gold-500/20 text-gold-400 border-gold-500/30',
            'XL'    => 'bg-orange-500/20 text-orange-400 border-orange-500/30',
            'XXL'   => 'bg-red-500/20 text-red-400 border-red-500/30',
            default => 'bg-dark-700 text-dark-400 border-dark-600',
        };
    }
}