<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $order_id
 * @property int $customer_id
 * @property int $total_price
 * @property string $currency
 * @property string $order_date
 *
 * @property User $customer
 * @property OrdersProduct[] $ordersProducts
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'total_price', 'currency', 'order_date'], 'required'],
            [['customer_id', 'total_price'], 'integer'],
            [['order_date'], 'safe'],
            [['currency'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'customer_id' => 'Customer ID',
            'total_price' => 'Total Price',
            'currency' => 'Currency',
            'order_date' => 'Order Date',
        ];
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(User::class, ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[OrdersProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersProducts()
    {
        return $this->hasMany(OrdersProduct::class, ['order_id' => 'order_id']);
    }
}
