<?php

require 'Product.php';

$routes = [
    'GET' => [],
    'POST' => [],
    'PUT' => [],
    'DELETE' => []
];

function addRoute($method, $path, $callback)
{
    global $routes;
    $routes[$method][$path] = $callback;
}

function getRequestMethod()
{
    return $_SERVER['REQUEST_METHOD'];
}

function getRequestPath()
{
    $path = $_SERVER['REQUEST_URI'];
    $path = parse_url($path, PHP_URL_PATH);
    return rtrim($path, '/');
}

function handleRequest()
{
    global $routes;

    $method = getRequestMethod();
    $path = getRequestPath();

    if (isset($routes[$method])) {
        foreach ($routes[$method] as $routePath => $callback) {
            if (preg_match('#^' . $routePath . '$#', $path, $matches)) {
                call_user_func_array($callback, $matches);
                return;
            }
        }
    }

    http_response_code(404);
    echo "404 Not Found";
}

addRoute('GET', '/products/(\d+)', function ($input) {

    $parts = explode('/', $input);
    $id = end($parts);
    try {
        $product = Product::Find($id);
        if ($product) {
            $data = [
                "type" => "products",
                "id" => $product->getId(),
                "attributes" => [
                    "nome" => $product->getNome(),
                    "prezzo" => $product->getPrezzo(),
                    "marca" => $product->getMarca(),
                ]
            ];
            $response = ['data' => $data];
            header("Location: /products/" . $product->getId());
            header("HTTP/1.1 200 OK");
            header("Content-Type: application/vnd.api+json");
            echo json_encode($response, JSON_PRETTY_PRINT);
        } else {
            header("HTTP/1.1 404 Not Found");
            header("Content-Type: application/vnd.api+json");
            http_response_code(404);
        }
    } catch (PDOException $exception) {
        header("HTTP/1.1 500 Internal Server Error");
        header("Content-Type: application/vnd.api+json");
        http_response_code(500);
        die($exception->getMessage());
    }
});


addRoute('GET', '/products', function () {

    try {
        $products = Product::FetchAll();
        if ($products) {
            $data = [];
            foreach ($products as $product) {
                $data[] = [
                    "type" => "products",
                    "id" => $product->getId(),
                    "attributes" => [
                        "nome" => $product->getNome(),
                        "prezzo" => $product->getPrezzo(),
                        "marca" => $product->getMarca(),
                    ]
                ];
            }
            $response = ['data' => $data];
            header("Location: /products");
            header("HTTP/1.1 200 OK");
            header("Content-Type: application/vnd.api+json");
            echo json_encode($response, JSON_PRETTY_PRINT);
        } else {
            header("HTTP/1.1 404 Not Found");
            header("Content-Type: application/vnd.api+json");
            http_response_code(404);
        }
    } catch (PDOException $exception) {
        header("HTTP/1.1 500 Internal Server Error");
        header("Content-Type: application/vnd.api+json");
        http_response_code(500);
        die($exception->getMessage());
    }
});
addRoute('POST', '/products', function () {


    if (isset($_POST['data']))
        $body = $_POST;
    else
        $body = json_decode(file_get_contents("php://input"), true);
    try {
        $product = Product::Create($body['data']['attributes']);
        $data = [
            "type" => "products",
            "id" => $product->getId(),
            "attributes" => [
                "nome" => $product->getNome(),
                "prezzo" => $product->getPrezzo(),
                "marca" => $product->getMarca(),
            ]
        ];

        $response = ['data' => $data];
        header("Location: /products/" . $product->getId());
        header("HTTP/1.1 201 CREATED");
        header("Content-Type: application/vnd.api+json");
        echo json_encode($response, JSON_PRETTY_PRINT);
    } catch (PDOException $exception) {
        header("HTTP/1.1 500 Internal Server Error");
        header("Content-Type: application/vnd.api+json");
        http_response_code(500);
        die($exception->getMessage());
    }
});
addRoute('PATCH', '/products/(\d+)', function ($input) {

    $parts = explode('/', $input);
    $id = end($parts);
    $product = Product::Find($id);
    if (!$product) {
        header("HTTP/1.1 400 Bad Request");
        header("Content-Type: application/vnd.api+json");
        http_response_code(400);
    } else {
        $body_row = json_decode(file_get_contents("php://input"), true);

        try {
            $body = $body_row['data']['attributes'];
            $product = $product->Update($body);
            $data = [
                "type" => "products",
                "id" => $product->getId(),
                "attributes" => [
                    "nome" => $product->getNome(),
                    "prezzo" => $product->getPrezzo(),
                    "marca" => $product->getMarca(),
                ]
            ];

            $response = ['data' => $data];
            header("Location: /products/" . $product->getId());
            header("HTTP/1.1 200 OK");
            header("Content-Type: application/vnd.api+json");
            echo json_encode($response, JSON_PRETTY_PRINT);
        } catch (PDOException $exception) {
            header("HTTP/1.1 500 Internal Server Error");
            header("Content-Type: application/vnd.api+json");
            http_response_code(500);
            die($exception->getMessage());
        }
    }
});
addRoute('DELETE', '/products/(\d+)', function ($input) {
    $parts = explode('/', $input);
    $id = end($parts);
    try {
        $product = Product::Find($id);
        if ($product) {
            $product->Delete();
            header("Location: /products/" . $id);
            header("HTTP/1.1 204 NO CONTENT");
            header("Content-Type: application/vnd.api+json");
        } else {
            header("HTTP/1.1 404 Not Found");
            header("Content-Type: application/vnd.api+json");
            http_response_code(404);
        }
    } catch (PDOException $exception) {
        header("HTTP/1.1 500 Internal Server Error");
        header("Content-Type: application/vnd.api+json");
        http_response_code(500);
        die($exception->getMessage());
    }
});

handleRequest();