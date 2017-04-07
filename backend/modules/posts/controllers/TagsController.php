<?php

namespace backend\modules\posts\controllers;

use Yii;
use backend\modules\posts\models\Tags;
use backend\modules\posts\models\TagsSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\posts\models\Taxonomy;
use backend\modules\posts\models\PostRelationships;
use yii\filters\AccessControl;

/**
 * TagsController implements the CRUD actions for Tags model.
 */
class TagsController extends \backend\controllers\BackendController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'delete', 'searchtagspost'],
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
     * Lists all Tags models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TagsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tags model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionSearchtagspost() {
        $json = [];
        if ($_POST['term']) {
            $term = $_POST['term'];
            $tags = Tags::find()->where(['LIKE', 'title', $term])->all();
            foreach ($tags as $value) {
                $json[] = $value->title;
            }
        }
        echo json_encode($json);
    }

    /**
     * Creates a new Tags model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Tags();

        if ($model->load(Yii::$app->request->post())) {
            $model->slug = Taxonomy::createSlug($model->id, $model->title, Tags::tableName());
            if ($model->save()) {
                $this->createPosts($model, FALSE, FALSE,FALSE);
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tags model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->getSeoPost();
        if ($model->load(Yii::$app->request->post())) {
            $model->slug = Taxonomy::createSlug($model->id, $model->slug, Posts::tableName(), FALSE);
            $model->save();
            if ($model->save()) {
                PostRelationships::deleteAll(['post_id' => $model->id, 'post_table' => Tags::tableName()]);
                $this->createPosts($model, FALSE, FALSE,FALSE);
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tags model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        if ($model) {
            PostRelationships::deleteAll(['post_id' => $model->id, 'post_table' => Tags::tableName()]);
            Taxonomy::deleteAll(['table_name' => Tags::tableName(), 'table_id' => $model->id]);
            $model->delete();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Tags model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tags the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Tags::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
