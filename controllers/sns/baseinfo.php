<?php
/**
 * ebh2.
 * User: jiangwei
 * Email: 345468755@qq.com
 * Time: 17:54
 */
class BaseinfoController extends SnsBaseController{

    public function getemotion(){
        $emotion = Ebh::app()->getConfig()->load('emotion');
        foreach ($emotion as $key=>$val){
            $tmp['tit'] = $key;
            $tmp['url'] = $val;
            $emotionarr[] = $tmp;
        }
        echo json_encode($emotionarr);
    }
}