<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require_once 'genericDAO.php';

$app = new \Slim\App;
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

$app->get('/table/{table}', function (Request $request, Response $response) {
    $table = $request->getAttribute('table');
    return GenericDAO::getAll($table);
});

$app->post('/table/{table}/insert', function (Request $request, Response $response,$args) {
    $table = $request->getAttribute('table');
    $params = $request->getParams();
    GenericDAO::insert($table,$params);
    return $response;
});

$app->delete('/table/{table}/delete/{id}', function (Request $request, Response $response) {
    $table = $request->getAttribute('table');
    $id = $request->getAttribute('id');
    GenericDAO::delete($table, $id);
    return $response;
});

$app->put('/table/{table}/update', function (Request $request, Response $response) {
    $table = $request->getAttribute('table');
    $params = $request->getParams();
    GenericDAO::update($table,$params);
    return $response;
});

$app->run();

?>