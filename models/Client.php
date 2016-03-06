<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property integer $client_id
 * @property string $client_name
 * @property string $client_alias
 * @property string $client_rank
 * @property string $client_ownership
 * @property string $client_contact
 * @property string $client_call
 * @property integer $client_address_id
 *
 * @property ClientAddress $clientAddress
 * @property Order[] $orders
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_name', 'client_address_id'], 'required'],
            [['client_address_id'], 'integer'],
            [['client_name', 'client_alias'], 'string', 'max' => 100],
            [['client_rank', 'client_ownership', 'client_contact', 'client_call'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'client_id' => 'Client ID',
            'client_name' => 'Client Name',
            'client_alias' => 'Client Alias',
            'client_rank' => 'Client Rank',
            'client_ownership' => 'Client Ownership',
            'client_contact' => 'Client Contact',
            'client_call' => 'Client Call',
            'client_address_id' => 'Client Address ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientAddress()
    {
        return $this->hasOne(ClientAddress::className(), ['client_address_id' => 'client_address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['client_id' => 'client_id']);
    }
}
