<?php
function smarty_function_widget($params, Smarty_Internal_Template $template){
    if (isset($params['path'])) {
        $path = $params['path']; 
    } else {
        throw new Exception("widget path参数不能为空[{$template->source->filepath}]");
    }
    unset($params['path']);
    $fn = 'smarty_template_function_fis_' . strtr(substr($path, 0, strrpos($path, '/')), '/', '_');
    if(function_exists($fn)){
        return $fn($template, $params);
    } else {
        $output = $template->getSubTemplate($path, $template->cache_id, $template->compile_id, null, null, $params, Smarty::SCOPE_LOCAL);
        if(function_exists($fn)){
            return $fn($template, $params);
        } else {
            return $output;
        }
    }
}