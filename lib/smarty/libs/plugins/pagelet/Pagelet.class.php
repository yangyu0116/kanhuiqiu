<?php
/**
 * Created by JetBrains PhpStorm.
 * User: danghongyang,yansunrong
 * Desc: 一个pagelet的对象，用于保存运行中的实例
 * Date: 12-2-22
 * Time: 下午5:32
 * To change this template use File | Settings | File Templates.
 */

class Pagelet {
    private $id = null;
    private $onloadArray = array();
    private $contentBuffer = array();
    private $controller ;

    /**
     * 构造函数
     * @param id pagelet的ID
     * @param controller pagelet的控制器。
     */
    public function __construct($id, $controller){
        $this->id = $id;
        $this->controller = $controller;
    }
    /**
     * 设置pagelet的id
     * @param id 
     */
    public function setId($id){
        $this->id = $id;
    }
    /**
     * 获取当前pagelet的id
     * @return id 
     */
    public function getId(){
        return $this->id;
    }

    /**
    * pagelet_script标签开始操作。
    */
    public function scriptsStart(){
        if($this->controller->ajaxType !== 0){
            $content = ob_get_contents();
            $this->conntentBufferPush($content);
            ob_clean();
            ob_start();
        }else{
            echo '<script type="text/javascript">';
        }
    }
    /**
    * pagelet_script标签结束操作。
    */
    public function scriptsEnd(){
        if($this->controller->ajaxType !== 0 ){
            $content = ob_get_contents();
             $this->pushOnloadArray($content);
            ob_clean();
            ob_start();
        }else{
            echo '</script>';
        }
    }

    /**
    * pagelet开始
    */
    public function pageletStart(){
        if($this->controller->ajaxType !== 0){
            ob_clean();
            ob_start();
        }
        

    }
    /**
    * pagelet结束
    */
    public function pageletEnd(){
        if($this->controller->ajaxType !==0){
            $content = ob_get_contents();
             $this->conntentBufferPush($content);
            ob_clean();
        }
    }

    /**
    * 添加js语句到数组中来。
    * @param onload js语句
    */
    public function pushOnloadArray($onload){
        array_push($this->onloadArray, $onload);
    }

    /**
    * 以json格式输出pagelet的数据。
    * @return json.stringify后的字符串
    */
    public function jsonStringify(){
        $result = array(
            "id" => $this->id,
            "onload" => $this->onloadArray,
            "html" => join("", $this->contentBuffer)
        );
        return json_encode($result);
    }

    /**
    * 将输出的内容放到缓冲池里
    */
    public function conntentBufferPush($buffer){
        array_push($this->contentBuffer, $buffer);
    }
   
}
