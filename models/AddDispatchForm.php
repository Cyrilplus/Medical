<?php

namespace app\models;

use yii\base\Model;

class AddDispatchForm extends Model
{
    public $productId;
    public $productNum;
    public $repository;

    public function rules()
    {
        return [
      [['productId', 'productNum', 'repository'], 'required'],
    ];
    }
}
