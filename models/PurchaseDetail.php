<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "purchase_detail".
 *
 * @property integer $purchase_detail_id
 * @property integer $purchase_id
 * @property integer $product_id
 * @property integer $product_num
 * @property integer $purchase_detail_total_money
 *
 * @property Product $product
 * @property Purchase $purchase
 */
class PurchaseDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchase_id', 'product_id'], 'required'],
            [['purchase_id', 'product_id', 'product_num', 'purchase_detail_total_money'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'purchase_detail_id' => 'Purchase Detail ID',
            'purchase_id' => 'Purchase ID',
            'product_id' => 'Product ID',
            'product_num' => 'Product Num',
            'purchase_detail_total_money' => 'Purchase Detail Total Money',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['product_id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchase()
    {
        return $this->hasOne(Purchase::className(), ['purchase_id' => 'purchase_id']);
    }
}
