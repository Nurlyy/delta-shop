<?php

namespace frontend\controllers;

use common\models\Products;
use common\models\Rubrik;
use yii\filters\AccessControl;
use yii\web\Controller;

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
        $products = Products::find()
            ->where(['rubrik_id' => $rubrik->rubrik_id])
            ->andWhere(['<>', 'product_id', $product_id])
            ->limit(4)
            ->all();
        return $this->render('product', ['product' => $product, 'products' => $products]);
    }
}
