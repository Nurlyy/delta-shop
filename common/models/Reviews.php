<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property int $product_id
 * @property int $customer_id
 * @property string $review
 * @property int $raiting
 * @property string $created_at
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'customer_id', 'review', 'raiting'], 'required'],
            [['id', 'product_id', 'customer_id', 'raiting'], 'integer'],
            [['review'], 'string'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'customer_id' => 'Customer ID',
            'review' => 'Review',
            'raiting' => 'Raiting',
            'created_at' => 'Created At',
        ];
    }
}
