<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subcategories".
 *
 * @property int $subcategory_id
 * @property string $subcategory_name
 * @property int|null $category_id
 *
 * @property Categories $category
 * @property Rubrik[] $rubriks
 */
class Subcategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subcategories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subcategory_name'], 'required'],
            [['category_id'], 'integer'],
            [['subcategory_name'], 'string', 'max' => 100],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'category_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'subcategory_id' => 'Subcategory ID',
            'subcategory_name' => 'Subcategory Name',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['category_id' => 'category_id']);
    }

    /**
     * Gets query for [[Rubriks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRubriks()
    {
        return $this->hasMany(Rubrik::class, ['subcategory_id' => 'subcategory_id']);
    }
}
