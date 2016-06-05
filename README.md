# Yii 2 - AtLeastValidator

[![Build Status](https://travis-ci.org/code-on-yii/yii2-at-least-validator.svg?branch=master)](https://travis-ci.org/code-on-yii/yii2-at-least-validator)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/code-on-yii/yii2-at-least-validator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/code-on-yii/yii2-at-least-validator/?branch=master)

Sometimes, in a set of fields, you need to make at least one of them
(sometimes two, or more) be filled. For example, phone OR e-mail,
(facebook OR linkedin) OR (linkedin OR instagram) and so on. You can do
it using required validator with a bunch of conditional rules. Or you can
use AtLeastValidator.

## Installation

Use composer:

```php
    composer require "codeonyii/yii2-at-least-validator"
```
In your Model, import the validator:
```php
use codeonyii\yii2validators\AtLeastValidator;

class MyModel extends Model
{
...
    public function rules()
    {
        // see examples below
    }
...
```

## Examples

In the following example, the `phone` and `email` attributes will
be verified. If none of them are filled `phone` will receive an error.
Please, note that `in` param is always mandatory.

```php
     // in rules()
     return [
         ['phone', AtLeastValidator::className(), 'in' => ['phone', 'email']],
     ];
```

Here, `facebook`, `linkedin` and `instagram` attributes will
be verified. If at least 2 (note the `min` param) of them are not filled,
`facebook` and `instagram` will receive an error:

```php
     // in rules()
     return [
         [['facebook', 'instagram'], AtLeastValidator::className(), 'in' => ['facebook', 'linkedin', 'instagram'], 'min' => 2],
     ];
```

### Showing errors in summary

If you want to show errors in a summary instead in the own attributes, you can do this:

*Note that summary will **not** work for client-side validation. If you want
to use it, you should disable the client-side validation for your fields
or for your entire form.*

```php
     // in the rules()
     // please note the exclamation mark. It will avoid the pk attribute to be massively assigned.
     return [
         ['!id', AtLeastValidator::className(), 'in' => ['attr1', 'attr2', 'attr3']], // where `id` is the pk
     ];

     // in the view, show all errors in the summary:
     ...
     echo yii\helpers\Html::errorSummary($model, ['class' => ['text-danger']]);

     // OR, to show only `id` errors:
     echo yii\helpers\Html::error($model, 'id', ['class' => ['text-danger']]);
```


## Changelog

* 1.1: Adds client-side validation;
* 1.0.3: Basic funcionality and tests;
