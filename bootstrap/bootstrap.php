<?php
//Disable for fix session locking
//session_start();
define('APP_START', microtime(true));

defined('ROOT') OR define('ROOT', realpath(dirname(__FILE__) . '/../'));

require_once ROOT . '/vendor/autoload.php';

$app = new \VatGia\Application();

$app->bind('notFoundHandler', function () {
    return function ($e) {
        throw $e;
    };
});

$app->bind('methodNotAllowHandler', function () {
    return function ($e) {
        throw $e;
    };
});

$app->bind('errorHandler', function () {
    return function ($e) {
        throw $e;
    };
});

$app->bind('phpErrorHandler', function () {
    return function ($e) {
        throw $e;
    };
});

$app->bind('shutdown', function () use ($app) {
    return function () use ($app) {
        //Đóng tất cả kết nối tại đây
        if (db_init::$links) {
            foreach (db_init::$links as &$link) {
                @mysqli_close($link);
            }
        }

        //Hiển thị debug bar
        if (
            config('app.debugbar')
            && config('app.debug')
            && !$app->runningInConsole()
            && !defined('IS_API_CALL')
        ) {
            echo view('debug/debug_bar')->render();
        }
    };
});

/**
 * Shutdown function
 */
register_shutdown_function(app('shutdown'));

$app->bind(\AppView\Repository\PostRepositoryInterface::class, \AppView\Repository\PostRepository::class);
$app->boot();

