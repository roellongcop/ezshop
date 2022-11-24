<?php

namespace app\controllers;

use app\helpers\App;
use app\helpers\Html;
use app\helpers\ArrayHelper;

use app\models\Email;
use app\models\Product;
use app\models\User;
use app\models\Province;
use app\models\Municipality;
use app\models\Wishlist;
use app\models\Review;

use app\models\search\ProductSearch;
use app\models\search\ReviewSearch;
use app\models\search\WishlistSearch;

use app\models\form\LoginForm;
use app\models\form\PasswordResetForm;
use app\models\form\CustomerSignupForm;
use app\models\form\ChangePasswordForm;

use app\models\form\user\BillingDetailForm;

use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    public $layout = 'frontend';
    
    const PUBLIC_ACTIONS = [
        'login', 
        'reset-password', 
        'contact', 
        'home', 
        'find-products-by-keywords',
        'about',
        'contact',
        'shop',
        'signup',
        'signup-success',
        'signup-verification',
        'my-account-details',
        'to-wishlist',
        'navbar-poll',
        'product-detail'
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['AccessControl'] = [
            'class' => 'app\filters\AccessControl',
            'publicActions' => self::PUBLIC_ACTIONS
        ];

        $behaviors['VerbFilter'] = [
            'class' => 'app\filters\VerbFilter',
            'verbActions' => [
                'logout' => ['post'],
            ]
        ];

        return $behaviors;
    }

    public function beforeAction($action)
    {
        App::view()->params['wishlistProductIds'] = App::isLogin() ? array_values(ArrayHelper::map(App::identity('wishlists'), 'id', 'product_id')): []; 
        
        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => 'error'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionSignupSuccess($verification_token)
    {
        $user = User::findOne(['verification_token' => $verification_token]);
        if ($user) {
            return $this->render('signup-success', [
                'user' => $user
            ]);
        }

        App::danger('User not found');

        return $this->redirect(['signup']);
    }

    public function actionSignupVerification($verification_token)
    {
        $user = User::findOne(['verification_token' => $verification_token]);
        if ($user) {
            if ($user->status == User::STATUS_UNVERIFIED) {
                $user->status = User::STATUS_ACTIVE;
                $user->save();

                App::loginUser($user, 0);

                App::success('Account Verified');

                return $this->redirect(['customer-dashboard']);
            }
            else {
                if (App::isGuest()) {
                    App::loginUser($user, 0);
                }
                App::success('User already verified');
                return $this->redirect(['customer-dashboard']);
            }
        }
        
        App::waring('User not found');
        return $this->redirect(['signup']);
    }

    public function actionCustomerDashboard()
    {
        return $this->render('customer-dashboard');
    }

    public function actionSignup()
    {
        $model = new CustomerSignupForm();

        if ($model->load(App::post()) && ($user = $model->signup()) != null) {
            App::success('Sign Up Successfully');

            return $this->redirect([
                'signup-success', 
                'verification_token' => $user->verification_token
            ]);
        }

        return $this->render('signup', [
            'model' => $model
        ]);
    }

    public function actionFindProductsByKeywords($keywords='')
    {
        return $this->asJson(
            Product::findByKeywords($keywords, ['name'])
        );
    }

    public function actionHome()
    {
        return $this->render('home');
    }

    public function actionResetPassword()
    {
        $model = new PasswordResetForm();
        if ($model->load(App::post())) {
            if (($user = $model->process()) != null) {
                if ($model->hint) {
                    App::success("Your password hint is: '{$user->password_hint}'.");
                }
                else {
                    App::success("Email sent.");
                }
            }
            else {
                App::danger($model->errors);
            }
        }

        return $this->redirect(['login']);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (App::isLogin()) {
            if (App::identity('isCustomer')) {
                return $this->redirect(['home']);
            }

            return $this->redirect(['dashboard/index']);
        }

        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (App::isLogin()) {
            if (App::identity('isCustomer')) {
                return $this->redirect(['customer-dashboard']);
            }
            return $this->redirect(['dashboard/index']);
        }

        $model = new LoginForm();
        $PSR = new PasswordResetForm();
        if ($model->load(App::post()) && $model->login()) {
            $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
            'PSR' => $PSR,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        App::logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new Email();
        if ($model->load(App::post()) && $model->save()) {
            App::success('Thank you for contacting us. We will respond to you as soon as possible.');
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

    public function actionShop()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(['ProductSearch' => App::queryParams()]);
        $dataProvider->pagination->pageSize = 9;

        return $this->render('shop', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionMyAccountDetails($province_id='')
    {
        if ($province_id) {
            return $this->asJson([
                'data' => Html::if(Province::findOne($province_id), function($province) {
                    return Html::foreach(Municipality::findAll(['prov' => $province->prov]), function($municipality) {
                        return Html::tag('option', $municipality->Municipality, [
                            'value' => $municipality->id
                        ]);
                    });
                })
            ]);
        }

        $identity = App::identity();

        $billing = new BillingDetailForm(['user_id' => $identity->id]);
        $password = new ChangePasswordForm(['user_id' => $identity->id]);
        

        if ($billing->load(App::post()) && $billing->save()) {
            App::success('Profile Information Updated');

            return $this->redirect(['my-account-details']);
        }

        if ($password->load(App::post()) && $password->changePassword()) {
            App::success('Password Updated');

            return $this->redirect(['my-account-details']);
        }

        return $this->render('my-account-details', [
            'identity' => $identity,
            'billing' => $billing,
            'password' => $password,
        ]);
    }

    public function actionToWishlist()
    {
        if (App::isGuest()) {
            return $this->asJson([
                'status' => 'failed',
                'errorSummary' => 'Adding item to wishlists needs an account.'
            ]);
        }

        if (($product_id = App::post('product_id')) != null) {

            $condition = [
                'product_id' => $product_id,
                'user_id' => App::identity('id')
            ];

            if (($wishlist = Wishlist::findOne($condition)) != null) {
                if ($wishlist->delete()) {
                    return $this->asJson([
                        'status' => 'success',
                        'action' => 'delete',
                        'title' => 'Add to Wishlist',
                        'message' => 'Removed from Wishlist'
                    ]);
                }
            }

            $wishlist = new Wishlist($condition);

            if ($wishlist->save()) {
                return $this->asJson([
                    'status' => 'success',
                    'action' => 'save',
                    'title' => 'Remove from Wishlist',
                    'message' => 'Added to Wishlist'
                ]);
            }
        }

        return $this->asJson([
            'status' => 'failed',
            'errorSummary' => 'No product found'
        ]);
    }

    public function actionNavbarPoll()
    {
        session_write_close();
        ignore_user_abort(false);
        set_time_limit(0);

        try {

            if(($post = App::post()) != null) {

                $noChanges = true;
                $trial = rand(5, 10);

                while($noChanges) {
                    if ($trial == 0) {
                        $response['status'] = 'failed';
                        $response['errorSummary'] = 'no changes';
                        return $this->asJson($response);
                    }
                    $response = [];

                    $myTotalWishlist = App::identity('myTotalWishlist');

                    if ($myTotalWishlist != (int)$post['totalWishlist']) {
                        $noChanges = false;
                        $response['totalWishlist'] = $myTotalWishlist;
                        $response['totalWishlistFormatted'] = number_format($myTotalWishlist);

                    }



                    if ($noChanges == false) {
                        $response['status'] = 'success';

                        return $this->asJson($response);
                    }

                    if (! $response) {
                        $trial--;
                    }

                    sleep(2);
                }
            }

            return $this->asJson([
                'status' => 'failed',
                'errorSummary' => 'No Chat State sent'
            ]);

        } 
        catch (\yii\base\ErrorException $e) {
            return $this->asJson([
                'status' => 'failed',
                'errorSummary' => $e->message
            ]);
        }
    }

    public function actionMyWishlist()
    {
        $searchModel = new WishlistSearch();
        $dataProvider = $searchModel->search(['WishlistSearch' => App::queryParams()]);
        $dataProvider->pagination->pageSize = 5;

        return $this->render('my-wishlist', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionFindWishlistByKeywords($keywords='')
    { 
        return $this->asJson(
            Wishlist::findByKeywords($keywords, ['p.name', 'p.regular_price', 'p.sale_price'])
        );
    }

    public function actionProductDetail($slug, $tab='')
    {
        $product = Product::findOne(['slug' => $slug]);
        if (!$product) {
            throw new NotFoundHttpException('Page not found.');
        }

        $searchModel = new ReviewSearch(['product_id' => $product->id]);
        $dataProvider = $searchModel->search(['ReviewSearch' => App::queryParams()]);
        $dataProvider->pagination->pageSize = 3;

        return $this->render('product-detail', [
            'product' => $product,
            'tab' => $tab,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddReview($product_id)
    {
        $review = new Review([
            'product_id' => $product_id,
            'user_id' => App::identity('id')
        ]);

        if ($review->load(App::post()) && $review->save()) {

            return $this->asJson([
                'status' => 'success',
                'review' => $review,
                'message' => 'Review Added',
            ]);
        }

        return $this->asJson([
            'status' => 'failed',
            'errorSummary' => $review->errorSummary
        ]);
    }
}