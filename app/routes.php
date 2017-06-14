<?php

use Symfony\Component\HttpFoundation\Request;

// Home page
$app->get('/', function () use ($app) {
    $links = $app['dao.link']->findAll();
    return $app['twig']->render('index.html.twig', array('links' => $links));
})->bind('home');

// Link details with comments
$app->get('/link/{id}', function ($id) use ($app) {
    $linkn = $app['dao.link']->find($id);
    $comments = $app['dao.comment']->findAllByLink($id);
    return $app['twig']->render('link.html.twig', array('link' => $link, 'comments' => $comments));
})->bind('link');

// Login Form - OK
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');


// Admin home page
$app->get('/admin', function() use ($app) {
    $links = $app['dao.link']->findAll();
    $users = $app['dao.user']->findAll();
    return $app['twig']->render('admin.html.twig', array(
        'links' => $links,
        'users' => $users));
})->bind('admin');
