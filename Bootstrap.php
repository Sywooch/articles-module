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

        // Add module I18N category.
        if (!isset($app->i18n->translations['alexsers/articles']) && !isset($app->i18n->translations['alexsers/*'])) {
            $app->i18n->translations['alexsers/articles'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@alexsers/articles/messages',
                'forceTranslation' => true,
                'fileMap' => [
                    'alexsers/articles' => 'articles.php',
                ]
            ];
        }
    }
}