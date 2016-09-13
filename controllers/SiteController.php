<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;
use yii\imagine\Image;

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
                    'entry' => ['get', 'put', 'post'],
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
            'page' => [
                'class' => 'yii\web\ViewAction',
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

    /**
     * Login action.
     *
     * @return string
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
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

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

    /**
     * 没意义，测试方法
     * @param string $message
     * @return string
     */
    public function actionSay($message = 'Hello')
    {
        return $this->render('say', ['message' => $message]);
    }


    public function actionEntry()
    {
        $model = new EntryForm;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // 验证 $model 收到的数据

            // 做些有意义的事 ...

            return $this->render('entryConfirm', ['model' => $model]);
        } else {
            // 无论是初始化显示还是数据验证错误
            return $this->render('entry', ['model' => $model]);
        }
    }

    /**
     * 小部件测试
     * @return string
     */
    public function actionHello()
    {
        return $this->render('hello');
    }

    /**
     * yiisoft/yii2-imagine 扩展测试 图片缩放
     */
    public function actionImg()
    {
        Image::thumbnail(Yii::$app->getBasePath().'\web\img\1.jpg', 120, 120)
            ->save(Yii::getAlias(Yii::$app->getBasePath().'\web\img\2.jpg'), ['quality' => 50]);
    }

    /**
     * 路由创建
     */
    public function actionUrl()
    {
        // creates a URL to a route: /index.php?r=post%2Findex
        echo Url::to(['post/index']);

        // creates a URL to a route with parameters: /index.php?r=post%2Fview&id=100
        echo Url::to(['post/view', 'id' => 100]);

        // creates an anchored URL: /index.php?r=post%2Fview&id=100#content
        echo Url::to(['post/view', 'id' => 100, '#' => 'content']);

        // creates an absolute URL: http://www.example.com/index.php?r=post%2Findex
        echo Url::to(['post/index'], true);

        // creates an absolute URL using the https scheme: https://www.example.com/index.php?r=post%2Findex
        echo Url::to(['post/index'], 'https');

        // currently requested route: /index.php?r=admin%2Fpost%2Findex
        echo Url::to(['']);

        // a relative route with action ID only: /index.php?r=admin%2Fpost%2Findex
        echo Url::to(['index']);

        // a relative route: /index.php?r=admin%2Fpost%2Findex
        echo Url::to(['post/index']);

        // an absolute route: /index.php?r=post%2Findex
        echo Url::to(['/post/index']);

        // /index.php?r=post%2Findex     assume the alias "@posts" is defined as "/post/index"
        echo Url::to(['@posts']);

        // currently requested URL: /index.php?r=admin%2Fpost%2Findex
        echo Url::to();

        // an aliased URL: http://example.com
        Yii::setAlias('@example', 'http://example.com/');
        echo Url::to('@example');

        // an absolute URL: http://example.com/images/logo.gif
        echo Url::to('/images/logo.gif', true);

        // home page URL: /index.php?r=site%2Findex
        echo Url::home();

        // the base URL, useful if the application is deployed in a sub-folder of the Web root
        echo Url::base();

        // the canonical URL of the currently requested URL
        // see https://en.wikipedia.org/wiki/Canonical_link_element
        echo Url::canonical();

        // remember the currently requested URL and retrieve it back in later requests
        Url::remember();
        echo Url::previous();
    }

    /**
     * 获取请求参数
     * 建议你像下面那样通过 request 组件来获取请求参数，
     * 而不是 直接访问 $_GET 和 $_POST。 这使你更容易编写测试用例，因为你可以伪造数据来创建一个模拟请求组件。
     */
    public function actionRequest()
    {
        $request = Yii::$app->request;

        $get = $request->get();
        // 等价于: $get = $_GET;

        $id = $request->get('id');
        // 等价于: $id = isset($_GET['id']) ? $_GET['id'] : null;

        $id = $request->get('id', 1);
        // 等价于: $id = isset($_GET['id']) ? $_GET['id'] : 1;

        $post = $request->post();
        // 等价于: $post = $_POST;

        $name = $request->post('name');
        // 等价于: $name = isset($_POST['name']) ? $_POST['name'] : null;

        $name = $request->post('name', '');
        // 等价于: $name = isset($_POST['name']) ? $_POST['name'] : '';

        // 返回所有参数
        //当实现 RESTful APIs 接口的时候，你经常需要获取通过PUT， PATCH或者其他的 request methods 请求方法提交上来的参数。
        //你可以通过调用 yii\web\Request::getBodyParam() 方法来获取这些参数。
        $params = $request->bodyParams;

        // 返回参数 "id"
        $param = $request->getBodyParam('id');
        //不同于 GET 参数，POST，PUT，PATCH 等等这些提交上来的参数是在请求体中被发送的。
        // 当你通过上面介绍的方法访问这些参数的时候，request 组件会解析这些参数。
        // 你可以通过配置 yii\web\Request::parsers 属性来自定义怎样解析这些参数。

        if ($request->isAjax) { /* 该请求是一个 AJAX 请求 */ }
        if ($request->isGet)  { /* 请求方法是 GET */ }
        if ($request->isPost) { /* 请求方法是 POST */ }
        if ($request->isPut)  { /* 请求方法是 PUT */ }

        // $headers 是一个 yii\web\HeaderCollection 对象
        $headers = Yii::$app->request->headers;

        // 返回 Accept header 值
        $accept = $headers->get('Accept');

        if ($headers->has('User-Agent')) {
            /* 这是一个 User-Agent 头 */
        }

        $userHost = Yii::$app->request->userHost;
        $userIP = Yii::$app->request->userIP;
    }


    public function actionA()
    {
        // $headers 是一个 yii\web\HeaderCollection 对象
        $headers = Yii::$app->request;

        // 返回 Accept header 值
        echo $headers->userIP;
    }
}