<?php

namespace ZBurgermeiszter\HTTP;

class RedirectResponse extends Response
{

    public function __construct($url = "", $responseCode = 301, $headers = [])
    {
        $this->responseCode = $responseCode;
        $this->headers = is_array($headers)?$headers:[];

        $this->headers['Location'] = $url;

        $this->content = '
        <meta http-equiv="refresh" content="0;url='.$url.'">
        Redirecting... <a href="'.$url.'">click here</a>
        ';

    }
}