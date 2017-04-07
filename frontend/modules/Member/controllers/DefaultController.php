<?php

namespace frontend\modules\Member\controllers;

use frontend\controllers\FrontendController;
use frontend\modules\Member\models\InfoForm;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use Yii;
use common\models\Config;
use common\models\LoginForm;
use common\models\Member;
use frontend\modules\Member\models\PasswordResetRequestForm;
use frontend\modules\Member\models\ResetPasswordForm;
use frontend\modules\Member\models\SignupForm;
use frontend\modules\Member\models\ChangeInfoForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use frontend\modules\Member\models\ChangePasswordForm;

/**
 * Site controller
 */
class DefaultController extends FrontendController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => TRUE,
                        'actions' => ['logout', 'index', 'info', 'upimage', 'signup', 'activate', 'changepassword', 'changeinfo', 'listpin', 'create', 'tree'],
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['signup', 'login', 'activate', 'demo', 'requestpasswordreset', 'resetpassword'],
                        'allow' => TRUE,
                        'roles' => ['?'],
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionInfo()
    {

        $model = InfoForm::findOne(Yii::$app->user->id);
        if ($model) {
            $steps = [
                [
                    'active' => $model->status >= Member::STATUS_ACTIVE,
                    'title' => Yii::t('app', 'MENU_INFO_PROFILE'),
                ],
                [
                    'active' => $model->status >= Member::STATUS_ADD_INFO,
                    'title' => Yii::t('app', 'INFO_BANK'),
                ],
                [
                    'active' => $model->status >= Member::STATUS_ACTIVED,
                    'title' => Yii::t('app', 'INFO_CHANGE_FINISH'),
                ]
            ];
            if ($model->status == Member::STATUS_ACTIVE){
                $model->scenario = InfoForm::SCENARIO_INFO;
            }
            if ($model->status == Member::STATUS_ADD_INFO){
                $model->scenario = InfoForm::SCENARIO_BANK;
            }
            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->changInfo()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'MEMBER_CHANGE_INFO_CHANGE_SCCESS'));
                return $this->redirect(Url::to(['info']));
            }else{
                if ($model->status < Member::STATUS_ACTIVED){
                    Yii::$app->session->setFlash('error', Yii::t('app', 'INFO_FAIL'));
                }
            }
            return $this->render('info', ['steps' => $steps, 'model' => $model]);
        }
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout = "@app/views/layouts/main-login.php";
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionUpimage()
    {
        if (isset($_FILES['image']) && !Yii::$app->user->isGuest) {
            $member = Member::findOne(Yii::$app->user->id);
            if ($member) {
                $image = $_FILES['image'];
                $sourcePath = $image['tmp_name'];
                $name = $image['name'];
                $type = @end(explode('.', $name));
                $nameNew = $member->username . '-' . strtotime("now") . '.' . $type;
                $path = Yii::getAlias("@pathimage") . '/avatar/temp/';
                $targetPath = $path . $nameNew;
                \common\func\FunctionCommon::getReziveFixed($name, $sourcePath, 600, 600, $targetPath);
                $strImage = Config::getValueConfig('baseUrl') . "/uploads/images/avatar/temp/" . $nameNew;
                echo json_encode(['link' => $strImage, 'name' => $nameNew]);
            }
        }
    }

    public function actionActivate($id, $key)
    {
        $member = Member::findOne(['id' => $id, 'auth_key' => $key]);
        if ($member) {
            if ($member->status == Member::STATUS_NOT_ACTIVE) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'ACTIVE_SUCCESS'));
                $member->status = Member::STATUS_ACTIVE;
                $member->auth_key = "";
                $member->save();
            }
            $this->goHome();
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSignup()
    {
        $key = \Yii::$app->request->get('key');
        $model = new SignupForm();
        $this->layout = "@app/views/layouts/main-login.php";
        $member = Member::findOne(['key_member' => $key]);
        if (!$member) {
            throw new BadRequestHttpException("Không tồn tại trang");
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup($member)) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'REGISTER_SUCCESS_INFO_ACTIVE'));
                return $this->goHome();
            }
        }
        return $this->render('signup-guest', [
            'model' => $model,
            'member' => $member
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionCreate()
    {
//        echo $key;die;
        $model = new SignupForm();
        $member = Member::findOne(Yii::$app->user->id);
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup($member)) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'REGISTER_SUCCESS_INFO_ACTIVE'));
                return $this->goHome();
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionIndex()
    {
        $model = ChangeInfoForm::findOne(Yii::$app->user->id);
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionTree()
    {
        $model = Member::findOne(Yii::$app->user->id);
        return $this->render('tree', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestpasswordreset()
    {
        $this->layout = "@app/views/layouts/main-login.php";
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'MEMBER_SIGNUP_REQUEST_PASSWORD_SUCCESS'));

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionChangeinfo()
    {
//        die(var_dump(rename($nameOld, $nameNew)));
        $model = ChangeInfoForm::findOne(Yii::$app->user->id);
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->changInfo()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'MEMBER_CHANGE_INFO_CHANGE_SCCESS'));
//            return $this->goHome();
        }
        return $this->render('chang_info', ['model' => $model]);
    }

    public function actionChangepassword()
    {
        $model = new ChangePasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->changepassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'MEMBER_CHANGE_PASSWORD_SUCCESS'));
//            return $this->goHome();
        }
        return $this->render('chang_password', ['model' => $model]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetpassword($token = '')
    {
        $this->layout = "@app/views/layouts/main-login.php";
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'MEMBER_SIGNUP_RESET_PASSWORD_SUCCESS'));
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

}
