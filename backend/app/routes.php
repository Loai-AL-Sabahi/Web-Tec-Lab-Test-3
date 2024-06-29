<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    // CORS Pre-Flight OPTIONS Request Handler
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    // Get all users
    $app->get('/users', function (Request $request, Response $response) {
        $users = [
            ['id' => 1, 'name' => 'Loai', 'email' => 'Loai@gmail.com'],
            ['id' => 2, 'name' => 'Ammar', 'email' => 'Ammar@gmail.com'],
        ];
        $response->getBody()->write(json_encode($users));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // Create a new user
    $app->post('/users', function (Request $request, Response $response) {
        $data = $request->getParsedBody();
        
        $newUser = ['id' => rand(3, 1000), 'name' => $data['name'], 'email' => $data['email']];
        $response->getBody()->write(json_encode($newUser));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // Update a user
    $app->put('/users/{id}', function (Request $request, Response $response, array $args) {
        $userId = $args['id'];
        $data = $request->getParsedBody();

        $updatedUser = ['id' => $userId, 'name' => $data['name'], 'email' => $data['email']];
        $response->getBody()->write(json_encode($updatedUser));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // Delete a user
    $app->delete('/users/{id}', function (Request $request, Response $response, array $args) {
        $userId = $args['id'];

        $response->getBody()->write(json_encode(['status' => 'User deleted', 'id' => $userId]));
        return $response->withHeader('Content-Type', 'application/json');
    });
};
