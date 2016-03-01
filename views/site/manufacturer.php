<?php

/* @var $this yii\web\View */
/* @var $manufacturers app\Models\manufacturer*/

$this->title = '厂商';
?>
<div class="row">
  <div class="col-lg-10 col-lg-offset-1">
    <table class="table table-striped">
      <caption>生产厂商</caption>
      <thead>
        <tr>
          <th>厂家名称</th>
          <th>厂家别名</th>
          <th>地址</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($manufacturers as $manufacturer): ?>
          <tr>
            <td><?php echo $manufacturer->manufacturer_name; ?></td>
            <td><?php echo $manufacturer->manufacturer_alias; ?></td>
            <td><?php
              $manufacturerAddress = $manufacturer->getManufacturerAddress()->one();
              echo $manufacturerAddress->getRegionProvince()->one()->region_name.
              $manufacturerAddress->getRegionCity()->one()->region_name.
              $manufacturerAddress->getRegionCountry()->one()->region_name.
              $manufacturerAddress->manufacturer_address;
             ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <span>
      <!-- <a href="?r=site/contact"><span class="btn btn-primary pull-right">添加药品</span></a> -->
      <input type="button" name="add" value="添加厂家" class="addProduct btn btn-primary pull-right">

    </span>
  </div>
</div>
