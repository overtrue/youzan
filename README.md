<h1 align="center"> Youzan</h1>

<p align="center">Youzan API client.</p>

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

## License

MIT