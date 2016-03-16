<?php

namespace app\models;

use yii\base\Model;

class AddPurchaseForm extends Model
{
    public $productId;
    public $productNum;

    public function rules()
    {
        return [
      [['productId', 'productNum'], 'required'],
    ];
    }
}
