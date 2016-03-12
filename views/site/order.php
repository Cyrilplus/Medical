<?php

/* @var $this yii\web\View */
/* @var $orders app\models\Order */
/* @var $product app\models\OrderDetail */

$this->title = '销售订单';

?>
<style media="screen">
  .addOrder{
    margin: 10px;
  }
</style>
<div class="row">
  <div class="col-lg-10 col-lg-offset-1">
    <?php foreach ($orders as $order): ?>
    <?php $products = $order['detail'] ?>
    <table class="table table-striped well">
      <caption>
        <?= '订单编号: '.$order['order']->order_id; ?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        <?= '客户: '.$order['order']->getClient()->one()->client_name;?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        <?= '总价: '.$order['order']->order_total_money; ?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        <?php
          if ($order['order']->order_status == 0) {
              echo '状态: 未完成';
          } elseif ($order['order']->order_status == 1) {
              echo '状态: ✅';
          }
          ?>

      </caption>
      <thead>
        <tr>
          <th>药品名称</th>
          <th>生产厂家</th>
          <th>数量</th>
          <th>所在仓库</th>
          <th>默认单价</th>
          <th>总价</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $product): ?>
          <tr>
            <td><?= $product->getProduct()->one()->product_name;  ?></td>
            <td><?= $product->getProduct()->one()->getManufacturer()->one()->manufacturer_name;  ?></td>
            <td><?= $product->product_num;  ?></td>
            <td><?= $product->getProduct()->one()->getRepository()->one()->repository_name; ?></td>
            <td><?= $product->getProduct()->one()->product_default_price;  ?></td>
            <td><?= $product->order_detail_total_money;  ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endforeach; ?>
    <span>
      <a href="?r=site/addorder"><span class="btn btn-primary pull-right addOrder">增加销售订单</span></a>
    </span>
  </div>
</div>
