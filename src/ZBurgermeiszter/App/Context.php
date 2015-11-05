<?php
namespace ZBurgermeiszter\App;

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

}