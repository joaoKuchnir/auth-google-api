<?php

namespace App\Services\Google;

use App\Services\Contracts\IGoogleAuthConfService;
use Google\Client;

class GoogleAuthConfService implements IGoogleAuthConfService
{
    /**
     * Constructor for google client instance
     *
     */
    public function __construct(
        public Client $client
    ) {}

    /**
     * Setting up the google client
     * 
     * @return Client
     */
    public function setupGoogleClient(): Client
    {
        $googleConfig = config('services.google');

        try {
            $this->client->setAuthConfig([
                'client_id'     => $googleConfig['client_id'],
                'client_secret' => $googleConfig['client_secret'],
            ]);

            $this->client->setScopes(['openid', 'profile', 'email']);
            $this->client->setState('logged_in');
            $this->client->setRedirectUri($googleConfig['redirect_uri']);

            return $this->client;

        } catch ( \Google_Service_Exception $e ) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

}

