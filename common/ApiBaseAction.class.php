<?php
/***************************************************************************
 * 
 * Copyright (c) 2013 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/
 
 
 
/**
 * @file ApiBaseAction.class.php
 * @author sixiaohai(sixiaohai@baidu.com)
 * @date 2013/04/26 23:40:09
 * @brief 
 *  
 **/

abstract class ApiBaseAction extends Action
{
	////////////////////////////////////////////////////////////////
    
    /**
     * 抽象函数 - 初始化子类相关资源
     * @param $initObject 传入CommonApiConfig::$action中的第四个参数
     * @return true 成功初始化
     *         false 初始化失败
     **/    
    public abstract function sub_init($initObject);

    ////////////////////////////////////////////////////////////////

    /**
     * Action初始化
     **/
    public function initial($initObject)
    {
        if ($this->sub_init($initObject)) {
            //初始化本类资源
            return true;
        }
        else {
            //初始化data area和service失败
            //- 停止action继续执行
            return false;
        }
    }


}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
