<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Category;
use app\models\Product;
use app\models\Client;
class SiteController extends Controller
{

    /**
     * @inheritdoc
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
     * Displays homepage.
     *
     * @return string
     */
     public function actionIndex()
    {
         return $this->render('index');
    }
    public function actionCatalog()
    {
        return $this->render('catalog');
    }

    /**
     * Login action.
     *
     * @return string
     */
    // public function actionLogin()
    // {
    //     if (!Yii::$app->user->isGuest) {
    //         return $this->goHome();
    //     }

    //     $model = new LoginForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->login()) {
    //         return $this->goBack();
    //     }
    //     return $this->render('login', [
    //         'model' => $model,
    //     ]);
    // }
    // public function actionSignup()
    // {
    //     $model = new SignupForm();
 
    //     if ($model->load(Yii::$app->request->post())) {
    //         if ($user = $model->signup()) {
    //             if (Yii::$app->getUser()->login($user)) {
    //                 return $this->goHome();
    //             }
    //         }
    //     }
 
    //     return $this->render('signup', [
    //         'model' => $model,
    //     ]);
    // }
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        
        return parent :: beforeAction($action);
    }
    public function actionRegister(){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $users = Client::find()->where(['=','name',$name])->orwhere(['=','email',$email])->orwhere(['=','phone',$phone])->one();
        if(isset($users)){
            $result = 'Пользователь с данным именем , почтой или телефоном уже существует!';
            return $this->render('register',compact('result')); 
        }
        else{
            $db=Yii::$app->getDb();
            $db->createCommand('INSERT INTO `clients` (`name`,`email`,`password`,`phone`,`city`,`adress`,`postcode`) VALUES (:name ,:email,:password,:phone,:city,:adress,:postcode)', [
                    ':name' => $_POST['name'],
                    ':email' => $_POST['email'],
                    ':password' => $_POST['password'],
                    ':phone' => $_POST['phone'],
                    ':city' => $_POST['city'],
                    ':adress' => $_POST['address'],
                    ':postcode' => $_POST['postcode']
                ])->execute();
            $result = 'Благодарим за регистрацию';

            $session = Yii::$app->session;
            $session->set('username', $name);
            return $this->render('register',compact('result','name'));
        }
    }
    public function actionLogin(){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $users = Client::find()->where(['=','name',$email])->orwhere(['=','email',$email])->andwhere(['=','password',$password])->one();
        if(isset($users)){
            $result = 'Успешно авторизировано!';

            $session = Yii::$app->session;
            $session->set('username', $email);
            $name=$email;
            return $this->render('login',compact('result','name'));
        }
        else{
            $result = 'Пользователь с такими данными не найден';
            return $this->render('login',compact('result')); 
        }
    }
    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->session->close();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
