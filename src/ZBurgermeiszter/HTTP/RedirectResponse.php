<?php

namespace ZBurgermeiszter\HTTP;

class RedirectResponse extends Response
{

    public function __construct($url = "", $responseCode = 301, $headers = [])
    {
        $content = '
        <meta http-equiv="refresh" content="0;url=' . $url . '">
        Redirecting... <a href="' . $url . '">click here</a>
        ';

        $headers = is_array($headers) ? $headers : [];
        $headers['Location'] = $url;

        parent::__construct($content, $responseCode, $headers);
    }
}