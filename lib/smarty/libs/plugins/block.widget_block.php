<?php

function smarty_block_widget_block($params, $content, Smarty_Internal_Template $template, &$repeat){
    if(!$repeat){

        if(!isset($params['name'])){
            throw new Exception("模版[{$template->source->filepath}]中定义的fis_widget_content必须包含name属性");
        }

        $name  = 'fis_widget_content_name_'.$params['name'];
        $value = $template->getTemplateVars($name);
        if($value === null){
            $template->assign($name, $content);

            return $content;
        }

        return $value;
    }
}