<?php

namespace ZBurgermeiszter\HTTP;

class JSONResponse extends Response
{

    public function __construct($content = "", $responseCode = 200, $headers = [])
    {
        $headers = is_array($headers) ? $headers : [];
        $headers['Content-Type'] = "application/json; charset=utf-8";

        $content = json_encode($content);

        parent::__construct($content, $responseCode, $headers);
    }
}