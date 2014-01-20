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
$app->register(new \Silex\Provider\UrlGeneratorServiceProvider());
$app['twig']      = $app->share($app->extend('twig', function ($twig, $app) {
    return $twig;
}));
$app['twig.path'] = array(ROOT . '/web/template');
$app['twig']->addExtension(new Twig_Extensions_Extension_I18n());
//$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');

// Paginator
define('POSTS_PER_PAGE', 5);
$app->register(new Paginator\Provider\PaginatorServiceProvider());

// Security
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
                                                                  'security.firewalls' => array(
                                                                      'admin' => array(
                                                                          'pattern' => '^/admin',
                                                                          'http' => true,
                                                                          'users' => array(
                                                                              'admin' => array('ROLE_ADMIN', '123')
                                                                          ),
                                                                      )
                                                                  ),
//                                                                  'security.encoders' => array(
//                                                                      'Symfony\Component\Security\Core\User\User' => 'plaintext',
//                                                                  )
));

// Controllers
require_once ROOT . '/App/Controller/frontend.php';
require_once ROOT . '/App/Controller/godlike.php';

// Models
spl_autoload_register('modelLoader');

function modelLoader($className)
{
    if (file_exists(ROOT . "/App/Model/$className.php")) {
        include ROOT . "/App/Model/$className.php";
    }
}