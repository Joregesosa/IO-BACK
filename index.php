<?php

require_once  $_SERVER['DOCUMENT_ROOT'] . '/Vendor/autoload.php';
require_once  $_SERVER['DOCUMENT_ROOT'] . '/Router/routes.php';

$requestUri = $_SERVER['REQUEST_URI'];
$json = file_get_contents('php://input');
$json_data = json_decode($json, true);
$request['data'] = $json_data;
$basePath = '/index.php';
$routeName = str_replace($basePath, '', $requestUri);
$controller_path = $routeName == '/auth'? './App/Controllers/Auth/' : './App/Controllers/';
$trimmedUri = $_SERVER['REQUEST_METHOD'] . ' ' . $routeName;
$matchedRoute = null;

header('Content-Type: application/json');

foreach ($routes as $url => $route) {
    $pattern = str_replace('/:id', '/(\d+)', $url);
    if ($trimmedUri === $url || preg_match("#^$pattern$#", $trimmedUri, $matches)) {
        $matchedRoute = $route;
        if (isset($matches[1])) {
            $request['id'] = $matches[1] ?? '';
        }
        break;
    }
}
 
if ($matchedRoute) {
    $controllerName = $matchedRoute['controller'];
    $actionName = $matchedRoute['action'];

    try {
        require_once  $controller_path . $controllerName . '.php';

        $controller = new $controllerName();
        $controller->$actionName($request);
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
        error_log("Error handling request: $errorMessage");

        $response = [
            'status' => 'error',
            'message' => $errorMessage,
        ];


        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit;
    }
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode([
        'status' => 'error',
        'message' => 'Route not found',
    ]);
    exit;
}
