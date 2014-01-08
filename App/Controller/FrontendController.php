<?php

namespace App\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;

class FrontendController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $frontendController = $app['controllers_factory'];

        $frontendController->get('/hello/{name}', function($name) use ($app){
            return 'Hello '.$app->escape($name);
        });

        return $frontendController;
    }
}

