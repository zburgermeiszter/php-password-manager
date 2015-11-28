<?php

namespace ZBurgermeiszter\PWManager\Middlewares;

use ZBurgermeiszter\App\Abstracts\AbstractRouteControllerMiddleware;
use ZBurgermeiszter\App\Services\ConfigurationService;
use ZBurgermeiszter\HTTP\JSONResponse;
use ZBurgermeiszter\HTTP\Response;
use ZBurgermeiszter\PWManager\DatabaseRepositories\SessionsRepository;
use ZBurgermeiszter\PWManager\DatabaseRepositories\UsersRepository;

class SessionHandlerMiddleware extends AbstractRouteControllerMiddleware
{
    protected static $route = '/session';

    // Login
    protected function httpPOST()
    {
        $authHeader = $this->context->getRequestHeader('Authorization');

        $credentials = $this->extractLoginCredentialsFromBasicAuth($authHeader);

        $response = $this->authenticateUser($credentials);

        $this->context->setResponse($response);
    }

    // Logout
    protected function httpDELETE()
    {
        /**
         * @var $sessionRepository SessionsRepository
         */
        $token = $this->context->getRequestHeader('X-Token');

        $sessionRepository = $this->context->getDatabaseRepository('ZBurgermeiszter:PWManager:Sessions');

        $destroyToken = $sessionRepository->destroyToken($token);

        if (!$destroyToken) {
            return $this->context->setResponse(JSONResponse::createFinal([], 500));
        }

        return $this->context->setResponse(JSONResponse::createFinal([], 200));
    }

    /**
     * @param $credentials
     * @return Response
     * @throws \Exception
     */
    private function authenticateUser($credentials)
    {
        /**
         * @var $sessionRepository SessionsRepository
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

        $sessionRepository = $this->context->getDatabaseRepository('ZBurgermeiszter:PWManager:Sessions');

        $configService = $this->context->getServiceRepository()->getService('config');
        $sessionConfig = $configService->get('session');

        $validityDays = 0;
        if (array_key_exists('token_validity_days', $sessionConfig)) {
            $validityDays = (int)$sessionConfig['token_validity_days'];
        }

        $validUntil = new \DateTime("+$validityDays days");

        $userRepository = $this->context->getDatabaseRepository('ZBurgermeiszter:PWManager:Users');
        $user = $userRepository->getUser($credentials['user'], $credentials['pass']);

        if (!$user) {
            throw new \Exception("User not found:" . $credentials['user']);
        }

        $session = $sessionRepository->createSession($user, $validUntil);

        $responseCode = $session ? 200 : 403;

        return JSONResponse::createFinal($session, $responseCode);

    }

    private function extractLoginCredentialsFromBasicAuth($authHeader)
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