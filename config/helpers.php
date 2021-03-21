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

function view(string $view, array $data = [])
{
   $viewer = dependencyInjector()->get('View');
   return $viewer->render($view, $data);
}