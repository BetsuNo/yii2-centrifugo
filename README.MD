# Yii2 Centrifugo Component

## Installation
Run command in shell
```shell
> php composer.phar require "betsuno/yii2-centrifugo"
```
or add
```json
"betsuno/yii2-centrifugo": "*"
```
in the `require` section of the `composer.json` file in your project 

## Setup
Add 
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