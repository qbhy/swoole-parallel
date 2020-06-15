<?php

declare(strict_types=1);
/**
 *  * This file is part of Hyperf.
 *  *
 *  * @link     https://www.hyperf.io
 *  * @document https://doc.hyperf.io
 *  * @contact  group@hyperf.io
 *  * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

require __DIR__.'/../vendor/autoload.php';

\Swoole\Coroutine::create(function () {
    $time = time();
    $parallel = new \Qbhy\SwooleParallel\Parallel(20);

//    $parallel->setCaller(function ($callback) {
//        return app()->call($callback); // laravel 内可以这样实现协程内依赖注入
//    });

    for ($i = 0; $i < 5; ++$i) {
        $parallel->add(function () use ($i) {
            \Swoole\Coroutine::sleep(1);
            return $i;
        });
    }

    $results = $parallel->wait();
    $diff = time() - $time;
    var_dump($results);
    print_r("运行了:{$diff}秒");
});
