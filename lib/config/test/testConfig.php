<pre><?php 
require_once '../Config.class.php';

require_once '../../cache/Cache.class.php';
//test array config
$cache = Cache::factory('source',array(
    'dir'=>'./cache',
    'encode'=>'md5',
));
$ArrayConfig = Config::factory('array',array(
    'fileName'=>'./config/array.php',
    'autoRefresh'=>TRUE,
    'cache'=>$cache,
));
if ($ArrayConfig)
{
    print_r($ArrayConfig->get('key1'));
    print_r($ArrayConfig->get('key2'));
    print_r($ArrayConfig->get('key2.key2_1'));
}

//test ini
$IniConfig = Config::factory('ini',array(
    'fileName' => './config/test.ini',
    'autoRefresh'=>TRUE,
    'cache'=>$cache,
));
if ($IniConfig)
{
    print_r($IniConfig->getData());
}
else 
{
    print_r(Config::getErrmsg());
}

//test configure
/*$config = Config::factory('configure',array(
    'dir'=>'./config',
    'confFileName'=>'test.conf',
    'rangeFileName'=>'test.range',
));
if ($config)
{
    print_r($config->getData());
}*/
//test configure2
$config = Config::factory('configure',array(
    'dir'=>'./config',
    'confFileName'=>'server.conf',
    'autoRefresh'=>TRUE,
    'cache'=>$cache,
));
if ($config)
{
    print_r($config->getData());
    print_r($config->get('member.server'));
}
else
{
    print_r(Config::getErrmsg());
}
?>
</pre>