<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use Vwork\Web\AppBuilder;
use Vwork\Web\Router\RouterTypes;

// When running via PHP's built-in web server (php -S), return false for existing static files
if (PHP_SAPI === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    if ($path !== false && is_file(__DIR__ . $path)) {
        return false;
    }
}

$builder = new AppBuilder();

$builder
    ->withRouter(RouterTypes::Trie)
    ->addServices([
        ... require __DIR__ . '/../config/services/utils.php',
        ... require __DIR__ . '/../config/services/controllers.php'
    ])
    ->addRoutes([
        ... require __DIR__ . '/../config/routes/dummy.php',
        ... require __DIR__ . '/../config/routes/customer.php'
    ]);

if ($_SERVER['FRANKENPHP_WORKER'] ?? false) {
    $app = $builder->build();
    while (frankenphp_handle_request($app)) {
        gc_collect_cycles();
    }
} else {
    $app = $builder
        ->withoutSecure()
        ->build();
    $app();
}
