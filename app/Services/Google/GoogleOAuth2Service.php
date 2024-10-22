<?php

namespace App\Services\Google;

use App\Services\Contracts\IGoogleOAuth2Service;
use App\Services\Google\GoogleAuthConfService;
use Google\Service\Oauth2;
use Google\Client;
use Google\Service\Oauth2\Userinfo;

class GoogleOAuth2Service implements IGoogleOAuth2Service
{
    /**
     * Google client instance
     * 
     * @var Client $oauthClient
     */
    protected $oauthClient;

    /**
     * Initializes the setup 
     * @param GoogleAuthConfService $client
     */
    public function __construct(public GoogleAuthConfService $client)
    {

        $this->oauthClient = $this->client->setupGoogleClient();
    }

    /**
     * Get the user data from google
     * 
     * @param string $code
     * @return array
     */
    public function getUserOAuth2(string $code): array
    {

        $accessToken = $this->getAccessToken($code);

        $this->oauthClient->setAccessToken($accessToken);

        $googleUserInfo = $this->getGoogleUserInfo();

        $user = [
            'name'          => $googleUserInfo->name,
            'email'         => $googleUserInfo->email,
            'picture'       => $googleUserInfo->picture,
            'verifiedEmail' => $googleUserInfo->verifiedEmail,
            'access_token'  => $accessToken
        ];

        return $user;
    }

    /**
     * Get and set access token from google
     * 
     * @param string $code
     */
    private function getAccessToken(string $code): string
    {

        $tokenData = $this->oauthClient->fetchAccessTokenWithAuthCode($code);

        return $tokenData['access_token'];
    }

    /**
     * Get and return the user info from google
     * 
     * @return array
     */

    private function getGoogleUserInfo(): Userinfo
    {

        $authService = new Oauth2($this->oauthClient);
        $googleUser  = $authService->userinfo->get();

        return $googleUser;
    }

}

