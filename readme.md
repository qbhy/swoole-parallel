## swoole-parallel
可以并行执行协程的库，摘自 hyperf/utils 由于hyperf/utils 的 parallel 只能在 hyperf 框架下面使用，所以有了这个项目。

## 安装 - install
```bash
$ composer require qbhy/swoole-parallel
```

## 使用 - usage
```php

require __DIR__ . 'vendor/autoload.php';

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
```
运行结果
```
array(5) {
  [0]=>
  int(0)
  [4]=>
  int(4)
  [3]=>
  int(3)
  [2]=>
  int(2)
  [1]=>
  int(1)
}
运行了:1秒
```
> 请务必在协程环境下使用

qbhy0715@qq.com