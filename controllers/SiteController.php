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
use app\models\Client;
use app\models\AddClientForm;
use app\models\ClientAddress;
use app\models\Purchase;
use app\models\PurchaseDetail;
use app\models\AddPurchaseForm;
use app\models\Dispatch;
use app\models\DispatchDetail;
use app\models\AddDispatchForm;

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

    public function actionClient()
    {
        $clients = Client::find()->all();

        return $this->render('client', ['clients' => $clients]);
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

    public function actionAddclient()
    {
        $model = new AddClientForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $address = new ClientAddress();
            $address->region_province_id = $model->regionProvince;
            $address->region_city_id = $model->regionCity;
            $address->region_country_id = $model->regionCountry;
            $address->client_address = $model->detailAddress;
            $address->save();
            $client = new Client();
            $client->client_name = $model->name;
            $client->client_address_id = $address->client_address_id;
            $client->save();

            return $this->redirect(['/site/client']);
        } else {
            $regionProvinces = Region::getProvices();

            return $this->render('addClient', ['model' => $model, 'regionProvinces' => $regionProvinces]);
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

    public function actionPurchase()
    {
        $purchases = Purchase::find()->all();
        $purchaseDetails = [];
        foreach ($purchases as $purchase) {
            $purchaseDetail = PurchaseDetail::find()->where(['purchase_id' => $purchase->purchase_id])->all();
            $purchaseStruct['order'] = $purchase;
            $purchaseStruct['detail'] = $purchaseDetail;
            array_push($purchaseDetails, $purchaseStruct);
        }

        return $this->render('purchase', ['purchases' => $purchaseDetails]);
    }

    public function actionDispatch()
    {
        $dispatchs = Dispatch::find()->all();
        $dispatchDetails = [];
        foreach ($dispatchs as $dispatch) {
            $purchaseDetail = DispatchDetail::find()->where(['dispatch_id' => $dispatch->dispatch_id])->all();
            $dispatchStruct['order'] = $dispatch;
            $dispatchStruct['detail'] = $purchaseDetail;
            array_push($dispatchDetails, $dispatchStruct);
        }

        return $this->render('dispatch', ['dispatchs' => $dispatchDetails]);
    }

    public function actionAddorder()
    {
        $model = new AddOrderForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $order = new Order();
            $order->order_status = 0;
            $order->client_id = $model->client;
            $order->order_total_money = 0;
            $order->save();
            $totalMoney = 0;
            $len = count($model->productId);
            for ($i = 0; $i < $len; ++$i) {
                $productId = intval($model->productId[$i]);
                $productNum = intval($model->productNum[$i]);

                if ($productNum > 0) {
                    $orderDetail = new OrderDetail();
                    $orderDetail->order_id = $order->order_id;
                    $orderDetail->product_id = $productId;
                    $orderDetail->product_num = $productNum;
                    $product = Product::find()->where(['product_id' => $productId])->one();
                    $orderDetail->order_detail_total_money = $product->product_default_price * $productNum;
                    $totalMoney = $totalMoney + $orderDetail->order_detail_total_money;
                    $orderDetail->save();
                }
            }
            $order->order_total_money = $totalMoney;
            $order->save();

            return $this->redirect(['site/order']);
        } else {
            $userAddress = UserAddress::findOne(['user_address_id', \Yii::$app->user->identity->user_address_id]);
            $products = Product::find()->all();
            $clientDb = Client::find()->all();
            $clients = [];
            foreach ($clientDb as $client) {
                $clients[$client->client_id] = $client->client_name;
            }

            return $this->render('addOrder', ['products' => $products, 'model' => $model, 'clients' => $clients]);
        }
    }

    public function actionAddpurchase()
    {
        $model = new AddPurchaseForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $purchase = new Purchase();
            $purchase->purchase_status = 0;
            $purchase->purchase_total_money = 0;
            $purchase->save();
            $totalMoney = 0;
            $len = count($model->productId);
            for ($i = 0; $i < $len; ++$i) {
                $productId = intval($model->productId[$i]);
                $productNum = intval($model->productNum[$i]);

                if ($productNum > 0) {
                    $purchaseDetail = new PurchaseDetail();
                    $purchaseDetail->purchase_id = $purchase->purchase_id;
                    $purchaseDetail->product_id = $productId;
                    $purchaseDetail->product_num = $productNum;
                    $product = Product::find()->where(['product_id' => $productId])->one();
                    $purchaseDetail->purchase_detail_total_money = $product->product_default_price * $productNum;
                    $totalMoney = $totalMoney + $purchaseDetail->purchase_detail_total_money;
                    $purchaseDetail->save();
                }
            }
            $purchase->purchase_total_money = $totalMoney;
            $purchase->save();

            return $this->redirect(['site/purchase']);
        } else {
            $products = Product::find()->all();

            return $this->render('addPurchase', ['products' => $products, 'model' => $model]);
        }
    }

    public function actionAdddispatch()
    {
        $model = new AddDispatchForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $dispatch = new Dispatch();
            $dispatch->dispatch_status = 0;
            $dispatch->repository_to_id = $model->repository;
            $dispatch->save();
            $len = count($model->productId);
            for ($i = 0; $i < $len; ++$i) {
                $productId = intval($model->productId[$i]);
                $productNum = intval($model->productNum[$i]);
                if ($productNum > 0) {
                    $dispatchDetail = new DispatchDetail();
                    $dispatchDetail->dispatch_id = $dispatch->dispatch_id;
                    $dispatchDetail->product_id = $productId;
                    $dispatchDetail->product_num = $productNum;
                    $dispatchDetail->save();
                }
            }

            return $this->redirect(['site/dispatch']);
        } else {
            $products = Product::find()->all();
            $repositoryDb = Repository::find()->all();
            $repositories = [];
            foreach ($repositoryDb as $repository) {
                $repositories[$repository->repository_id] = $repository->repository_name;
            }

            return $this->render('addDispatch', ['products' => $products, 'model' => $model, 'repositories' => $repositories]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
