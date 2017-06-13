<?php

// Home page
$app->get('/', function () use ($app) {
    $links = $app['dao.link']->findAll();

    return $app['twig']->render('index.html.twig', array('links' => $links));
})->bind('home');

// Login Form
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');
