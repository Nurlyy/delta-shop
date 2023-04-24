<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/products/<product_id:\w+>' => '/products/view',
                '/products/<product_id:\w+>/update' => '/products/update',
                '/products/<product_id:\w+>/delete' => '/products/delete',
                '/products/create' => '/products/create/',
                '/products/update-manufacturer/<manufacturer_id:\w+>' => '/products/update-manufacturer',
                '/products/delete-manufacturer/<manufacturer_id:\w+>' => '/products/delete-manufacturer',
                '/products/update-category/<category_id:\w+>' => '/products/update-category',
                '/products/delete-category/<category_id:\w+>' => '/products/delete-category',
                '/products/update-category/<category_id:\w+>/create-subcategory' => '/products/create-subcategory',
                '/products/update-category/<category_id:\w+>/update-subcategory/<subcategory_id:\w+>' => '/products/update-subcategory',
                '/products/update-category/<category_id:\w+>/delete-subcategory/<subcategory_id:\w+>' => '/products/delete-subcategory',
                '/products/update-category/<category_id:\w+>/update-subcategory/<subcategory_id:\w+>/create-rubrik' => '/products/create-rubrik',
                '/products/update-category/<category_id:\w+>/update-subcategory/<subcategory_id:\w+>/update-rubrik/<rubrik_id:\w+>' => '/products/update-rubrik',
                '/products/update-category/<category_id:\w+>/update-subcategory/<subcategory_id:\w+>/delete-rubrik/<rubrik_id:\w+>' => '/products/delete-rubrik',
            ],
        ],
        
    ],
    'params' => $params,
];
