<?php

/* @var $this yii\web\View */
/* @var $clients app\Models\manufacturer*/

use app\assets\AppAsset;

$this->title = '厂商';
?>
<style media="screen">
   .addClient{
     margin: 10px;
   }
</style>
<div class="row">
  <div class="col-lg-10 col-lg-offset-1">
    <table class="table table-striped" id="product">
      <caption>客户</caption>
      <thead>
        <tr>
          <th>名称</th>
          <th>联系人</th>
          <th>联系号码</th>
          <th>地址</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($clients as $client): ?>
          <tr>
            <td><?= $client->client_name; ?></td>
            <td><?= $client->client_contact ?></td>
            <td>
              <?= $client->client_call;  ?>
            </td>
            <td><?php
              $clientAddress = $client->getClientAddress()->one();
              echo $clientAddress->getRegionProvince()->one()->region_name.
              $clientAddress->getRegionCity()->one()->region_name.
              $clientAddress->getRegionCountry()->one()->region_name.
              $clientAddress->client_address;
             ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <a href="?r=site/addclient"><span class="btn btn-primary pull-right addManufacturer">添加用户</span></a>
  </div>
</div>
<?php AppAsset::addJsFile($this, '/js/jquery.dataTables.min.js'); ?>
<?php AppAsset::addJsFile($this, '/js/index.js'); ?>
