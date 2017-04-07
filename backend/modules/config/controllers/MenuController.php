<?php

namespace backend\modules\config\controllers;

use Yii;
use backend\modules\config\models\Menu;
use common\func\StaticDefine;
use backend\modules\posts\models\Category;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller {
    public $enableCsrfValidation = false;
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['get'],
                ],
            ],
        ];
    }

    public function saveMenu($value, $parent_id, $order) {
        $name = $value->name;
        $val = $value->idpost;
        $tblName = $value->type;
        $optab = $value->newtab;
        if ($tblName == 'linktinh') {
            $val = $value->url;
        }

        $model = Menu::saveMenu($name, $val, $tblName, $parent_id, $optab, $order);
        if (isset($value->children)) {
            $orderPar = 1;
            foreach ($value->children as $k => $child) {
                if ($model) {
                    $this->saveMenu($child, $model->id, $orderPar);
                }
                $orderPar++;
            }
        }
    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex($id = 0, $new = 0) {
        $category = Category::find()->all();
        $model = Menu::findOne($id);
        if (!$model && $new == 1) {
            $model = new Menu();
        } elseif (!$model) {
            $model = Menu::find()->orderBy(['id' => SORT_ASC])->one();
            if ($model) {
                $model->select_menu = $model->id;
            }
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $arrMenu = json_decode($model->json_value);
            $model->Xoa();
            foreach ($arrMenu as $key => $value) {
                $this->saveMenu($value, $model->id, 0);
            }
            return $this->redirect(['index', 'id' => $model->id]);
        }
        return $this->render('index', [
                    'category' => $category,
                    'model' => $model
        ]);
    }

    public function actionManage() {
        $model = new Menu();
        $_header = Menu::findOne(['type' => StaticDefine::$HEADER_MENU]);
        if ($_header) {
            $model->header_menu = $_header->id;
        }
        $_footer = Menu::findOne(['type' => StaticDefine::$FOOTER_MENU]);
        if ($_footer) {
            $model->footer_menu = $_footer->id;
        }
        $_sidebar = Menu::findOne(['type' => StaticDefine::$SIDEBAER_MENU]);
        if ($_sidebar) {
            $model->sidebar_menu = $_sidebar->id;
        }
        if ($model->load(Yii::$app->request->post())) {
            $hear = Menu::findOne($model->header_menu);
            if ($hear) {
                $hear->setTypeMenu(StaticDefine::$HEADER_MENU);
            }  else {
                if ($_header) {
                    $_header->type = '';
                    $_header->save(FALSE);
                }
            }
            $footer = Menu::findOne($model->footer_menu);
            if ($footer) {
                $footer->setTypeMenu(StaticDefine::$FOOTER_MENU);
            }  else {
                if ($_footer) {
                    $_footer->type = '';
                    $_footer->save(FALSE);
                }
            }
            $sibar = Menu::findOne($model->sidebar_menu);
            if ($sibar) {
                $sibar->setTypeMenu(StaticDefine::$SIDEBAER_MENU);
            }  else {
                if ($_sidebar) {
                    $_sidebar->type = '';
                    $_sidebar->save(FALSE);
                }
            }
            return $this->redirect(['manage']);
        }
        return $this->render('manage', ['model' => $model]);
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->Xoa();
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
