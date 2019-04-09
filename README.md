<h1 align="center"> Youzan</h1>

<p align="center">Youzan API client.</p>

> 🚧警告！此 SDK 目前仅支持自用型应用，不支持其它类型的应用接入。
> 由于有赞的不人道的 996 策略，以及在没有通知用户的情况下关闭了个人收款渠道，现决定不再维护他们家任何相关 SDK，谢谢！

## Installing

```shell
$ composer require overtrue/youzan -vvv
```

## Usage

```php

use Overtrue\Youzan\Client;

$clientId = '0a24a9a466xxxxxxx';
$clientSecret = 'eeb65cce4e1adf251306dxxxxxxxx';
$storeId = 40050388;

$client = new Client($clientId, $clientSecret, $storeId);

$response = $client->get('youzan.pay.qrcodes.get', ['page_size' => 1, 'page_no' => 1]);

// or 

$response = $client->post('youzan.pay.xxxx.xxx', ['xxx' => 'xxx']);
```

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/overtrue/youzan/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/overtrue/youzan/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## PHP 扩展包开发

> 想知道如何从零开始构建 PHP 扩展包？
>
> 请关注我的实战课程，我会在此课程中分享一些扩展开发经验 —— [《PHP 扩展包实战教程 - 从入门到发布》](https://learnku.com/courses/creating-package)


## License

MIT
