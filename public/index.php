<?php 
require_once __DIR__ . '/../includes/app.php';


use Controllers\ProductoController;
use MVC\Router;
use Controllers\AppController;
$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);


$router->get('/', [AppController::class,'index']);

$router->get('/productos', [ProductoController::class, 'renderizarPagina']);
$router->post('/productos/guardarAPI', [ProductoController::class, 'guardarAPI']);
$router->get('/productos/buscarAPI', [ProductoController::class, 'buscarAPI']);
$router->post('/productos/modificarAPI', [ProductoController::class, 'modificarAPI']);
$router->post('/productos/eliminarAPI', [ProductoController::class, 'eliminarAPI']);
$router->post('/productos/cambiarEstadoAPI', [ProductoController::class, 'cambiarEstadoAPI']);
$router->get('/productos/obtenerSeleccionesAPI', [ProductoController::class, 'obtenerSeleccionesAPI']);

$router->comprobarRutas();