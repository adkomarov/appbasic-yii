<?php
/*
 * Файл assets/AppAsset.php
 */
namespace app\modules\specialsection\assets;
use yii\web\AssetBundle;
use yii\web\View;

class AppAsset extends AssetBundle
{
    public $sourcePath='@module_specialsection_root_public';
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style.css'
    ];  
    public $js = [
        //'/js/form2.js'
    ];
    public $jsOptions = [
        // скрипты будут подключены в <head>
        'position' => View::POS_HEAD
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}