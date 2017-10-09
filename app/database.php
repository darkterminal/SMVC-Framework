<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$caps = new Capsule();

$caps->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'website',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => ''
]);

$caps->bootEloquent();