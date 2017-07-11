<?php

namespace app\controllers;

use app\models\SearchForm;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\widgets\ActiveForm;

class SiteController extends Controller
{
//    /**
//     * @inheritdoc
//     */
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['logout'],
//                'rules' => [
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
//    }

    /**
     * @inheritdoc
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
     * Displays homepage For Hotel Deals
     *
     * @return string
     */
    public function actionIndex()
    {
        // Let start by create Search From to make your life easy ;)
        $searchModel = new SearchForm();
        // Load string query to model
        $params=Yii::$app->request->get();
        $searchModel->load($params);
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($searchModel);
        }

        //Search for match result
        $deals =[];
        if(!empty($params)) {
            $deals = $searchModel->search();
        
        }
        $dataProvider = new ArrayDataProvider([
            'models' => $deals,
            'totalCount' => count($deals),
            'pagination' => [
                'pageSize' =>  count($deals),
                'totalCount' => count($deals),
                'forcePageParam' => true,
            ]
        ]);
        return $this->render('index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'title'=>Inflector::pluralize($searchModel->productType) .' Deals'
        ]);
    }


}
