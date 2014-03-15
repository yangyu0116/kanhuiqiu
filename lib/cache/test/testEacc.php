<?php 
require_once '../engine/EaccCache.class.php';

try 
{
    $cache = new EaccCache();    
    //test normal
    $key = 'test_eacc';
    if ( $rs = $cache->get($key))
    {
        echo 'Cache!<br />';
        var_dump($rs);
    }
    else 
    {
        echo 'not Cache!<br />';
        //save
        $value = 'cache content';
        $cache->set($key,$value);
    }
    
    //test remove
    echo 'test remove <br />';
    $key = 'test_remove';
    $value = 'test_remove_value';
    $cache->set($key,$value);
    echo 'after set ,get[' . $key .']:['.$cache->get($key).']<br />';
    
    $cache->remove($key);
    echo 'after remove ,get[' . $key .']:['.var_export($cache->get($key),TRUE).']<br />';
}
catch (Exception $e)
{
    var_dump($e);
}
?>