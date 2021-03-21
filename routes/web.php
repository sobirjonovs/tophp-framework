<?php

use App\Controllers\HomeController;

$route->get('/', [HomeController::class, 'index']);

$route->get('user/:id/slug/:slug', function($id, $slug) {
    return view('welcome', compact('id', 'slug'));
});

$route->get('home', function() {
    return view('welcome');
});