<?php
class BaseModel 
{
    protected $tablename;
    protected $db;
    protected $memcache;
    protected $use_cache;
    protected $cache_expire_time;

    public function __construct($config, $_db, $_memcache)
    {
        $this->use_cache = $config['use_cache'];
        $this->cache_expire_time = $config['cache_expire_time'];

		$this->db = $_db;
		$this->memcache = $_memcache;

		if (!empty($this->db)){
			$this->db->query('set names utf8');
		}
    }

    protected function do_sql($sql)
    {
        $result = false;
        if(empty($this->db))
        {
            CLogger::warning('db object NULL, sql: '.$sql);
            return false;
        }
        $ret = $this->db->query($sql);
        if($ret === false)
        {
            CLogger::warning('db query fail, sql: '.$sql);
        }
        else
        {
            //CLogger::debug('db query, sql: '.$sql);
        }
        return $ret;
    } 
    
	/** 
		* @brief 
		* 执行sql语句，其中包含了cache读取逻辑
		* 
		* @param $sql 执行的sql语句
		* @param $found_rows[out] sql操作的行数 
		* 
		* @return 
		* false	执行sql失败
		* 其他	返回的结果集 
	 */
    protected function do_query($sql, &$found_rows)
    {
    	$cache_key = $sql;
    		
        $result = false;
		// memcache为NULL or 不使用Cache
		if (empty($this->memcache) || 
			$this->use_cache === false)
		{
			if (empty($this->db))
			{
                CLogger::warning('db object NULL, sql: '.$sql);
				return false;
			}

            $ret = $this->db->query($sql);
            
            if ($ret !== false)
            {
                $result = $ret;
				$ret2 = $this->db->query('SELECT FOUND_ROWS()');
				$found_rows = $ret2[0]['FOUND_ROWS()'];
                CLogger::debug('db query, sql: '.$sql);
            } 
            else
            {
                CLogger::warning('db query fail, sql: '.$sql);
            }
		}
		// 使用cache
        else
        {
            $ret = $this->memcache->get($cache_key);
            $ret2 = $this->memcache->get('SELECT FOUND_ROWS()'.$cache_key);
            if ($ret === false || $ret2 === false)
            {
				if (empty($this->db))
				{
					CLogger::warning('db object NULL, sql: '.$sql);
					return false;
				}

                $ret = $this->db->query($sql);
                // 要cache结果集合和结果数目
                if ($ret !== false)
                {
					$result = $ret;

        	 		$ret = $this->memcache->set($cache_key, $result, false, $this->cache_expire_time);
                    if ($ret === false)
                    {
                        CLogger::warning('memcache set fail, key: '.$cache_key);
                    }     

					$ret2 = $this->db->query('SELECT FOUND_ROWS()');
					$found_rows = $ret2[0]['FOUND_ROWS()'];

					$ret = $this->memcache->set('SELECT FOUND_ROWS()'.$cache_key, $found_rows, false, $this->cache_expire_time);
					if ($ret === false)
					{
						CLogger::warning('memcache set fail, key: '.'SELECT FOUND_ROWS()'.$cache_key);
					}     
					CLogger::debug('db query, sql: '.$sql);
                }
				else
				{
					CLogger::warning('db query fail, sql: '.$sql);
				}
            } 
            else
            {
                $result = $ret;
                $found_rows = $ret2;
				CLogger::debug('mc query, sql: '.$sql);
            }       
        }
	
        return $result;    
    } 

    protected function debug_sql($sql)
    {
		CLogger::debug('DEBUG_SQL: '.$sql);
    }
}
?>
