<?php
/*
 * Файл assets/AppAsset.php
 */

namespace app\modules\takedatam\assets;
use yii\web\AssetBundle;
use yii\web\View;

class AppAsset extends AssetBundle
{
    //public $sourcePath = '@modulestakedatamroot';
    public $sourcePath="@app/modules/takedatam/public/";
    public $basePath = '@webroot/assets';
    public $baseUrl = '@web/assets';
    public $css = [
    ];
    public $js = [
    ];
    public $jsOptions = [
        // скрипты будут подключены в <head>
        'position' => View::POS_HEAD
    ];
    
    //public $cssOptions = [
    //    // скрипты будут подключены в <head>
    //    'position' => View::POS_HEAD
    //];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}

/*
namespace app\modules\takedatam\assets;

use yii\web\AssetBundle;
use Yii;

class AppAsset extends AssetBundle
{
    public $sourcePath="/work/sites/yiiprojects/appbasic/basic/modules/takedatam/public/";
    public $basePath = '@webroot/assets';
    public $baseUrl = '@web/assets';
    public $css = [];
    public $js = [];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD,
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];

    public function init()
    {
        parent::init();

        // Добавляем CSS файлы
        $this->css = $this->getFilesFromDirectory(Yii::getAlias($this->sourcePath . '/css'), 'css');

        // Добавляем JS файлы
        $this->js = $this->getFilesFromDirectory(Yii::getAlias($this->sourcePath . '/js'), 'js');
    }

    
    private function getFilesFromDirectory($directory, $extension)
    {
        $files = [];
        if (is_dir($directory)) {
            foreach (scandir($directory) as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === $extension) {
                    $files[] = ($extension == 'css' ? 'css/' : 'js/') . $file;
                }
            }
        }
        return $files;
    }
}
*/
/*
namespace app\modules\takedatam\assets;

use yii\web\AssetBundle;
use Yii;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/takedatam/public';
    //public $basePath = '@webroot/assets';
    //public $baseUrl = '@web/assets';
    public $css = [];
    public $js = [];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD,
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];

    public function init()
    {
        parent::init();

        // Добавляем CSS файлы
        $this->css = $this->getFilesFromDirectory(Yii::getAlias($this->sourcePath . '/css'), 'css');

        // Добавляем JS файлы
        $this->js = $this->getFilesFromDirectory(Yii::getAlias($this->sourcePath . '/js'), 'js');
    }

    
    private function getFilesFromDirectory($directory, $extension)
    {
        $files = [];
        $filePattern = $directory . '/*.' . $extension;
        foreach (glob($filePattern) as $filePath) {
            $files[] = $extension . '/' . basename($filePath);
        }
        return $files;
    }
}
*/















/*<?php

namespace app\modules\takedatam\assets;
use yii\web\AssetBundle;
use yii\web\View;

class AppAsset extends AssetBundle
{
    public $sourcePath="@modulestakedatamroot";
    public $basePath = '@webroot/assets';
    public $baseUrl = '@web/assets';
    public $css = [
        // 'css/site.css',
    ];  
    public $js = [
        // '/js/form2.js'
    ];
    public $jsOptions = [
        // скрипты будут подключены в <head>
        'position' => View::POS_HEAD
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}*/