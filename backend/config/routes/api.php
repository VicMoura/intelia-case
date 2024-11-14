<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

// Inicializando a coleção de rotas
$routes = new RouteCollection();


// Adicionando as rotas com prefixo
$routes->add('api_user_create', new Route('/user/create', [
    '_controller' => 'App\Controller\UserController::create',
], ['methods' => 'GET'])); 

// Adicionando outra rota
$routes->add('api_user_update', new Route('/user/update', [
    '_controller' => 'App\Controller\UserController::update',
], ['methods' => 'PUT']));  


return $routes;
