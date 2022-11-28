<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\helpers\Inflector;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SeedController extends Controller
{
    public function actionInit()
    {
        $this->actionTruncate(['users', 'roles', 'ips']);
        $classes = [
            'Role',
            'User',
            'Ip',
        ];

        foreach ($classes as $class) {
            $this->actionIndex($class, 5);
        }
    }

    public function actionIndex($class, $rows=1)
    {
        $class = Inflector::id2camel($class);
        $model = Yii::createObject([
            'class' => "\\app\\commands\\seeder\\{$class}Seeder",
            'rows' => $rows
        ]);
        $model->seed();
    }

    public function actionProduct($rows=1)
    {
        $data = [];
        $faker = \Faker\Factory::create();
        $totalProduct = \app\models\Product::find()->count();

        $categories = array_values(\app\models\ProductCategory::dropdown('id', 'name'));

        for ($i=1; $i <= $rows; $i++) { 
            $number = $totalProduct + $i;
            $rp = rand(100, 2000);
            $lst = rand(10, 50);
            $hst = rand($lst + 100, $lst + 1000);
            $qty = rand(0, $hst + 100);

            if ($qty > $lst) {
                if ($qty >= $hst) {
                    $sts = \app\models\Product::THRESHOLD_HIGH;
                }
                else {
                    $sts = \app\models\Product::THRESHOLD_SAFE;
                }
            }
            else {
                $sts = \app\models\Product::THRESHOLD_LOW;
            }

            $image = \app\helpers\App::setting('image')->primary_logo;


            $data[] = [
                'name' => "Product Name {$number}",
                'regular_price' => $rp,
                'sale_price' => rand(100, $rp),
                'categories' => json_encode([$faker->randomElement($categories)]),
                'specification' => $faker->realText,
                'description' => $faker->realText,
                'added_shipping_fee' => rand(0, 100),
                'quantity' => $qty,
                'low_stock_threshold' => $lst,
                'high_stock_threshold' => $hst,
                'stock_threshold_status' => $sts,
                'sku' => "sku-{$number}",
                'image' => $image,
                'tags' => json_encode(['tag1', 'tag2']),
                'gallery' => json_encode([$image, $image]),
                'colors' => json_encode(['blue', 'red', 'green']),
                'sizes' => json_encode(['small', 'medium', 'large']),
                'token' => "tokeng-{$number}",
                'slug' => \yii\helpers\Inflector::slug("Product Name {$number}"),
                'record_status' => \app\models\Product::RECORD_ACTIVE,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => new \yii\db\Expression('UTC_TIMESTAMP'),
                'updated_at' => new \yii\db\Expression('UTC_TIMESTAMP'),
            ];
        }

        \app\models\Product::batchInsert($data);
    }
}
