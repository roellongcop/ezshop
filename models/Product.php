<?php

namespace app\models;

use app\helpers\App;
use app\helpers\ArrayHelper;
use app\helpers\Url;
use app\helpers\Html;
use yii\helpers\Html as YiiHtml;


use app\widgets\Anchor;
use yii\db\Expression;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $categories
 * @property string|null $description
 * @property string|null $tags
 * @property string|null $image
 * @property string|null $gallery
 * @property float $regular_price
 * @property float $sale_price
 * @property string|null $sku
 * @property string $token
 * @property string $slug
 * @property int|null $quantity
 * @property int|null $low_stock_threshold
 * @property int|null $high_stock_threshold
 * @property int|null $stock_threshold_status
 * @property float|null $added_shipping_fee
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Product extends ActiveRecord
{
    const THRESHOLD_SAFE = 0;
    const THRESHOLD_HIGH = 1;
    const THRESHOLD_LOW = 2;

    const STEP_FORM = [
        [
            'counter' => 1,
            'state' => 'current',
            'step' => 'general',
            'title' => 'General Information',
            'description' => 'Fill up Primary Details'
        ],
        [
            'counter' => 2,
            'state' => 'pending',
            'step' => 'inventory',
            'title' => 'Inventory',
            'description' => 'Manage Stock & Threshold'
        ],
        [
            'counter' => 3,
            'state' => 'pending',
            'step' => 'photos',
            'title' => 'Photos',
            'description' => 'Create Image Gallery'
        ],
        [
            'counter' => 4,
            'state' => 'pending',
            'step' => 'variations',
            'title' => 'Variations',
            'description' => 'Colors & Sizes'
        ],
        [
            'counter' => 5,
            'state' => 'pending',
            'step' => 'others',
            'title' => 'Others',
            'description' => 'Tags, Shipping & etc.'
        ],
        [
            'counter' => 6,
            'state' => 'pending',
            'step' => 'completed',
            'title' => 'Completed',
            'description' => 'Review and Submit'
        ]
    ];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%products}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'product',
            'mainAttribute' => 'name',
            'paramName' => 'slug',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['name', 'regular_price', 'sale_price', 'categories', 'specification'], 'required'],
            ['name', 'unique'],
            [['description'], 'string'],
            [['regular_price', 'sale_price', 'added_shipping_fee'], 'number'],
            [['quantity', 'low_stock_threshold', 'high_stock_threshold', 'stock_threshold_status'], 'integer'],
            [['name', 'image', 'sku'], 'string', 'max' => 255],
            [['categories', 'tags', 'gallery', 'colors', 'sizes'], 'safe'],
            [['low_stock_threshold', 'high_stock_threshold'], 'validateThresholdStock'],
            [['sale_price', 'regular_price'], 'validatePrice'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'name' => 'Name',
            'categories' => 'Categories',
            'description' => 'Description',
            'tags' => 'Tags',
            'image' => 'Image',
            'gallery' => 'Gallery',
            'regular_price' => 'Regular Price',
            'sale_price' => 'Sale Price',
            'sku' => 'Stock Keeping Unit',
            'quantity' => 'Quantity',
            'low_stock_threshold' => 'Low Stock Threshold',
            'high_stock_threshold' => 'High Stock Threshold',
            'stock_threshold_status' => 'Stock Status',
            'added_shipping_fee' => 'Added Shipping Fee',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ProductQuery(get_called_class());
    }

    public function validatePrice($attribute, $params)
    {
        if ($this->sale_price > $this->regular_price) {
            $this->addError($attribute, 'Sale price must not be greater than regular price');
        }
    }

    public function validateThresholdStock($attribute, $params)
    {
        if ($this->low_stock_threshold > 0 || $this->high_stock_threshold > 0) {
            if ($this->low_stock_threshold == $this->high_stock_threshold) {
                $this->addError($attribute, 'Threshold must not be equal');
            }
            else {
                if ($this->low_stock_threshold > $this->high_stock_threshold) {
                    $this->addError($attribute, 'Low threshold must not be greater than high treshold');
                }
            }
        }
    }

    public function getDefaultGridColumns()
    {
        return [
            'serial',
            'checkbox',
            'image',
            'name',
            // 'sku',
            'regular_price',
            'sale_price',
            'quantity',
            'stock_threshold_status',
            'created_at',
            'active',
        ];
    }

    public function gridColumns()
    {
        return [
            'image' => [
                'attribute' => 'image', 
                'value' => 'photo', 
                'format' => 'raw',
            ],
            'name' => [
                'attribute' => 'name', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->name,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            // 'categories' => ['attribute' => 'categories', 'format' => 'raw'],
            'description' => ['attribute' => 'description', 'format' => 'raw'],
            // 'tags' => ['attribute' => 'tags', 'format' => 'raw'],
            // 'gallery' => ['attribute' => 'gallery', 'format' => 'raw'],
            'regular_price' => ['attribute' => 'regular_price', 'format' => 'peso'],
            'sale_price' => ['attribute' => 'sale_price', 'format' => 'peso'],
            'sku' => ['attribute' => 'sku', 'format' => 'raw'],
            'quantity' => ['attribute' => 'quantity', 'format' => 'numberFormat'],
            'low_stock_threshold' => ['attribute' => 'low_stock_threshold', 'format' => 'numberFormat'],
            'high_stock_threshold' => ['attribute' => 'high_stock_threshold', 'format' => 'numberFormat'],
            'stock_threshold_status' => [
                'attribute' => 'stock_threshold_status', 
                'format' => 'raw',
                'value' => 'thresholdBagde'
            ],
            'added_shipping_fee' => ['attribute' => 'added_shipping_fee', 'format' => 'numberFormat'],
        ];
    }

    public function getPhoto($w=50)
    {
        return Html::image($this->image, ['w' => $w], ['class' => 'img-thumbnail']);
    }

    public function detailColumns()
    {
        return [
            'name:raw',
            'categories:jsonEditor',
            'description:raw',
            'tags:jsonEditor',
            'image:raw',
            'gallery:jsonEditor',
            'regular_price:numberFormat',
            'sale_price:numberFormat',
            'sku:raw',
            'quantity:numberFormat',
            'low_stock_threshold:numberFormat',
            'high_stock_threshold:numberFormat',
            'thresholdBagde:raw',
            'added_shipping_fee:numberFormat',
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['ProductBehavior'] = [
            'class' => 'app\behaviors\ProductBehavior'
        ];

        $behaviors['SluggableBehavior'] = [
            'class' => 'yii\behaviors\SluggableBehavior',
            'attribute' => 'name',
            'ensureUnique' => true,
        ];

        $behaviors['JsonBehavior']['fields'] = [
            'categories', 
            'tags',
            'gallery',
            'colors',
            'sizes',
        ];

        return $behaviors;
    }

    public function getIsSafe()
    {
        return $this->stock_threshold_status == self::THRESHOLD_SAFE;
    }

    public function getIsHigh()
    {
        return $this->stock_threshold_status == self::THRESHOLD_HIGH;
    }

    public function getIsLow()
    {
        return $this->stock_threshold_status == self::THRESHOLD_LOW;
    }

    public static function stepForms($step)
    {
        $stepForms = ArrayHelper::index(self::STEP_FORM, 'step');
        $activeStep = $stepForms[$step];

        foreach ($stepForms as &$stepForm) {
            if ($activeStep['counter'] == $stepForm['counter']) {
                $stepForm['state'] = 'current';
            }
            elseif ($activeStep['counter'] > $stepForm['counter']) {
                $stepForm['state'] = 'done';
            }
            elseif ($activeStep['counter'] < $stepForm['counter']) {
                $stepForm['state'] = 'pending';
            }
        }

        return $stepForms;
    }

    public function getPreviousStep($activeStep)
    {
        if ($activeStep['step'] == 'general') {
            return $activeStep;
        }

        $stepForms = ArrayHelper::index(self::STEP_FORM, 'counter');

        return $stepForms[$activeStep['counter'] - 1];
    }

    public function getImageFiles()
    {
        if (($gallery = $this->gallery) != null) {
            $files = [];

            foreach ($gallery as $token) {
                if (($file = File::findByToken($token)) != null) {
                    $files[] = $file;
                }
            }

            return $files;
        }
    }

    public function getThresholdBagde()
    {
        $status = App::params('stock_threshold_status')[$this->stock_threshold_status] ?? '';

        return $status ? Html::tag('label', $status['label'], [
            'class' => 'badge badge-' . $status['class']
        ]): '';
    }

    public static function random($limit=2)
    {
        return self::find()
            ->where('`regular_price` > `sale_price`')
            ->active()
            ->orderBy(new Expression('rand()'))
            ->limit($limit)
            ->all();
    }

    public function getProductCategoryImageUrl()
    {
        if (($productCategory = $this->productCategory) != null) {
            return $productCategory->imageUrl;
        }
    }

    public function getProductCategory()
    {
        if (($productCategories = $this->productCategories) != null) {
            $count = count($productCategories);

            return $productCategories[rand(0, $count - 1)];
        }
    }

    public function getProductCategories()
    {
        return $this->hasMany(ProductCategory::class, ['name' => 'categories']);
    }

    public function getSalePercentage()
    {
        if ($this->regular_price <= $this->sale_price) {
            return 0;
        }

        return abs((($this->regular_price - $this->sale_price) * 100) / $this->regular_price);
    }

    public function getImageUrl($w=100)
    {
        return Url::image($this->image, ['w' => $w]);
    }

    public function getGalleryImageUrl($token, $w=100)
    {
        return Url::image($token, ['w' => $w]);
    }

    public function getIsOnSale()
    {
        return $this->regular_price > $this->sale_price;
    }

    public function getRegularPrice()
    {
        return number_format($this->regular_price);
    }

    public function getSalePrice()
    {
        return number_format($this->sale_price);
    }

    public function getDisplayPrice()
    {
        if ($this->isOnSale) {
            return <<< HTML
                <h5>₱ {$this->salePrice}</h5>
                <h6 class="text-muted ml-2">
                    <del>₱ {$this->regularPrice}</del>
                </h6>
            HTML;
        }

        return Html::tag('h5', '₱ ' . $this->regularPrice);
    }

    public static function recent($limit=8)
    {
        return self::find()
            ->active()
            ->orderBy(['id' => SORT_DESC])
            ->addOrderBy(new Expression('rand()'))
            ->limit($limit)
            ->all();
    }

    public static function uniqueSizes()
    {
        return App::formatter()->asUniqueArrayFlatten(
            self::dropdown('name', 'sizes')
        );
    }

    public static function uniqueColors()
    {
        return App::formatter()->asUniqueArrayFlatten(
            self::dropdown('name', 'colors')
        );
    }

    public function getFrontendUrl()
    {
        return Url::toRoute(['/site/product-detail', 'slug' => $this->slug]);
    }

    public function getReviews()
    {
        return $this->hasMany(Review::class, ['product_id' => 'id'])
            ->orderBy(['id' => SORT_DESC]);
    }

    public function getTotalReviews()
    {
        return Review::find()
            ->where(['product_id' => $this->id])
            ->active()
            ->count();
    }

    public function getUniqueReviews()
    {
        return Review::find()
            ->where(['product_id' => $this->id])
            ->groupBy('user_id')
            ->orderBy(['id' => SORT_DESC])
            ->limit(5)
            ->all();
    }

    public function getAverageScore()
    {
        $score = Review::find()
            ->where(['product_id' => $this->id])
            ->active()
            ->average("score");

        return ceil($score);
    }


    public function generateStar($filled='', $unfilled='')
    {
        $data = [];
        $filled = $filled ?: '<small class="fas fa-star text-primary mr-1"></small>';
        $unfilled = $unfilled ?: '<small class="far fa-star text-primary mr-1"></small>';

        for ($i = $this->averageScore; $i > 0; $i--) { 
            $data[] = $filled;
        }
        for ($i = (5 - $this->averageScore); $i > 0; $i--) { 
            $data[] = $unfilled;
        }

        return implode('', $data);
    }

    public function getTotalPendingReview($user='')
    {
        $user = $user ?: App::identity();

        if ($user) {
            return Review::find()
                ->where([
                    'user_id' => $user->id, 
                    'product_id' => $this->id,
                    'record_status' => parent::RECORD_INACTIVE
                ])
                ->count();
        }

        return 0;
    }

    public function getProductView($w=50)
    {
        return Html::tag('div',
            implode('', [
                Html::img($this->getImageUrl($w), ['class' => "img-fluid"]),
                YiiHtml::a($this->name, $this->frontendUrl, ['class' => 'text-dark ml-2']),
            ]),
            ['class' => 'd-flex align-items-center justify-content-center']
        );
    }
}

