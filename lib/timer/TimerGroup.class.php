<?php

/**
 * TimerGroup - ��ʱ���飬�����ۺϿ��ƶ����ʱ��
 *
 * @author: zhangdongjin@baidu.com
 */

require_once('Timer.class.php');

class TimerGroup
{
    private $arrTimer = array();
    private $precision;

    /** 
     * ���캯��
     * 
     * @param [in] $precision: int
     *              ���ؾ��ȣ�֧��ms��s���ȣ�Ĭ��Ϊms
     */
    function __construct($precision = Timer::PRECISION_MS)
    {
        $this->precision = $precision;
    }

    /** 
     * ���ö�ʱ����
     * 
     * @param [in] $completely:
     *              �Ƿ���ȫ����
     *              true  - �������ж�ʱ��
     *              false - �������ж�ʱ��
     */
    function reset($completely = false)
    {
        if($completely)
        {
            $this->arrTimer = array();
            return;
        }
        foreach($this->arrTimer as $timer)
        {
            $timer->reset();
        }
    }

    /** 
     * ����ָ����ʱ��
     * 
     * @param [in] $strName: string
     *              ��ʱ������
     *
     * @return true  - ok
     *         false - ָ����ʱ��������
     *
     * @note �Զ����������ڵĶ�ʱ��
     */
    function start($strName)
    {
        if(!array_key_exists($strName, $this->arrTimer))
        {
            $this->arrTimer[$strName] = new Timer(true, $this->precision);
            return true;
        }
        else
        {
            return $this->arrTimer[$strName]->start();
        }
    }

    /** 
     * ָֹͣ����ʱ��
     * 
     * @param [in] $strName: string
     *              ��ʱ������
     *
     * @return int   - ָ����ʱ�����׶εļ�ʱ������ͬ��ʱ������
     *         false - ָ����ʱ��������
     */
    function stop($strName)
    {
        if(!array_key_exists($strName, $this->arrTimer))
        {
            return false;
        }
        return $this->arrTimer[$strName]->stop();
    }

    /** 
     * ��ȡ�ܼ�ʱʱ��
     * 
     * @param [in] $strName: string
     *              ��ʱ�����ƣ�null��ʾ��ȡ���ж�ʱ����ʱ��
     *
     * @param [in] $precision: int
     *              ���ؾ��ȣ�֧��ms/s��Ĭ��Ϊ��ʱ������
     *
     * @return array - (��ʱ���� => ��ʱ)������
     *         int   - ָ����ʱ���ļ�ʱ
     *         false - ָ����ʱ��������
     */
    function getTotalTime($strName = null, $precision = null)
    {
        if($strName !== null)
        {
            if(!array_key_exists($strName, $this->arrTimer))
            {
                return false;
            }
            return $this->arrTimer[$strName]->getTotalTime($precision);
        }

        $arrTime = array();
        foreach($this->arrTimer as $name => $timer)
        {
            $arrTime[$name] = $timer->getTotalTime($precision);
        }
        return $arrTime;
    }
}

?>
