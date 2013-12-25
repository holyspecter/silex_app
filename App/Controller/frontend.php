<?php

use Symfony\Component\HttpFoundation\Request;

// Index Controller
$app->get('/', function() use ($app){
    return $app['twig']->render('index.html', array());//new \Symfony\Component\HttpFoundation\Response();
});

// Add Controller
$app->match('/add', function(Request $request) use($app) {

    if ($request->isMethod('POST')) {
        $data = filter_input_array(INPUT_POST, array());
    }

//    $app['db']->insert('post', array(
//                                    'name' => 'test',
//                                    'description' => 'lalala',
//                                    'file_path' => null,
//                               ));

//    $form = $app['form.factory']->createBuilder('form')
//        ->add('name')
//        ->add('description')
//        ->add('file', 'file', array(
//            'required' => true,
//        ))
//        ->getForm();
//
//    $form->handleRequest($request);
//
//    if ($form->isValid()) {
//
//    }

    return $app['twig']->render('add.html', array());
});