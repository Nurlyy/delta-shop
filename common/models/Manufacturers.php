<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "manufacturers".
 *
 * @property int $manufacturer_id
 * @property string $manufacturer_name
 *
 * @property Products[] $products
 */
class Manufacturers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'manufacturers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['manufacturer_name'], 'required'],
            [['manufacturer_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'manufacturer_id' => 'Manufacturer ID',
            'manufacturer_name' => 'Manufacturer Name',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::class, ['manufacturer_id' => 'manufacturer_id']);
    }
}
