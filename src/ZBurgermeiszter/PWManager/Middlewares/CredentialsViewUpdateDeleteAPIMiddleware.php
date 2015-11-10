<?php

namespace ZBurgermeiszter\PWManager\Middlewares;

use ZBurgermeiszter\App\Abstracts\AbstractRouteControllerMiddleware;
use ZBurgermeiszter\HTTP\JSONResponse;
use ZBurgermeiszter\PWManager\DatabaseRepositories\CredentialsRepository;

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

        die("TODO: Request, application/json, json_decode, save it.");

        $credentialsRepository = $this->context->getDatabaseRepository('ZBurgermeiszter:PWManager:Credentials');
        //$credential = $credentialsRepository->updateCredentials($user, );

        if (!$credential) {
            return $this->context->setResponse($response = JSONResponse::createFinal([], 403));
        }

        return $this->context->setResponse($response = JSONResponse::createFinal($credential));
    }

}