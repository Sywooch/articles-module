<?php

namespace alexsers\articles;

/**
 * Class Module
 * @package alexsers\articles
 */
class Module extends \alexsers\base\components\Module
{

    public static $name = 'articles';

    /**
     * @var int Articles per page
     */
    public $recordPerPage = 10;

    /**
     * Whether posts need to be moderated before publishing
     */
    public $moderation = true;

    /**
     * @var string Files path
     */
    public $filePath = '@statics/web/articles/files';

    /**
     * @var string Files path
     */
    public $contentPath = '@statics/web/articles/content';

    /**
     * @var string Files URL
     */
    public $fileUrl = '/statics/articles/files';

    /**
     * @var string Files URL
     */
    public $contentUrl = '/statics/articles/content';
}
