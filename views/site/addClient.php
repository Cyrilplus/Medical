<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;

/* @var $this yii\web\View */
/* @var $model app\models\AddClientForm */
/* @var $form ActiveForm */

$this->title = '添加客户'
?>
<div class="row addClient col-lg-8 col-lg-offset-2 well">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'name')->label('客户名') ?>
        <?= $form->field($model, 'contact')->label('联系人') ?>
        <?= $form->field($model, 'call')->label('联系电话') ?>
        <?= $form->field($model, 'regionProvince')->dropDownList($regionProvinces)->label('省份') ?>
        <?= $form->field($model, 'regionCity')->dropDownList([])->label('县级') ?>
        <?= $form->field($model, 'regionCountry')->dropDownList([])->label('市级') ?>
        <?= $form->field($model, 'detailAddress')->label('具体地址') ?>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- addClient -->

<?php AppAsset::addJsFile($this, '/js/add-client.js'); ?>
