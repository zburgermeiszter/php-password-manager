<?php

namespace ZBurgermeiszter\PWManager\Middlewares;

use ZBurgermeiszter\App\Abstracts\AbstractRouteControllerMiddleware;
use ZBurgermeiszter\App\Context;
use ZBurgermeiszter\App\Services\ConfigurationService;
use ZBurgermeiszter\HTTP\JSONResponse;
use ZBurgermeiszter\HTTP\Response;
use ZBurgermeiszter\PWManager\DatabaseRepositories\UsersRepository;

class LoginMiddleware extends AbstractRouteControllerMiddleware
{
    protected static $route = '/login';

    public function execute(Context $context)
    {
        $authHeader = $context->getRequestHeader('Authorization');

        $credentials = $this->extractCredentialsFromBasicAuth($authHeader);

        $response = $this->authenticateCredentials($context, $credentials);

        $context->setResponse($response);
    }

    /**
     * @param Context $context
     * @param $credentials
     * @return Response
     * @throws \Exception
     */
    private function authenticateCredentials(Context $context, $credentials)
    {
        /**
         * @var $userRepository UsersRepository
         * @var $configService ConfigurationService
         */

        $validCredentialFormat = (
            is_array($credentials)
            && array_key_exists('user', $credentials)
            && array_key_exists('pass', $credentials)
        );

        if (!$validCredentialFormat) {
            return JSONResponse::createFinal([], 403);
        };

        $userRepository = $context->getDatabaseRepository('ZBurgermeiszter:PWManager:User');

        $configService = $context->getServiceRepository()->getService('config');
        $sessionConfig = $configService->get('session');

        $validityDays = 0;
        if (array_key_exists('token_validity_days', $sessionConfig)) {
            $validityDays = (int)$sessionConfig['token_validity_days'];
        }

        $validUntil = new \DateTime("+$validityDays days");

        $session = $userRepository->createSession($credentials['user'], $credentials['pass'], $validUntil);

        $responseCode = $session ? 200 : 403;

        return JSONResponse::createFinal($session, $responseCode);

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