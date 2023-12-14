<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'success',
        'failed',
        'payment/*',
        'admin/sort-payment-methods',
		'*/save-token*',
		'*get-states-by-country*',
        '*get-cities-by-state*',
        '*/listing/get/subcategory*',
		'*/select-payment-gateway*',
		'*/make-payment-details*',

    ];
}
