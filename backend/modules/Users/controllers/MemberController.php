<?php

namespace backend\modules\Users\controllers;

use Yii;
use common\models\Member;
use backend\models\MemberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\Users\models\CreateTakeForm;
use backend\modules\Users\models\MemberEditForm;
use yii\helpers\ArrayHelper;
use common\models\Trangthai;
use yii\helpers\Url;
/**
 * MemberController implements the CRUD actions for Member model.
 */
class MemberController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Member models.
     * @return mixed
     */
    public function actionIndex($filer = 0) {
        $searchModel = new MemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$filer);
        
        $linkAjax = Url::to(["/Users/member/filerindex"]);
        $countAll = Member::find()->count();
        $countNotActive = Member::find()->where(['status' => Member::STATUS_NOT_ACTIVE])->count();
        $countTake = Member::find()->where(['role_id' => Member::ROLE_TAKE])->count();
        $arrTitle = [
          ['count'=>$countAll,'title'=>'Tất cả','filer'=>0],
          ['count'=>$countNotActive,'title'=>'Chưa active','filer'=>  Member::STATUS_NOT_ACTIVE],
          ['count'=>$countTake,'title'=>'Được quyền nhận','filer'=>-Member::ROLE_TAKE],
        ];
        $dataListAction = ArrayHelper::map(Trangthai::find()->where(['type' => "Users"])->all(), 'id', 'ten');
        
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'filer' => $filer,
                    'type' => 'post',
                    'dataList'=>$dataListAction,
                    'arrTitle'=>$arrTitle,
                    'dataProvider' => $dataProvider,
                    'linkAjax'=>$linkAjax
        ]);
    }
    public function actionFilerindex() {
        if (isset($_POST['ids']) && isset($_POST['action'])) {
            $data = json_decode(stripslashes($_POST['ids']));
            $action = $_POST['action'];
            foreach ($data as $d) {
                $model = Member::findOne($d);
                $trangthai = Trangthai::findOne(['id' => $action]);
                if ($model && $trangthai) {
                    $value = $trangthai->getValue();
                    if ($value == -1) {
                        $model->_delete();
                    } else {
                        $feild = $trangthai->getFeild();
                        if (!empty($feild)) {
                            $model->$feild = $trangthai->getValue();
                            if ($feild == "role_id" && $trangthai->getValue() == Member::ROLE_TAKE) {
                                $model->count_role = 1;
                            }
                            $model->save(false);
                        }
                    }
                }
            }
        }
    }

    /**
     * Displays a single Member model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Member model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MemberEditForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->saveData()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Member model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->saveData()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Member model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    //Tạo người có thể nhận cho một số người dùng
    public function actionCreatetake() {
        $model = new CreateTakeForm;
        $model->is_take = 1;
        if ($model->load(Yii::$app->request->post()) && $model->saveData()) {
            Yii::$app->session->setFlash('log','Cập nhật thành công');
        }
        return $this->render('create_take',[
            'model'=>$model
        ]) ;
    }
    /**
     * Finds the Member model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MemberEditForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
