<?php

/* @var $this yii\web\View */
/* @var $dispatchs app\models\Dispatch */
/* @var $product app\models\DispatchDetail */

$this->title = '调度订单';

?>
<style media="screen">
  .adddispatch{
    margin: 10px;
  }
</style>
<div class="row">
  <div class="col-lg-10 col-lg-offset-1">
    <?php foreach ($dispatchs as $dispatch): ?>
    <?php $products = $dispatch['detail'] ?>
    <table class="table table-striped well">
      <caption>
        <?= '调度订单编号: '.$dispatch['order']->dispatch_id; ?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        <?= '目标仓库:'.$dispatch['order']->getRepositoryTo()->one()->repository_name;?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        <?php
          if ($dispatch['order']->dispatch_status == 0) {
              echo '状态: 未完成';
          } elseif ($dispatch['order']->dispatch_status == 1) {
              echo '状态: ✅';
          }
          ?>
      </caption>
      <thead>
        <tr>
          <th>药品名称</th>
          <th>生产厂家</th>
          <th>原始仓库</th>
          <th>数量</th>
          <th>默认单价</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $product): ?>
          <tr>
            <td><?= $product->getProduct()->one()->product_name;  ?></td>
            <td><?= $product->getProduct()->one()->getManufacturer()->one()->manufacturer_name;  ?></td>
            <td><?= $product->getProduct()->one()->getRepository()->one()->repository_name; ?></td>
            <td><?= $product->product_num;  ?></td>
            <td><?= $product->getProduct()->one()->product_default_price;  ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endforeach; ?>
    <span>
      <a href="?r=site/adddispatch"><span class="btn btn-primary pull-right adddispatch">增加采购订单</span></a>
    </span>
  </div>
</div>
