<?php

declare(strict_types=1);

// When running via PHP's built-in web server (php -S), return false for existing static files
if (PHP_SAPI === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    if ($path !== false && is_file(__DIR__ . $path)) {
        return false;
    }
}

require __DIR__ . '/../../vendor/autoload.php';

use Vwork\Shared\Collections\IRegistry;
use Vwork\Web\Http\HttpMethods;
use Vwork\Web\Controllers\IController;
use Vwork\Web\Middleware\IMiddleware;
use Vwork\Web\AppBuilder;
use Vwork\Web\Router\RouterTypes;
use Vwork\Web\Utils\IUtility;

$builder = new AppBuilder();

/**
 * @var array<class-string<IUtility>, Closure(IRegistry): object>
 */
$utils = require __DIR__ . '/../config/services/utils.php';
$builder->addServices($utils);

/**
 * @var array<class-string<IController>, Closure(IRegistry): object>
 */
$controllers = require __DIR__ . '/../config/services/controllers.php';
$builder->addServices($controllers);

/**
 * @var list<array{
 *  method: HttpMethods,
 *  path: string,
 *  controller: array{
 *    class: class-string<IController>,
 *    method: string
 *  },
 *  middleware: list<class-string<IMiddleware>>,
 *  context: array<string, mixed>
 * }>
 */
// Routes:
$dummyRoutes = require __DIR__ . '/../config/routes/dummy.php';
$builder->addRoutes($dummyRoutes);

$customerRoutes = require __DIR__ . '/../config/routes/customer.php';
$builder->addRoutes($customerRoutes);


$builder->withRouter(RouterTypes::Trie);


if ($_SERVER['FRANKENPHP_WORKER'] ?? false) {
    // prod
    $app = $builder->build();
    while (frankenphp_handle_request($app)) {
        gc_collect_cycles();
    }
} else {
    // dev
    $app = $builder
        ->withoutSecure()
        ->build();
    $app();
}
