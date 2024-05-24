<?php


namespace app\modules\testmodule\controllers;

use yii\web\Controller;


class TaskController extends Controller{

        
    public function actionIndex(){
        var_dump('Task list index');

    }

    public function actionEdit(){
        var_dump('Edit Task');

    }
}