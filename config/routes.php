<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;
use App\Controller\IndexController;

Router::addGroup('/parallel', function () {
    Router::get('[{sequence}]', [IndexController::class, 'parallel']);
    Router::get('/[{sequence}]', [IndexController::class, 'parallel']);
});
Router::addGroup('/sequential', function () {
  Router::get('[{sequence}]', [IndexController::class, 'sequential'], ['opa'=>1]);
  Router::get('/[{sequence}]', [IndexController::class, 'sequential']);
});