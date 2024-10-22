<?php

namespace App\Services\Contracts;

use Google\Client;

interface IGoogleAuthConfService
{
    /**
     * Interface IGoogleAuthConfService
     *
     * Provides the contract for Google Authentication Configuration services.
     */
    public function setupGoogleClient(): Client;

}

