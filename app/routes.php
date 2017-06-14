<?php

use Symfony\Component\HttpFoundation\Request;
use WebLinks\Domain\Link;
use WebLinks\Form\Type\LinkType;
use WebLinks\Domain\User;
use WebLinks\form\Type\UserType;

    // Home page
$app->get('/', "WebLinks\Controller\HomeController::indexAction")
    ->bind('home');

    // Login Form
$app->get("/login", "WebLinks\Controller\HomeController::loginAction" )
    ->bind('login');

    // Admin home page
$app->get('/admin', "WebLinks\Controller\AdminController::indexAction")
    ->bind('admin');

    // Add a new link
$app->match('/admin/link/add', "WebLinks\Controller\AdminController::addLinkAction")
    ->bind('admin_link_add');

    // Edit an existing link
$app->match('/admin/link/{id}/edit', "WebLinks\Controller\AdminController::editLinkAction")
    ->bind('admin_link_edit');

    // Delete a link
$app->get('/admin/link/{id}/delete', "WebLinks\Controller\AdminController::deleteLinkAction")
    ->bind('admin_link_delete');

    // Add a user
$app->match('/admin/user/add', "WebLinks\Controller\AdminController::addUserAction")
    ->bind('admin_user_add');

    // Edit an existing user
$app->match('/admin/user/{id}/edit', "WebLinks\Controller\AdminController::editUserAction")->bind('admin_user_edit');

    // Remove a user
$app->get('/admin/user/{id}/delete', "WebLinks\Controller\AdminController::deleteUserAction")
    ->bind('admin_user_delete');

/************************************************************************\
 *                CONTROLLER DE L'API DE CONSULTATION                   *
\***********************************************************************/
    // API : get all links
$app->get('/api/links', "WebLinks\Controller\ApiController::getLinksAction")
    ->bind('api_links');

    // API : get an link with details
$app->get('/api/link/{id}', "WebLinks\Controller\ApiController::getLinkAction")
    ->bind('api_link');