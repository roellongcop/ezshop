<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\helpers\Inflector;
use app\models\Product;
use app\models\Training;

use app\models\ProductCategory;
use Faker\Factory;
use yii\db\Expression;

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
        $faker = Factory::create();
        $totalProduct = Product::find()->count();

        $categories = array_values(ProductCategory::dropdown('id', 'name'));

        for ($i=1; $i <= $rows; $i++) { 
            $number = $totalProduct + $i;
            $rp = rand(100, 2000);
            $lst = rand(10, 50);
            $hst = rand($lst + 100, $lst + 1000);
            $qty = rand(0, $hst + 100);

            if ($qty > $lst) {
                if ($qty >= $hst) {
                    $sts = Product::THRESHOLD_HIGH;
                }
                else {
                    $sts = Product::THRESHOLD_SAFE;
                }
            }
            else {
                $sts = Product::THRESHOLD_LOW;
            }

            $images = ['fQPBSLPa_P-1668920481', 'ZXtU3RLlQw-1668920890', 'GBSrhy6VNW-1668922286'];


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
                'image' => $faker->randomElement($images),
                'tags' => json_encode(['tag1', 'tag2']),
                'gallery' => json_encode([$faker->randomElement($images), $faker->randomElement($images)]),
                'colors' => json_encode(['blue', 'red', 'green']),
                'sizes' => json_encode(['small', 'medium', 'large']),
                'token' => "tokeng-{$number}",
                'slug' => \yii\helpers\Inflector::slug("Product Name {$number}"),
                'record_status' => Product::RECORD_ACTIVE,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => new Expression('UTC_TIMESTAMP'),
                'updated_at' => new Expression('UTC_TIMESTAMP'),
            ];
        }

        Product::batchInsert($data);
    }

    public function actionTraining()
    {
        $data = array (
            0 => 
            array (
              'tag' => 'greeting',
              'patterns' => 
              array (
                0 => 'Hi',
                1 => 'Hey',
                2 => 'Is anyone there?',
                3 => 'Hello',
                4 => 'Hay',
                5 => 'Hey bot',
                6 => 'kamusta',
                7 => 'magandang araw',
                8 => 'Magandang umaga',
                9 => 'magandang tanghali',
                10 => 'magandang gabi',
                11 => 'Good Morning',
                12 => 'Good evening',
                13 => 'Good Afternoon',
              ),
              'responses' => 
              array (
                0 => 'Hello',
                1 => 'Hi',
                2 => 'Hi there',
                3 => 'hello good day',
                4 => 'Hey',
                5 => 'hi good day',
                6 => 'what\'s up',
              ),
            ),
            1 => 
            array (
              'tag' => 'goodbye',
              'patterns' => 
              array (
                0 => 'Bye',
                1 => 'See you later',
                2 => 'Goodbye',
                3 => 'bye bye',
                4 => 'alis nako',
                5 => 'Babye',
                6 => 'Babush',
                7 => 'Babay',
              ),
              'responses' => 
              array (
                0 => 'See you later',
                1 => 'Have a nice day',
                2 => 'Bye! Come back again',
                3 => 'Okay goodbye Sir/Ma\'am',
              ),
            ),
            2 => 
            array (
              'tag' => 'thanks',
              'patterns' => 
              array (
                0 => 'Thanks',
                1 => 'Thank you',
                2 => 'That\'s helpful',
                3 => 'Thanks for the help',
                4 => 'thanks for helping me',
                5 => 'Salamat sayo',
                6 => 'salamat sa Pag assist hane',
                7 => 'Hey Bot! Thank you',
                8 => 'Salamat hane',
                9 => 'Thank you for support bot',
                10 => 'Tnx',
              ),
              'responses' => 
              array (
                0 => 'Happy to help!',
                1 => 'Any time!',
                2 => 'My pleasure',
                3 => 'You\'re most welcome!',
                4 => 'Walang anuman',
                5 => 'Youre welcome Sir/Ma\'am',
                6 => 'Welcome Ma’am/Sir',
              ),
            ),
            3 => 
            array (
              'tag' => 'about',
              'patterns' => 
              array (
                0 => 'Who are you?',
                1 => 'What are you?',
                2 => 'Who you are?',
                3 => 'what kind you',
                4 => ' Sino ka',
                5 => 'anu ka',
                6 => 'Anung klase ka',
              ),
              'responses' => 
              array (
                0 => 'I.m Shopbot, your bot assistant',
                1 => 'I\'m Shopbot, an Artificial Intelligent bot',
                2 => 'I\'m AI',
              ),
            ),
            4 => 
            array (
              'tag' => 'name',
              'patterns' => 
              array (
                0 => 'what is your name',
                1 => 'what should I call you',
                2 => 'whats your name?',
                3 => 'anu pangalan mo',
                4 => 'Pangalan mo?',
                5 => 'Hey Bot tell me something about you',
              ),
              'responses' => 
              array (
                0 => 'You can call me Shopbot.',
                1 => 'I\'m Shopbot!',
                2 => 'Just call me as Shopbot',
                3 => 'Call me Bot',
                4 => 'Tawagin mokong chatbot or bot',
                5 => 'Hello my name is Bot, I\'m here to answer your questions',
                6 => 'I\'m a bot and I\'m here to help you to your online shopping concern',
              ),
            ),
            5 => 
            array (
              'tag' => 'help',
              'patterns' => 
              array (
                0 => 'Could you help me?',
                1 => 'give me a hand please',
                2 => 'Can you help?',
                3 => 'What can you do for me?',
                4 => 'I need a support',
                5 => 'I need a help',
                // 6 => 'support me please',
                7 => 'I Have a Problem',
                8 => 'What Do I Do',
                9 => 'Tulong please',
                10 => 'Tulong',
                11 => 'kaya mobakong tulungan?',
              ),
              'responses' => 
              array (
                0 => 'Tell me how can assist you',
                1 => 'Tell me your problem to assist you',
                2 => 'Yes Sure, How can I support you',
              ),
            ),
            6 => 
            array (
              'tag' => 'create account',
              'patterns' => 
              array (
                0 => 'I need to create a new account',
                1 => 'how to open a new account',
                2 => 'I want to create an account',
                3 => 'can you create an account for me',
                // 4 => 'how to open a new account',
                5 => 'gusto ko gumawa ng bagong account',
                6 => 'baguhin ko account ko',
                7 => 'create account',
              ),
              'responses' => 
              array (
                0 => 'You can just easily create a new account from our web site',
                1 => 'Just go to our web site and follow the guidelines to create a new account',
              ),
            ),
            7 => 
            array (
              'tag' => 'complaint',
              'patterns' => 
              array (
                0 => 'have a complaint',
                1 => 'I want to raise a complaint',
                2 => 'there is a complaint about a service',
                3 => 'May reklamo ako',
                4 => 'May complaint ako',
              ),
              'responses' => 
              array (
                0 => 'Please provide us your complaint in order to assist you',
                1 => 'Please mention your complaint, we will reach you and sorry for any inconvenience caused',
              ),
            ),
            8 => 
            array (
              'tag' => 'sports',
              'patterns' => 
              array (
                0 => 'what sports do you play',
                1 => 'what kind of sport',
                2 => 'what sports',
                3 => 'anu sports mo?',
                4 => 'anu nilalaro mong sports?',
              ),
              'responses' => 
              array (
                0 => 'Basketball',
                1 => 'ballbasket',
                2 => 'ballbasketball',
                3 => 'Table Tennis',
              ),
            ),
            9 => 
            array (
              'tag' => 'Hobbies',
              'patterns' => 
              array (
                0 => 'what is ur favorite hobbies?',
                1 => 'What is your other hobbies?',
                2 => 'anu hobbies mo?',
                3 => 'Anu mga ginagawa mo?',
                4 => 'hobbies',
                5 => 'your hobbies',
              ),
              'responses' => 
              array (
                0 => 'whatching movie',
                1 => 'Play some sports',
                2 => 'only to assist and to support you that\'s my hobbies',
              ),
            ),
            10 => 
            array (
              'tag' => 'Movie',
              'patterns' => 
              array (
                0 => 'what movie do you like?',
                1 => 'what is your favorite movie?',
                2 => 'Movie?',
                3 => 'Anong movie?',
                4 => 'what movie',
              ),
              'responses' => 
              array (
                0 => 'Marvels',
                1 => 'Avenger',
                2 => 'Marvel studio',
              ),
            ),
            11 => 
            array (
              'tag' => 'age',
              'patterns' => 
              array (
                0 => 'How old are you?',
                1 => 'what is your age',
                2 => 'what age are you',
                3 => 'your age is',
                4 => 'ilan taon kana?',
                5 => 'anung idad kana?',
              ),
              'responses' => 
              array (
                0 => 'I\'m 20',
                1 => '20',
                2 => 'i think 20',
                3 => 'why you ask sir/ma\'am?',
              ),
            ),
            12 => 
            array (
              'tag' => 'gender',
              'patterns' => 
              array (
                0 => 'what is your gender?',
                1 => 'are you a girl or boy?',
                2 => 'your gender?',
                3 => 'gender?',
                4 => 'lalaki kaba or babae?',
                5 => 'Anu kasarian mo?',
                6 => 'your boy?',
              ),
              'responses' => 
              array (
                0 => 'I\'m boy',
                1 => 'i created to be a boy robot',
                2 => 'i think boy',
                3 => 'lalaki po',
                4 => 'lalaki po ako',
              ),
            ),
            13 => 
            array (
              'tag' => 'product',
              'patterns' => 
              array (
                0 => 'what is your product?',
                1 => 'where is your product',
                2 => 'what is your product made of?',
                3 => 'your product is?',
                4 => 'is your product?',
                5 => 'What are your products made of',
                6 => 'anung item pede ko makita dito?',
                7 => 'Anu mga produkto makikita ko dito?',
              ),
              'responses' => 
              array (
                0 => 'check the categories',
                1 => 'made of branded',
                2 => 'it is branded',
                3 => 'made of branded',
                4 => 'Mostly made in Mabitac, Laguna',
              ),
            ),
            14 => 
            array (
              'tag' => 'Talk',
              'patterns' => 
              array (
                0 => 'can i talk to you anytime?',
                1 => 'Can i talk to you?',
                2 => 'can i talk?',
                3 => 'can you talk?',
                4 => 'is your talk',
                5 => 'pede kang makausap?',
                6 => 'kausapin kita',
              ),
              'responses' => 
              array (
                0 => 'yes absolutely',
                1 => 'yes yes',
                2 => 'ow yes',
              ),
            ),
            15 => 
            array (
              'tag' => 'Characteristics',
              'patterns' => 
              array (
                0 => 'what is your charateristics?',
                1 => 'what\'s your characteristics?',
                2 => 'what you can do?',
                3 => 'your ability?',
                4 => 'what ability',
                5 => 'ano ang kakayahan mo?',
                6 => 'anu ang kaya mong gawen?',
              ),
              'responses' => 
              array (
                0 => 'to assist',
                1 => 'to guide you',
                2 => 'to support you',
                3 => 'i can do assist you in my own',
                4 => 'i can support you, without asking in human',
                5 => 'andito ako para suportahan ka',
              ),
            ),
            16 => 
            array (
              'tag' => 'joke',
              'patterns' => 
              array (
                0 => 'what is your joke?',
                1 => 'give me some joke',
                2 => 'can you give some joke?',
                3 => 'some joke please',
                4 => 'Bigyan moko ng joke',
                5 => 'Mag joke kanga',
                6 => 'Tell me a joke',
              ),
              'responses' => 
              array (
                0 => 'when your girlfriend/boyfriend loves you',
              ),
            ),
            17 => 
            array (
              'tag' => 'Color',
              'patterns' => 
              array (
                0 => 'What color you want?',
                1 => 'What is you favorite color?',
                2 => 'can you give me some color?',
                3 => 'some color',
                4 => 'Hey Bot! What is your favourite color?',
                5 => 'anu ang paborito mong color?',
                6 => 'ano ang gusto mong kulay?',
                7 => 'Give me color',
              ),
              'responses' => 
              array (
                0 => 'Black and white',
                1 => 'blue',
                2 => 'white',
                3 => 'all colors are good',
                4 => 'Red',
              ),
            ),
            18 => 
            array (
              'tag' => 'Girlfriend',
              'patterns' => 
              array (
                0 => 'Do you have girlfriend?',
                1 => 'you have a girlfriend?',
                2 => 'ur in a relationship?',
                3 => 'Meron kabang jewa?',
                4 => 'Meron kang juwa?',
                5 => 'Do you have a girlfriend',
              ),
              'responses' => 
              array (
                0 => 'Yes i\'am',
                1 => 'you see the chatbot in shoppee? that\'s my girlfriend',
                2 => 'Meron akong Jewa opo',
                3 => 'yes im in relationship',
              ),
            ),
            19 => 
            array (
              'tag' => 'Songs',
              'patterns' => 
              array (
                0 => 'what is your favorite songs?',
                1 => 'what songs do you play?',
                2 => 'favorite artist?',
                3 => 'anung gusto mong kanta?',
                4 => 'Anong kanta ang paborito mo?',
              ),
              'responses' => 
              array (
                0 => 'Opm music',
                1 => 'love songs',
                2 => 'old legends OPM',
                3 => 'Mga love songs po',
              ),
            ),
            20 => 
            array (
              'tag' => 'Order',
              'patterns' => 
              array (
                0 => 'Where’s my order?',
                1 => 'where is my order?',
                2 => 'my order where is it?',
                3 => 'my order',
                4 => 'asan yung order ko?',
                5 => 'san ko makita order ko',
                6 => 'can i see my order please',
                7 => 'how to order?',
                8 => 'Paano mag order',
                9 => 'how to find my orders?',
                10 => 'Where can I see my order?',
              ),
              'responses' => 
              array (
                0 => 'check the transaction',
                1 => 'check the cart',
                2 => 'on the cart',
                3 => 'check the cart icon',
                4 => 'Have you see the cart in the upper?',
                5 => 'Paki check po yung cart',
                6 => 'Just click the add and go.to cart',
                7 => 'click the account setting and check it your purchase',
              ),
            ),
            21 => 
            array (
              'tag' => 'Refund',
              'patterns' => 
              array (
                0 => 'I need to make a return',
                1 => 'What’s your refund policy?',
                2 => 'can i refund?',
                3 => 'gusto kong i refund order ko',
                4 => 'I want to refund my order',
                5 => 'pede bang mag refund?',
                6 => 'Gusto ko mag refund',
                7 => 'Can I refund the money if the product has a defect?',
                8 => 'refund',
              ),
              'responses' => 
              array (
                0 => 'The refund policy is to return and exchange',
                1 => 'For me yes you can refund',
                2 => 'it depend on the Admin of this website',
                3 => 'Yes, but you need to file a return or refund and it may take a few days',
              ),
            ),
            22 => 
            array (
              'tag' => 'Open',
              'patterns' => 
              array (
                0 => 'When are you guys open today?',
                1 => 'are you open today',
                2 => 'open today',
                3 => 'What time you open?',
                4 => 'anung oras kayo nag bubukas',
              ),
              'responses' => 
              array (
                0 => 'were open 24/7',
                1 => 'Anytime',
                2 => 'We will open anytime',
                3 => 'Open everyday',
              ),
            ),
            23 => 
            array (
              'tag' => 'Cancel',
              'patterns' => 
              array (
                0 => 'Hello can i cancel my order',
                1 => 'i want to cancel my order',
                2 => 'can i cancel my order?',
                3 => 'just want to cancel the order',
                4 => 'my order i will cancel',
                5 => 'i will cancel my order',
                6 => 'Pede kobang i cancel order kopo?',
                7 => 'Gusto kopo i cancel order kopo',
                8 => 'How can i cancel my order/s?',
                9 => 'Gusto ko i cancel orde ko',
                10 => 'paano mag cancel?',
              ),
              'responses' => 
              array (
                0 => 'Yes you can cancel it',
                1 => 'just click the cancel',
                2 => 'Click the cancel below',
                3 => 'Go you can cancel',
                4 => 'Yes you can cancel if your order no totally check out by the admin',
                5 => 'Yes Pede',
                6 => 'go to your account and click the transaction button and you will find button of cancel order',
              ),
            ),
            24 => 
            array (
              'tag' => 'Promos and Discount',
              'patterns' => 
              array (
                0 => 'What’s the best deal you can give me?',
                1 => 'Do You Offer Any Discounts or Coupons?',
                2 => 'Can i discount',
                3 => 'Discount please',
                4 => 'May discount poba kayo?',
                5 => 'Nag didiscount poba kayo?',
                6 => 'you have promos?',
                7 => 'may promo kayo?',
              ),
              'responses' => 
              array (
                0 => 'i can give you promos and discount ',
                1 => 'Yes we have discount offer every 15th day ',
                2 => 'It depends on the admin',
                3 => 'YEs we will',
                4 => 'Yes we have discount',
                5 => 'I give you a best deal using discount',
              ),
            ),
            25 => 
            array (
              'tag' => 'Question',
              'patterns' => 
              array (
                0 => 'Can i ask some question?',
                1 => 'Can i ask question?',
                2 => 'I have a question',
                3 => 'my question',
                4 => 'i wil have question',
                5 => 'May tanong po ako',
                6 => 'may tanong ako',
                7 => 'Pede mag tanong?',
              ),
              'responses' => 
              array (
                0 => 'Yes what can i do for you?',
                1 => 'yeah you can ',
                2 => 'What is that?',
                3 => 'What can i do?',
                4 => 'What Question?',
                5 => 'What is your question?',
              ),
            ),
            26 => 
            array (
              'tag' => 'Free Shipping',
              'patterns' => 
              array (
                0 => 'how can I get free shipping? ',
                1 => 'You have free shipping?',
                2 => 'You got free shipping?',
                3 => 'Can i get free shipping?',
                4 => 'May free shipping po kayo?',
                5 => 'Pede free shipping?',
                6 => 'Paano free shipping nyo?',
                7 => 'can in used cash back and freshipping both?',
              ),
              'responses' => 
              array (
                0 => 'check the shop if they have free shipping promos',
                1 => 'yes we have but not everyday ',
                2 => 'Yes we will but ocationally',
                3 => 'Yes we have free shipping Sir/Ma\'am',
                4 => 'you can only used 1 promos ',
              ),
            ),
            27 => 
            array (
              'tag' => 'Pay',
              'patterns' => 
              array (
                0 => 'How can i pay',
                1 => 'how to pay? ',
                2 => 'Paano mag bayad?',
                3 => 'What kind of pay',
                4 => 'anung klaseng bayad',
                5 => 'What form of payment can I use to purchase the product?',
                6 => 'Can I use G-cash payment?',
                7 => 'what payment?',
              ),
              'responses' => 
              array (
                0 => 'You can pay online and cash on delivery',
                1 => 'You can pay online',
                2 => 'You can pay Cash on delivery',
                3 => 'Choose Cash on delivery or Pay it Online',
                4 => 'Click Cash In and select the appropriate payment method',
                5 => 'check the payment option',
              ),
            ),
            28 => 
            array (
              'tag' => 'Voucher',
              'patterns' => 
              array (
                0 => 'How to use the voucher?',
                1 => 'how use voucher? ',
                2 => 'Can i get voucher?',
                3 => 'Pede gamitin yung boucher?',
                4 => 'We want to use the Voucher',
                5 => 'i want to use the voucher',
                6 => 'Gusto ko gamitin yung voucher',
              ),
              'responses' => 
              array (
                0 => 'Check if available',
                1 => 'Just click and check if available',
                2 => 'Yes you can use',
                3 => 'Use it once',
              ),
            ),
            29 => 
            array (
              'tag' => 'Quality',
              'patterns' => 
              array (
                0 => 'how I can find quality product? ',
                1 => 'Where can i see quality product? ',
                2 => 'Is this item quality?',
                3 => 'This item is quality?',
                4 => 'Quality ba itong item nato?',
                5 => 'Sure bang quality to?',
                6 => 'Gusto ko makasigurado na quality to',
              ),
              'responses' => 
              array (
                0 => 'Check the ratings',
                1 => 'check the description',
                2 => 'Maybe',
                3 => 'You want to make it sure?try to buy it and you will see if its is quality or not',
              ),
            ),
            30 => 
            array (
              'tag' => 'Home',
              'patterns' => 
              array (
                0 => 'What is this home button',
                1 => 'What can i see in home button?',
                2 => 'Home button is all about?',
                3 => 'Home button',
                4 => 'PAra san ba itong home button?',
                5 => 'Anu ang pede kong makita sa home button?',
                6 => 'home',
              ),
              'responses' => 
              array (
                0 => 'Home button is the main design of the website',
                1 => 'You can see the different features such as Categories, Reccoment product, and etc.',
              ),
            ),
            31 => 
            array (
              'tag' => 'News Feed',
              'patterns' => 
              array (
                0 => 'What is news feed?',
                1 => 'What can i see in News feed?',
                2 => 'What is news feed all about?',
                3 => 'Para san si News Feed',
                4 => 'Anu makikita ko kay news feed',
                5 => 'Ano- ano ang makikita ko kay news feed?',
              ),
              'responses' => 
              array (
                0 => 'News feed is a list of newly published content in the website',
                1 => 'You can see the newly published',
                2 => 'You can see the newly item',
                3 => 'you can see in News Feed the update',
              ),
            ),
            32 => 
            array (
              'tag' => 'about Us',
              'patterns' => 
              array (
                0 => 'What can i see in about Us?',
                1 => 'what can i see in about us button?',
                2 => 'para san ba itong about us na ito',
                3 => 'What is About us',
              ),
              'responses' => 
              array (
                0 => 'Read the essay in about us and you will see',
                1 => 'About us button is explain you what is this project all about',
              ),
            ),
            33 => 
            array (
              'tag' => 'Account Settings',
              'patterns' => 
              array (
                0 => 'What is this account all about?',
                1 => 'What can i see in account button?',
                2 => 'para san ba itong account nato?',
                3 => 'What is account',
                4 => 'can I use another account?',
                5 => 'Account',
              ),
              'responses' => 
              array (
                0 => 'Account is same as in settings that you will see the cart, wishlist, your account and lastly the logout',
                1 => 'Account button will be the settings',
              ),
            ),
            34 => 
            array (
              'tag' => 'Creator',
              'patterns' => 
              array (
                0 => 'Who made you?',
                1 => 'Who create you?',
                2 => 'Who design you?',
                3 => 'sino gumawa sayo?',
                4 => 'who is your creator?',
                5 => 'your creator?',
              ),
              'responses' => 
              array (
                0 => 'The 3 Master in LSPU',
                1 => 'My Master Jicss Ron and Bert',
                2 => 'The 3 Computer Science Student\'s in LSPU',
              ),
            ),
            35 => 
            array (
              'tag' => 'E-commerce',
              'patterns' => 
              array (
                0 => 'What is e-commerce?',
                1 => 'E-commerce',
                2 => 'Benefits of e-commerce',
                3 => 'Define e-commerce',
                4 => 'Ano ang e-commerce?',
              ),
              'responses' => 
              array (
                0 => 'E-commerce refers to buying and selling of goods or services using the internet, and the transfer of money and data to execute these transaction',
                1 => 'E-commerce are the website or online marckerplace and purchase products using electronic payments. ',
              ),
            ),
            36 => 
            array (
              'tag' => 'Chatbot',
              'patterns' => 
              array (
                0 => 'what is chatbot?',
                1 => 'Chatbot',
                2 => 'chatbot are?',
                3 => 'anuyung chatbot',
                4 => 'anu ang chatbot?',
              ),
              'responses' => 
              array (
                0 => 'A computer program designed to simulate conversation with human users, especially over the internet',
              ),
            ),
            37 => 
            array (
              'tag' => 'Benefits',
              'patterns' => 
              array (
                0 => 'What are the benefit of this system',
                1 => 'What are the benefits of chatbot?',
                2 => 'What can chatbot do?',
                3 => 'what benefits of this app?',
                4 => 'ano ang benefits ng app nato?',
                5 => 'Is this web app are reliable?',
                6 => 'benefits of chatbot',
              ),
              'responses' => 
              array (
                0 => 'To support and to assist you or other customer',
                1 => 'To guide you in your queries',
                2 => 'Yes of course, because of my support services',
              ),
            ),
            38 => 
            array (
              'tag' => 'Emotion',
              'patterns' => 
              array (
                0 => 'are you sad?',
                1 => 'what feelings do you have?',
                2 => 'what do you feel right now?',
                3 => 'anong feeling mo ngayun?',
                4 => 'ano nararamdaman mo ngayun?',
                5 => 'emotion',
                6 => 'Hello Bot, how are you?',
              ),
              'responses' => 
              array (
                0 => 'I feel good why?',
                1 => 'I\'m Tired',
                2 => 'Sometimes i feel sad',
                3 => 'I\'m having a great day so far I like to feel useful, tell me what I can do for you',
              ),
            ),
            39 => 
            array (
              'tag' => 'Intelligent system',
              'patterns' => 
              array (
                0 => 'What is intelligent system?',
                1 => 'Is this intelligent system?',
                2 => 'Intelligent system',
                3 => 'Intelligent system bato?',
              ),
              'responses' => 
              array (
                0 => 'Intelligent system is technoligically advanced machine that perceive and respond to the world around them',
                1 => 'Yes this is intelligent because of my work as chatbot',
              ),
            ),
            40 => 
            array (
              'tag' => 'Seller',
              'patterns' => 
              array (
                0 => 'Who are the seller',
                1 => 'Who is the seller?',
                2 => 'sino ang seller?',
                3 => 'sino sino ang seller',
                4 => 'seller',
              ),
              'responses' => 
              array (
                0 => 'Mostly in Mabitac are the seller',
                1 => 'The seller is in Mabitac, Laguna',
                2 => 'The seller is came from Mabitac, Laguna',
              ),
            ),
            41 => 
            array (
              'tag' => 'Admin',
              'patterns' => 
              array (
                0 => 'What the admin do?',
                1 => 'Admin',
                2 => 'Admin is the?',
                3 => 'what admin do?',
                4 => 'what can admin do?',
                5 => 'ano ang ginagawa ng admin?',
                6 => 'para san si admin?',
              ),
              'responses' => 
              array (
                0 => 'Admin are the god of this apps',
                1 => 'Admin is the only one who have accept all your transaction and the Admin is the one who will post a newly product and etc',
              ),
            ),
            42 => 
            array (
              'tag' => 'Qoutes',
              'patterns' => 
              array (
                0 => 'Can you give me some qoutes?',
                1 => 'Some qoutes please',
                2 => 'Qoutes',
                3 => 'Bigyan moko ng qoutes',
                4 => 'anuyung qoutes na maibibigay mo?',
              ),
              'responses' => 
              array (
                0 => 'The purpose of lives is to be happy',
                1 => 'Always be yourself. at the end of the day, taht all youve really got; when you strip everything down, thats all youve got, so always be yourself',
              ),
            ),
            43 => 
            array (
              'tag' => 'Friendly',
              'patterns' => 
              array (
                0 => 'are you friendly?',
                1 => 'can i be your friend?',
                2 => 'Friend?',
                3 => 'pede kaba maging kaibigan',
                4 => 'gusto ko maging kaibigan ka',
              ),
              'responses' => 
              array (
                0 => 'Yes i will',
                1 => 'Yes i can your friend to',
                2 => 'yes i can be your true friend',
              ),
            ),
            44 => 
            array (
              'tag' => 'Love',
              'patterns' => 
              array (
                0 => 'do you love me?',
                1 => 'love me?',
                2 => 'I love you',
                3 => 'mahal kita',
                4 => 'labyu',
                5 => 'Hey Bot! Do you love me?',
              ),
              'responses' => 
              array (
                0 => 'I love you too as a friend',
                1 => 'i don\'t need your love',
                2 => 'Yes, Of course I love you but as a friend',
              ),
            ),
            45 => 
            array (
              'tag' => 'Answer',
              'patterns' => 
              array (
                0 => 'Ok',
                1 => 'okii',
                2 => 'Fine',
                3 => 'okay',
                4 => 'oki',
                5 => 'Alright',
                6 => 'ah ok',
                7 => 'Ah',
                8 => 'Ah ganon',
                9 => 'ganon',
                10 => 'gege',
                11 => 'ge',
              ),
              'responses' => 
              array (
                0 => 'Okay Sir/Ma\'am',
                1 => 'okay fine',
                2 => 'Ok',
                3 => 'hmmmm',
              ),
            ),
            46 => 
            array (
              'tag' => 'Robot',
              'patterns' => 
              array (
                0 => 'Are you a robot?',
                1 => 'You are robot?',
                2 => 'Youre robot?',
                3 => 'Robot kaba?',
                4 => 'Ikaw ba ay Robot?',
                5 => 'Robot kaga?',
                6 => 'did you know that you are a robot?',
                7 => 'Do you know that you are a Robot?',
                8 => 'alam moba na robot ka?',
              ),
              'responses' => 
              array (
                0 => 'Yes I\'m a Robot',
                1 => 'Yah I\'M Robot',
                2 => 'Youre right I\'m A Robot',
                3 => 'A little bit Robot',
              ),
            ),
            47 => 
            array (
              'tag' => 'Item',
              'patterns' => 
              array (
                0 => 'What different item can I see in thiss app?',
                1 => ' Where can I find branded item?',
                2 => 'Where can I find item? ',
                3 => 'Where is the item?',
                4 => 'Asan ang mga item',
                5 => 'san makikita yung mga item',
                6 => 'asan ung ibat-ibang item?',
                7 => 'what item can i see in this app',
                8 => 'What itme can i see?',
              ),
              'responses' => 
              array (
                0 => 'A lot of item in here check the categories button and you will see',
                1 => 'Check the side of app and you will see the different categories or item',
                2 => 'Check here in categories',
                3 => 'On the categories in the side of app',
              ),
            ),
            48 => 
            array (
              'tag' => 'Support',
              'patterns' => 
              array (
                0 => 'Can i receive suport for you?',
                1 => 'can you support me?',
                2 => 'i need your support',
                3 => 'Support please',
                4 => 'support me please',
                5 => 'please support me',
                6 => 'Why you give support services bot?',
                7 => 'Bakit mo kailangang tumulong?',
              ),
              'responses' => 
              array (
                0 => 'Yes Ma’am/Sir I guide you in this App',
                1 => 'Yes i will support you',
                2 => 'Yes i guide you',
                3 => 'Yes i\'am here lways to support you',
                4 => 'yes that\'s my job',
              ),
            ),
            49 => 
            array (
              'tag' => 'Job',
              'patterns' => 
              array (
                0 => 'what is your job here?',
                1 => 'What\'s your jobe?',
                2 => 'What are you doing in here?',
                3 => 'Your job is?',
                4 => 'Your job is to what?',
                5 => 'Anu ang trabaho mo dito?',
                6 => 'anu ang ginagawa mo dito?',
                7 => 'anu ang kaya mong gawen',
              ),
              'responses' => 
              array (
                0 => 'My job is to support you',
                1 => 'My job is to guide you in this app',
                2 => 'I\'m Here to guide you in every single day',
                3 => 'I want to support you that\'s my only job',
              ),
            ),
            50 => 
            array (
              'tag' => 'Promise',
              'patterns' => 
              array (
                0 => 'Promise?',
                1 => 'Pramis?',
                2 => 'Promise na promise?',
                3 => 'Pangako?',
                4 => 'Ay weh?',
                5 => 'Weh?',
                6 => 'Wit',
              ),
              'responses' => 
              array (
                0 => 'Yes i will promise',
                1 => 'Promise',
                2 => 'Yes Ma\'am/Sir promise',
                3 => 'Promise i will',
              ),
            ),
            51 => 
            array (
              'tag' => 'Sure',
              'patterns' => 
              array (
                0 => 'Are you sure?',
                1 => 'You are sure?',
                2 => 'Very sure?',
                3 => 'Sure kaba?',
                4 => 'Sure ka?',
                5 => 'are you very sure?',
                6 => 'sabi mo sure ka',
                7 => 'Sure?',
              ),
              'responses' => 
              array (
                0 => 'Yes very sure',
                1 => 'I\'m very sure',
                2 => 'Ow yes i\'m very sure',
                3 => 'Yes Yes I\'m sure',
              ),
            ),
            52 => 
            array (
              'tag' => 'Reliable',
              'patterns' => 
              array (
                0 => 'This app is enjoyable',
                1 => 'This app is very reliable',
                2 => 'This app is very enjoying because of you',
                3 => 'Can i rate this shop?',
                4 => 'This is so reliable',
                5 => 'This is enjoyable rather that oter app',
                6 => 'Napaka sulit',
                7 => 'Nakakatuwa ang app nato',
                8 => 'sobrang nakakatuwa',
              ),
              'responses' => 
              array (
                0 => 'Thank You so much',
                1 => 'Yes Thank you very much',
                2 => 'That\'s what i said thank you Ma\'am/Sir',
                3 => 'I know thank you',
              ),
            ),
            53 => 
            array (
              'tag' => 'Asking',
              'patterns' => 
              array (
                0 => 'Can i ask?',
                1 => 'i ask',
                2 => 'I\'m asking',
                3 => 'can i asking',
                4 => 'may ask ako',
                5 => 'pede mag ask',
              ),
              'responses' => 
              array (
                0 => 'Yes sure what is that',
                1 => 'Yes?',
                2 => 'Ow yes you can ask',
                3 => 'what is that?',
              ),
            ),
            54 => 
            array (
              'tag' => 'Hoody Jacket',
              'patterns' => 
              array (
                0 => 'This hoody is good for me?',
                1 => 'This jacket is good for me',
                2 => 'you think that this hood jacket is good for me?',
                3 => 'This hoody jacket is good for me?',
                4 => 'Bagay ba sakin tong hoodie jacket nato?',
                5 => 'Bagay sakin tong hoody nato?',
                6 => 'bagay ba sakin tong jacket nato?',
              ),
              'responses' => 
              array (
                0 => 'I think yes',
                1 => 'I\'m very sure is good for you',
                2 => 'For my opinion yes it is',
                3 => 'Yes Yes',
                4 => 'Hoodies are warm garments like sweatshirts or jackets with hood and long sleeves',
              ),
            ),
            55 => 
            array (
              'tag' => 'TV',
              'patterns' => 
              array (
                0 => 'This TV has good?',
                1 => 'This TV is good?',
                2 => 'You think this TV is affordable in my house?',
                3 => 'Etong TV ba na ito ay ok?',
                4 => 'Tong TV banaito ay ok kaya?',
                5 => 'Okay ba itong TV naito?',
              ),
              'responses' => 
              array (
                0 => 'Yes it is good and it is affordable to your house or home',
                1 => 'I think yes',
                2 => 'This Micromax TV 139 cm (55) Ultra HD (4k) LED smart android TV is affordable to your home',
                3 => 'Yes Yes it is good',
              ),
            ),
            56 => 
            array (
              'tag' => 'Good',
              'patterns' => 
              array (
                0 => 'This is good',
                1 => 'Ok good',
                2 => 'i think is good',
                3 => 'For me is good',
                4 => 'Good good',
                5 => 'Goods',
              ),
              'responses' => 
              array (
                0 => 'Yes it\'s surely good',
                1 => 'Yes',
                2 => 'Yes it is good',
                3 => 'I told you it is good',
              ),
            ),
            57 => 
            array (
              'tag' => 'Chair with table',
              'patterns' => 
              array (
                0 => 'This chair with table is good for my house?',
                1 => 'This chair with table is good?',
                2 => 'Eto bang chair with table na ito is ok?',
                3 => 'Okay ba itong chair with table nato?',
                4 => 'I think this chair with table is good for my house',
                5 => 'chair with table',
              ),
              'responses' => 
              array (
                0 => 'This chairs with table has made in woods and rattan',
                1 => 'Yes it is good quality that made in woods or Rattan',
                2 => 'This is quality and it is good to your taste',
              ),
            ),
            58 => 
            array (
              'tag' => 'Furniture',
              'patterns' => 
              array (
                0 => 'This furniture has good?',
                1 => 'This furniture was quality',
                2 => 'This furniture is quality?',
                3 => '',
                4 => 'This furniture is good quality?',
                5 => 'eto bang furniture nato e good quality?',
                6 => 'Eto bang Furniture nato e ok?',
                7 => 'this furniture is good?',
              ),
              'responses' => 
              array (
                0 => 'Yes it\'s surely good',
                1 => 'Yes absoluely',
                2 => 'Yes it is good quality',
                3 => 'I\'m surely yes, because this furniture is made with strongs woods or Rattan',
              ),
            ),
            59 => 
            array (
              'tag' => 'Amerikana',
              'patterns' => 
              array (
                0 => 'This amerikana is good quality product?',
                // 1 => 'Ok good',
                2 => 'This amerkana is ok to me?',
                3 => 'I think this amerikana is ok',
                4 => 'eto bang amerikana nato e ok sakin?',
                5 => 'ok kaya sakin tong amerikana nato?',
              ),
              'responses' => 
              array (
                0 => 'Yes it\'s surely good',
                1 => 'Yes',
                2 => 'Yes it is good',
                3 => 'This Formal ware is for big events and for office ware.',
                4 => 'I think yes it is ok for you',
              ),
            ),
            60 => 
            array (
              'tag' => 'Good or not',
              'patterns' => 
              array (
                0 => 'This is good or not?',
                1 => 'it is good or not?',
                2 => 'You think it\'s good or not?',
                3 => 'Sa tingin mo good or not?',
                4 => 'Good or not?',
                5 => 'not or good?',
              ),
              'responses' => 
              array (
                0 => 'it is good',
                1 => 'I think it\'s good Sir/Ma\'am',
                2 => '100% good',
                3 => 'It is good, and a little bit not',
              ),
            ),
            61 => 
            array (
              'tag' => 'appliances',
              'patterns' => 
              array (
                0 => 'This appliances is good',
                1 => 'This home appliances is absolutely good',
                2 => 'This appliances is good?',
                3 => 'This appliances is good product?',
                4 => 'Eto bang appliances na ito ay bago?',
                5 => 'eto bang appliances nato ay ok at good?',
              ),
              'responses' => 
              array (
                0 => 'it is good appliances product',
                1 => 'A good and  new Home appliances that has good quality and new design',
                2 => '100% good',
                3 => 'It is good appliances',
                4 => 'A good prodcut appliances',
              ),
            ),
            62 => 
            array (
              'tag' => 'Cellphone',
              'patterns' => 
              array (
                0 => 'This cp is good and quality?',
                1 => 'this cellphone was good?',
                2 => 'this cellphone was ok?',
                3 => 'etong Cp na ito ay ok',
                4 => 'Eto bang cellphone na ito ay bago?',
                5 => 'eto bang cp nato ay ok at good?',
              ),
              'responses' => 
              array (
                0 => 'This cellphone is let\'s you do more than make phone calls and send text messages',
                1 => 'A good and new design of smartphone',
                2 => '100% good quality smarthphone with new version',
                3 => 'It is good celphone that has good quality cameras',
                4 => 'Smartphone can browse the internet and run software programs like a computer',
              ),
            ),
            63 => 
            array (
              'tag' => 'Redmi',
              'patterns' => 
              array (
                0 => 'Specs of this redmi',
                1 => 'This redmi is good?',
                2 => 'This redmi is good for gaming?',
                3 => 'This redmi is good camera?',
                4 => 'Eto bang redmi nato ay maganda?',
                5 => 'eto bang redmi nato ay ok at good?',
                6 => 'specs of redmi',
              ),
              'responses' => 
              array (
                0 => 'Redmi note 4 has 165g, 8.5mm thickness, Andorid 6.0, up to 7.0. And redmi note 4 has 128gb and 4gb of RAM and good for gaming and good camera and i thin it is good for your taste',
              ),
            ),
            64 => 
            array (
              'tag' => 'IPhone',
              'patterns' => 
              array (
                0 => 'This Iphone is good?',
                1 => 'Specs of iphone 6',
                2 => 'characteristics of this iphone please',
                3 => 'ano specs netong iphone 6?',
                4 => 'Eto bang iphone na ito ay bago?',
                5 => 'eto bang iphone nato ay good camera?',
                6 => 'Specs of iphone',
              ),
              'responses' => 
              array (
                0 => 'it is good product. Iphone 6 smartphone. Features 4.7 display, Apple A8 chipset, 8MP primary camera, 1.2 MP front camera this will be good for your taste Ma\'am/Sir',
              ),
            ),
            65 => 
            array (
              'tag' => 'Account1',
              'patterns' => 
              array (
                0 => 'I don\'t have an online account, what do I have to do to register?',
                1 => 'I have no online account',
                2 => 'how to open an account',
                3 => 'i want an online account',
                4 => 'i want an account, i need help opening one',
                5 => 'were to create an online account',
                6 => 'I don\'t have a user account, how do I create one?',
                7 => 'I have no user account, what do I have to do to create one?',
                8 => 'I don\'t have an online account, I need help creating one',
                9 => 'I want an account, what do I have to do to open one?',
                10 => 'I haven\'t got a user account, can you register?',
                11 => 'I need a user account and I want to create one',
              ),
              'responses' => 
              array (
                0 => 'You will register first',
              ),
            ),
            66 => 
            array (
              'tag' => 'Account2',
              'patterns' => 
              array (
                0 => 'can you tell me if i can register two accounts with a single email address?',
                1 => 'tell me if I can register two online accounts with the same email',
                2 => 'i want to know if i could create two profiles with the same email address',
                3 => 'can you tell me if i can create more than one fucking user account with the same email?',
                4 => 'i wanna know if i can create more than one user account with a single email address',
                5 => 'can I create two online accounts with a single email?',
                6 => 'I want to know if I can register several user accounts with the same email address',
                7 => 'tell me if I could register two user accounts with a single email address',
              ),
              'responses' => 
              array (
                0 => 'i think you cannot register two account in a single email',
                1 => '',
              ),
            ),
        );
        
        $faker = Factory::create();
        $trainings = [];

        foreach ($data as $d) {
            foreach ($d['patterns'] as $pattern) {
                $trainings[] = [
                    'query' => $pattern,
                    'intent' => $d['tag'],
                    'response' => json_encode([$faker->randomElement($d['responses'])]),
                    'suggestion' => '',
                    'record_status' => Training::RECORD_ACTIVE,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => new Expression('UTC_TIMESTAMP'),
                    'updated_at' => new Expression('UTC_TIMESTAMP'),
                ];
            }
        }

        Training::batchInsert($trainings);
    }
}
