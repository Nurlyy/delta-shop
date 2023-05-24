<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\Categories;
use common\models\Rubrik;
use common\models\Subcategories;
use common\models\Products;
use common\models\Images;

class CategoriesController extends Controller
{

    public $layout = 'layout';


    public function actionIndex()
    {
        return $this->redirect('/');
    }


    public function actionCategory()
    {
        $tree = "";

        $cats = Categories::find()->all();
        $subcats = Subcategories::find()->all();
        $rubs = Rubrik::find()->all();

        $category_id = htmlentities($_GET['category_id']);
        $subcategory_id = isset($_GET['subcategory_id']) ? htmlentities($_GET['subcategory_id']) : null;
        $rubrik_id = isset($_GET['rubrik_id']) ? htmlentities($_GET['rubrik_id']) : null;

        $products = [];

        $subcategories = [];
        $rubriks = [];

        $category = Categories::find()->where(['category_id' => $category_id])->one();
        $tree .= "{$category->category_name} /";

        if (isset($subcategory_id)) {
            $subcategories = Subcategories::find()->where(['subcategory_id' => $subcategory_id, 'category_id' => $category_id])->one();
            $tree .= " {$subcategories->subcategory_name} /";
        } else {
            $subcategories = Subcategories::find()->where(['category_id' => $category_id])->all();
        }

        if (isset($rubrik_id)) {
            $rubriks = Rubrik::find()->where(['rubrik_id' => $rubrik_id, 'subcategory_id' => $subcategory_id])->one();
            $tree .= " {$rubriks->rubrik_name} /";
        } else {
            $subs_ids = [];
            if (isset($subcategory_id)) {
                array_push($subs_ids, $subcategories->subcategory_id);
            } else {
                foreach ($subcategories as $sub) {
                    array_push($subs_ids, $sub->subcategory_id);
                }
            }
            $rubriks = Rubrik::find()->where(['in', 'subcategory_id', $subs_ids])->all();
        }

        if (!isset($rubriks[0]) && !empty($rubriks)) {
            // var_dump($rubriks);exit;
            $prods = Products::find()->where(['rubrik_id' => $rubriks->rubrik_id])->all();
            foreach($prods as $prod){
                array_push($products, $prod);
            }
            $products = $prods;
        } else {
            $prods = [];
            foreach ($rubriks as $rubrik) {
                $p = Products::find()->where(['rubrik_id' => $rubrik->rubrik_id])->all();
                // 
                if (!empty($p)) {
                    foreach ($p as $_p) {
                        // var_dump($_p);exit;
                        array_push($prods, $_p);
                    }
                }
            }
            $products = $prods;
        }
        $images = [];
        foreach($products as $model) {
            $temp_images = Images::find()->where(['prod_id' => $model->product_id])->one();
            if(!empty($temp_images)){
                $images[$model->product_id] = $temp_images;
            }
        }

        // var_dump($products);
        // exit;

        return $this->render('category', ['categories' => $cats, 'subcategories' => $subcats, 'images'=> $images, 'rubrics' => $rubs, 'models' => $products, 'tree' => $tree]);
    }
}
