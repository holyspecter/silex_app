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
->value('page', 1);

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
});