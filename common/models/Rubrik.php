<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rubrik".
 *
 * @property int $rubrik_id
 * @property string $rubrik_name
 * @property int|null $subcategory_id
 *
 * @property Products[] $products
 * @property Subcategories $subcategory
 */
class Rubrik extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rubrik';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rubrik_name'], 'required'],
            [['subcategory_id'], 'integer'],
            [['rubrik_name'], 'string', 'max' => 100],
            [['subcategory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subcategories::class, 'targetAttribute' => ['subcategory_id' => 'subcategory_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rubrik_id' => 'Rubrik ID',
            'rubrik_name' => 'Rubrik Name',
            'subcategory_id' => 'Subcategory ID',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::class, ['rubrik_id' => 'rubrik_id']);
    }

    /**
     * Gets query for [[Subcategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory()
    {
        return $this->hasOne(Subcategories::class, ['subcategory_id' => 'subcategory_id']);
    }
}
