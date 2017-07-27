<?php

$vendor = __DIR__ . '/../vendor';
require_once ($vendor . '/autoload.php');
require_once ($vendor . '/yiisoft/yii2/Yii.php');

use yii\console\Application;

// Initializes a Yii2 console application and assigns it to Yii::$app.
new Application(['id' => 'testing-app', 'basePath' => dirname(__DIR__)]);
