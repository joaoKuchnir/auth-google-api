<?php

namespace App\Services\Contracts;

interface IGoogleOAuth2Service
{
    public function getUserOAuth2(string $code): array;

}

