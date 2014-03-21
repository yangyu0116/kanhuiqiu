<?php 
/**
 * Cache引擎的接口类
 * @author xuliqiang@baidu.com
 * @since 2009-10-20
 * @package cache
 *
 */
abstract class AbstractCacheEngine
{
    protected $_errno = 0;
    
    const CACHE_DIR_INVALD = 1;
    
    const APC_NOT_FOUND = 2;
    
    const EACC_NOT_FOUND = 3;
    
    abstract public function get($key);
    
    abstract public function set($key,$value,$lifeTime=NULL);
    
    abstract public function remove($key);        
    
    abstract public function setOption($config);
    /**
     * 获取当前时间，unix时间戳
     *
     * @return int
     */
    public function getNowTime()
    {
        if (method_exists('Util','getTime'))
        {
            return Util::getTime();
        }
        return time();
    }
    
    protected function _error($errno)
    {
        $this->_errno = $errno;
    }
    
    public function getError()
    {
        return $this->_errno;
    }
    
    public function isError()
    {
        return (bool)($this->_errno != 0);
    }
}