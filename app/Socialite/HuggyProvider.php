<?php

namespace App\Socialite;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;
use Psr\Http\Message\StreamInterface;

class HuggyProvider extends AbstractProvider implements ProviderInterface
{
    protected $scopes = ['install_app', 'read_agent_profile'];
    protected $scopeSeparator = ' ';


    protected function getAuthUrl($state): string
    {
        return $this->buildAuthUrlFromBase(config(key: 'services.huggy.base_auth_url') . '/authorize', state: $state);
    }

    public function getAccessToken($code): StreamInterface
    {
        $response = $this->getHttpClient()->post(uri: $this->getTokenUrl(), options: [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'redirect_uri' => config(key: 'services.huggy.redirect'),
                'client_id' => config(key: 'services.huggy.client_id'),
                'client_secret' => config(key: 'services.huggy.client_secret'),
                'code' => $code,
            ],
        ]);
        return $response->getBody();
    }

    protected function getTokenUrl(): string
    {
        return config(key: 'services.huggy.base_auth_url') . '/access_token';
    }

    protected function getUserByToken($token)
    {
        $url = config('services.huggy.base_api_url') . '/' . config('services.huggy.api_version') . '/agents/profile';
        $response = $this->getHttpClient()->get(uri: $url, options: [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);
        return json_decode(json: (string) $response->getBody(), associative: true);
    }

    protected function mapUserToObject(array $user): User
    {
        return (new User)->setRaw(user: $user)->map(attributes: [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'avatar' => $user['photo'],
        ]);
    }
}
