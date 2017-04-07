<?php

namespace backend\modules\posts\controllers;

use Yii;
use backend\modules\posts\models\Category;
use backend\modules\posts\models\PostRelationships;
use backend\modules\posts\models\CategorySearch;
use yii\web\NotFoundHttpException;
use backend\modules\posts\models\Taxonomy;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\func\StaticDefine;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends \backend\controllers\BackendController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'delete', 'postcategory'],
                        'roles' => ['managePost'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPostcategory() {
        /* @var $_POST type */
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            $id = isset($_POST["id"]) ? $_POST["id"] : 0;
            $type = isset($_POST["type"]) ? $_POST["type"] : "posts";
            $parent = Category::findOne($id);
            $id = $parent == NULL ? 0 : $parent->id;
            $testData = Category::find()->where(['title' => $name])->all();
            if ($testData == NULL) {
                $model = new Category();
                $model->parent_id = $id;
                $model->title = $name;
                $model->type = $type;
                if ($model->save(FALSE)) {
                    $model->slug = Taxonomy::createSlug($model->id, $model->title, Category::tableName());
            $model->save();
                    $categories = Category::find()->where(['type'=>$type])->all();
                    $data['check'] = $id;
                    $data['html'] = $this->renderPartial('post_category', ['categories' => $categories]);
                    $data['title'] = "<label><input type='checkbox' checked='true' name='category[]' value='$model->id'> $model->title</label><br>";
                    return \yii\helpers\Json::encode($data);
                }
            }
        }
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Category();
        if ($model->load(Yii::$app->request->post())) {
            $model->parent_id = $model->parent_id == NULL ? 0 : $model->parent_id;
            if ($model->type == '') {
                $model->type = \common\models\Posts::tableName();
            }
            if ($model->save()) {
                Taxonomy::setTaxonomy($model->id, $model->tableName(), StaticDefine::$ICON_CATEGORY,$model->icon);
                $model->slug = Taxonomy::createSlug($model->id, $model->title, Category::tableName());
                $model->save();
                $this->createPosts($model, FALSE, FALSE,FALSE);
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->getSeoPost();
        $model->icon = Taxonomy::getTaxonomy($model->id, $model->tableName(), StaticDefine::$ICON_CATEGORY);
        if ($model->load(Yii::$app->request->post())) {
            $model->slug = Taxonomy::createSlug($model->id, $model->slug, Category::tableName(),FALSE);
            Taxonomy::setTaxonomy($model->id, $model->tableName(), StaticDefine::$ICON_CATEGORY,$model->icon);
            $model->save();
            $model->parent_id = $model->parent_id == NULL ? 0 : $model->parent_id;
            if ($model->save()) {
                PostRelationships::deleteAll(['post_id' => $model->id, 'post_table' => Category::tableName()]);
                $this->createPosts($model, FALSE, FALSE,FALSE);
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        if ($model) {
            PostRelationships::deleteAll(['post_id' => $model->id, 'post_table' => Category::tableName()]);
            Taxonomy::deleteAll(['table_name' => Category::tableName(), 'table_id' => $model->id]);
            $model->delete();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
