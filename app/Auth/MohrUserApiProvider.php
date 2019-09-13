<?php

namespace App\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;

class MohrUserApiProvider
{
    const SUCCESS = 'success';
    const OFFLINE = 'offline';
    const FAIL = 'fail';

    public static function retrieveByCredentials(array $credentials)
    {
        try {
            list($username, $domain) = explode('@', $credentials['email']);

            $client = new Client([
                'base_uri' => env('MOHR_USER_API_URL'),
                'json' => ['user_id' => $username, 'password' => $credentials['password']],
            ]);

            $response = $client->request('POST');

            return json_decode((string) $response->getBody());
        } catch (ConnectException $e) {
            return json_decode("{\"status\" : \"" . self::OFFLINE . "\"}");
        }
    }
}
