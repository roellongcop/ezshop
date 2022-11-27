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
use app\models\Cart;

use app\models\search\ProductSearch;
use app\models\search\ReviewSearch;
use app\models\search\WishlistSearch;
use app\models\search\CartSearch;

use app\models\form\LoginForm;
use app\models\form\PasswordResetForm;
use app\models\form\CustomerSignupForm;
use app\models\form\ChangePasswordForm;
use app\models\form\CartForm;

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
        'add-to-cart',
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
            Product::findByKeywords($keywords, ['name'], 10, [
                'record_status' => Product::RECORD_ACTIVE
            ])
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
            if (App::identity('isCustomer')) {
                return $this->redirect(['customer-dashboard']);
            }
            return $this->redirect(['dashboard/index']);
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
        $searchModel = new ProductSearch(['record_status' => Product::RECORD_ACTIVE]);
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
                'status' => 'account-required',
                'errorSummary' => 'Adding item to wishlists needs an account.'
            ]);
        }

        if (($product_id = App::post('product_id')) != null) {

            $condition = [
                'product_id' => $product_id,
                'user_id' => App::identity('id')
            ];

            $wishlist = Wishlist::findOne($condition) ?: new Wishlist($condition);
            if ($wishlist->isNewRecord) {
                if ($wishlist->save()) {
                    return $this->asJson([
                        'status' => 'success',
                        'action' => 'save',
                        'title' => 'Remove from Wishlist',
                        'message' => 'Added to Wishlist'
                    ]);
                }
            }
            else {
                if ($wishlist->delete()) {
                    return $this->asJson([
                        'status' => 'success',
                        'action' => 'delete',
                        'title' => 'Add to Wishlist',
                        'message' => 'Removed from Wishlist'
                    ]);
                }
            }
            

            return $this->asJson([
                'status' => 'failed',
                'errorSummary' => $model->errorSummary
            ]); 
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

        $counter = rand(5, 10);
        $totalWishlist = App::post('totalWishlist') ?: 0;
        $totalCart = App::post('totalCart') ?: 0;

        for ($i=0; $i < $counter; $i++) { 
            $myTotalWishlist = App::identity('myTotalWishlist');
            $myTotalCart = App::identity('myTotalCart');

            if ($myTotalWishlist != (int)$totalWishlist || $myTotalCart != (int)$totalCart) {
                return $this->asJson([
                    'status' => 'success',
                    'totalWishlist' => $myTotalWishlist,
                    'totalWishlistFormatted' => number_format($myTotalWishlist),
                    'totalCart' => $myTotalCart,
                    'totalCartFormatted' => number_format($myTotalCart)
                ]);
                break;
            }

            
            sleep(2);
        }

        return $this->asJson([
            'status' => 'failed',
            'errorSummary' => 'no changes'
        ]);
    }

    public function actionMyWishlist()
    {
        $searchModel = new WishlistSearch([
            'user_id' => App::identity("id")
        ]);
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
            Wishlist::findByKeywords($keywords, 
                ['p.name', 'p.regular_price', 'p.sale_price'], 
                10, 
                [
                'w.user_id' => App::identity('id')
                ]
            )
        );
    }

    public function actionProductDetail($slug, $tab='description')
    {
        $product = Product::findOne(['slug' => $slug]);
        if (!$product) {
            throw new NotFoundHttpException('Page not found.');
        }

        $searchModel = new ReviewSearch([
            'product_id' => $product->id,
            'record_status' => Review::RECORD_ACTIVE,
        ]);
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
        if (App::isGuest()) {
            return $this->asJson([
                'status' => 'account-required',
                'errorSummary' => 'Adding item to cart needs an account.'
            ]);
        }
        
        $review = new Review([
            'product_id' => $product_id,
            'user_id' => App::identity('id'),
            'record_status' => Review::RECORD_INACTIVE
        ]);

        if ($review->load(App::post()) && $review->save()) {

            return $this->asJson([
                'status' => 'success',
                'review' => $review,
                'message' => 'Your review will be visible once approved',
            ]);
        }

        return $this->asJson([
            'status' => 'failed',
            'errorSummary' => $review->errorSummary
        ]);
    }


    public function actionMyReviews()
    {
        $searchModel = new ReviewSearch([
            'user_id' => App::identity("id")
        ]);
        $dataProvider = $searchModel->search(['ReviewSearch' => App::queryParams()]);
        $dataProvider->pagination->pageSize = 5;

        return $this->render('my-reviews', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionFindReviewsByKeywords($keywords='')
    { 
        return $this->asJson(
            Review::findByKeywords($keywords, 
                ['p.name', 'r.review'], 
                10, 
                [
                'r.user_id' => App::identity('id')
                ]
            )
        );
    }

    public function actionRemoveFromCart()
    {
        if (App::isGuest()) {
            return $this->asJson([
                'status' => 'account-required',
                'errorSummary' => 'Adding item to cart needs an account.'
            ]);
        }

        if (($cart = Cart::findOne(App::post('id'))) != null) {
            if ($cart->delete()) {
                return $this->asJson([
                    'status' => 'success',
                    'message' => 'Removed from Cart'
                ]);
            }
            else {
                return $this->asJson([
                    'status' => 'failed',
                    'errorSummary' => $cart->errorSummary
                ]);
            }
        }

        return $this->asJson([
            'status' => 'failed',
            'errorSummary' => 'Item not Found'
        ]);
    }

    public function actionAddToCart()
    {
        if (App::isGuest()) {
            return $this->asJson([
                'status' => 'account-required',
                'errorSummary' => 'Adding item to cart needs an account.'
            ]);
        }

        $model = new CartForm(['user_id' => App::identity('id')]);

        if ($model->load(['CartForm' => App::post()]) && $model->save()) {
            return $this->asJson([
                'status' => 'success',
                'message' => 'Added to cart'
            ]);
        }

        return $this->asJson([
            'status' => 'failed',
            'errorSummary' => Html::errorSummary($model)
        ]);
    }


    public function actionMyCart()
    {
        if (($carts = App::post('cart')) != null) {

            if (App::isGuest()) {
                return $this->asJson([
                    'status' => 'account-required',
                    'errorSummary' => 'Updating item to cart needs an account.'
                ]);
            }

            foreach ($carts as $cart) {
                Cart::updateAll(['quantity' => $cart['quantity']], ['id' => $cart['id']]);
            }

            return $this->asJson([
                'status' => 'success',
                'message' => 'Cart Updated'
            ]);
        }

        $searchModel = new CartSearch([
            'user_id' => App::identity("id"),
            'session_id' => App::session('id')
        ]);

        $dataProvider = $searchModel->search(['CartSearch' => App::queryParams()]);
        $dataProvider->pagination->pageSize = 5;

        return $this->render('my-cart', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    public function actionFindCartByKeywords($keywords='')
    { 
        return $this->asJson(
            Cart::findByKeywords($keywords, 
                ['c.color', 'c.size', 'p.name', 'p.regular_price', 'p.sale_price'], 
                10, 
                [
                'c.user_id' => App::identity('id')
                ]
            )
        );
    }

    public function actionCheckout()
    {
        $billing = new BillingDetailForm(['user_id' => App::identity('id')]);


        return $this->render('checkout', [
            'billing' => $billing
        ]);
    }
}