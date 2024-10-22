<?php

namespace App\Services\Contracts;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

interface IGoogleClientService
{
    public function handlerAuthenticate(array $googleToken);

}
