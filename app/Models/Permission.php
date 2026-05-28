<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions')
            ->withTimestamps()
            ->withPivot('is_active');
    }

    public static function syncRoutes(): void
    {
        foreach (Route::getRoutes()->getRoutes() as $route) {
            if (! $route->getAction('prefix') && ! str_starts_with($route->uri(), 'api/')) {
                continue;
            }

            $methods = array_filter($route->methods(), fn ($method) => $method !== 'HEAD');
            $method = $methods[0] ?? 'GET';
            $uri = $route->uri();

            if ($uri === 'api' || $uri === 'health') {
                continue;
            }

            $permissionName = $route->getName() ?: self::routePermissionName($method, $uri);
            $description = sprintf('Auto-generated permission for %s %s.', $method, $uri);

            self::firstOrCreate(
                ['name' => $permissionName],
                ['description' => $description, 'is_active' => true]
            );
        }
    }

    protected static function routePermissionName(string $method, string $uri): string
    {
        $normalized = Str::of($uri)
            ->replace(['{', '}', '/'], ['', '', '.'])
            ->trim('.')
            ->replace('..', '.')
            ->lower();

        return sprintf('%s.%s', strtolower($method), $normalized);
    }
}
