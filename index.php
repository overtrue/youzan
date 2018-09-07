<?php

/*
 * This file is part of the overtrue/youzan.
 *
 * (c) overtrue <anzhengchao@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

include __DIR__.'/vendor/autoload.php';

use Overtrue\Youzan\Client;

$client = new Client('0a24a9a466a98d98a2', 'eeb65cce4e1adf251306d44ad232d5ed', '40050399');

var_dump($client->get('youzan.pay.qrcodes.get', ['page_size' => 1, 'page_no' => 1]));
