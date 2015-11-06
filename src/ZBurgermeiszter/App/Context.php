<?php
namespace ZBurgermeiszter\App;

use ZBurgermeiszter\App\Services\RouterService;
use ZBurgermeiszter\App\Services\ServiceRepository;
use ZBurgermeiszter\HTTP\Request;
use ZBurgermeiszter\HTTP\Response;

class Context {

    private $request;
    private $response;
    private $serviceRepository;

    public function __construct(Request $request, Response $response, ServiceRepository $serviceRepository)
    {
        $this->request = $request;
        $this->response = $response;
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return string
     */
    public function getRequestMethod()
    {
        return $this->getRequest()->getMethod();
    }

    public function getRequestRoute()
    {
        return $this->getRequest()->getUriPath();
    }

    public function getRequestHeader($headerName)
    {
        return $this->getRequest()->getHeader($headerName);
    }

    /**
     * @param Response $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return ServiceRepository
     */
    public function getServiceRepository()
    {
        return $this->serviceRepository;
    }

    public function getService($serviceName)
    {
        return $this->getServiceRepository()->getService($serviceName);
    }

    /**
     * @return RouterService
     * @throws \Exception
     */
    public function getRouter()
    {
        return $this->getServiceRepository()->getService('router');
    }

}