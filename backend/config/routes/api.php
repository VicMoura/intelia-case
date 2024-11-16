<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

// Inicializando a coleção de rotas
$routes = new RouteCollection();


// Adicionando as rotas com prefixo
$routes->add('api_user_create', new Route('/user', [
    '_controller' => 'App\Controller\UserController::create',
], ['methods' => 'GET'])); 

// Adicionando outra rota
$routes->add('api_user_update', new Route('/user/{id}', [
    '_controller' => 'App\Controller\UserController::update',
], ['methods' => 'PUT']));


// Adicionando as rotas com prefixo
$routes->add('api_address_create', new Route('/address', [
    '_controller' => 'App\Controller\AddressController::create',
], ['methods' => 'GET'])); 

// Adicionando outra rota
$routes->add('api_address_update', new Route('/address/{id}', [
    '_controller' => 'App\Controller\AddressController::update',
], ['methods' => 'PUT']));


// Adicionando as rotas com prefixo
$routes->add('api_phone_create', new Route('/phone', [
    '_controller' => 'App\Controller\PhonesController::create',
], ['methods' => 'GET'])); 

// Adicionando outra rota
$routes->add('api_phone_update', new Route('/phone/{id}', [
    '_controller' => 'App\Controller\PhonesController::update',
], ['methods' => 'PUT']));

$routes->add('api_user_show', new Route('/user/{id}', [
    '_controller' => 'App\Controller\UserController::show',
], ['methods' => 'GET'])); 

return $routes;
