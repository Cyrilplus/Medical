<?php

namespace app\models;

use yii\base\Model;

class AddProductForm extends Model
{
    public $name;
    public $manufacturer;
    public $num;
    public $repository;
    public $defaultPrice;

    public function rules()
    {
        return [
        [['name', 'manufacturer', 'num', 'repository', 'defaultPrice'], 'required'],
      ];
    }
}
