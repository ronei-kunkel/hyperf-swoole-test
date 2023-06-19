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
use App\Infra\Http\Controller\IndexController;

Router::get('[/]', [IndexController::class, 'index']);

Router::get('/parallel[/[{sleepSequence:[0-5][/]?}]]', [IndexController::class, 'parallel']);
Router::get('/sequential[/[{sleepSequence:[0-5][/]?}]]', [IndexController::class, 'sequential']);
