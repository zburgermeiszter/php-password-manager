<?php

namespace ZBurgermeiszter\PWManager\Middlewares;

use ZBurgermeiszter\App\Abstracts\AbstractRouteControllerMiddleware;
use ZBurgermeiszter\HTTP\JSONResponse;
use ZBurgermeiszter\PWManager\DatabaseRepositories\CredentialsRepository;
use ZBurgermeiszter\PWManager\DataStructures\Credentials;

class CredentialsListInsertAPIMiddleware extends AbstractRouteControllerMiddleware
{
    protected static $route = [
        '/credentials'
    ];

    protected function httpGET()
    {
        /**
         * @var $credentialsRepository CredentialsRepository
         */

        $user = $this->context->getSession()->get('user');

        $credentialsRepository = $this->context->getDatabaseRepository('ZBurgermeiszter:PWManager:Credentials');

        $credentials = $credentialsRepository->listCredentials($user);

        $this->context->setResponse(JSONResponse::createFinal($credentials, 200));
    }

    protected function httpPOST()
    {
        /**
         * @var $credentialsRepository CredentialsRepository
         */
        $requestContent = $this->context->getRequest()->getContent();
        $user = $this->context->getSession()->get('user');

        $credentials = new Credentials($requestContent);

        $credentialsRepository = $this->context->getDatabaseRepository('ZBurgermeiszter:PWManager:Credentials');
        $credentialID = $credentialsRepository->addCredentials($user, $credentials);

        if (!$credentialID) {
            return $this->context->setResponse($response = JSONResponse::createFinal([
                'error' => 'Failed to save credentials. Please try again.'
            ], 500));
        }

        $credentials->setId($credentialID);

        return $this->context->setResponse(JSONResponse::createFinal($credentials));
    }

}