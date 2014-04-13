<?php
class DefaultAction extends Action
{
    public function execute($context, $actionParam = null)
    {
    	header('location:'.GlobalConfig::$default_url);
    	CLogger::notice("executing DefaultAction");
    }
}

