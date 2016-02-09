Text Area Tokens - Yii2 extension
=====

This is drop-in replacement for textarea form element. It provides tokens below form element. Text is automatically inserted
into textarea by clicking one of tokens.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist mmedojevicbg/yii2-text-area-tokens "dev-master"
```

or add

```
"mmedojevicbg/yii2-text-area-tokens": "dev-master"
```

to the require section of your `composer.json` file.


Usage
------------

```php
echo TextAreaTokens::widget(['model' => $model,
                             'attribute' => 'textfield1',
                             'tokens' => ['first_name', 'last_name', 'phone_number'],
                             'options' => ['rows' => 8, 'cols' => 100]])
```