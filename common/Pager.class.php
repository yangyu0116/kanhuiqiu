<?php
/** 
 * @file Pager.class.php
 * @brief 翻页模块
 */
class Pager 
{
    protected $pn;    //页码
    protected $rn;    //每页结果数
    protected $tn;    //总共结果数
    protected $url_prefix;    //url前缀

    protected $pn_num;    //当前页的前后页码数
    protected $type; //页码类型：0:单位增减 ; 1:rn增减

    protected $pager_html;
    protected $pager_html2;

    /** 
     * @brief 
     * 
     * @param $_url_prefix    url前缀，后边补上&pn=X
     * @param $_tn    总数目
     * @param $_pn    当前页码
     * @param $_rn    每页记录数
     * 
     * @return 
     */
    public function __construct($_url_prefix, $_tn, $_pn, $_rn, $_op = "=", $_and = "&", $_pn_num = 4 , $_type = 0) 
    {
        $this->pn = $_pn;
        $this->rn = $_rn;
        $this->tn = $_tn;
        $this->url_prefix = $_url_prefix;

        $this->pn_num = $_pn_num;
        $this->type = $_type;
		$this->op = $_op;
		$this->and = $_and;

        $this->generate();
    }

    protected function generate()
    {
        $this->pager_html = '';
        $this->pager_html2 = '';
        $this->res_data_arr = array();

        $total_num = $this->tn;

        if ($this->type === 0)
        {
            $first_id = ($this->pn-1)*$this->rn+1;
        }
        else
        {
            $first_id = intval($this->pn/$this->rn)*$this->rn+1;
        }

        // 1,无效页码
        if ($first_id > $total_num || $first_id <= 0)
        {
            return;
        }

        // 2,小于1页
        if ($total_num <= $this->rn)
        {
            return;
        }

        // 3,多页
        if ($this->type === 0)
        {
            $min_pn = 1;
            $max_pn = ceil($total_num*1.0/$this->rn);

            $pn_num = $this->pn_num;
            if ($this->pn+$pn_num < $max_pn)
                $max_pn = $this->pn+$pn_num;
            if ($this->pn-$pn_num > $min_pn)
                $min_pn = $this->pn-$pn_num;

            for ($i = $min_pn; $i <= $max_pn; $i++) 
            {
                $html = '';
                $html2 = '';

                if ($i == $this->pn)
                {
                    $html = '<span>['.$i.']</span>';
                    //$html2 = '<span class='cur'>'.$i.'</span>';
                    $html2 = sprintf("<span class='cur'>%d</span>", $i);
                }
                else
                {
                    $html = sprintf("<a href='%s".$this->and."pn".$this->op."%d'>[%d]</a>", $this->url_prefix, $i, $i);
                    $html2 = sprintf("<a href='%s".$this->and."pn".$this->op."%d'>%d</a>", $this->url_prefix, $i, $i);
                }
                $this->pager_html = $this->pager_html . $html; 
                $this->pager_html2 = $this->pager_html2 . $html2; 
            }

            if ($this->pn != 1)
            {
                $html = sprintf("<a href='%s".$this->and."pn".$this->op."%d'>上一页</a>", $this->url_prefix, $this->pn-1);
                $html2 = sprintf("<a href='%s".$this->and."pn".$this->op."%d' class='page-ctrl'>&lt;上一页</a>", $this->url_prefix, $this->pn-1);
                $this->pager_html = $html.$this->pager_html; 
                $this->pager_html2 = $html2.$this->pager_html2; 
            }

            if ($this->pn != $max_pn)
            {
                $html = sprintf("<a href='%s".$this->and."pn".$this->op."%d'>下一页</a>", $this->url_prefix, $this->pn+1);
                $html2 = sprintf("<a href='%s".$this->and."pn".$this->op."%d' class='page-ctrl'>下一页&gt;</a>", $this->url_prefix, $this->pn+1);
                $this->pager_html = $this->pager_html.$html;
                $this->pager_html2 = $this->pager_html2.$html2;
            }
        }
        else
        {
            $min_pn = 1;
            $max_pn = ceil($total_num*1.0/$this->rn);

            $pn = intval($this->pn/$this->rn)+1;
            $pn_num = $this->pn_num;
            if ($pn+$pn_num < $max_pn)
                $max_pn = $pn+$pn_num;
            if ($pn-$pn_num > $min_pn)
                $min_pn = $pn-$pn_num;

            for ($i = $min_pn; $i <= $max_pn; $i++) 
            {
                $html = '';
                $html2 = '';

                if ($i == $pn)
                {
                    $html = '<span>['.$i.']</span>';
                    //$html2 = '<span class='cur'>'.$i.'</span>';
                    $html2 = sprintf("<span class='cur'>%d</span>", $i);
                }
                else
                {
                    $html = sprintf("<a href='%s".$this->and."pn".$this->op."%d'>[%d]</a>", $this->url_prefix, ($i-1)*$this->rn, $i);
                    $html2 = sprintf("<a href='%s".$this->and."pn".$this->op."%d'>%d</a>", $this->url_prefix, ($i-1)*$this->rn, $i);
                }
                $this->pager_html = $this->pager_html . $html; 
                $this->pager_html2 = $this->pager_html2 . $html2; 
            }
            
            if ($pn != 1)
            {
                $html = sprintf("<a href='%s".$this->and."pn".$this->op."%d'>上一页</a>", $this->url_prefix, ($pn-2)*$this->rn);
                $html2 = sprintf("<a href='%s".$this->and."pn".$this->op."%d' class='page-ctrl'>&lt;上一页</a>", $this->url_prefix, ($pn-2)*$this->rn);
                $this->pager_html = $html.$this->pager_html; 
                $this->pager_html2 = $html2.$this->pager_html2; 
            }

            if ($pn != $max_pn)
            {
                $html = sprintf("<a href='%s".$this->and."pn".$this->op."%d'>下一页</a>", $this->url_prefix, ($pn)*$this->rn);
                $html2 = sprintf("<a href='%s".$this->and."pn".$this->op."%d' class='page-ctrl'>下一页&gt;</a>", $this->url_prefix, ($pn)*$this->rn);
                $this->pager_html = $this->pager_html.$html;
                $this->pager_html2 = $this->pager_html2.$html2;
            }

        }
    }

    /** 
     * @brief 获取生成的html代码
     * 
     * @return 
     */
    public function get_html()
    {
         return $this->pager_html;
    }

    /** 
     * @brief 获取生成的html2代码
     * 
     * @return 
     */
    public function get_html2()
    {
         return $this->pager_html2;
    }

}
?>
