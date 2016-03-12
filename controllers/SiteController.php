<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UserAddress;
use app\models\Product;
use app\models\Manufacturer;
use app\models\ManufacturerAddress;
use app\models\Repository;
use app\models\AddProductForm;
use app\models\AddManufacturerForm;
use app\models\Region;
use app\models\AddRepository;
use app\models\RepositoryAddress;
use app\models\Order;
use app\models\OrderDetail;
use app\models\AddOrderForm;

class SiteController extends Controller
{
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

    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(array('/site/login'));
        } else {
            //print_r(\Yii::$app->user->name);
            $userAddress = UserAddress::findOne(['user_address_id', \Yii::$app->user->identity->user_address_id]);
            $products = Product::find()->all();

            return $this->render('index', ['products' => $products]);
        }
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['/site/login']);
    }

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

    public function actionManufacturer()
    {
        $manufacturers = Manufacturer::find()->all();

        return $this->render('manufacturer', ['manufacturers' => $manufacturers]);
    }

    public function actionRepository()
    {
        $repositories = Repository::find()->all();

        return $this->render('repository', ['repositories' => $repositories]);
    }

    public function actionAddproduct()
    {
        $model = new AddProductForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            print_r($model);
            $product = new Product();
            $product->product_name = $model->name;
            $product->manufacturer_id = $model->manufacturer;
            $product->product_num = $model->num;
            $product->repository_id = $model->repository;
            $product->product_default_price = $model->defaultPrice;
            $product->save();

            return $this->redirect(['site/index']);
        } else {
            $manufacturerDatabases = Manufacturer::find()->all();
            $manufacturers = [];
            foreach ($manufacturerDatabases as $manufacture) {
                $manufacturers[$manufacture->manufacturer_id] = $manufacture->manufacturer_name;
            }

            $repositoryDatabases = Repository::find()->all();
            $repositories = [];
            foreach ($repositoryDatabases as $repository) {
                $repositories[$repository->repository_id] = $repository->repository_name;
            }

            return $this->render('addProduct', ['model' => $model, 'manufacturers' => $manufacturers, 'repositories' => $repositories]);
        }
    }

    public function actionAddmanufacturer()
    {
        $model = new AddManufacturerForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $address = new ManufacturerAddress();
            $address->region_province_id = $model->regionProvince;
            $address->region_city_id = $model->regionCity;
            $address->region_country_id = $model->regionCountry;
            $address->manufacturer_address = $model->detailAddress;
            $address->save();
            $manufacturer = new Manufacturer();
            $manufacturer->manufacturer_name = $model->name;
            $manufacturer->manufacturer_address_id = $address->manufacturer_address_id;
            $manufacturer->save();

            return $this->redirect(['/site/manufacturer']);
        } else {
            $regionProvinces = Region::getProvices();

            return $this->render('AddManufacturer', ['model' => $model, 'regionProvinces' => $regionProvinces]);
        }
    }

    public function actionGetregion()
    {
        if (isset(Yii::$app->request->post()['parentId'])) {
            $parentId = Yii::$app->request->post()['parentId'];
            $regions = Region::getRegionByParent($parentId);
            echo json_encode($regions, JSON_UNESCAPED_UNICODE);
        }
    }

    public function actionAddrepository()
    {
        $model = new AddRepository();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $address = new RepositoryAddress();
            $address->region_province_id = $model->regionProvince;
            $address->region_city_id = $model->regionCity;
            $address->region_country_id = $model->regionCountry;
            $address->repository_address = $model->detailAddress;
            $address->save();
            $repository = new Repository();
            $repository->repository_address_id = $address->repository_address_id;
            $repository->repository_name = $model->name;
            $repository->repository_contact_name = $model->contactName;
            $repository->repository_contact_call = $model->contactCall;
            $repository->save();

            return $this->redirect(['site/repository']);
        } else {
            $regionProvinces = Region::getProvices();

            return $this->render('addRepository', ['model' => $model, 'regionProvinces' => $regionProvinces]);
        }
    }

    public function actionOrder()
    {
        $orders = Order::find()->all();
        $orderDetails = [];
        foreach ($orders as $order) {
            $orderDetail = OrderDetail::find()->where(['order_id' => $order->order_id])->all();
            $orderStruct['order'] = $order;
            $orderStruct['detail'] = $orderDetail;
            array_push($orderDetails, $orderStruct);
        }

        return $this->render('order', ['orders' => $orderDetails]);
    }

    public function actionAddorder()
    {
        $model = new AddOrderForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            var_dump($model->productId);
        } else {
            $userAddress = UserAddress::findOne(['user_address_id', \Yii::$app->user->identity->user_address_id]);
            $products = Product::find()->all();

            return $this->render('addOrder', ['products' => $products, 'model' => $model]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
