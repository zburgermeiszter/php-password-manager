<?php

namespace ZBurgermeiszter\PWManager\Middlewares;

use ZBurgermeiszter\App\Abstracts\AbstractRouteControllerMiddleware;
use ZBurgermeiszter\HTTP\JSONResponse;
use ZBurgermeiszter\PWManager\DatabaseRepositories\CredentialsRepository;
use ZBurgermeiszter\PWManager\DataStructures\Credentials;

class CredentialsViewUpdateDeleteAPIMiddleware extends AbstractRouteControllerMiddleware
{
    protected static $route = [
        '/\/credentials\/(\d+)/'
    ];

    protected function httpGET()
    {
        /**
         * @var $credentialsRepository CredentialsRepository
         */

        $matches = $this->getRouteMatches();
        $user = $this->context->getSession()->get('user');

        $credentialsRepository = $this->context->getDatabaseRepository('ZBurgermeiszter:PWManager:Credentials');
        $credential = $credentialsRepository->getCredential($user, $matches[0]);

        if (!$credential) {
            return $this->context->setResponse($response = JSONResponse::createFinal([], 403));
        }

        return $this->context->setResponse($response = JSONResponse::createFinal($credential));
    }

    protected function httpPUT()
    {
        /**
         * @var $credentialsRepository CredentialsRepository
         */

        $matches = $this->getRouteMatches();
        $user = $this->context->getSession()->get('user');
        $requestContent = $this->context->getRequestContent();

        $credentials = new Credentials($requestContent);
        $credentials->setId($matches[0]);

        $credentialsRepository = $this->context->getDatabaseRepository('ZBurgermeiszter:PWManager:Credentials');
        $credentialUpdate = $credentialsRepository->updateCredentials($user, $credentials);

        if (!$credentialUpdate) {
            return $this->context->setResponse($response = JSONResponse::createFinal([], 500));
        }

        return $this->context->setResponse($response = JSONResponse::createFinal([]));
    }

}