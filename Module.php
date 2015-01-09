<?php

namespace alexsers\articles;

/**
 * Class Module
 * @package alexsers\articles
 */
class Module extends \yii\base\Module
{
    /**
     * @var string
     */
    public $controllerNamespace = 'alexsers\articles\controllers\frontend';

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

    /**
     * @var boolean Whether module is used for backend or not
     */
    protected $_isBackend;

    public function run()
    {
        return "Hello!";
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->getIsBackend() === true) {
            $this->setViewPath('@alexsers/articles/views/backend');
        } else {
            $this->setViewPath('@alexsers/articles/views/frontend');
        }
    }

    /**
     * Check if module is used for backend application.
     *
     * @return boolean true if it's used for backend application
     */
    public function getIsBackend()
    {
        if ($this->_isBackend === null) {
            $this->_isBackend = strpos($this->controllerNamespace, 'backend') === false ? false : true;
        }

        return $this->_isBackend;
    }
}
