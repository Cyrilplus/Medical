<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $product_id
 * @property string $product_name
 * @property string $product_chemical_name
 * @property string $product_specification
 * @property integer $manufacturer_id
 * @property integer $product_num
 * @property integer $repository_id
 * @property integer $product_default_price
 * @property integer $price_id
 *
 * @property DispatchDetail[] $dispatchDetails
 * @property OrderDetail[] $orderDetails
 * @property Manufacturer $manufacturer
 * @property Price $price
 * @property Repository $repository
 * @property PurchaseDetail[] $purchaseDetails
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manufacturer_id', 'product_num', 'repository_id'], 'required'],
            [['manufacturer_id', 'product_num', 'repository_id', 'product_default_price', 'price_id'], 'integer'],
            [['product_name', 'product_chemical_name', 'product_specification'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'product_name' => 'Product Name',
            'product_chemical_name' => 'Product Chemical Name',
            'product_specification' => 'Product Specification',
            'manufacturer_id' => 'Manufacturer ID',
            'product_num' => 'Product Num',
            'repository_id' => 'Repository ID',
            'product_default_price' => 'Product Default Price',
            'price_id' => 'Price ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDispatchDetails()
    {
        return $this->hasMany(DispatchDetail::className(), ['product_id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetail::className(), ['product_id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManufacturer()
    {
        return $this->hasOne(Manufacturer::className(), ['manufacturer_id' => 'manufacturer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrice()
    {
        return $this->hasOne(Price::className(), ['price_id' => 'price_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepository()
    {
        return $this->hasOne(Repository::className(), ['repository_id' => 'repository_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::className(), ['product_id' => 'product_id']);
    }
}
