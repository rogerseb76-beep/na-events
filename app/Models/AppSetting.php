<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AppSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public static function getValue(
        string $key,
        mixed $default = null
    ): mixed {
        return Cache::remember(
            'app_setting:' . $key,
            now()->addMinutes(30),
            fn () => static::query()
                ->where('key', $key)
                ->value('value') ?? $default
        );
    }

    public static function setValue(
        string $key,
        mixed $value
    ): void {
        static::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget('app_setting:' . $key);
    }

    public static function registrationState(): string
    {
        return (string) static::getValue(
            'registration_state',
            'open'
        );
    }

    public static function registrationsAreOpen(): bool
    {
        return static::registrationState() === 'open';
    }
}
