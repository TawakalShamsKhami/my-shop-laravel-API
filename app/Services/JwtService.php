<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JwtService
{
    public static function jwtSecret(): string
    {
        $secret = env('JWT_SECRET', env('APP_KEY'));

        if (Str::startsWith($secret, 'base64:')) {
            return base64_decode(substr($secret, 7));
        }

        return $secret;
    }

    public static function issueToken(User $user): string
    {
        $payload = [
            'sub' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + 3600,
            'jti' => (string) Str::uuid(),
        ];

        return self::encode($payload);
    }

    public static function encode(array $payload): string
    {
        $header = ['alg' => 'HS256', 'typ' => 'JWT'];
        $segments = [
            self::base64UrlEncode(json_encode($header)),
            self::base64UrlEncode(json_encode($payload)),
        ];

        $signingInput = implode('.', $segments);
        $signature = hash_hmac('sha256', $signingInput, self::jwtSecret(), true);
        $segments[] = self::base64UrlEncode($signature);

        return implode('.', $segments);
    }

    public static function decode(string $token): ?array
    {
        $parts = explode('.', $token);

        if (count($parts) !== 3) {
            return null;
        }

        [$encodedHeader, $encodedPayload, $encodedSignature] = $parts;
        $signature = self::base64UrlDecode($encodedSignature);
        $data = $encodedHeader . '.' . $encodedPayload;
        $expectedSignature = hash_hmac('sha256', $data, self::jwtSecret(), true);

        if (! hash_equals($expectedSignature, $signature)) {
            return null;
        }

        $payload = json_decode(self::base64UrlDecode($encodedPayload), true);

        if (! is_array($payload)) {
            return null;
        }

        if (isset($payload['exp']) && time() > $payload['exp']) {
            return null;
        }

        return $payload;
    }

    public static function authenticateRequest(Request $request): ?User
    {
        $header = $request->header('Authorization', '');

        if (! Str::startsWith($header, 'Bearer ')) {
            return null;
        }

        $token = trim(Str::after($header, 'Bearer '));
        $payload = self::decode($token);

        if (empty($payload['sub'])) {
            return null;
        }

        $user = User::find($payload['sub']);

        if (! $user || ! $user->is_active) {
            return null;
        }

        return $user;
    }

    public static function respondWithToken(User $user): array
    {
        return [
            'access_token' => self::issueToken($user),
            'token_type' => 'bearer',
            'expires_in' => 3600,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles->pluck('name'),
                'permissions' => $user->allPermissions()->pluck('name'),
            ],
        ];
    }

    private static function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    private static function base64UrlDecode(string $value): string
    {
        $remainder = strlen($value) % 4;

        if ($remainder > 0) {
            $value .= str_repeat('=', 4 - $remainder);
        }

        return base64_decode(strtr($value, '-_', '+/')) ?: '';
    }
}
