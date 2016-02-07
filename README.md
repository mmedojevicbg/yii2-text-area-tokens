Text Area Tokens - Yii2 extension
=====

This is drop-in replacement for textarea form element. It provides tokens below form element. Text is automatically inserted
into textarea by clicking one of tokens.

Usage
---

```php
echo TextAreaTokens::widget(['model' => $model,
                             'attribute' => 'textfield1',
                             'tokens' => ['first_name', 'last_name', 'phone_number'],
                             'options' => ['rows' => 8, 'cols' => 100]])
```