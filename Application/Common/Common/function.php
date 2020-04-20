<?php


 /**
 * 时间格式化
 */
 function format_time($time, $type = 1 , $date = 'Y-m-d H:i:s') {
    if(is_numeric($type)){
        switch ($type) {
            case 1:
                return date($date,$time);
                break;
            case 2:
                $d=time()-$time;
                if($d<0){ 
                    return date($date,$time);
                }
                if($d<60){ 
                    return $d.'秒前'; 
                }else{ 
                    if($d<3600){ 
                        return floor($d/60).'分钟前'; 
                    }else{ 
                        if($d<86400){ 
                            return floor($d/3600).'小时前'; 
                        }else{ 
                            if($d<259200){
                                return floor($d/86400).'天前'; 
                            }else{ 
                                return date($date,$time); 
                            } 
                        } 
                    } 
                }
                break;
        }
    }else{
        return date($type, $time);
    }
}

