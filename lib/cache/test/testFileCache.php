<?php 
require_once '../engine/FileCache.class.php';
$cache = new FileCache(array(
    'level'=>1,
    'dir'=>'./cache',
    'lifeTime'=>60,
));
$key = 'test';

$boolRs = $cache->get($key);
if (!$boolRs)
{
    $value = 'test value! hello world!';
    echo 'not cache!<br/>';
    $cache->set($key,$value);
}
else 
{
    echo 'cache!<br />';
    echo $boolRs;
}
//remove test
$key = 'test_remove';
$value = 'test';
$cache->set($key,$value);
echo 'after set ,get:' . $cache->get($key) . '<br/>';
$cache->remove($key);
$cache->get($key);
echo 'after remove,get :';
var_dump($cache->get($key)); 
?>