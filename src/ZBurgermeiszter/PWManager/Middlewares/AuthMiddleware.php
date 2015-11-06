<?php

namespace ZBurgermeiszter\PWManager\Middlewares;

use ZBurgermeiszter\App\Abstracts\AbstractRouteControllerMiddleware;
use ZBurgermeiszter\App\Context;
use ZBurgermeiszter\HTTP\JSONResponse;

class AuthMiddleware extends AbstractRouteControllerMiddleware
{
    protected static $preRoute = [
        '/list'
    ];

    public function execute(Context $context)
    {
        $authHeader = $context->getRequestHeader('Authorization');

        $credentials = $this->extractCredentialsFromBasicAuth($authHeader);

        $this->authenticateCredentials($context, $credentials);

        $context->setResponse(JSONResponse::createFinal([
            "error" => "Unauthorized"
        ], 401));
    }

    private function authenticateCredentials(Context $context, $credentials)
    {
        $validCredentialFormat = (
            is_array($credentials)
            && array_key_exists('user', $credentials)
            && array_key_exists('pass', $credentials)
        );

        if (!$validCredentialFormat) return false;

        die("Here should be a MODEL to authenticate user credentials against database.");

    }

    private function extractCredentialsFromBasicAuth($authHeader)
    {
        list($authType, $authContent) = explode(' ', $authHeader);

        if ($authType != 'Basic') return false;

        $credentialsString = base64_decode($authContent);
        list($user, $pass) = explode(':', $credentialsString);

        if ($user === null || $pass === null) return false;

        return [
            'user' => $user,
            'pass' => $pass
        ];
    }

}