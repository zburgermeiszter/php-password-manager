<?php

namespace ZBurgermeiszter\PWManager\Middlewares;

use ZBurgermeiszter\App\Abstracts\AbstractRouteControllerMiddleware;
use ZBurgermeiszter\App\Services\ConfigurationService;
use ZBurgermeiszter\HTTP\JSONResponse;
use ZBurgermeiszter\PWManager\DatabaseRepositories\SessionsRepository;

class AuthMiddleware extends AbstractRouteControllerMiddleware
{
    protected static $preRoute = [
        '/credentials',
        '/\/credentials\/(\d+)/'
    ];

    protected function http()
    {
        /**
         * @var $sessionRepository SessionsRepository
         */
        $sessionRepository = $this->context->getDatabaseRepository('ZBurgermeiszter:PWManager:Sessions');

        $token = $this->context->getRequest()->getHeader('X-Token');
        $user = $sessionRepository->getUserByToken($token);

        if (!$user) {
            return $this->context->setResponse(JSONResponse::createFinal([
                'error' => 'Invalid token'
            ], 403));
        }

        $this->updateValidUntil($token);

        $this->context->getSession()->set('user', $user);

        return true;
    }

    private function updateValidUntil($token)
    {
        /**
         * @var $sessionRepository SessionsRepository
         * @var $configService ConfigurationService
         */
        $configService = $this->context->getServiceRepository()->getService('config');
        $sessionConfig = $configService->get('session');

        $sessionRepository = $this->context->getDatabaseRepository('ZBurgermeiszter:PWManager:Sessions');

        $validityDays = 0;
        if (array_key_exists('token_validity_days', $sessionConfig)) {
            $validityDays = (int)$sessionConfig['token_validity_days'];
        }

        $validUntil = new \DateTime("+$validityDays days");

        $sessionRepository->updateToken($token, $validUntil);
    }

}