<?php

define('YII_ENV', 'test');
defined('YII_DEBUG') or define('YII_DEBUG', true);

require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ .'/../vendor/autoload.php';
/*
define('YII_ENV', 'test');
defined('YII_DEBUG') or define('YII_DEBUG', true);

require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ .'/../vendor/autoload.php';

$config = require '/work/sites/yiiprojects/appbasic/basic/config/test.php';
new yii\web\Application($config);
*/
/*
<?php

// Ensure that we use the correct environment
defined('YII_ENV') or define('YII_ENV', 'test');
defined('YII_DEBUG') or define('YII_DEBUG', true);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/test.php';
new yii\web\Application($config);
*/