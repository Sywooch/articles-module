<?php

namespace alexsers\articles;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        // Add module URL rules
        $app->getUrlManager()->addRules(
            [
                'articles' => 'articles/articles/index',
                'articles/<alias:[a-zA-Z0-9_-]{1,100}+>' => 'articles/articles/view',
                'category/<category:[a-zA-Z0-9_-]{1,100}+>' => 'articles/articles/category',
            ]
        );
    }
}