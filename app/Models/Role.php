<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = ['name', 'label', 'description'];

    // All users belonging to this role
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id');
    }

    // Permissions assigned to this role
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permissions',
            'role_id',
            'permission_id'
        );
    }

    // Check if the role is admin
    public function isAdmin(): bool
    {
        return $this->name === 'admin';
    }

    // Check if the role is editor
    public function isEditor(): bool
    {
        return $this->name === 'editor';
    }
}