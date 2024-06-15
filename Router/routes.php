<?php

$routes = [
    /* category routes */
    'GET /categories' => [
        'controller' => 'CategoryController',
        'action' => 'index',
    ],
    'GET /categories/:id' => [
        'controller' => 'CategoryController',
        'action' => 'show',
    ],
    'POST /categories' => [
        'controller' => 'CategoryController',
        'action' => 'create',
    ],
    'PUT /categories/:id' => [
        'controller' => 'CategoryController',
        'action' => 'update',
    ],
    'DELETE /categories/:id' => [
        'controller' => 'CategoryController',
        'action' => 'delete',
    ],
    /* income routes */
    'GET /incomes' => [
        'controller' => 'IncomeController',
        'action' => 'index',
    ],
    'GET /incomes/:id' => [
        'controller' => 'IncomeController',
        'action' => 'show',
    ],
    'POST /incomes' => [
        'controller' => 'IncomeController',
        'action' => 'create',
    ],
    'PUT /incomes/:id' => [
        'controller' => 'IncomeController',
        'action' => 'update',
    ],
    'DELETE /incomes/:id' => [
        'controller' => 'IncomeController',
        'action' => 'delete',
    ],
    /* outcomes */
    'GET /outcomes' => [
        'controller' => 'OutcomeController',
        'action' => 'index',
    ],
    'GET /outcomes/:id' => [
        'controller' => 'OutcomeController',
        'action' => 'show',
    ],
    'POST /outcomes' => [
        'controller' => 'OutcomeController',
        'action' => 'create',
    ],
    'PUT /outcomes/:id' => [
        'controller' => 'OutcomeController',
        'action' => 'update',
    ],
    'DELETE /outcomes/:id' => [
        'controller' => 'OutcomeController',
        'action' => 'delete',
    ],
    /* user routes */
    'GET /users/:id' => [
        'controller' => 'UserController',
        'action' => 'show',
    ],
    'POST /users' => [
        'controller' => 'UserController',
        'action' => 'create',
    ],
    'PUT /users/:id' => [
        'controller' => 'UserController',
        'action' => 'update',
    ],
    'DELETE /users/:id' => [
        'controller' => 'UserController',
        'action' => 'delete',
    ],
    /* auth */
    'POST /auth' =>[
        'controller' => 'AuthController',
        'action' => 'login', 
    ],
    'PUT /auth' =>[
        'controller' => 'AuthController',
        'action' => 'logout', 
    ]

];
