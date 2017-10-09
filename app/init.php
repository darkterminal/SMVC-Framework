<?php
// Require composer autoloader
require_once '../vendor/autoload.php';
require '../vendor/illuminate/support/helpers.php';

require_once 'database.php';
require_once 'core/app.php';
require_once 'core/controller.php';

$basePath = str_finish(dirname(__FILE__), '/');
$controllersDirectory = $basePath . 'controllers';
$modelsDirectory = $basePath . 'models';
$viewsDirectory = $basePath . 'models';

Illuminate\Support\ClassLoader::register();
Illuminate\Support\ClassLoader::addDirectories(array($controllersDirectory, $modelsDirectory, $viewsDirectory));

$app = new Illuminate\Container\Container;
Illuminate\Support\Facades\Facade::setFacadeApplication($app);

$app['app'] = $app;
$app['env'] = 'production';

with(new Illuminate\Events\EventServiceProvider($app))->register();
with(new Illuminate\Routing\RoutingServiceProvider($app))->register();

require $basePath . 'routes.php';

$request = Illuminate\Http\Request::createFromGlobals();
$response = $app['router']->dispatch($request);

$response->send();