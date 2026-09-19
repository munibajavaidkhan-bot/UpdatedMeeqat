<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role_id',
        'avatar',
        'country',
        'city',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    // =========================================
    // RELATIONSHIPS
    // =========================================

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function chaddarCalculations(): HasMany
    {
        return $this->hasMany(ChaddarCalculation::class);
    }

    public function meeqatDistanceLogs(): HasMany
    {
        return $this->hasMany(MeeqatDistanceLog::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function bookmarkedDuas()
    {
        return $this->belongsToMany(Dua::class, 'user_dua_bookmarks', 'user_id', 'dua_id');
    }

    // =========================================
    // ROLE CHECK HELPERS
    // =========================================

    public function isAdmin(): bool
    {
        return $this->role?->name === 'admin';
    }

    public function isEditor(): bool
    {
        return $this->role?->name === 'editor';
    }

    public function isPilgrim(): bool
    {
        return $this->role?->name === 'user';
    }

    public function isAdminOrEditor(): bool
    {
        return in_array($this->role?->name, ['admin', 'editor']);
    }

    // =========================================
    // PERMISSION CHECK
    // =========================================

    public function hasPermission(string $permissionName): bool
    {
        return $this->role
            ->permissions()
            ->where('name', $permissionName)
            ->exists();
    }

    // =========================================
    // SCOPES
    // =========================================

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeAdmins(Builder $query): Builder
    {
        return $query->whereHas('role', fn($q) => $q->where('name', 'admin'));
    }

    // =========================================
    // ACCESSORS
    // =========================================

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return \Illuminate\Support\Facades\Storage::url($this->avatar);
        }
        return asset('images/default-avatar.png');
    }

    public function getRoleLabelAttribute(): string
    {
        return $this->role?->label ?? 'Unknown';
    }
}