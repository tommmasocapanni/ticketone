<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// La variabile name assumerà il valore della rotta
// dinamica in fase di richiesta.
// Ad esempio: se Jack farà richiesta per http://localhost:8000/greetings/andrea
// name varrà andrea.
$router->get('/greetings/{name}', function ($name) {
    return "Hello $name!";
});

// I metodi HTTP disponibili sono diversi
// noi utilizzeremo solo questi quattro

// GET -> per recuperare leggere una risorsa
// POST -> Per scrivere/creare una risorsa
// PUT -> per modificare una risorsa
// DELETE -> per eliminare una risorsa


