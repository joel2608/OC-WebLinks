<?php

use Symfony\Component\HttpFoundation\Request;
use WebLinks\Domain\Link;
use WebLinks\Form\Type\LinkType;

// Home page
$app->get('/', function () use ($app) {
    $links = $app['dao.link']->findAll();
    return $app['twig']->render('index.html.twig', array('links' => $links));
})->bind('home');

//// Link details with comments
//$app->get('/link/{id}', function ($id) use ($app) {
//    $link = $app['dao.link']->find($id);
//    $comments = $app['dao.comment']->findAllByLink($id);
//    return $app['twig']->render('link.html.twig', array('link' => $link, 'comments' => $comments));
//})->bind('link');

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

// Add a new link
$app->match('/admin/link/add', function(Request $request) use ($app) {
    $link = new Link();
    $linkForm = $app['form.factory']->create(LinkType::class, $link);
    $linkForm->handleRequest($request);
    if ($linkForm->isSubmitted() && $linkForm->isValid()) {
        $app['dao.link']->save($link);
        $app['session']->getFlashBag()->add('success', 'The link was successfully created.');
    }
    return $app['twig']->render('link_form.html.twig', array(
        'title' => 'New link',
        'linkForm' => $linkForm->createView() ));
})->bind('admin_link_add');

// Edit an existing link
$app->match('/admin/link/{id}/edit', function($id, Request $request) use ($app) {
    $link = $app['dao.link']->find($id);
    $linkForm = $app['form.factory']->create(LinkType::class, $link);
    $linkForm->handlerequest($request);
    if ($linkForm->isSubmitted() && $linkForm->isValid()) {
        $app['dao.link']->save($link);
        $app['session']->getFlashBag()->add('success', 'The link was successfully updated.');
    }
    return $app['twig']->render('link_form.html.twig', array(
        'title' => 'Edit link',
        'linkForm' => $linkForm->createView() ));
})->bind('admin_link_edit');

// Delete a link
$app->get('/admin/link/{id}/delete', function ($id, Request $request) use ($app) {
    // Delete the link
    $app['dao.link']->delete($id);
    $app['session']->getFlashBag()->add('success', 'The link was successfully removed.');
    // Redirect to admin home page
    return $app->redirect($app['url_generator']->generate('admin'));
})->bind('admin_link_delete');