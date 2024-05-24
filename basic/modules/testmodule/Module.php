<?php

namespace app\modules\testmodule;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class Module extends yii\base\Module
{

    public $defaultController = 'app\modules\testmodule\controllers\TestModule';
    
    public function init()
    {
        parent::init();
    }
}