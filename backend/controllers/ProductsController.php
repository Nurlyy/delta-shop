<?php

namespace backend\controllers;

use common\models\ProductCharacteristics;
use common\models\Manufacturers;
use common\models\Products;
use common\models\Rubrik;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use Yii;

class ProductsController extends Controller
{

    public $layout = 'layout';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ]
            ],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Products::find()->orderBy('product_id DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        // $posts = $dataProvider->getModels();
        return $this->render('index', ['dataProvider' => $dataProvider]);
        // return $this->render('index', ['posts' => $posts]);
    }

    public function actionView()
    {
        $id = htmlentities($_GET['product_id']);
        $product = Products::find()->where(['product_id' => $id])->one();
        return $this->render('view', ['product' => $product]);
    }

    public function actionUpdate()
    {
        $manufacturers = Manufacturers::find()->all();
        $rubriks = Rubrik::find()->all();
        $id = htmlentities($_GET['product_id']);
        $product = Products::find()->where(['product_id' => $id])->one();
        $characteristics = ProductCharacteristics::find()->where(['product_id' => $product->product_id])->asArray()->all();
        if (Yii::$app->request->isPost) {
            // var_dump('pass');exit;
            $db = Yii::$app->db;
            $transaction = $db->beginTransaction();
            try {
                if (isset($_POST['product_name'])) {
                    $product->product_name = htmlentities(Yii::$app->request->post('product_name'));
                }
                if (isset($_POST['manufacturer_id'])) {
                    $product->manufacturer_id = htmlentities(Yii::$app->request->post('manufacturer_id'));
                }
                if (isset($_POST['rubrik_id'])) {
                    $product->rubrik_id = htmlentities(Yii::$app->request->post('rubrik_id'));
                }
                if (isset($_POST['characteristics'])) {
                    $new_characteristics = Yii::$app->request->post('characteristics');
                    if ($new_characteristics != null && !empty($new_characteristics)) {
                        foreach ($new_characteristics as $new_characteristic) {
                            if (isset($new_characteristic['id'])) {
                                $ch = ProductCharacteristics::find()->where(['id' => $new_characteristic['id']])->one();
                                $ch->key = $new_characteristic['key'];
                                $ch->value = $new_characteristic['value'];
                                if ($ch->validate()) {
                                    $ch->save();
                                }
                            } else {
                                $ch = new ProductCharacteristics();
                                $ch->product_id = $product->product_id;
                                $ch->key = $new_characteristic['key'];
                                $ch->value = $new_characteristic['value'];
                                if ($ch->validate()) {
                                    $ch->save();
                                }
                            }
                        }
                    }
                }
                
                if (isset($_POST['deleted_characteristics'])) {
                    
                    $deleted_characteristics = $_POST['deleted_characteristics'];
                    foreach ($deleted_characteristics as $deleted_characteristic) {
                        if (isset($deleted_characteristic['id'])) {
                            $ch = ProductCharacteristics::find()->where(['product_id' => $deleted_characteristic])->one();
                            if ($ch != null && !empty($ch)) {
                                $ch->delete();
                            }
                        }
                    }
                }
                
                if (isset($_POST['price'])) {
                    $product->price = htmlentities(Yii::$app->request->post('price'));
                }
                
                if (isset($_POST['count'])) {
                    $product->count = htmlentities(Yii::$app->request->post('count'));
                }

                if (Yii::$app->request->post('description') != null) {
                    $product->description = htmlentities(Yii::$app->request->post('description'));
                }

                // var_dump($product);exit;
                
                if ($product->validate()) {
                    
                    $product->save();
                }
                $transaction->commit();
                return 'true';
            } catch (\Exception $e) {
                $transaction->rollback();
                return $e;
            }
        }
        return $this->render('update', [
            'product' => $product, 'manufacturers' => $manufacturers, 'rubriks' => $rubriks, 'characteristics' => $characteristics,
        ]);
    }

    public function actionDelete()
    {
        $id = htmlentities($_POST['product_id']);
        $product = Products::find()->where(['product_id' => $id])->one();
        if ($product->delete()) {
            return $this->redirect('/products');
        } else {
            return 'false';
        }
    }
}
