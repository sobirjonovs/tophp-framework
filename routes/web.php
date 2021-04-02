<?php

use App\Controllers\HomeController;

// Default home page
$route->get('/', [HomeController::class, 'index']);

// Routing with wildcards
$route->get('user/:id', function($id) {
    return view('welcome', compact('id'));
});
