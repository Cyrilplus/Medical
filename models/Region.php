<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property integer $region_id
 * @property integer $region_parent_id
 * @property string $region_name
 * @property integer $region_type
 *
 * @property ClientAddress[] $clientAddresses
 * @property ClientAddress[] $clientAddresses0
 * @property ClientAddress[] $clientAddresses1
 * @property ManufacturerAddress[] $manufacturerAddresses
 * @property ManufacturerAddress[] $manufacturerAddresses0
 * @property ManufacturerAddress[] $manufacturerAddresses1
 * @property Price[] $prices
 * @property RepositoryAddress[] $repositoryAddresses
 * @property RepositoryAddress[] $repositoryAddresses0
 * @property RepositoryAddress[] $repositoryAddresses1
 * @property UserAddress[] $userAddresses
 * @property UserAddress[] $userAddresses0
 * @property UserAddress[] $userAddresses1
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_parent_id', 'region_name'], 'required'],
            [['region_parent_id', 'region_type'], 'integer'],
            [['region_name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'region_id' => 'Region ID',
            'region_parent_id' => 'Region Parent ID',
            'region_name' => 'Region Name',
            'region_type' => 'Region Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientAddresses()
    {
        return $this->hasMany(ClientAddress::className(), ['region_province_id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientAddresses0()
    {
        return $this->hasMany(ClientAddress::className(), ['region_city_id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientAddresses1()
    {
        return $this->hasMany(ClientAddress::className(), ['region_country_id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManufacturerAddresses()
    {
        return $this->hasMany(ManufacturerAddress::className(), ['region_province_id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManufacturerAddresses0()
    {
        return $this->hasMany(ManufacturerAddress::className(), ['region_city_id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManufacturerAddresses1()
    {
        return $this->hasMany(ManufacturerAddress::className(), ['region_country_id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrices()
    {
        return $this->hasMany(Price::className(), ['price_destination_id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepositoryAddresses()
    {
        return $this->hasMany(RepositoryAddress::className(), ['region_province_id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepositoryAddresses0()
    {
        return $this->hasMany(RepositoryAddress::className(), ['region_city_id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepositoryAddresses1()
    {
        return $this->hasMany(RepositoryAddress::className(), ['region_country_id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAddresses()
    {
        return $this->hasMany(UserAddress::className(), ['region_province_id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAddresses0()
    {
        return $this->hasMany(UserAddress::className(), ['region_city_id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAddresses1()
    {
        return $this->hasMany(UserAddress::className(), ['region_country_id' => 'region_id']);
    }
}
