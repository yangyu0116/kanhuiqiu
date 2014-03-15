<?php
/**
 * @package bingo/config
 * @author  zhangdongjin@baidu.com
 *
 * Bingo֧������autoloadģʽ��
 *
 * 1����ͨģʽ
 *
 * ���Զ�������ClassAʱ��BingoĬ�ϴ�include_path�м���ClassA.class.php
 *
 * 2������ģʽ
 *
 * ������include_path��Ѱ����Ϊ��xxx.class.php�����ļ�������class=>file��ӳ�䣬
 * autoloadʱֱ�Ӵ�cache��ȡ��������ɨĿ¼
`* ����ģʽ��Ч������ͨģʽһ����ֻ������������
 *
 * 3������ģʽ
 *
 * �����õ�·���еݹ��ҳ�����php(.php, .inc)�ļ�������������ļ����ҳ�class��interface������class=>file��ӳ��
 * autoloadʱֱ�Ӵ�cache��ȡ��������ɨĿ¼
 *
 * note��
 *
 * 1���������������ʱ���Զ�ˢ��cache��cache�����ڡ������޷���cache���ҵ���������cacheָ�����ļ�����ʧ��
 * 2��ʹ�õ�����ģʽʱ����Ҫע�����������ͻ
 *
 * Tips��
 *
 * 1�������Ŀ¼��ν��٣���include_pathҲ����ʱ��������ͨģʽ���ɣ�
 * 2�������include_path�϶࣬��Ŀ¼��β���ʱ�����ü���ģʽ��
 * 3�������include_path�϶࣬��Ŀ¼��ν���ʱ�����ü���ģʽ��
 *
 * CAUTION:
 *
 * ����ģʽ�޷�����ע�͵��࣬��˻����Ľ���ע�͵������cache
 * Ϊ�˱�������⣬��������ע�ͣ�
 *
 * /*class SomeClass{
 * ...
 *
 * */
class AutoLoadConfig
{
    // �Ƿ�ʹ��class cache
    const USE_AUTOLOAD_CACHE = true;

    // �Ƿ�򿪼���ģʽ��USE_AUTOLOAD_CACHEΪtrueʱ��Ч
    const AUTOLOAD_CACHE_EXTREME_MOD = false;

    // �����ڼ���ģʽ���ݹ�Ϊ��ЩĿ¼����cache
    public static $AUTOLOAD_PATH_CONFIG;
}

// �����ڼ���ģʽ���ݹ�Ϊ��ЩĿ¼����cache
AutoLoadConfig::$AUTOLOAD_PATH_CONFIG = array(
    CONFIG_PATH,        // ���뱣��
    FRAMEWORK_PATH,     // ���뱣��
    MODULE_PATH,
    LIB_PATH,
    COMMON_PATH,
);

?>
