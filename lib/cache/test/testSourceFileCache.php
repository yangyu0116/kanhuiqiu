<?php 

require_once '../engine/SourceFileCache.class.php';

$cache = new SourceFileCache(array(
    'dir'=>'./cache',
));
$key = 'test_source';

$rs = $cache->get($key);
if (!$rs)
{
    $value = array(
    	'test'=>1,
    	'test2'=>array(1,2,3),
    );
    echo $key . ' not cache!';
    $cache->set($key,$value);
}
else 
{
    echo $key . ' cache!<br/>';
    echo 'cache rs:' ;
    print_r($rs);   
}

//test remove
$key = 'test_remove';
$value = 'test""\'';
$cache->set($key,$value);
echo 'after set ,get:' . $cache->get($key) . '<br/>';
$cache->remove($key);
$cache->get($key);
echo 'after remove,get :';
var_dump($cache->get($key)); 
?>