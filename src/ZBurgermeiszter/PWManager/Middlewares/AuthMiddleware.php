<?php

namespace ZBurgermeiszter\PWManager\Middlewares;

use ZBurgermeiszter\App\Abstracts\AbstractRouteControllerMiddleware;
use ZBurgermeiszter\App\Services\ConfigurationService;
use ZBurgermeiszter\HTTP\JSONResponse;
use ZBurgermeiszter\PWManager\DatabaseRepositories\UsersRepository;

class AuthMiddleware extends AbstractRouteControllerMiddleware
{
    protected static $preRoute = [
        '/credentials',
        '/\/credentials\/(\d+)/'
    ];

    protected function http()
    {
        /**
         * @var $userRepository UsersRepository
         */
        $userRepository = $this->context->getDatabaseRepository('ZBurgermeiszter:PWManager:Users');

        $token = $this->context->getRequest()->getHeader('X-Token');
        $user = $userRepository->getUserByToken($token);

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
         * @var $userRepository UsersRepository
         * @var $configService ConfigurationService
         */
        $configService = $this->context->getServiceRepository()->getService('config');
        $sessionConfig = $configService->get('session');

        $userRepository = $this->context->getDatabaseRepository('ZBurgermeiszter:PWManager:Users');

        $validityDays = 0;
        if (array_key_exists('token_validity_days', $sessionConfig)) {
            $validityDays = (int)$sessionConfig['token_validity_days'];
        }

        $validUntil = new \DateTime("+$validityDays days");

        $userRepository->updateToken($token, $validUntil);
    }

}