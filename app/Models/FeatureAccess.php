<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureAccess extends Model
{
    protected $table = 'feature_access';

    protected $fillable = [
        'role',
        'feature',
        'allowed',
    ];

    public $timestamps = false;

    /** @var array<string, array<string, bool>> */
    protected static array $cache = [];

    public static function clearCache(): void
    {
        static::$cache = [];
    }

    public static function can(string $role, string $feature): bool
    {
        if ($role === 'admin') {
            return true;
        }

        if (!isset(static::$cache[$role])) {
            static::$cache[$role] = self::where('role', $role)
                ->pluck('allowed', 'feature')
                ->map(fn ($val) => (bool) $val)
                ->toArray();
        }

        // Jika feature tidak ada titik (mis. 'dashboard'), cek juga 'feature.view' untuk kompatibilitas
        if (isset(static::$cache[$role][$feature])) {
            return static::$cache[$role][$feature];
        }
        if (!str_contains($feature, '.') && isset(static::$cache[$role][$feature . '.view'])) {
            return static::$cache[$role][$feature . '.view'];
        }

        return false;
    }
}

