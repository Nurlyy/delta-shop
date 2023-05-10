<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property int $id
 * @property int $prod_id
 * @property string $path
 *
 * @property Products $prod
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prod_id', 'path'], 'required'],
            [['prod_id'], 'integer'],
            [['path'], 'string'],
            [['prod_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['prod_id' => 'product_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prod_id' => 'Prod ID',
            'path' => 'Path',
        ];
    }

    /**
     * Gets query for [[Prod]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProd()
    {
        return $this->hasOne(Products::class, ['product_id' => 'prod_id']);
    }
}
