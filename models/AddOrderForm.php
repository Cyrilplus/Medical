<?php

namespace app\models;

use yii\base\Model;

class AddOrderForm extends Model
{
    public $productId;
    public $productNum;
    public $client;

    public function rules()
    {
        return [
      [['productId', 'productNum', 'client'], 'required'],
    ];
    }
}
