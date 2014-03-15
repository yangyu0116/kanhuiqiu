<?php
error_reporting(E_ALL);
require_once('DBMan.class.php');
require_once('SQLTemplate.class.php');


// create a selector object
$rs = new RandSelector();
// create a statusman object
$sm = new StatusManFile('tmp');

// hosts config
$arrHosts = array(
    array('127.0.0.1', 3306), // the only vaild host
    array('127.0.0.1', 21),
    array('127.0.0.1', 8900),
    array('127.0.0.1', 9999),
    array('127.0.0.1', 3306),
    array('127.0.0.1', 3307),
    array('127.0.0.1', 3308),
);

// user config
$arrUser = array(
    'uname'  => 'root',
    'passwd' => NULL
);

$dbname = 'wiki';

// create dbman object
$man = new DBMan($arrHosts, $arrUser, $dbname, $rs, $sm);
// get db object
$db = $man->db;
if(!$db)
{
    exit("failed to get db connection\n");
}
echo "current host:\n";
print_r($man->currentHost);
$db->enableProfiling(true);
// fail handler
function reportFail(DB $db, $res)
{
    echo "DB ERROR: ({$db->errno}){$db->error}\n";
}
$db->onFail('reportFail');

// use SQLTemplate to create sql statement
$tpl = new SQLTemplate($db);
$tpl->prepare('select versionid from tblLemma where id = {id:n}');
// select and print the versionid for the lemmas from 1 to 9
for($i = 1; $i < 10; ++$i)
{
    $tpl->bindParam('id', $i);
    // do query, return assoc array by default
    $res = $db->query($tpl);
    echo "1 -- $i: ".$res[0]['versionid']."\n";
}
echo "--------------\n";

// add hook to modify sql

function modSQL(DB $db, $sql, $extArgs = NULL)
{
    $sql .= ' where id < 10 order by id';
}

$db->addHook(DB::HK_BEFORE_QUERY, 'modsql', 'modSQL');

// now we use DBResult to access the result
$sql = 'select id, versionid from tblLemma';
$res = $db->query($sql, DB::FETCH_OBJ);
// the sql was changed, now remove hook
$db->removeHook(DB::HK_BEFORE_QUERY, 'modsql');
while($row = $res->next())
{
    echo '2 -- '.$row['id'].": ".$row['versionid']."\n";
}
echo "--------------\n";

// and then, we use callback
function printRes($row, $num)
{
    echo "$num -- ".$row['id'].": ".$row['versionid']."\n";
}
$res->walk('printRes', DB::FETCH_ASSOC, 3);
echo "--------------\n";

$res->free();

// use high level query wrapper
$tables = array(
    'tblVersion as a',
    'tblLemma as b'
);

$fields = array(
    'b.id as lid',
    'a.id as vid',
    'b.lemmatitle as title',
    'a.authorname as author'
);

$conds = array(
    'b.id <' => 100,
    'b.versionid = a.id',
);

$options = 'DISTINCT';

$appends = array(
    'ORDER BY b.id',
    'LIMIT 5'
);

print_r($db->select($tables, $fields, $conds, $options, $appends));

// print profiling data
print_r($db->getProfilingData());
echo "total: {$db->totalCost}\n";

$db->close();

?>
