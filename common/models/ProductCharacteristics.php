<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_characteristics".
 *
 * @property int $product_id
 * @property int $characteristic_id
 * @property string $value
 */
class ProductCharacteristics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_characteristics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'characteristic_id', 'value'], 'required'],
            [['product_id', 'characteristic_id'], 'integer'],
            [['value'], 'string'],
            [['product_id', 'characteristic_id'], 'unique', 'targetAttribute' => ['product_id', 'characteristic_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'characteristic_id' => 'Characteristic ID',
            'value' => 'Value',
        ];
    }
}
