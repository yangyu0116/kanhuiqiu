<?php
/**
* brief of test/testDB.php:
* 
* @author 
* @date 2008/11/10 17:50:23
* @version $Revision: 1.1 $ 
* @todo 
*/


require_once('DB.class.php');

function dumpRes(DB $db, $res, $extArgs = NULL)
{
    echo $db->getLastSQL()."\n---\n";
    if($res === false)
    {
        echo "{$db->errno}: {$db->error}\n";
    }
    else if($res === true)
    {
        echo "ins_id({$db->insertID}), aff_rows({$db->affectedRows})\n";
    }
    else if(is_array($res))
    {
        print_r($res);
    }
    else
    {
        echo "get result OK\n";
    }
   // $res = array('fake'=>'modify');
}

function modSQL(DB $db, $sql, $extArgs = NULL)
{
    $sql = 'aaaaa';
    return false;
}

$conn = new DB(true);
if(0)
{
    //$conn->addHook(DB::HK_BEFORE_QUERY, 'main', 'modSQL');
    $conn->addHook(DB::HK_AFTER_QUERY, 'main', 'dumpRes');
    $conn->addHook(DB::HK_AFTER_QUERY, 'main2', 'dumpRes');
}

$ret = $conn->connect('127.0.0.1', 'root', '', 'wiki');

print_r($conn->getTables('%User%'));
var_dump($conn->isTableExists('tblUser'));
exit;

if(1)
{
    function reportFail(DB $db, $res)
    {
        echo "DB ERROR: ({$db->errno}){$db->error}\n";
        $res = array(array("id"=>7));
    }
    $conn->onFail('reportFail');
    print_r($conn->query('SELECT * from asdas'));
    $conn->onFail(NULL);
    print_r($conn->query('SELECT * from asdas'));
    exit;

    // Ô¤·ÀSQL×¢Èë
    print_r($conn->queryf("select id, lemmatitle from tblLemma where id < %n or lemmatitle = '%s'",
        "2pad", "' or '1' = '1"));
}
if(0)
{
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
        //'LIMIT 11, 5',
    );

    //print_r($conn->select($tables, $fields, $conds, NULL, $appends));
    var_dump($conn->selectCount('tblTag'));
    echo $conn->getLastCost();
    
    $ins = array(
        'a=8',
        'b' => 'neweqw',
    );
    //var_dump($conn->insert('test1', $ins, 'HIGH_PRIORITY', 'a='.rand()));
    //echo $conn->getInsertID();
    $conds = array(
        'a > 3000',
        'b != 2 OR b = 2'
    );
    //var_dump($conn->delete('test1', $conds, 'QUICK', 'LIMIT 1'));
    //var_dump($conn->update('test1', $ins, $conds, 'LOW_PRIORITY', 'LIMIT 1'));
    exit;
}

if(0)
{
    $ret = $conn->getTables('mysql');
    var_dump($ret);
    $ret = $conn->isTableExists('tblVersion');
    var_dump($ret);
}

if(0)
{
    $conn->query('select * from dasdas');
    $conn->query('update tblLemma set id=0 where id=4');
    $res = $conn->query('select id, lemmatitle from tblLemma where id < 100 and versionid != 0 limit 19', DB::FETCH_OBJ);
    print_r($conn->getProfilingData());
    function walk($row)
    {
        var_dump($row);
    }
    $res->walk('walk');
    $res->free();
    exit;
}


?>
