<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders_product".
 *
 * @property int $order_id
 * @property int $product_id
 * @property int $product_count
 *
 * @property Orders $order
 * @property Products $product
 */
class OrdersProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'product_count'], 'required'],
            [['order_id', 'product_id', 'product_count'], 'integer'],
            [['order_id', 'product_id'], 'unique', 'targetAttribute' => ['order_id', 'product_id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'product_id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::class, 'targetAttribute' => ['order_id' => 'order_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'product_count' => 'Product Count',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::class, ['order_id' => 'order_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::class, ['product_id' => 'product_id']);
    }
}
