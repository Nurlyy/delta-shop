<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $product_id
 * @property string $product_name
 * @property int|null $manufacturer_id
 * @property int|null $rubrik_id
 * @property int $characteristics_id
 * @property int $price
 * @property int $count
 * @property int $image
 *
 * @property Characteristics $characteristics
 * @property Manufacturers $manufacturer
 * @property Orders[] $orders
 * @property OrdersProduct[] $ordersProducts
 * @property Rubrik $rubrik
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_name', 'characteristics_id', 'price', 'count'], 'required'],
            [['manufacturer_id', 'rubrik_id', 'characteristics_id', 'price', 'count'], 'integer'],
            [['product_name'], 'string', 'max' => 255],
            [['rubrik_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rubrik::class, 'targetAttribute' => ['rubrik_id' => 'rubrik_id']],
            [['manufacturer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Manufacturers::class, 'targetAttribute' => ['manufacturer_id' => 'manufacturer_id']],
            [['characteristics_id'], 'exist', 'skipOnError' => true, 'targetClass' => Characteristics::class, 'targetAttribute' => ['characteristics_id' => 'characteristics_id']],
            [['image'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'product_name' => 'Product Name',
            'manufacturer_id' => 'Manufacturer ID',
            'rubrik_id' => 'Rubrik ID',
            'characteristics_id' => 'Characteristics ID',
            'price' => 'Price',
            'count' => 'Count',
            'image' => 'Image',
        ];
    }

    /**
     * Gets query for [[Characteristics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacteristics()
    {
        return $this->hasOne(Characteristics::class, ['characteristics_id' => 'characteristics_id']);
    }

    /**
     * Gets query for [[Manufacturer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManufacturer()
    {
        return $this->hasOne(Manufacturers::class, ['manufacturer_id' => 'manufacturer_id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['order_id' => 'order_id'])->viaTable('orders_product', ['product_id' => 'product_id']);
    }

    /**
     * Gets query for [[OrdersProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersProducts()
    {
        return $this->hasMany(OrdersProduct::class, ['product_id' => 'product_id']);
    }

    /**
     * Gets query for [[Rubrik]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRubrik()
    {
        return $this->hasOne(Rubrik::class, ['rubrik_id' => 'rubrik_id']);
    }
}
