<?php

define('ROOT', dirname(__DIR__));

$loader = require_once ROOT.'/vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

$app['autoloader'] = $app->share(function()use($loader){return $loader;});
$app['autoloader']->add("App",ROOT);

// Twig
$app->register(new \Silex\Provider\TwigServiceProvider());
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    return $twig;
}));
$app['twig.path'] = array(__DIR__.'/../template');
//$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');

$app->register(new Silex\Provider\FormServiceProvider());

require_once ROOT.'/App/Controller/frontend.php';