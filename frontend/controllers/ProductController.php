<?php

namespace frontend\controllers;

use common\models\Categories;
use common\models\Products;
use common\models\Rubrik;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\Manufacturers;
use common\models\ProductCharacteristics;
use common\models\Subcategories;

class ProductController extends Controller
{
    public $layout = 'layout';
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // $behaviors['access'] = [
        //     'class' => AccessControl::class,

        // ];

        return $behaviors;
    }

    public function actionIndex()
    {
        return $this->redirect('/');
    }

    public function actionProduct()
    {
        $product_id = htmlentities($_GET['product_id']);
        $product = Products::find()->where(['product_id' => $product_id])->one();
        $rubrik = Rubrik::find()->where(['rubrik_id' => $product->rubrik_id])->one();
        $subcategory = Subcategories::find()->where(['subcategory_id' => $rubrik->subcategory_id])->one();
        $category = Categories::find()->where(['category_id' => $subcategory->category_id])->one();
        $manufacturer = Manufacturers::find()->where(['manufacturer_id' => $product->manufacturer_id])->one();
        $characteristics = ProductCharacteristics::find()->where(['product_id'=>$product->product_id])->all();
        $products = Products::find()
            ->where(['rubrik_id' => $rubrik->rubrik_id])
            ->andWhere(['<>', 'product_id', $product_id])
            ->limit(4)
            ->all();
        return $this->render('product', [
            'product' => $product,
            'products' => $products,
            'manufacturer' => $manufacturer,
            'rubrik' => $rubrik,
            'subcategory' => $subcategory,
            'category' => $category,
            'characteristics' => $characteristics
        ]);
    }
}
