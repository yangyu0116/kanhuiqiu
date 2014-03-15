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
     * ������ - ��ʼ�����������Դ
     * @param $initObject ����CommonApiConfig::$action�еĵ��ĸ�����
     * @return true �ɹ���ʼ��
     *         false ��ʼ��ʧ��
     **/    
    public abstract function sub_init($initObject);

    ////////////////////////////////////////////////////////////////

    /**
     * Action��ʼ��
     **/
    public function initial($initObject)
    {
        if ($this->sub_init($initObject)) {
            //��ʼ��������Դ
            return true;
        }
        else {
            //��ʼ��data area��serviceʧ��
            //- ֹͣaction����ִ��
            return false;
        }
    }


}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
