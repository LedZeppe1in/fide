<?php

namespace app\controllers;

use app\models\FishboneDiagram;
use app\models\FishboneDiagramSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;




class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
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

    /*Displays homepage.*/
    public function actionIndex()
    {
        return $this->render('index');
    }

    /*Login action.*/
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /*Logout action.*/
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /*Displays about page.*/
    public function actionAbout()
    {
        return $this->render('about');
    }

    /*Displays help page.*/

    public function actionHelp()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('help', [
            'model' => $model,
        ]);
    }

    /*Displays documentation page.*/

    public function actionDocumentation()
    {
        return $this->render('documentation');
    }

    /*FishboneDiagram models*/
    /*Displays diagram page.*/
    public function actionDiagrams()
    {
        $searchModel = new FishboneDiagramSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('diagrams', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /*View a selected diagram.*/
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /*Creates a new FishboneDiagram model.*/
    public function actionCreate()
    {
        $model = new FishboneDiagram();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
            ]);
    }

    /*Updates an existing FishboneDiagram model.*/
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /*Deletes an existing FishboneDiagram model.*/
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['diagrams']);
    }

    /*Finds the FishboneDiagram model based on its primary key value.*/
    protected function findModel($id)
    {
        if (($model = FishboneDiagram::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
