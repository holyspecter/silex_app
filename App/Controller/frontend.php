<?php

use Symfony\Component\HttpFoundation\Request;

// Index Controller
$app->get('/{page}', function($page) use ($app){

    $countAll = $app['db']->fetchAssoc("SELECT COUNT(id) as count FROM post");

    $paginator = new Paginator\Paginator();
    $paginator->setCurrentPageNumber($page); // set current page
    $paginator->setItemCountPerPage(POSTS_PER_PAGE); // items per page, default : 10
    $paginator->setTotalItemCount(array_pop($countAll));

    $offset = ($page - 1) * POSTS_PER_PAGE;
    $posts = $app['db']->fetchAll("SELECT * FROM post LIMIT $offset, ".POSTS_PER_PAGE);

    return $app['twig']->render('index.html.twig', array(
                                                 'posts' => $posts,
                                                 'paginator' => $paginator,
                                              ));
})
->assert('page', '\d+')
->value('page', 1)
->bind('home');

// View Controller
$app->get('/post/{id}', function($id) use ($app) {

    $post = $app['db']->fetchAssoc("SELECT * FROM post WHERE id=:id", array('id' => $id));

    return $app['twig']->render('view.html.twig', array(
                                                       'post' => $post,
                                                  ));
})
->assert('id', '\d+')
->bind('post_view');

// Add Controller
$app->match('/add', function(Request $request) use($app) {

    $post = new Post();

    if ($request->isMethod('POST')) {
        if ($post->validate()) {
            $post->save();
        }
    }

    return $app['twig']->render('add.html.twig', array(
                                                 'validationErrors' => $post->getValidationErrors(),
                                            ));
})
->bind('post_add');