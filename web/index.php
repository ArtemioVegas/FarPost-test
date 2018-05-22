<?php
use Artemio\services\DatabaseConnect;
use Artemio\services\ModelFactory;
use Artemio\services\Router;
use League\Plates\Engine;

require_once '../vendor/autoload.php';

define('APP_PATH', __DIR__ . '/..');
define('UPLOAD_PATH', APP_PATH . '/web/uploads');

session_start();

$routes   = include '../config/routes.php';
$database = include '../config/database.php';

$template_engine = new Engine(APP_PATH . '/resources/views');
$databaseConnect = DatabaseConnect::getInstance($database);

$modelFactory = ModelFactory::getInstance($databaseConnect);

$router = new Router($routes);
$content = $router->dispatch($template_engine, $modelFactory);

print $content;