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

        /*
             GET / HTTP/1.1
            Host: localhost:8000
            Connection: keep-alive
            Cache-Control: max-age=0
            Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,;q=0.8
            X-FirePHP-Version: 0.0.6
            Upgrade-Insecure-Requests: 1
            User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36
            Accept-Encoding: gzip, deflate, sdch
            Accept-Language: hu-HU,hu;q=0.8,en-US;q=0.6,en;q=0.4

        */
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string|null
     */
    public function getUriPath()
    {
        if (array_key_exists('path', $this->uri)) {
            return $this->uri['path'];
        }
        return null;
    }


}
