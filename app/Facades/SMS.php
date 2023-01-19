<?php

namespace App\Facades;

use Exception;
use Melipayamak\MelipayamakApi;

class SMS
{
    public function send(string $to, string $text): bool
    {
        try {
            $username = config('sms.username');
            $password = config('sms.password');
            $api = new MelipayamakApi($username, $password);
            $sms = $api->sms();
            $response = $sms->send($to, config('sms.from'), $text);
            $json = json_decode($response);
            $json->Value;
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}