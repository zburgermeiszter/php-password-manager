<?php

require_once('../src/autoload.php');

$app = new \ZBurgermeiszter\App\App();
$app->emit('request');