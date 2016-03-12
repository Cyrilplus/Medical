<?php

namespace app\models;

use yii\base\Model;

class AddOrderForm extends Model
{
    public $productId;

    public function rules()
    {
        return [
      [['productId'], 'required'],
    ];
    }
}
