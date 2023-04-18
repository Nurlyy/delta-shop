<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customers".
 *
 * @property int $id
 * @property int $user_id
 * @property int $name
 * @property int $birth_date
 * @property string $sex
 * @property int $discount_id
 */
class Customers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'name', 'birth_date', 'sex', 'discount_id'], 'required'],
            [['id', 'user_id', 'name', 'birth_date', 'discount_id'], 'integer'],
            [['sex'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'birth_date' => 'Birth Date',
            'sex' => 'Sex',
            'discount_id' => 'Discount ID',
        ];
    }
}
