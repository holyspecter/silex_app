<?php

define('ROOT', dirname(__DIR__));

$loader = require_once ROOT . '/vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

$app['autoloader'] = $app->share(function () use ($loader) {
    return $loader;
});
$app['autoloader']->add("App", ROOT);

// Symfony forms
$app->register(new Silex\Provider\FormServiceProvider(), array(
                                                              'translator.messages' => array(),
                                                         ));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
                                                                  'db.options' => array(
                                                                      'driver'   => 'pdo_mysql',
                                                                      'dbname'   => 'silex',
                                                                      'host'     => '127.0.0.1',
                                                                      'user'     => 'root',
                                                                      'password' => 'root',
                                                                      'charset'  => 'utf8',
                                                                  )
                                                             ));

// Twig
$app->register(new \Silex\Provider\TwigServiceProvider());
$app['twig']      = $app->share($app->extend('twig', function ($twig, $app) {
    return $twig;
}));
$app['twig.path'] = array(__DIR__ . '/../template');
$app['twig']->addExtension(new Twig_Extensions_Extension_I18n());
//$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');

require_once ROOT . '/App/Controller/frontend.php';
require_once ROOT . '/App/Model/Post.php';