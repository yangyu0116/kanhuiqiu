<?php
/**
 * Created by JetBrains PhpStorm.
 * User: danghongyang,yansunrong
 * Date: 12-2-22
 * Time: 下午5:07
 * To change this template use File | Settings | File Templates.
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Pagelet.class.php';
class PageletController {
    private $_NOSCRIPT_TAG="_noscript";//noscript参数名称
    private $_AJAX_TAG="ajax";//异步请求标记
    private $_SESSION_TAG="session";
    private $_PAGELET_TAG="pagelet";

    public $isNoScript = false;//当前页面是否为不支持script
    public $isAllPagelet = false;//是否请求当前页面的所有pagelet
    public $ajaxType = 0 ; // 请求形式，0 表示正常请求，1 表示pagelet请求，2表示直接需要html数据
    public $sessionId = 0; //一次异步请求的session id

    private $pagelets = array();//当前页面的所有pagelet
    private $rels = array();//请求的pagelet列表。 ["area_1","area_2"]
    private $currentPagelet = null ;//临时的pageletid

    public function __construct(){
		if(isset($_GET[$this->_AJAX_TAG])){
			$this->ajaxType = intval($_GET[$this->_AJAX_TAG]);
		}
        if(isset($_GET[$this->_PAGELET_TAG])){
            if($_GET[$this->_PAGELET_TAG] == "all"){
                 $this->isAllPagelet = true;
            }else{
                $this->rels = explode(',', $_GET[$this->_PAGELET_TAG]);
            }
        }else{
            $this->isAllPagelet = true;
        }
        if(isset($_GET[$this->_NOSCRIPT_TAG])){
            $this->isNoScript = true;
        }
        if(isset($_GET[$this->_SESSION_TAG])){
            $this->sessionId = $_GET[$this->_SESSION_TAG];
        }
    }


    /**
    * 向controll里添加pagelet
    * @param id pagelet的id
    */
    public function addPagelet($id){
        $this->currentPagelet = new Pagelet($id, $this);
        $this->pagelets[] = $this->currentPagelet;
    }

    /**
    * 获取controll里最近添加pagelet
    * @return pagelet对象
    */
    public function getCurrentPagelet(){
        return $this->currentPagelet;
    }

    /**
    * 调用current的pagelet将onload内容push
    * @param onload JS语句
    */
    public function pageletOnloadPush($onload){
        $this->currentPagelet->pushOnloadArray($onload);
    }

    /**
    * 调用当前的pagelet实例进行script开始的操作输出
    */
    public function scriptsStart(){
        $this->currentPagelet->scriptsStart();
    }

    /**
    * 调用当前的pagelet实例进行script结束的操作输出
    */
    public function scriptsEnd(){
        $this->currentPagelet->scriptsEnd();
    }

    /**
    * 调用当前的pagelet实例进行paglet块的开始操作输出
    */
    public function pageletStart(){
        $this->currentPagelet->pageletStart();
    }

    /**
    * 调用当前的pagelet实例进行paglet块的结束操作输出
    */
    public function pageletEnd(){
        $this->currentPagelet->pageletEnd();
    }


     /**
    * 输出所有的pagelet的结果
    */
    public function outputPagelets(){
        if($this->isNoScript){
            return;
        }
        if($this->ajaxType === 0){
            echo '<script type="text/javascript">F.use("/static/common/lib/fis/pagelet/pagelet.js");</script>';
            return;
        }
        if($this->ajaxType !== 0){
            ob_clean();
        }
		$pageletItems = array();
        foreach($this->pagelets as $item){
            if($this->isAllPagelet){
                $pageletItems[] = $this->getPageletItem($item);
            }else{
                foreach ($this->rels as $rel) {
                   if($rel == $item->getId()){
                       $pageletItems[] = $this->getPageletItem($item);
                   }
                }
            }
        }
         if($this->ajaxType === 1){
			foreach ($pageletItems as $i) {
				echo $i;
			}
            echo 'pagelet.sessionEnd(',$this->sessionId,');';
        }else if($this->ajaxType === 2){
			echo '[';
			for($index=0;$index < count($pageletItems);$index++){
				echo $pageletItems[$index];
				if($index !== 0){
					echo ';';
				}
			}
			echo ']';
		}
    }

    /**
    * 调用当前的pagelet实例进行title块的开始操作输出
    */
    public function titleStart($title){
        if($this->ajaxType === 1){
            ob_clean();
            //这里编码设置是一个问题
            echo 'document.title = "'.$title.'";';
            ob_start();
        }
        else {
            echo '<title>'.$title.'</title>';

            //添加头部的跳转,
            echo "<script type=\"text/javascript\">(function(l){var h=l.hash;h&&h.length>2&&h.substr(0,3)=='#!/'&&(l.href=l.protocol+'//'+l.host+'/'+h.substr(3))})(location);</script> ";
        }
    }


    /**
     * 添加noscript标记
     * @return url 标记后的url
     */
    private function addNoScriptMeta(){
        $uri = $_SERVER["REQUEST_URI"];
        if(strpos($uri, '?')){
            return $uri.'&'.$this->_NOSCRIPT_TAG.'=1';
        }else{
            return $uri.'?'.$this->_NOSCRIPT_TAG.'=1';
        }
    }


    /**
     * 输出pagelet的片断
     * @param item pagelet实例
     */
    private function getPageletItem($item){
        if($this->ajaxType === 1){
            return "pagelet.onArrive(".$item->jsonStringify().");";
        }else if($this->ajaxType === 2){
			 return $item->jsonStringify();
		}
    }
}
