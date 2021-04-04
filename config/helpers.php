<?php

function includeCommands()
{
    return require __DIR__ . '/commands.php';
}

function getDatabase()
{
    return require __DIR__ . '/database.php';
}

function app()
{
    return dependencyInjector()->get('Application');
}

function request()
{
    return dependencyInjector()->get('request');
}

function view(string $view, array $data = [], $layout = 'app')
{
    $viewClass = dependencyInjector()->get('View');
    $viewClass->layout = $layout;
    try {
        return $viewClass->render($view, $data);
    } catch (Exception $exception) {
        die($exception->getMessage());
    }
}

function str_ends_with($needle, $string): bool
{
    if (substr($string, -1) === $needle) return true;
    return false;
}
