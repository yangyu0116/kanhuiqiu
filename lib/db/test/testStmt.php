<?php
/**
* brief of test/testStmt.php:
* 
* @author 
* @date 2008/11/10 17:54:12
* @version $Revision: 1.1 $ 
* @todo 
*/


require_once('DB.class.php');
require_once('DBStmt.class.php');

$db = new DB();
$db->connect('127.0.0.1', 'root', '', 'wiki');
//print_r($db->query('select a.id as aid, b.id as bid, b.lemmatitle as title from tblVersion as a , tblLemma as b where a.id=b.versionid limit 100, 3', 9));exit;
//print_r($db->query('select id as ida, a.a as aa from tblVersion, a limit 2'));exit;
//$stmt = $db->prepare('select a.a as aa, b.a as ba, max(a.a) as max from a as a, b as b where a.a = b.a and a.a > ? group by a.a');
//$stmt = $db->prepare('select tblVersion.id from tblVersion ,tblLemma where tblVersion.id=tblLemma.versionid limit 1');
$stmt = $db->prepare('select lemmaid from tblVersion where id < ?');

$stmt->bindParam('i', 0);
//print_r($stmt->execute(2));

$stmt->bindParam('i', 10);
$res = $stmt->execute(DB::FETCH_OBJ);
var_dump($res->next(2));
var_dump($res->next(1));
//var_dump($res->next());

function aaa($row)
{
    var_dump($row);
}
$res->walk('aaa', 2);
//var_dump($res->seek(0));
echo $res->tell();



?>
