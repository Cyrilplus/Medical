<?php

namespace app\models;

use yii\base\Model;

class AddClientForm extends Model
{
    public $name;
    public $contact;
    public $call;
    public $regionProvince;
    public $regionCity;
    public $regionCountry;
    public $detailAddress;

    public function rules()
    {
        return [
        [['name', 'contact', 'call', 'regionProvince', 'regionCountry', 'regionCity', 'detailAddress'], 'required'],
      ];
    }
}
