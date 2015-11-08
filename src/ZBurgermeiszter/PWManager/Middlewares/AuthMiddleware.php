<?php

namespace ZBurgermeiszter\PWManager\Middlewares;

use ZBurgermeiszter\App\Abstracts\AbstractRouteControllerMiddleware;
use ZBurgermeiszter\App\Context;
use ZBurgermeiszter\HTTP\JSONResponse;
use ZBurgermeiszter\PWManager\DatabaseRepositories\UsersRepository;

class AuthMiddleware extends AbstractRouteControllerMiddleware
{
    protected static $preRoute = [
        '/credentials'
    ];

    public function execute(Context $context)
    {
        /**
         * @var $userRepository UsersRepository
         */
        $userRepository = $context->getDatabaseRepository('ZBurgermeiszter:PWManager:Users');

        $token = $context->getRequest()->getHeader('X-Token');
        $user = $userRepository->getUserByToken($token);

        if (!$user) {
            return $context->setResponse(JSONResponse::createFinal([
                'error' => 'Invalid token'
            ], 403));
        }

        $context->getSession()->set('user', $user);

        return true;
    }

}