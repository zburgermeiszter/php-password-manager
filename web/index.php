<?php
# sudo php -S localhost:80 -t web
require_once('../vendor/autoload.php');

$app = new \ZBurgermeiszter\App\App();
$app->emit('request');