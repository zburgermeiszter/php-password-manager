<?php

namespace ZBurgermeiszter\PWManager\Middlewares;

use ZBurgermeiszter\App\Abstracts\AbstractRouteControllerMiddleware;
use ZBurgermeiszter\App\Context;
use ZBurgermeiszter\HTTP\JSONResponse;
use ZBurgermeiszter\PWManager\DatabaseRepositories\CredentialsRepository;
use ZBurgermeiszter\PWManager\DataStructures\Credentials;

class CredentialsAPIMiddleware extends AbstractRouteControllerMiddleware
{
    protected static $route = [
        '/credentials'
    ];

    protected function httpGET(Context $context)
    {
        /**
         * @var $credentialsRepository CredentialsRepository
         */

        $user = $context->getSession()->get('user');

        $credentialsRepository = $context->getDatabaseRepository('ZBurgermeiszter:PWManager:Credentials');

        $credentials = $credentialsRepository->listCredentials($user);

        $context->setResponse(JSONResponse::createFinal($credentials, 200));
    }

    protected function httpPOST(Context $context)
    {
        /**
         * @var $credentialsRepository CredentialsRepository
         */
        $requestContent = $context->getRequest()->getContent();
        $user = $context->getSession()->get('user');

        $credentials = new Credentials($requestContent);

        $credentialsRepository = $context->getDatabaseRepository('ZBurgermeiszter:PWManager:Credentials');
        $credentialID = $credentialsRepository->addCredentials($user, $credentials);

        if (!$credentialID) {
            return $context->setResponse($response = JSONResponse::createFinal([
                'error' => 'Failed to save credentials. Please try again.'
            ], 500));
        }

        $credentials->setId($credentialID);

        return $context->setResponse(JSONResponse::createFinal($credentials));
    }

}