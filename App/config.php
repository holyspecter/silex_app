<?php

define('ROOT', dirname(__DIR__));

$loader = require_once ROOT.'/vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

$app['autoloader'] = $app->share(function()use($loader){return $loader;});
$app['autoloader']->add("App",ROOT);

require_once ROOT.'/App/routes.php';