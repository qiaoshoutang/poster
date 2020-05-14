<?php
namespace Home\Controller;
use Common\Controller\BaseController;
/**
*  @author tjinx
 * 前台公共类
 */
class SiteController extends BaseController {
  
    /**
     * @param  $mould 海报模板
     * @param  $path 海报的路径
     * @param  $word1 海报上的文字1
     * @param  $word2 海报上的文字2
     * @param  $word3 海报上的文字3
     * @return  $path
     */
    
    public function makePosterDna($mould,$path,$word1,$word2,$word3){ // by tjx
        
        if(!$mould||!$path||!$word1) return array('status'=>-1,'msg'=>'参数错误');
        
        $img =  new \Think\Image(1);
        

        $nameFont = './Public/font/pf.TTF';
        
        if(empty($word3)){
            $img->open($mould)
            ->text($word1,$nameFont,'50','#ffffff', 5,array(0,-10))
            ->text($word1,$nameFont,'50','#ffffff', 5,array(1,-10))
            ->text($word2,$nameFont,'24','#ffffff', 5,array(0,70))
            ->save($path);
        }else{
            $img->open($mould)
            ->text($word1,$nameFont,'50','#ffffff', 5,array(0,-15))
            ->text($word1,$nameFont,'50','#ffffff', 5,array(1,-15))
            ->text($word2,$nameFont,'24','#ffffff', 5,array(0,60))
            ->text($word3,$nameFont,'24','#ffffff', 5,array(0,105))
            ->save($path);
        }
        
        return $path;
        
    }

    /**
     * 前台模板显示 调用内置的模板引擎显示方法
     * @access protected
     * @param string $name 模板名
     * @param bool $type 模板输出
     * @return void
     */
    protected function siteDisplay($name='',$type = true,$tpl='') {
        C('TAGLIB_PRE_LOAD','Dux');
        C('TAGLIB_BEGIN','<!--{');
        C('TAGLIB_END','}-->');
        C('VIEW_PATH','./themes/');
        if(empty($tpl)){
            $tpl = C('TPL_NAME');
        }
        $data = $this->view->fetch($tpl.'/'.$name);
        //模板包含
        if(preg_match_all('/<!--#include\s*file=[\"|\'](.*)[\"|\']-->/', $data, $matches)){
            foreach ($matches[1] as $k => $v) {
                $ext=explode('.', $v);
                $ext=end($ext);
                $file=substr($v, 0, -(strlen($ext)+1));
                $phpText = $this->view->fetch($tpl.'/'.$file);
                $data = str_replace($matches[0][$k], $phpText, $data);
            }
        }
        //替换资源路径
        $tplReplace=array(
            //普通转义
            'search' => array(
                //转义路径
                "/<(.*?)(src=|href=|value=|background=)[\"|\'](images\/|img\/|css\/|js\/|style\/)(.*?)[\"|\'](.*?)>/",
            ),
            'replace' => array(
               
                "<$1$2\"".C('cdn').__ROOT__."/themes/".$tpl."/"."$3$4\"$5>",
            ),      
        );
        $data = preg_replace(  $tplReplace['search'] , $tplReplace['replace'] , $data);
        if($type){
            echo $data;
        }else{
            return $data;
        }
        
    }
	
	
}