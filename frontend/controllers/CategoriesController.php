<?php 

namespace frontend\controllers;

use yii\web\Controller;
use common\models\Categories;
use common\models\Rubrik;
use common\models\Subcategories;

class CategoriesController extends Controller {

    public $layout = 'layout';


    public function actionIndex(){
        return $this->redirect('/');
    }


    public function actionCategory(){
        $category_id = htmlentities($_GET['category_id']);
        $category = Categories::find()->where(['category_id' => $category_id])->one();
        $subcategories = Subcategories::find()->where(['category_id' => $category->id])->all();
        $rubriks = [];
        foreach($subcategories as $subcategory) {
            array_push($rubriks, Rubrik::find()->where(['subcategory_id' => $subcategory->id])->all());
        } 

        $products = [];
    }

}