<?php

/* @var $this yii\web\View */

$this->title = '医疗销售系统';

?>
<div class="row">
  <div class="col-lg-10 col-lg-offset-1">
    <table class="table table-striped">
      <caption>药品目录</caption>
      <thead>
        <tr>
          <th>药品名称</th>
          <th>生产厂家</th>
          <th>数量</th>
          <th>所在仓库</th>
          <th>默认价格</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $product): ?>
          <tr>
            <td><?php echo $product->product_name; ?></td>
            <td><?php echo $product->getManufacturer()->one()->manufacturer_name; ?></td>
            <td><?php echo $product->product_num; ?></td>
            <td><?php echo $product->getRepository()->one()->repository_name; ?></td>
            <td><?php echo $product->product_default_price; ?></td>
          </tr>
        <?php endforeach; ?>

        <tr>
          <td>后悔药</td>
          <td>梦工厂</td>
          <td>1</td>
          <td>天庭</td>
          <td>10000</td>
        </tr>
        <tr>
          <td>后悔药</td>
          <td>梦工厂</td>
          <td>1</td>
          <td>天庭</td>
          <td>10000</td>
        </tr>
        <tr>
          <td>后悔药</td>
          <td>梦工厂</td>
          <td>1</td>
          <td>天庭</td>
          <td>10000</td>
        </tr>
        <tr>
          <td>后悔药</td>
          <td>梦工厂</td>
          <td>1</td>
          <td>天庭</td>
          <td>10000</td>
        </tr>
      </tbody>
    </table>
    <span>
      <input type="button" name="add" value="添加药品" class="btn btn-primary pull-right">
    </span>
  </div>
</div>
