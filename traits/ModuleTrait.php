<?php

namespace alexsers\articles\traits;

use alexsers\articles\Module;

trait ModuleTrait
{
    private $_module;

    public function getModule()
    {
        if($this->_module === null){
            $this->_module = Module::getInstance();
        }

        return $this->_module;
    }
}