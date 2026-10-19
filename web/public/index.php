<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use Vwork\Shared\Collections\IRegistry;
use Vwork\Shared\Types\Cast;
use Vwork\Web\Http\HttpMethods;
use Vwork\Web\Controllers\IController;
use Vwork\Web\Middleware\IMiddleware;
use Vwork\Web\AppBuilder;
use Vwork\Web\Router\RouterTypes;
use Vwork\Web\Utils\IUtility;

// When running via PHP's built-in web server (php -S), return false for existing static files
if (PHP_SAPI === 'cli-server') {
    $path = parse_url(Cast::string($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
    if ($path !== false && is_file(__DIR__ . $path)) {
        return false;
    }
}

$builder = new AppBuilder();

/** @var array<class-string<IUtility>, Closure(IRegistry): object> */
$utils = require __DIR__ . '/../config/services/utils.php';
$builder->addServices($utils);

/** @var array<class-string<IController>, Closure(IRegistry): object> */
$controllers = require __DIR__ . '/../config/services/controllers.php';
$builder->addServices($controllers);


$dummyRoutes = require __DIR__ . '/../config/routes/dummy.php';
// @phpstan-ignore argument.type
$builder->addRoutes($dummyRoutes);

$customerRoutes = require __DIR__ . '/../config/routes/customer.php';
// @phpstan-ignore argument.type
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
