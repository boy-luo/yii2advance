<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\rest\ActiveController;

//use yii\filters\RateLimiter;

/**
 * RESTful Web 服务（RESTful Web Services）:
 */
// class RestfulController extends Controller
class RestfulController extends ActiveController
{
    // public $modelClass = 'app\models\User';
    public $modelClass = 'common\models\User';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

//        $behaviors['rateLimiter'] = [
//            'class' => RateLimiter::className(),
//            'enableRateLimitHeaders' => true,
//        ];

          $behaviors['rateLimiter']['enableRateLimitHeaders'] = true;
        return $behaviors;

        // 注意:  漏桶配置在parent的配置中有class名称 才可以
//        $behaviors = [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['logout', 'signup'],
//                'rules' => [
//                    [
//                        'actions' => ['signup'],
//                        'allow' => true,
//                        'roles' => ['?'],
//                    ],
//                    [
//                        'actions' => ['logout'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
//        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        return 'doing...';
        // return $this->render('study');
    }

}
