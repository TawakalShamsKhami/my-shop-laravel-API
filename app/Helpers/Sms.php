<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Sms
{
    public static function send(String $phone, String $message)
    {
        $auth_key = env('SMS_AUTH');
        $base_url = env('SMS_BASE_URL');
        $phoneNumber = '';

        if (str_starts_with($phone, '255') && strlen($phone) == 12) {
            $phoneNumber = $phone;
        } elseif (str_starts_with($phone, '0') && strlen($phone) == 10) {
            $phoneNumber = '255' . substr($phone, 1);
        } elseif (str_starts_with($phone, '+') && strlen($phone) == 13) {
            $phoneNumber = substr($phone, 1);
        } else {
            return ApiResponse::error(400, "Invalid Phone number");
        }

        $postData = array(
            'from' => 'INFO',
            'to' => $phoneNumber,
            'text' => $message,
            'reference' => $phoneNumber
        );

        $response = Http::withHeaders([
            'Authorization' => $auth_key,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->withOptions(['verify' => false])->post($base_url, $postData);

        return $response->json();
    }
}
