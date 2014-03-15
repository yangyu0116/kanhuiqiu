<?php
/**
* brief of ISQL.class.php:
*
* interface of SQL generator
*
* @author zhangdongjin
*/


interface ISQL
{
    // return SQL text or false on error
    public function getSQL();
}

?>
