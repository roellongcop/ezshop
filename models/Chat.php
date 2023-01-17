<?php

namespace app\models;

use app\widgets\Anchor;
use app\widgets\Label;
use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;

/**
 * This is the model class for table "{{%chats}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $reply_id
 * @property string $session_id
 * @property string|null $message
 * @property int $status
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Chat extends ActiveRecord
{
    const ANSWERED = 0;
    const UN_ANSWERED = 1;
    const TRAINED = 2;

    const TYPE_CHATBOT = 0;
    const TYPE_USER = 1;

    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%chats}}';
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['timeSent'] = 'timeSent';
        $fields['displayMessage'] = 'displayMessage';


        return $fields;
    }

    public function config()
    {
        return [
            'controllerID' => 'chat',
            'mainAttribute' => 'id',
            'paramName' => 'id',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['user_id', 'reply_id', 'status', 'type'], 'integer'],
            [['session_id', 'type'], 'required'],
            [['message'], 'string'],
            [['session_id'], 'string', 'max' => 255],
            ['user_id', 'exist', 'targetRelation' => 'user', 'when' => fn($model) => $model->user_id],
            ['reply_id', 'exist', 'targetRelation' => 'reply', 'when' => fn($model) => $model->reply_id],
            ['status', 'in', 'range' => [
                self::ANSWERED,
                self::UN_ANSWERED,
                self::TRAINED
            ]],
            ['type', 'in', 'range' => [
                self::TYPE_CHATBOT,
                self::TYPE_USER,
            ]],
            [['message', 'hidden_message'], 'trim'],
            [['hidden_message'], 'safe'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'user_id' => 'User ID',
            'reply_id' => 'Reply ID',
            'session_id' => 'Session ID',
            'message' => 'Message',
            'status' => 'Status',
        ]);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->message = $this->setTheMessage();

        $this->user_id = App::ifElse(App::identity(), fn($user) => $user->id, 0);

        return true;
    }

    public function setTheMessage()
    {
        $replace = $this->replace();

        $message = $this->message;

        foreach ($replace as $key => $data) {
            if (str_contains($message, $key)) {
                $value = is_callable($data['value']) ? call_user_func($data['value']): $data['value'];

                $message = str_replace($key, $value, $message);
            }
        }

        return $message;
    }

    public function replace()
    {
        $chatbot = App::setting('chatbot');

        return [
            '[CHATBOT_NAME]' => [
                'description' => 'Chatbot Name',
                'value' => $chatbot->name
            ],
            '[LOGIN_PAGE]' => [
                'description' => 'Login page link',
                'value' => Html::tag('a', 'Login Page', [
                    'href' => Url::toRoute(['site/login']),
                    'class' => 'btn btn-outline-success btn-pill mb-1',
                    'target' => '_blank'
                ]),
            ],
            '[SIGNUP_PAGE]' => [
                'description' => 'Signup page link',
                'value' => Html::tag('a', 'Signup Page', [
                    'href' => Url::toRoute(['site/signup']),
                    'class' => 'btn btn-outline-success btn-pill mb-1',
                    'target' => '_blank'
                ]),
            ],
            '[HOME_PAGE]' => [
                'description' => 'Home page link',
                'value' => Html::tag('a', 'Home Page', [
                    'href' => Url::toRoute(['site/home']),
                    'class' => 'btn btn-outline-success btn-pill mb-1',
                    'target' => '_blank'
                ]),
            ],
            '[SHOP_PAGE]' => [
                'description' => 'Shop page link',
                'value' => Html::tag('a', 'Shop Page', [
                    'href' => Url::toRoute(['site/shop']),
                    'class' => 'btn btn-outline-success btn-pill mb-1',
                    'target' => '_blank'
                ]),
            ],
            '[CART_PAGE]' => [
                'description' => 'Cart page link',
                'value' => Html::tag('a', 'Cart Page', [
                    'href' => Url::toRoute(['site/my-cart']),
                    'class' => 'btn btn-outline-success btn-pill mb-1',
                    'target' => '_blank'
                ]),
            ],
            '[CHECKOUT_PAGE]' => [
                'description' => 'Checkout page link',
                'value' => Html::tag('a', 'Checkout Page', [
                    'href' => Url::toRoute(['site/checkout']),
                    'class' => 'btn btn-outline-success btn-pill mb-1',
                    'target' => '_blank'
                ]),
            ],
            '[ABOUT_PAGE]' => [
                'description' => 'About page link',
                'value' => Html::tag('a', 'About Page', [
                    'href' => Url::toRoute(['site/about']),
                    'class' => 'btn btn-outline-success btn-pill mb-1',
                    'target' => '_blank'
                ]),
            ],

            '[CONTACT_PAGE]' => [
                'description' => 'Contact page link',
                'value' => Html::tag('a', 'Contact Page', [
                    'href' => Url::toRoute(['site/contact']),
                    'class' => 'btn btn-outline-success btn-pill mb-1',
                    'target' => '_blank'
                ]),
            ],
            '[PRICE_RANGE]' => [
                'description' => 'Clickable price range of products',
                'value' => function() {

                    return App::foreach(App::setting('price')->priceRange, 
                        fn($value, $key) => Html::tag('a', '₱'.number_format($key).' - ₱' . number_format($value), [
                        'href' => Url::toRoute(['site/shop', 'price_range[]' => "{$key}-{$value}"]),
                        'class' => 'btn btn-outline-success btn-pill mb-1',
                        'target' => '_blank'
                    ]));
                }
            ],
            '[PRODUCT_CATEGORIES]' => [
                'description' => 'Clickable 5 product categories',
                'value' => function() {
                    $categories = ProductCategory::dropdown('id', 'name',[], true, 5);

                    $data = App::foreach($categories, fn($category) => Html::tag('a', $category, [
                        'href' => Url::toRoute(['site/shop', 'categories' => $category]),
                        'class' => 'btn btn-outline-success btn-pill mb-1',
                        'target' => '_blank'
                    ]), false);

                    return implode('', $data ?: []);
                }
            ],
            '[PRODUCT_SALE]' => [
                'description' => 'Clickable 5 product on sale',
                'value' => function() {
                    $products = Product::find()
                        ->where("`sale_price` < `regular_price`")
                        ->active()
                        ->limit(5)
                        ->all();

                    $data = App::foreach($products, fn($product) => Html::tag('a', $product->name, [
                        'href' => Url::toRoute(['site/product-detail', 'slug' => $product->slug]),
                        'class' => 'btn btn-outline-success btn-pill mb-1',
                        'target' => '_blank'
                    ]), false);

                    return implode('', $data ?: []);
                }
            ],
            '[BEST_SELLER]' => [
                'description' => 'Top 3 Best Seller Product',
                'value' => function() {
                    $carts = Cart::find()
                        ->alias('c')
                        ->joinWith('product p')
                        ->select(['SUM(`c`.`quantity`) AS total', 'p.name AS produt_name', 'p.slug AS slug'])
                        ->groupBy('c.product_id')
                        ->orderBy(['total' => SORT_DESC])
                        ->asArray()
                        ->limit(5)
                        ->all();
                    $data = App::foreach($carts, fn($cart) => Html::tag('a', $cart['produt_name'], [
                        'href' => Url::toRoute(['site/product-detail', 'slug' => $cart['slug']]),
                        'class' => 'btn btn-outline-success btn-pill mb-1',
                        'target' => '_blank'
                    ]), false);

                    return implode('', $data ?: []);
                }
            ],
            '[SALE_BUTTON]' => [
                'description' => 'Product Sale button',
                'value' => Html::tag('a', 'Product on Sale', [
                    'href' => '#',
                    'data-message' => 'Product on Sale',
                    'data-hidden_message' => '--showProductOnSale',
                    'class' => 'btn btn-outline-success btn-pill mb-1 btn-hidden-message',
                ])
            ],
            '[CATEGORY_BUTTON]' => [
                'description' => 'Category button',
                'value' => Html::tag('a', 'Show Categories', [
                    'href' => '#',
                    'data-message' => 'Show Categories',
                    'data-hidden_message' => '--showCategory',
                    'class' => 'btn btn-outline-success btn-pill mb-1 btn-hidden-message',
                ])
            ],
            '[PRICE_RANGE_BUTTON]' => [
                'description' => 'Price range button',
                'value' => Html::tag('a', 'Show Price Range', [
                    'href' => '#',
                    'data-message' => 'Show Price Range',
                    'data-hidden_message' => '--showPriceRange',
                    'class' => 'btn btn-outline-success btn-pill mb-1 btn-hidden-message',
                ])
            ],
            '[BEST_SELLER_BUTTON]' => [
                'description' => 'Best seller button',
                'value' => Html::tag('a', 'Best Seller', [
                    'href' => '#',
                    'data-message' => 'Best Seller',
                    'data-hidden_message' => '--showBestSeller',
                    'class' => 'btn btn-outline-success btn-pill mb-1 btn-hidden-message',
                ])
            ],
            '[COLORS_BUTTON]' => [
                'description' => 'Colors button',
                'value' => Html::tag('a', 'Available Colors', [
                    'href' => '#',
                    'data-message' => 'Available Colors',
                    'data-hidden_message' => '--showColors',
                    'class' => 'btn btn-outline-success btn-pill mb-1 btn-hidden-message',
                ])
            ],
            '[COLORS]' => [
                'description' => 'Clickable color of products',
                'value' => function() {
                    return App::foreach(
                        Product::uniqueColors(), 
                        fn($color) => Html::tag('a', $color, [
                            'href' => Url::toRoute(['site/shop', 'colors[]' => $color]),
                            'class' => 'btn btn-outline-success btn-pill mb-1',
                            'target' => '_blank'
                        ])
                    );
                }
            ],
            '[SIZES_BUTTON]' => [
                'description' => 'Sizes button',
                'value' => Html::tag('a', 'Available Sizes', [
                    'href' => '#',
                    'data-message' => 'Available Sizes',
                    'data-hidden_message' => '--showSizes',
                    'class' => 'btn btn-outline-success btn-pill mb-1 btn-hidden-message',
                ])
            ],
            '[SIZES]' => [
                'description' => 'Clickable color of products',
                'value' => function() {
                    return App::foreach(
                        Product::uniqueSizes(), 
                        fn($size) => Html::tag('a', $size, [
                            'href' => Url::toRoute(['site/shop', 'sizes[]' => $size]),
                            'class' => 'btn btn-outline-success btn-pill mb-1',
                            'target' => '_blank'
                        ])
                    );
                }
            ],
        ];
    }

    public function getReply()
    {
        return $this->hasOne(Chat::class, ['id' => 'reply_id']);
    }

    public function getUserEmail()
    {
        return App::if($this->user, fn($user) => $user->email);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ChatQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ChatQuery(get_called_class());
    }

    public function getStatusBadge()
    {
        $param = App::params('chat_status')[$this->status];

        if ($param) {
            return Label::widget(['options' => $param]);
        }
    }


    public function getTypeBadge()
    {
        $param = App::params('chat_type')[$this->type];

        if ($param) {
            return Label::widget(['options' => $param]);
        }
    }

    public function getDefaultGridColumns()
    {
        return [
            'serial',
            'checkbox',
            'session_id',
            'message',
            'reply',
            'status',
            'type',
            'created_at',
            'active',
        ];
    }

    public function getReplyList()
    {
        return App::ifElse(
            $this->replies, 
            fn($replies) => Html::tag('ul', 
                App::foreach($replies, fn($chat) => Html::tag('li', $chat->displayMessage))
            ), 
            'Default Message'
        );
    }
     
    public function gridColumns()
    {
        return [
            'session_id' => [
                'attribute' => 'session_id', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->session_id,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'message' => ['attribute' => 'message', 'format' => 'raw'],
            'reply' => [
                'attribute' => 'reply_id', 
                'label' => 'reply', 
                'format' => 'raw', 
                'value' => 'replyList'
            ],
            'user_email' => [
                'label' => 'User email',
                'attribute' => 'userEmail', 
                'format' => 'raw',
                'value' => 'userEmail'
            ],
            'status' => ['attribute' => 'status', 'format' => 'raw', 'value' => 'statusBadge'],
            'type' => ['attribute' => 'type', 'format' => 'raw', 'value' => 'typeBadge'],
            // 'reply_id' => ['attribute' => 'reply_id', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            // 'reply_id:raw',
            'session_id:raw',
            'userEmail:raw',
            'message:raw',
            'statusBadge:raw',
            'typeBadge:raw',
        ];
    }

    public function dateDiff($date1, $date2, $format="days")
    {
        $date1 = new \DateTime($date1);
        $date2 = new \DateTime($date2);

        $diff = $date1->diff($date2);

        return $diff->{$format};
    }

    public function getTimeSent()
    {
        $start = date("Y-m-d", strtotime(App::formatter()->asDateToTimezone('', 'Y-m-d H:i:s'))); 
        $end = date("Y-m-d", strtotime($this->created_at)); 

        $day   = $this->dateDiff($start, $end);
        $month = $this->dateDiff($start, $end, 'm');
        $year  = $this->dateDiff($start, $end, 'y');

        if ($year > 1) {
            return implode(' AT ', [
                date('M d, Y', strtotime($this->createdAt)),
                date('h:i A', strtotime($this->createdAt)),
            ]);
        }
        elseif ($month > 1 || $day >= 6) {
            return implode(' AT ', [
                date('M d', strtotime($this->createdAt)),
                date('h:i A', strtotime($this->createdAt)),
            ]);
        }
        elseif ($day > 1 || $start != $end) {
            return implode(' AT ', [
                date('D', strtotime($this->createdAt)),
                date('h:i A', strtotime($this->createdAt)),
            ]);
        }
        else {
            return date('h:i A', strtotime($this->createdAt));
        }
    }

    public function getReplies()
    {
        return $this->hasMany(Chat::class, ['reply_id' => 'id']);
    }

    public static function response($training, $chat)
    {
        if ($training->suggestion == 'ai') {
            $faker = \Faker\Factory::create();
            $response = $faker->randomElement($training->response);
            $model = new self([
                'session_id' => App::session('id'),
                'reply_id' => $chat->id,
                'type' => self::TYPE_CHATBOT,
                'message' => $response,
                'status' => self::ANSWERED 
            ]);
            $model->save();
        }
        else {
            foreach ($training->response as $response) {
                $model = new self([
                    'session_id' => App::session('id'),
                    'reply_id' => $chat->id,
                    'type' => self::TYPE_CHATBOT,
                    'message' => $response,
                    'status' => self::ANSWERED 
                ]);
                $model->save();
            }
        }
    }

    public static function dummy()
    {
        $chat = new Chat([
            'session_id' => App::session('id'),
            'type' => Chat::TYPE_CHATBOT,
            'message' => App::setting('chatbot')->default_message,
            'status' => Chat::ANSWERED 
        ]);
        $chat->save();
    }

    public static function findByKeywords($keywords='', $attributes='', $limit=10, $andFilterWhere=[])
    {
        return parent::findByKeywordsData($attributes, function($attribute) use($keywords, $limit, $andFilterWhere) {
            return self::find()
                ->select("{$attribute} AS data")
                ->alias('c')
                ->joinWith('user u')
                ->groupBy($attribute)
                ->where(['LIKE', $attribute, $keywords])
                ->andFilterWhere($andFilterWhere)
                ->limit($limit)
                ->asArray()
                ->all();
        });
    }

    public function getTotalPerSession()
    {
        return self::find()
            ->where(['session_id' => $this->session_id])
            ->count();
    }

    public function getDisplayMessage()
    {
        return nl2br($this->message);
    }

    public function getChatSession()
    {
        return $this->hasOne(ChatSession::class, ['session_id' => 'session_id']);
    }

    public function afterSave ($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            $chatSession = ChatSession::findOrCreate(['session_id' => $this->session_id]);

            if ($chatSession->isNewRecord) {
                $chatSession->status = chatSession::CHATBOT;
                $chatSession->save(false);
            }
        }
    }
}