<?php

namespace app\models\form\setting;

use Yii;

class AboutUsForm extends SettingForm
{
    const NAME = 'about-us-settings';
    /* EMAIL */
    public $owner;
    public $shop_name;
    public $address;
    public $contact_no;
    public $information;
    public $mapIframe;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['owner', 'shop_name', 'address', 'contact_no', 'information'], 'required'],
            [['owner', 'shop_name', 'address', 'contact_no', 'information', 'mapIframe'], 'string'],
        ];
    }

    public function default()
    {
        return [
            'owner' => [
                'name' => 'owner',
                'default' => 'Jasmin Montealegre'
            ],
            'shop_name' => [
                'name' => 'shop_name',
                'default' => 'Montealegre Synthetic Furniture'
            ],
            'address' => [
                'name' => 'address',
                'default' => 'C-3 brgy. Paagahan Mabitac, Laguna'
            ],
            'contact_no' => [
                'name' => 'contact_no',
                'default' => '09054370417'
            ],
            'mapIframe' => [
                'name' => 'mapIframe',
                'default' => <<< HTML
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30909.45580894858!2d121.37141547101629!3d14.445482386251284!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ee6768e8a36d%3A0xe466853e8760b5ca!2sPaagahan%2C%20Mabitac%2C%20Laguna!5e0!3m2!1sen!2sph!4v1668933625242!5m2!1sen!2sph" width="600" height="450" style="border:0;width: 100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                HTML
            ],
            
            'information' => [
                'name' => 'information',
                'default' => <<< HTML
                    <h5>Purpose of the Project System</h5>
                    The purpose of this system is to help online shopping and to speed up the shopping transaction true online. it was made for shops and online sellers to help their business sell quickly. Many people all over the world prefer to shop online and purchase products from various brands and companies that they cannot find or cannot purchase in their home countries. People from all over the world are now purchasing items online while sitting in their homes, thanks to new technology and the support of the internet. Buying items and products on the Internet is a simple process. It is now playing an increasingly important role in everyone's life, particularly for the elderly and those with a hectic schedule. It offers its customers a very convenient service by allowing them to save an item in their personal shopping bag and purchase it later. Shopping on the internet is only available to those who have a valid credit card, debit card, or internet bank account.
                    We use Artificial Intelligence to support our system, the purpose of the Artificial Intelligence is to give a support services for our E-commerce Website. We use Artificial Intelligence for Chatbot, the chatbot will answer the customer needs and questions and it will support and give guide to customer for better browse in our system. AI plays a significant role in improving customer experiences and developing innovative solutions in the eCommerce industry. Some of the most notable applications of AI in eCommerce are product recommendations, personalized shopping experiences, virtual assistants, chatbots, and voice search.
                    <p></p>
                    <h5>Importance</h5>
                    Companies can benefit from viewing AI through the lens of business capabilities rather than technologies. In general, AI can help with three critical business needs: automating business processes, gaining insight through data analysis, and engaging with customers and employees. Because of the numerous advantages and benefits, an increasing number of people now prefer online shopping to traditional shopping. In recent years, the buyer's decision-making process has shifted dramatically. Buyers conduct extensive online research before speaking with a salesperson. Buyers are also making more direct purchases online and through their smartphones, never entering traditional brick-and-mortar stores. Doing business has become much easier and faster thanks to the internet. It has resulted in changes in how people conduct business, with a rapidly growing global trend toward online shopping or e-commerce
                    <p></p>
                    <h5>Benefits of Development of intelligent e-commerce customer support services using NLP Algorithm</h5>
                    <ul>
                        <li>Faster Buying</li>
                        <li>Affordable Marketing</li>
                        <li>Faster response to buyer</li>
                        <li>Speed and Flexibility</li>
                        <li>Scalability</li>
                        <li>Reviews and Ratings</li>
                        <li>Upgraded Chatbots</li>
                    </ul>
                HTML
            ],
        ];
    }
}