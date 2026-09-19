<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;

    protected $fillable = ['key', 'value', 'type', 'group', 'label'];

    // Static helper — get setting value
    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();

        if (!$setting) {
            return $default;
        }

        return match ($setting->type) {
            'boolean' => (bool) $setting->value,
            'number'  => (float) $setting->value,
            'json'    => json_decode($setting->value, true),
            default   => $setting->value,
        };
    }

    // Static helper — set setting value
    public static function set(string $key, mixed $value, ?string $type = null): void
    {
        $data = ['value' => is_array($value) ? json_encode($value) : $value];

        if ($type !== null) {
            $data['type'] = $type;
        }

        static::updateOrCreate(['key' => $key], $data);
    }
}