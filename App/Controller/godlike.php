<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->get('/admin', function() use ($app) {
    return new Response("admin panel should be here");
});