<?php

namespace App\Http\Middleware;

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        'payment/initiate',
        'payment/status',
        'payment/callback'
    ];
}
