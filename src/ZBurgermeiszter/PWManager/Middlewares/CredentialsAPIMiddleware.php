<?php

namespace ZBurgermeiszter\PWManager\Middlewares;

use ZBurgermeiszter\App\Abstracts\AbstractRouteControllerMiddleware;
use ZBurgermeiszter\App\Context;
use ZBurgermeiszter\App\Services\DatabaseRepositoryLoaderService;
use ZBurgermeiszter\HTTP\JSONResponse;
use ZBurgermeiszter\PWManager\DatabaseRepositories\CredentialsRepository;

class CredentialsAPIMiddleware extends AbstractRouteControllerMiddleware
{
    protected static $route = [
        '/credentials'
    ];

    public function method_get(Context $context)
    {
        /**
         * @var $databaseRepositoryLoader DatabaseRepositoryLoaderService
         * @var $credentialsRepository CredentialsRepository
         */

        $user = $context->getSession()->get('user');

        if ($user === null) {
            $context->setResponse(JSONResponse::createFinal([
                'error' => 'User not found.'
            ], 404));
        }

        $databaseRepositoryLoader = $context->getService('databaseRepositoryLoader');
        $credentialsRepository = $databaseRepositoryLoader->getRepository('ZBurgermeiszter:PWManager:Credentials');

        $credentials = $credentialsRepository->listCredentials($user);

        $context->setResponse(JSONResponse::createFinal($credentials, 200));
    }

}