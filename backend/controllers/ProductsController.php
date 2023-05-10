<?php

namespace backend\controllers;

use common\models\Categories;
use common\models\Images;
use common\models\ProductCharacteristics;
use common\models\Manufacturers;
use common\models\Products;
use common\models\Rubrik;
use common\models\Subcategories;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use Yii;
use Exception;
use yii\web\UploadedFile;

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
        $images = Images::find()->where(['prod_id' => $product->product_id])->all();
        $characteristics = ProductCharacteristics::find()->where(['product_id' => $product->product_id])->asArray()->all();
        if (Yii::$app->request->isPost) {
            // var_dump('pass');exit;
            $db = Yii::$app->db;
            $transaction = $db->beginTransaction();
            try {
                $newImages = [];
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
                    // var_dump(json_decode(Yii::$app->request->post('characteristics')));exit;
                    // var_dump(Yii::$app->request->post('characteristics'));exit;
                    $new_characteristics = json_decode(Yii::$app->request->post('characteristics'));
                    // var_dump($_POST['characteristics']);exit;
                    if ($new_characteristics != null && !empty($new_characteristics)) {
                        foreach ($new_characteristics as $new_characteristic) {
                            if (isset($new_characteristic->id)) {
                                $ch = ProductCharacteristics::find()->where(['id' => $new_characteristic->id])->one();
                                $ch->key = $new_characteristic->key;
                                $ch->value = $new_characteristic->value;
                                if ($ch->validate()) {
                                    $ch->save();
                                }
                            } else {
                                $ch = new ProductCharacteristics();
                                $ch->product_id = $product->product_id;
                                $ch->key = $new_characteristic->key;
                                $ch->value = $new_characteristic->value;
                                if ($ch->validate()) {
                                    $ch->save();
                                }
                            }
                        }
                    }
                }

                if (isset($_POST['deleted_characteristics'])) {

                    $deleted_characteristics = json_decode(Yii::$app->request->post('deleted_characteristics'));
                    // var_dump($deleted_characteristics);exit;
                    if (!empty($deleted_characteristics)) {
                        if(gettype($deleted_characteristics) == 'integer'){
                            $ch = ProductCharacteristics::find()->where(['id' => htmlentities($deleted_characteristics)])->one();
                            // throw new Exception(isset($ch)?'true':'false');
                            // throw new Exception(htmlentities($deleted_characteristic));
                            if ($ch != null && !empty($ch)) {
                                $ch->delete();
                            }
                        }else{
                            foreach ($deleted_characteristics as $deleted_characteristic) {
                                // throw new Exception($deleted_characteristic);
                                $ch = ProductCharacteristics::find()->where(['id' => htmlentities($deleted_characteristic)])->one();
                                // throw new Exception(isset($ch)?'true':'false');
                                // throw new Exception(htmlentities($deleted_characteristic));
                                if ($ch != null && !empty($ch)) {
                                    $ch->delete();
                                }
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

                if (!empty($_FILES['imageFiles']['name'])) {
                    $newImages = UploadedFile::getInstancesByName('imageFiles');
                    foreach ($newImages as $file) {
                        // var_dump($file);exit;
                        $image = new Images();
                        $filename = uniqid() . '.' . $file->extension;
                        $file->saveAs('uploads/' . $filename);
                        $image->path = $filename;
                        $image->prod_id = $product->product_id; // Set the ID of the product the image belongs to
                        $image->save();
                    }
                }


                $transaction->commit();
                return $this->redirect('/products');
            } catch (\Exception $e) {
                $transaction->rollback();
                return $e;
            }
        }
        return $this->render('update', [
            'product' => $product, 'manufacturers' => $manufacturers, 'rubriks' => $rubriks, 'characteristics' => $characteristics, 'images' => $images,
        ]);
    }

    public function actionDelete()
    {
        $id = htmlentities($_POST['product_id']);
        $product = Products::find()->where(['product_id' => $id])->one();
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            $characteristics = ProductCharacteristics::find()->where(['product_id' => $product->product_id])->all();
            foreach ($characteristics as $characteristic) {
                $characteristic->delete();
            }
            $product->delete();

            $transaction->commit();
            return $this->redirect('/products');
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $e->getMessage();
        }
    }

    public function actionCreate()
    {
        $manufacturers = Manufacturers::find()->all();
        $rubriks = Rubrik::find()->all();

        if (Yii::$app->request->isPost) {
            // var_dump('gkroepg');exit;
            // var_dump($_POST);exit;


            // var_dump('gkroepg');exit;



            $db = Yii::$app->db;
            $transaction = $db->beginTransaction();
            try {
                $product = new Products();
                $images = [];

                if (isset($_POST['product_name'])) {
                    $product->product_name = htmlentities(Yii::$app->request->post('product_name'));
                } else {
                    throw new Exception();
                }
                if (isset($_POST['manufacturer_id'])) {
                    $product->manufacturer_id = htmlentities(Yii::$app->request->post('manufacturer_id'));
                }
                if (isset($_POST['rubrik_id'])) {
                    $product->rubrik_id = htmlentities(Yii::$app->request->post('rubrik_id'));
                }
                if (isset($_POST['characteristics'])) {
                    // var_dump(json_decode(Yii::$app->request->post('characteristics')));exit;
                    $new_characteristics = json_decode(Yii::$app->request->post('characteristics'));
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
                } else {
                    throw new Exception();
                }

                if (isset($_POST['count'])) {
                    $product->count = htmlentities(Yii::$app->request->post('count'));
                } else {
                    throw new Exception();
                }

                if (Yii::$app->request->post('description') != null) {
                    $product->description = htmlentities(Yii::$app->request->post('description'));
                }

                // var_dump($product);exit;

                if ($product->validate()) {

                    $product->save();
                }

                if (!empty($_FILES['imageFiles']['name'])) {
                    $images = UploadedFile::getInstancesByName('imageFiles');
                }
                foreach ($images as $file) {
                    // var_dump($file);exit;
                    $image = new Images();
                    $filename = uniqid() . '.' . $file->extension;
                    $file->saveAs('uploads/' . $filename);
                    $image->path = $filename;
                    $image->prod_id = $product->product_id; // Set the ID of the product the image belongs to
                    $image->save();
                }

                $transaction->commit();
                return $this->redirect('/products');
            } catch (Exception $e) {
                $transaction->rollback();
                return $e;
            }
        }

        return $this->render('create', ['manufacturers' => $manufacturers, 'rubriks' => $rubriks]);
    }

    public function actionManufacturers()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Manufacturers::find()->orderBy('manufacturer_id DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        // $posts = $dataProvider->getModels();
        return $this->render('manufacturers', ['dataProvider' => $dataProvider]);
    }

    public function actionCreateManufacturer()
    {
        if (Yii::$app->request->isPost) {
            $manufacturer_name = htmlentities(Yii::$app->request->post('manufacturer_name'));
            $manufacturer = new Manufacturers();
            $manufacturer->manufacturer_name = $manufacturer_name;
            if ($manufacturer->validate() && $manufacturer->save()) {
                return $this->redirect('/products/manufacturers/');
            }
        }
        return $this->render('create_manufacturer');
    }

    public function actionDeleteManufacturer()
    {
        if (Yii::$app->request->isPost) {
            $manufacturer_id = htmlentities(Yii::$app->request->post('manufacturer_id'));
            $manufacturer = Manufacturers::find()->where(['manufacturer_id' => $manufacturer_id])->one();
            if ($manufacturer->delete()) {
                return $this->redirect('/manufacturers');
            }
        }
    }

    public function actionUpdateManufacturer()
    {
        $manufacturer_id = htmlentities(Yii::$app->request->get('manufacturer_id'));
        $manufacturer = Manufacturers::find()->where(['manufacturer_id' => $manufacturer_id])->one();
        // var_dump($manufacturer);exit;
        if (Yii::$app->request->isPost) {
            $manufacturer_name = htmlentities(Yii::$app->request->post('manufacturer_name'));
            $manufacturer->manufacturer_name = $manufacturer_name;
            if ($manufacturer->validate() && $manufacturer->save()) {
                return $this->redirect('/manufacturers');
            }
        }
        return $this->render('update_manufacturer', ['manufacturer' => $manufacturer]);
    }

    public function actionCategories()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Categories::find()->orderBy('category_id DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        // $posts = $dataProvider->getModels();
        return $this->render('categories', ['dataProvider' => $dataProvider]);
    }

    public function actionCreateCategory()
    {
        if (Yii::$app->request->isPost) {
            $category_name = htmlentities(Yii::$app->request->post('category_name'));
            $category = new Categories();
            $category->category_name = $category_name;
            if ($category->validate() && $category->save()) {
                return $this->redirect('/products/categories/');
            }
        }
        return $this->render('create_category');
    }

    public function actionUpdateCategory()
    {
        $category_id = htmlentities(Yii::$app->request->get('category_id'));
        $category = Categories::find()->where(['category_id' => $category_id])->one();
        // $subcategories = Subcategories::find()->where(['category_id' => $category->category_id])->all();
        $dataProvider = new ActiveDataProvider([
            'query' => Subcategories::find()->where(['category_id' => $category->category_id])->orderBy('category_id DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        // var_dump($category);exit;
        if (Yii::$app->request->isPost) {
            $category_name = htmlentities(Yii::$app->request->post('category_name'));
            $category->category_name = $category_name;
            if ($category->validate() && $category->save()) {
                return $this->redirect('/products/categories/');
            }
        }
        return $this->render('update_category', ['category' => $category, 'dataProvider' => $dataProvider]);
    }

    public function actionDeleteCategory()
    {
        if (Yii::$app->request->isPost) {
            $category_id = htmlentities(Yii::$app->request->post('category_id'));
            $category = Categories::find()->where(['category_id' => $category_id])->one();
            if ($category->delete()) {
                return $this->redirect('/products/categories/');
            }
        }
    }

    public function actionCreateSubcategory()
    {
        $category_id = htmlentities(Yii::$app->request->get('category_id'));
        // return $category_id;
        if (Yii::$app->request->isPost) {
            $category_id = htmlentities(Yii::$app->request->post('category_id'));
            $subcategory_name = htmlentities(Yii::$app->request->post('subcategory_name'));
            $subcategory = new Subcategories();
            $subcategory->subcategory_name = $subcategory_name;
            $subcategory->category_id = $category_id;
            if ($subcategory->validate() && $subcategory->save()) {
                return $this->redirect('/products/update-category/' . $category_id);
            }
        }
        return $this->render('create_subcategory', ['category_id' => $category_id]);
    }

    public function actionUpdateSubcategory()
    {
        $subcategory_id = htmlentities(Yii::$app->request->get('subcategory_id'));
        $subcategory = Subcategories::find()->where(['subcategory_id' => $subcategory_id])->one();
        // $subcategories = Subcategories::find()->where(['category_id' => $category->category_id])->all();
        $dataProvider = new ActiveDataProvider([
            'query' => Rubrik::find()->where(['subcategory_id' => $subcategory->subcategory_id])->orderBy('rubrik_id DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        // var_dump($category);exit;
        if (Yii::$app->request->isPost) {
            $subcategory_name = htmlentities(Yii::$app->request->post('subcategory_name'));
            $subcategory->subcategory_name = $subcategory_name;
            if ($subcategory->validate() && $subcategory->save()) {
                return $this->redirect("/prpducts/update-category/{$subcategory->category_id}");
            }
        }
        return $this->render('update_subcategory', ['subcategory' => $subcategory, 'dataProvider' => $dataProvider]);
    }

    public function actionDeleteSubcategory()
    {
        if (Yii::$app->request->isPost) {
            $db = Yii::$app->db;
            $transaction = $db->beginTransaction();
            try {
                $subcategory_id = htmlentities(Yii::$app->request->post('subcategory_id'));
                $subcategory = Subcategories::find()->where(['subcategory_id' => $subcategory_id])->one();
                $rubriks = Rubrik::find()->where(['subcategory_id' => $subcategory->subcategory_id])->all();
                foreach ($rubriks as $rubrik) {
                    $rubrik->delete();
                }
                if ($subcategory->delete()) {
                    $transaction->commit();
                    return $this->redirect('/products/update-category/' . $subcategory->category_id);
                }
            } catch (Exception $e) {
                $transaction->rollback();
                return $e->getMessage();
            }
        }
    }

    public function actionCreateRubrik()
    {
        $subcategory_id = htmlentities(Yii::$app->request->get('subcategory_id'));
        // return $category_id;
        if (Yii::$app->request->isPost) {
            $subcategory_id = htmlentities(Yii::$app->request->post('subcategory_id'));
            $subcategory = Subcategories::find()->where(['subcategory_id' => $subcategory_id])->one();
            $rubrik_name = htmlentities(Yii::$app->request->post('rubrik_name'));
            $rubrik = new Rubrik();
            $rubrik->rubrik_name = $rubrik_name;
            $rubrik->subcategory_id = $subcategory_id;
            if ($rubrik->validate() && $rubrik->save()) {
                return $this->redirect('/products/update-category/' . $subcategory->category_id . '/update-subcategory/' . $subcategory->subcategory_id);
            }
        }
        return $this->render('create_rubrik', ['subcategory_id' => $subcategory_id]);
    }

    public function actionUpdateRubrik()
    {
        $rubrik_id = htmlentities(Yii::$app->request->get('rubrik_id'));
        $rubrik = Rubrik::find()->where(['rubrik_id' => $rubrik_id])->one();
        // $subcategories = Subcategories::find()->where(['category_id' => $category->category_id])->all();
        // var_dump($category);exit;
        if (Yii::$app->request->isPost) {
            $rubrik_name = htmlentities(Yii::$app->request->post('rubrik_name'));
            $subcategory = Subcategories::find()->where(['subcategory_id' => $rubrik->subcategory_id])->one();
            $rubrik->rubrik_name = $rubrik_name;
            if ($rubrik->validate() && $rubrik->save()) {
                return $this->redirect("/products/update-category/{$subcategory->category_id}/update-subcategory/{$subcategory->subcategory_id}");
            }
        }
        return $this->render('update_rubrik', ['rubrik' => $rubrik]);
    }

    public function actionDeleteRubrik()
    {
        if (Yii::$app->request->isPost) {
            $db = Yii::$app->db;
            $transaction = $db->beginTransaction();
            try {
                $rubrik_id = htmlentities(Yii::$app->request->post('rubrik_id'));
                $rubrik = Rubrik::find()->where(['rubrik_id' => $rubrik_id])->one();
                $subcategory = Subcategories::find()->where(['subcategory_id' => $rubrik->subcategory_id])->one();
                if ($rubrik->delete()) {
                    $transaction->commit();
                    return $this->redirect('/products/update-category/' . $subcategory->category_id . '/update-subcategory/' . $subcategory->subcategory_id);
                }
            } catch (Exception $e) {
                $transaction->rollback();
                return $e->getMessage();
            }
        }
    }
}
