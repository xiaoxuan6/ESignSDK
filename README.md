# E签宝·开放平台 认证服务 SDK

[接口文档](https://open.esign.cn/doc/opendoc/identity_service/shiming)

# Usage
配置信息

```angular2html
$config = [
    'mode' => 'dev', // dev:测试(默认) prod:正式
    'app_id' => 'xxx',
    'app_key' => 'xxx',
    'client' => [
        'verify' => false,
        'timeout' => 10,
    ],
    'middlewares' => [
        'log' => \Vinhson\EsignSdk\Kernel\Middlewares\LogMiddleware::class,
    ],
    /**
    * 日志配置信息
    */
    'log_enable' => true,
    'log_path' => __DIR__ . '/../../access.log',
    'log_max' => 7 // 日志保留天数
];

$app = new Vinhson\EsignSdk\Application($config);
```

# 容器中变量对应的类
```angular2html
* @property OCR\Client $ocr ocr识别能力
* @property Enterprise\Client $enterprise 信息查询
* @property Info\Client $info 信息对比能力
* @property AuthFlow\Client $auth 认证流程查询
* @property Account\Client $account 用户认证服务
```

# OCD 检测
```angular2html
$app->ocr->idCard('xxxx', '')
```

# tests
```angular2html
composer test
```