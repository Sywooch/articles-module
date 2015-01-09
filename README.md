Yii2 articles-module
====================
Articles Module

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist alexsers/articles-module "*"
```

or add

```
"alexsers/articles-module": "*"
```

to the require section of your `composer.json` file.

app config

// common

    'modules' => [
        'articles' => [
            'class' => 'alexsers\articles\Module'
        ],
    ],

// backend

    'modules' => [
        'articles' => [
            'controllerNamespace' => 'alexsers\articles\controllers\backend'
        ],
    ],

// frontend

    'modules' => [
        'articles' => [
            'controllersNamespace' => 'alexsers\articles\controllers\frontend'
        ]
    ],
