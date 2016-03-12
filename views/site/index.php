<?php

/* @var $this yii\web\View */

use app\assets\AppAsset;

$this->title = '医疗销售系统';

?>
<style media="screen">
   .addProduct{
     margin: 10px;
   }
</style>
<div class="row">
  <div class="col-lg-10 col-lg-offset-1">
    <table class="table table-striped" id="product">
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
      </tbody>
    </table>
    <span>
      <a href="?r=site/addproduct"><span class="btn btn-primary pull-right addProduct">添加药品</span></a>
    </span>
  </div>
</div>

<?php AppAsset::addJsFile($this, '/js/jquery.dataTables.min.js'); ?>
<?php AppAsset::addJsFile($this, '/js/index.js'); ?>
