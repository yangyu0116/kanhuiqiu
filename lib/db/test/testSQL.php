<?php
/**
* brief of test/testSQL.php:
* 
* @author 
* @date 2008/11/10 18:08:35
* @version $Revision: 1.1 $ 
* @todo 
*/


require_once('SQLTemplate.class.php');
require_once('SQLAssember.class.php');

if(0)
{
$sa = new SQLAssember();

$ins = array(
    'a=1',
    'b' => 'asdadas',
    'c' => NULL
);

$tables = array(
    'tblVersion as a',
    'tblLemma as b'
);

$fields = array(
    'b.id as lid',
    'a.id as vid',
    'b.lemmatitle as title'
);

$conds = array(
    'b.versionid = a.id',
    'b.versionid != 0',
    'b.id < 100'
);

$appends = array(
    'ORDER BY b.id DESC',
    'LIMIT 1, 100',
);

$sql = $sa->getInsert('test1', $ins, array('HIGH_PRIORITY', 'IGNORE'), 'a=now()');
$sql = $sa->getSelect($tables, $fields, NULL, 'HIGH_PRIORITY', $appends);

$row = array(
    'id'=>12345,
    'lemmatitle' => 'vvvvvv',
    );

$conds = array(
    'id < 100',
    'versionid = 0'
);

$options = array(
    'LOW_PRIORITY',
    'IGNORE'
);

echo $sa->getUpdate('tblLemma', $row, $conds, $options, 'LIMIT 1')."\n";
echo $sa->getDelete('tblLemma', $conds, $options, 'LIMIT 1')."\n";
}


$conn = new DB(true);
$ret = $conn->connect('127.0.0.1', 'root', '', 'wiki');
$st = new SQLTemplate($conn);

$st->prepare('SELECT * FROM tblA where id={id:n} and name={name:s} and id={id:n} and a>9');
$st->bindParam(array('id'=>100, 'name' => 'abc'), NULL, true);
$st->bindParam('name', 'AAAA');
var_dump($st->getSQL());
$st->prepare('SELECT * FROM tblA where id={id:n} and name={aa:s} and time={time:r}');
$st->bindParam('aa', "'''");
$st->bindParam('id', '1000');
$st->bindParam('time', 'now()');
var_dump($st->getSQL());

?>
