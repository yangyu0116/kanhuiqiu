<?php
/** 
 * @file Storage.class.php
 * @brief ��װmysql��memcached�Ĺ���
 */
class Storage 
{
    public $db;
    public $memcache;
	public $redis;
    private $db_name;
	private $convert_to_memcache = false;

    public function __construct($_db_name, $is_cache=true)
    {
        $this->db_name = $_db_name;
        if($is_cache)
        {
			if ($this->convert_to_memcache == true){
				$this->get_connect_memcached($_db_name);
			}else{
				$this->get_connect_redis();
			}
        }
    }
    
    public function __destruct() 
    {
        if (!empty($this->db))
        {
            $this->db->close();  
        }
		if ($this->convert_to_memcache == true){
			if (!empty($this->memcache))
			{
				$this->memcache->close();  
			}
		}
    }

    /** 
     * @brief ��mysql
     * 
     * @return 
     */
    public function get_connect_db($_db_name)
    {
        if (empty($this->db))
        {
            $this->db = new DB(true);
            $databases = GlobalConfig::$database;
            //�������ݿ⣬�����Ի���
            $isConnected = false;
            //yuping begin
            while(count($databases))
            {
                $databasekey = array_rand($databases,1);
                $database = $databases[$databasekey];
                $ret = $this->db->setConnectTimeOut(GlobalConfig::DATABASE_TIMEOUT);
                if($ret===false)
                {
                    //�������ӳ�ʱʧ��
                    Clogger::warning('set connect timeout fail', GlobalConfig::BINGO_LOG_ERRNO, $database);
                }
                $isConnected = $this->db->connect($database['host'],$database['username'],
                $database['password'],$this->db_name,$database['port']);
                if($isConnected === false)
                {
                    Clogger::warning('connect to database fail', GlobalConfig::BINGO_LOG_ERRNO, $database);
                    array_splice($databases,$databasekey,1);
                } else {   
                    //���ӳɹ�                   
                    Clogger::debug('connect to database success', 0, $database);
                    break;
                }
            }    
            //yuping end
            //���е����Ӿ�ʧ��
            if($isConnected === false)
            {
                CLogger::fatal('all database down!', GlobalConfig::BINGO_LOG_ERRNO);
            }
        }
        return $this->db;
    }

    /** 
     * @brief ��memcached
     * 
     * @return 
     */
    public function get_connect_memcached($_db_name)
    {
        if (empty($this->memcache))
        {
            $this->memcache = new MemcacheProxy();
            if($_db_name === GlobalConfig::$db_ugc)
            {
                $config = GlobalConfig::$memcached_ugc;
            }   
            else
            {
                $config = GlobalConfig::$memcached;
            }
            $ret = $this->memcache->connect($config['host'], $config['port']);
            if ($ret === false)
            {               
                CLogger::warning('connect to memcached fail');
            }
        }
        return $this->memcache;
    }

	/** 
     * @brief ��redis
     * 
     * @return 
     */
    public function get_connect_redis()
    {
        if (empty($this->memcache))
        {
			//ʹ��redis
            //$config = RedisConf::$HOSTS;
			$this->memcache = new RedisProxy();

            if ($this->memcache === false)
            {               
                CLogger::warning('connect to redis fail');
            }
        }
        return $this->memcache;
    }
    

}
?>
