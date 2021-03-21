#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

$container = dependencyInjector($argv);
$kernel = $container->get('Kernel');
$kernel->setArgument($argv);
$kernel->load();
?>

