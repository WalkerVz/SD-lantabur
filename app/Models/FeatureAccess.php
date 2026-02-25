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

    public static function can(string $role, string $feature): bool
    {
        if ($role === 'admin') {
            return true;
        }

        static $cache = [];
        if (!isset($cache[$role])) {
            $cache[$role] = self::where('role', $role)
                ->pluck('allowed', 'feature')
                ->map(fn ($val) => (bool) $val)
                ->toArray();
        }

        return $cache[$role][$feature] ?? false;
    }
}

