<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\Models\AddProductForm */
/* @var $form ActiveForm */

$this->title = '添加药品';
?>
<div class="row">
  <div class="addProduct col-lg-8 col-lg-offset-2 well">
    <h4>添加药品</h4>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->label('药品名称') ?>
    <?= $form->field($model, 'manufacturer')->dropDownList($manufacturers)->label('生产厂家') ?>
    <?= $form->field($model, 'num')->label('数量') ?>
    <?= $form->field($model, 'repository')->dropDownList($repositories)->label('仓库') ?>
    <?= $form->field($model, 'defaultPrice')->label('默认价格') ?>
    <div class="form-group">
      <?= Html::submitButton('Submit', ['class' => 'btn btn-primary pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>

  </div>
  <!-- addProduct -->
</div>
