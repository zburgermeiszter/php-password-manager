<?php

require_once('../vendor/autoload.php');

$app = new \ZBurgermeiszter\App\App();
$app->emit('request');