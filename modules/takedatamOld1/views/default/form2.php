<?php

use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
use yii\helpers\Html;
use app\modules\takedatam\assets\AppAsset;
AppAsset::register($this);
//$this->registerJsFile('//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
$this->registerJsFile('//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
$this->registerJsFile('@modulestakedatamscript/form2.js');
$this->registerCssFile('@modulestakedatamcss/form2.css');

?>
<h4><b>Сведения о каждом учредителе образовательной организации</h4>
<div class="row" id="no">
    <div class="col-sm-3 hightrow"><b>Наименование учредителя образовательной организации</b></div>
    <div class="col-sm-2 hightrow"><b>Юридический адрес учредителя</b></div>
    <div class="col-sm-2 hightrow"><b>Контактный телефон учредителя</b></div>
    <div class="col-sm-3 hightrow"><b>Адрес электронной почты учредителя</b></div>
    <div class="col-sm-2 hightrow"><b>Адрес сайта учредителя в сети &laquo;Интернет&raquo;</b></div>
</div>
<?php $form = ActiveForm::begin(); ?>
<?php echo Html::hiddenInput(\Yii::$app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(), []) ?>
    <?= $form->field($model, 'variable') ?>
    <?= $form->field($model, 'datafilds')?>
    <?= $form->field($model, 'namefildsforms')?>
    <?= Html::submitButton('OK') ?>
<?php ActiveForm::end(); ?>
<?php 
$js = <<<JS
    $('form').on('submit', function(){ 
        var data = $(this).serialize(); 

        $.ajax({ 
            url: '/takedatam/default/form2', 
            type: 'POST', 
            data: data, 
            success: function(){ 
            alert('Success!'); 
            }, 
            error: function(){ 
                alert('Error!'); 
            } 
        }); 
        return false; 
    }); 
JS; 
$this->registerJs($js); 
?>