<?php
function query_encode($queryArr=array()) {
    $query = array();
    foreach($queryArr as $k=>$v){
        $query[] = $k.'='.htmlspecialchars($v);
    }
    return $query;
}

function smarty_function_append_path_info($params, $template) {
    $query = query_encode($template->tpl_vars['params']->value);
    $queryStr = implode('&amp;',$query);
    return strpos($params['url'],'?') === false ?  $params['url'].'?'.$queryStr : $params['url'].'&amp;'.$queryStr;
}