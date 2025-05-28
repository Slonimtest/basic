<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Url;
use Endroid\QrCode\Builder\Builder;
use yii\helpers\Url as YiiUrl;
use Endroid\QrCode\Writer\PngWriter;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionShorten()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $inputUrl = Yii::$app->request->post('url');

        if (!filter_var($inputUrl, FILTER_VALIDATE_URL)) {
            return ['success' => false, 'message' => 'Невалидный URL'];
        }

        if (!@fopen($inputUrl, 'r')) {
            return ['success' => false, 'message' => 'Данный URL не доступен'];
        }

        $shortCode = substr(md5($inputUrl . microtime()), 0, 6);
        $model = new Url([
            'original_url' => $inputUrl,
            'short_code'   => $shortCode,
        ]);

        if ($model->save()) {
            $shortLink = YiiUrl::to(['/redirect/go', 'code' => $shortCode], true);
            return [
                'success' => true,
                'short_link' => $shortLink,
                'qr' => YiiUrl::to(['/site/qr', 'code' => $shortCode], true),
            ];
        }

        return ['success' => false, 'message' => 'Ошибка при сохранении'];
    }

    public function actionQr($code)
    {
        $url = Url::findOne(['short_code' => $code]);
        if (!$url) {
            throw new \yii\web\NotFoundHttpException('Ссылка не найдена');
        }

        $builder = new Builder(
            new PngWriter(),
            [],
            false,
            YiiUrl::to(['/redirect/go', 'code' => $url->short_code], true),
        );

        $result = $builder->build();

        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', $result->getMimeType());
        return $result->getString();
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
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

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
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
