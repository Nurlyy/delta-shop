<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\Categories;
use common\models\Rubrik;
use common\models\Subcategories;
use common\models\Products;

class CategoriesController extends Controller
{

    public $layout = 'layout';


    public function actionIndex()
    {
        return $this->redirect('/');
    }


    public function actionCategory()
    {
        $category_id = htmlentities($_GET['category_id']);
        $category = Categories::find()->where(['category_id' => $category_id])->one();
        $categories = Categories::find()->all();

        $subcategory_id = isset($_GET['subcategory_id']) ? htmlentities($_GET['subcategory_id']) : null;
        $subcategorie = Subcategories::find()->where(['subcategory_id' => $subcategory_id])->one();
        $subcategories = Subcategories::find()->all();

        $rubrik_id = isset($_GET['rubrik_id']) ? htmlentities($_GET['rubrik_id']) : null;
        $rubric = Rubrik::find()->where(['rubrik_id' => $rubrik_id])->all();
        $rubriks = [];

        $products = [];



        foreach ($subcategorie as $subcategory) {
            $rubriks[$subcategory->subcategory_id] = Rubrik::find()->where(['subcategory_id' => $subcategory->subcategory_id])->all();
        }

        if (!empty($rubriks)) {
            foreach ($rubriks as $rubrik) {
                foreach ($rubrik as $r) {
                    $prods = Products::find()->where(['rubrik_id' => $r->rubrik_id])->all();
                    array_push($products, $prods);
                }
            }
        }

        $tree = "{$category->category_name}/";
        if(isset($subcategory_id)){
            $tree .= "{$subcategorie->subcategory_name}/";
        }
        if(isset($rubrik_id)){
            $tree .= "{$rubrik->rubrik_name}/";
        }
        
        return $this->render('category', ['models' => $products, 'cat' => $category, 'subcategories' => $subcategories, 'rubric' => $rubric, 'rubriks' => $rubriks, 'categories' => $categories]);
    }
}
