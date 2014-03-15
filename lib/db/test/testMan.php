<?php

require_once('DBMan.class.php');


$rs = new RandSelector();
$sm = new StatusManFile('tmp');

$arrDB = array(
    array('127.0.0.1', 3306),
    array('127.0.0.1', 3307),
    array('127.0.0.1', 3308),
//    array('127.0.0.1', 9099),
);

$man = new DBMan($arrDB, array('uname'=>'root', 'passwd'=>NULL), 'wiki', $rs, $sm);
$db = $man->getDB();
print_r($db->query('select * from tblLemma limit 1'));

?>
