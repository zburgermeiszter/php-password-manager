<?php

namespace ZBurgermeiszter\HTTP;

class Response
{
    protected $responseCode;
    protected $headers;
    protected $content;

    public function __construct($content = "", $responseCode = 200, $headers = [])
    {
        $this->responseCode = $responseCode;
        $this->headers = is_array($headers)?$headers:[];
        $this->content = $content;


        if(!array_key_exists("Content-Type", $this->headers) && $responseCode == 200) {
            $this->headers['Content-Type'] = "text/plain";
        }

    }

    public function __toString()
    {
        http_response_code($this->responseCode);

        foreach($this->headers as $headerName => $headerContent) {
            header(implode(': ', [$headerName, $headerContent]));
        }

        return $this->content;
    }
}