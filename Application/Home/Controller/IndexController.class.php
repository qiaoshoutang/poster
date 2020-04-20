<?php
namespace Home\Controller;
use Home\Controller\SiteController;
/**
 * 站点首页
 */

class IndexController extends SiteController {
    
    /**
     * 首页
     */
    public function index(){ 
        
        $this->siteDisplay('index',true,'poster');
        
    }
    
    /**
     * 制作页
     */
    public function makeZh(){ 
        
        $this->siteDisplay('FillInformation',true,'poster');
    }


    
}