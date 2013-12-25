<?php

use Symfony\Component\HttpFoundation\Request;

// Index Controller
$app->get('/', function() use ($app){
    $posts = $app['db']->fetchAll('SELECT * FROM post');

    return $app['twig']->render('index.html', array(
                                                 'posts' => $posts,
                                              ));
});

// Add Controller
$app->match('/add', function(Request $request) use($app) {

    $post = new Post();

    if ($request->isMethod('POST')) {
        if ($post->validate()) {
            $post->save();
        }
    }

    return $app['twig']->render('add.html', array(
                                                 'validationErrors' => $post->getValidationErrors(),
                                            ));
});