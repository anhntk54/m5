<?php

namespace backend\modules\M5\controllers;

use Yii;
use common\models\Transactions;
use backend\models\TransactionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Trangthai;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use frontend\modules\M5\models\TransactionsViewForm;

/**
 * TransactionsController implements the CRUD actions for Transactions model.
 */
class TransactionsController extends Controller
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
     * Lists all Transactions models.
     * @return mixed
     */
    public function actionIndex($filer = 0)
    {
        $searchModel = new TransactionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$filer);

        $linkAjax = Url::to(['/M5/transactions/filerindex']);
        $countAll = Transactions::find()->count();
        $countNotActive = Transactions::find()->where(['status' => Transactions::SCENARIO_DEFAULT,'table_id'=>0,'type'=>'Pin'])->count();
        $countTake = Transactions::find()->where(['status' =>  Transactions::SATTUS_SUCCESS,'type'=>'Pin'])->count();
        $arrTitle = [
          ['count'=>$countAll,'title'=>'Tất cả','filer'=>0],
          ['count'=>$countNotActive,'title'=>'Yêu cầu pin','filer'=>  1  ],
          ['count'=>$countTake,'title'=>'Kết thúc','filer'=>  Transactions::SATTUS_SUCCESS],
        ];
        $dataListAction = ArrayHelper::map(Trangthai::find()->where(['type' => "Transactions"])->all(), 'id', 'ten');

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'filer' => $filer,
                    'type' => '',
                    'arrTitle'=>$arrTitle,
                    'dataProvider' => $dataProvider,
                    'dataList'=>$dataListAction,
                    'linkAjax'=>$linkAjax
        ]);
    }
    public function actionFilerindex() {
        if (isset($_POST['ids']) && isset($_POST['action'])) {
            $data = json_decode(stripslashes($_POST['ids']));
            $action = $_POST['action'];
            foreach ($data as $d) {
                $model = Transactions::findOne($d);
                $trangthai = Trangthai::findOne(['id' => $action]);
                if ($model && $trangthai ) {
                    $value = $trangthai->getValue();
                    if ($value == -1) {
                        $model->_delete();
                    } else {
                        if ($model->status != Transactions::SATTUS_SUCCESS) {
                            $model->run();
                        }
                    }
                }
            }
        }
    }
    public function actionView($id) {
        $model = TransactionsViewForm::findOne($id);
        if ($model) {
            if (Yii::$app->request->post() && $model->validate() && $model->saveData(TRUE)) {
                Yii::$app->session->setFlash('success', "Bạn đã bán pin thành công");
            }
            return $this->render('view',['model'=>$model]);
        }
    }


    /**
     * Deletes an existing Transactions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Transactions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transactions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transactions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
