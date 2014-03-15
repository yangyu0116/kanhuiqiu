<?php 
require_once '../Cache.class.php';
//test static
$statiCache = Cache::factory('static');
$statiCache->set('static_key','static value');
echo 'staticCache get :' . $statiCache->get('static_key');

//test fileCache
echo '<hr/>';
$fileCache = Cache::factory('file',array('dir'=>'./cache','lifeTime'=>900));
$key = 'file_key';
if ( $rs = $fileCache->get($key) )
{
    echo 'fileCache get : ' . var_export($rs,TRUE);
}
else 
{
    echo 'filecache not cache!';
    $fileCache->set($key,array(
        'test'=>array(1,2,3),
        't'=>'value',
    ));
}

//test eacc
echo '<hr/>';
try 
{
    $eacc = Cache::factory('eacc',array(
        'lifeTime'=>900,
    ));
    $key = 'test_eacc';
    if ( $rs = $eacc->get($key) )
    {
        echo 'eacc cache!get rs' . var_export($rs,TRUE);
    }
    else 
    {
        echo 'eacc not cache!';
        $eacc->set($key,'eacc cache value');
    }
}
catch (Exception $e)
{
    var_dump($e);
}
?>