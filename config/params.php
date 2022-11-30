<?php

return [
    'user.passwordResetTokenExpire' => 3600,
    'pagination' => [25 => 25, 50 => 50, 75 => 75, 100 => 100],
    'order_status' => [
        0 => [ 'id' => 0, 'label' => 'Pending', 'class' => 'warning'],
        1 => [ 'id' => 1, 'label' => 'Processing', 'class' => 'info'],
        2 => [ 'id' => 2, 'label' => 'For Delivery', 'class' => 'primary'],
        3 => [ 'id' => 3, 'label' => 'Completed', 'class' => 'success'],
        4 => [ 'id' => 4, 'label' => 'Cancelled', 'class' => 'danger'],
        5 => [ 'id' => 5, 'label' => 'Void', 'class' => 'dark'],
    ],
    'customer_links' => [
        [
            'label' => 'My Dashboard', 
            'url' => ['site/customer-dashboard'], 
            'icon' => 'fas fa-dashboard',
            'page' => 'customer-dashboard',
        ],
        [
            'label' => 'My Cart', 
            'url' => ['site/my-cart'], 
            'icon' => 'fas fa-cart-plus',
            'page' => 'my-cart'
        ],
        [
            'label' => 'My Orders History', 
            'url' => ['site/my-orders'], 
            'icon' => 'fas fa-book',
            'page' => 'my-orders'
        ],
        [
            'label' => 'My Wishlist', 
            'url' => ['site/my-wishlist'], 
            'icon' => 'fas fa-bookmark',
            'page' => 'my-wishlist'
        ],
        [
            'label' => 'My Product Reviews', 
            'url' => ['site/my-reviews'], 
            'icon' => 'fas fa-star-half-alt',
            'page' => 'my-reviews'
        ],
        [
            'label' => 'My Account Details', 
            'url' => ['site/my-account-details'], 
            'icon' => 'fas fa-user-lock',
            'page' => 'my-account-details'
        ],
    ],
    'price_filter' => [
        0 => 100,
        100 => 500,
        500 => 1000,
        1000 => 5000,
        5000 => 10000
    ],
    'product_sorting' => [
        'latest' => ['id' => 0, 'label' => 'Latest', 'class' => 'primary'],
        'popularity' => ['id' => 1, 'label' => 'Popularity', 'class' => 'success'],
        'rating' => ['id' => 2, 'label' => 'Best Rating', 'class' => 'danger'],
    ],
    'stock_threshold_status' => [
        0 => ['id' => 0, 'label' => 'Safe', 'class' => 'primary'],
        1 => ['id' => 1, 'label' => 'High', 'class' => 'success'],
        2 => ['id' => 2, 'label' => 'Low', 'class' => 'danger'],
    ],
    'record_status' => [
        0 => ['id' => 0, 'label' => 'In-active', 'class' => 'danger'],
        1 => ['id' => 1, 'label' => 'Active', 'class' => 'success'],
    ],
    'ip_types' => [
        0 => ['id' => 0, 'label' => 'Black List', 'class' => 'success'],
        1 => ['id' => 1, 'label' => 'White List', 'class' => 'danger'],
    ],
    'notification_status' => [
        0 => ['id' => 0, 'label' => 'New', 'class' => 'danger'],
        1 => ['id' => 1, 'label' => 'Read', 'class' => 'success'],
    ],
    'notification_types' => [
        0 => [
            'id' => 0, 
            'type' => 'notification_change_password', 
            'label' => 'Password Changed'
        ],
        1 => [
            'id' => 1, 
            'type' => 'new_review', 
            'label' => 'Product Review'
        ],
        2 => [
            'id' => 2, 
            'type' => 'new_order', 
            'label' => 'New Order'
        ],
        3 => [
            'id' => 3, 
            'type' => 'cancel_order', 
            'label' => 'Cancel Order'
        ]
    ],
    'user_status' => [
        0 => ['id' => 0, 'label' => 'Archived', 'class' => 'danger'],
        9 => ['id' => 9, 'label' => 'Not Verified', 'class' => 'warning'],
        10 => ['id' => 10, 'label' => 'Active', 'class' => 'success'],
    ],
    'user_block_status' => [
        0 => ['id' => 0, 'label' => 'Allowed', 'class' => 'success'],
        1 => ['id' => 1, 'label' => 'Blocked', 'class' => 'danger'],
    ],
    'visit_log_actions' => [
        0 => ['id' => 0, 'label' => 'Login', 'class' => 'success'],
        1 => ['id' => 1, 'label' => 'Logout', 'class' => 'danger'],
    ],
    'whitelist_ip_only' => [
        0 => ['id' => 0, 'label' => 'All', 'class' => 'danger'],
        1 => ['id' => 1, 'label' => 'Whitelist Only', 'class' => 'success'],
    ],
    'enable_visitor' => [
        0 => ['id' => 0, 'label' => 'Disable', 'class' => 'danger'],
        1 => ['id' => 1, 'label' => 'Enable (require internet connection)', 'class' => 'success'],
    ],
];