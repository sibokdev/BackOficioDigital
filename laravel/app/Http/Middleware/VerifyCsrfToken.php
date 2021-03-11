<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/*',
        'api/v1/users/login',
        'api/v1/users/contract',
        'api/v1/users/{client_id}/completeData',
        'api/v1/users/{client_id}/services',
        'api/v1/users/{client_id}/serviceDetail/{service_id}',
        'api/v1/users/paymentMethod',
        'api/v1/users/paymentMethodData'
    ];
}
