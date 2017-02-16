# Yii2 Centrifugo Component

## Installation
Run command in shell
```shell
> php composer.phar require "betsuno/yii2-centrifugo"
```
or add this line in to the `require` section of the `composer.json` file in your project 
```json
"betsuno/yii2-centrifugo": "*"
```

## Setup
Add into your config file as following
```php
'components' => [
	...
	'centrifugo' => [
		'class'  => 'yii2\centrifugo\Client',
		'host'   => 'http://localhost:8000',
		'secret' => 'very-long-secret-key',
		// also you can specify your own transport class as below
		'transport' => [
			'class' => 'your\transport\ClassName',
			...
		]
	],
	...
]
```

## Usage
```php
Yii::$app->centrifugo->publish('test', ['message' => 'hello world']);
```