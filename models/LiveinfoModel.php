<?php

/**
 * 直播信息
 * Class LiveinfoModel
 */
class LiveinfoModel extends CModel{

    /**
     * @param $cwid
     * @param $data
     * 添加直播信息
     */
    public function addLiveInfo($cwid,$data){
        if($this->getLiveInfoByCwid($cwid)){
            return $this->db->update('ebh_course_liveinfos',$data,array('cwid'=>$cwid));
        }else{
            $data['cwid'] = $cwid;
            return $this->db->insert('ebh_course_liveinfos',$data);
        }
    }

    /**
     * 通过cwid获取直播信息
     * @param $cwid
     * @return mixed
     */
    public function getLiveInfoByCwid($cwid){
        $sql = "select cwid,liveid,type,httppullurl,hlspullurl,rtmppullurl,pushurl,review,review_start,review_end,camera_sourceid,video_sourceid from ebh_course_liveinfos where cwid=".$cwid;
        $row = $this->db->query($sql)->row_array();
        return $row;
    }

    /**
     * 通过liveid获取直播信息
     * @param $liveid
     * @return mixed
     */
    public function getLiveInfoByLiveid($liveid){
        $sql = "select cwid,liveid,type,httppullurl,hlspullurl,rtmppullurl,pushurl,review,review_start,review_end,camera_sourceid,video_sourceid from ebh_course_liveinfos where liveid=".$liveid;
        $row = $this->db->query($sql)->row_array();
        return $row;
    }
}