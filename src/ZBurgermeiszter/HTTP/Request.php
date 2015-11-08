<?php

namespace ZBurgermeiszter\HTTP;

class Request
{
    private $uri;

    // $_GET or $_POST
    private $parameters;

    private $headers;

    // string
    private $content;

    private $method;

    private $server;

    public static function createFromGlobals()
    {
        $request = new static;
        $content = file_get_contents('php://input');
        $request->load($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], getallheaders(), $_REQUEST, $content, $_SERVER);
        return $request;
    }

    public function load($uri, $method = 'GET', $headers = [], $parameters = [], $content = "", $server = [])
    {
        $this->uri = parse_url($uri);
        $this->headers = $headers;
        $this->parameters = $parameters;
        $this->content = $content;
        $this->server = $server;

        switch ($method) {
            case 'GET':
            case 'POST':
            case 'PUT':
            case 'DELETE':
                $this->method = $method;
                break;
            default:
                throw new \Exception("Unsupported request ($method)");
        }

    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    public function getHeader($headerName)
    {
        foreach ($this->headers as $key => $val) {
            if ($key === $headerName) {
                return $val;
            }
        }

        return false;
    }

    /**
     * @return string|null
     */
    public function getUriPath()
    {
        if (!array_key_exists('path', $this->uri)) {
            return null;
        }

        return $this->uri['path'];
    }


}
