<?php
namespace Home\Controller;
use Home\Controller\SiteController;
/**
 * 
 */
class AjaxController extends SiteController {
    
    /*
     * DNA邀请函海报生成
     */
    public function getPoster(){
        
        $user_name=I('request.user_name','','trim');
        $first=I('request.first','','trim');
        $second=I('request.second','','trim');


        if(!$user_name){
            $this->ajaxReturn(array('code'=>0,'msg'=>'缺少参数'));
        }
        
        $path='./Uploads/poster/'.date('Y-m-d').'/';
        if(!is_dir($path)){
            mkdir($path);
        }
        $fileName = md5($user_name.'_'.$first.'_'.$second.'_'.$third);
        $path2='/Uploads/poster/'.date('Y-m-d').'/';
        $postImg2=$path2.$fileName.'.png';//海报的绝对路径
        
        //         if(is_file($postImg2)){//如果海报已存在  直接返回海报
        //             $this->ajaxReturn(array('code'=>1,'msg'=>'生成海报成功','poster'=>$postImg2));
        //         } 
        
        $moule='./Public/mould/mould_dna.jpg';


        
        
        $postImg=$path.$fileName.'.png';

        $post_url = $this->makePosterDna($moule,$postImg,$user_name,$first,$second);
        if($post_url){
            $this->ajaxReturn(array('code'=>1,'msg'=>'生成海报成功','poster'=>$postImg2));
        }else{
            $this->ajaxReturn(array('code'=>0,'msg'=>'生成海报失败'));
        }
        
    }

    
}