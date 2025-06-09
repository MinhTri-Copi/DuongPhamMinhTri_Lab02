<?php
session_start();
require_once 'app/models/ProductModel.php';
require_once 'app/helpers/SessionHelper.php';
require_once 'app/controllers/ProductApiController.php';
require_once 'app/controllers/CategoryApiController.php';
// Start session
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);
// Kiểm tra phần đầu tiên của URL để xác định controller
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 
'DefaultController';
// Kiểm tra phần thứ hai của URL để xác định action
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';
// Định tuyến các yêu cầu API
if (strpos($controllerName, 'ApiController') !== false || isset($url[1]) && strpos($url[1], 'Api') !== false) {
    $apiControllerName = $controllerName;
    
    // Nếu URL có dạng /ProductApi/... thì $url[0] là ProductApi
    if (strpos($url[0], 'Api') !== false) {
        $apiControllerName = $url[0] . 'Controller';
        $id = $url[2] ?? null;
        $action = $url[1] ?? 'index';
    } else {
        // Nếu URL có dạng /Api/Product/... thì $url[1] là Product
        $apiControllerName = ucfirst($url[1]) . 'ApiController';
        $id = $url[2] ?? null;
        $action = isset($url[3]) ? $url[3] : null;
    }
    
    if (file_exists('app/controllers/' . $apiControllerName . '.php')) {
        require_once 'app/controllers/' . $apiControllerName . '.php';
        $controller = new $apiControllerName();
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Xác định action dựa trên HTTP method
        switch ($method) {
            case 'GET':
                if ($action == 'show' || is_numeric($action)) {
                    $controller->show($action);
                } else {
                    $controller->index();
                }
                break;
                
            case 'POST':
                if ($action == 'store') {
                    $controller->store();
                } else {
                    $controller->index();
                }
                break;
                
            case 'PUT':
                if ($action == 'update' && $id) {
                    $controller->update($id);
                } else if (is_numeric($action)) {
                    $controller->update($action);
                } else {
                    http_response_code(400);
                    echo json_encode(['message' => 'Missing ID for update']);
                }
                break;
                
            case 'DELETE':
                if ($action == 'delete' && $id) {
                    $controller->delete($id);
                } else if (is_numeric($action)) {
                    $controller->delete($action);
                } else {
                    http_response_code(400);
                    echo json_encode(['message' => 'Missing ID for delete']);
                }
                break;
                
            default:
                http_response_code(405);
                echo json_encode(['message' => 'Method Not Allowed']);
                exit;
        }
        exit;
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'API Controller not found: ' . $apiControllerName]);
        exit;
    }
}
// Tạo đối tượng controller tương ứng cho các yêu cầu không phải API
if (file_exists('app/controllers/' . $controllerName . '.php')) {
require_once 'app/controllers/' . $controllerName . '.php';
$controller = new $controllerName();
} else {
die('Controller not found');
}
// Kiểm tra và gọi action
if (method_exists($controller, $action)) {
call_user_func_array([$controller, $action], array_slice($url, 2));
} else {
die('Action not found');
}
?>