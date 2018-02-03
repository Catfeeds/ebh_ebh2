<?php
/**
 *年级和课件版本控制器
 *@author zkq
 *注:根据catid获取年级和课件版本的<select>控件,供后台课件管理中的编辑和添加课件页面ajax调用
 */
class coursewareattrController extends CControl{
    private function getInfo($name){
        /**
        *年级 
        * */
        $grade=array(
            'preschool'=>array(),
            'primary'=>array(
                '1'=>'一年级',
                '2'=>'二年级',
                '3'=>'三年级',
                '4'=>'四年级',
                '5'=>'五年级',
                '6'=>'六年级'
            ),
            'middle'=>array(
                '7'=>'七年级',
                '8'=>'八年级',
                '9'=>'九年级',
            ),
            'senior'=>array(
                '10'=>'高一',
                '11'=>'高二',
                '12'=>'高三',
            ),
            'campus'=>array(),
            'adult'=>array(),
            'vocational'=>array(),
            'skill'=>array(),
            'language'=>array(),
            'management'=>array(),
            'vocational'=>array(),
        );

        /**
         *版本
         * */

        $editionarr=array(
            array('人教版'=>'1'),
            array('北师大版'=>'2'),
            array('华师大版'=>'3'),
            array('苏教版'=>'4'),
            array('浙教版'=>'5'),
            array('上教版'=>'6'),
            array('豫教版'=>'7'),
            array('湘教版'=>'8'),
            array('粤教版'=>'9'),
            array('上科版'=>'10'),
            array('新目标'=>'11'),
            array('深港版'=>'12'),
            array('外研英语'=>'13'),
            array('牛津版'=>'14'),
            array('冀教版'=>'15'),
            array('人教朗文'=>'16'),
            array('人民版'=>'17'),
            array('沪教'=>'18'),
            array('其他'=>'19'),
        );
        $editionarrvalue=array(
            '1'=>'人教版',
            '2'=>'北师大版',
            '3'=>'华师大版',
            '4'=>'苏教版',
            '5'=>'浙教版',
            '6'=>'上教版',
            '7'=>'豫教版',
            '8'=>'湘教版',
            '9'=>'粤教版',
            '10'=>'上科版',
            '11'=>'新目标',
            '12'=>'深港版',
            '13'=>'外研英语',
            '14'=>'牛津版',
            '15'=>'冀教版',
            '16'=>'人教朗文',
            '17'=>'人民版',
            '18'=>'沪教版',
            '19'=>'其他',
        );
        $edition=array(
            'preschool'=>array(
                $editionarr[0],
                $editionarr[1],
                $editionarr[2],
                $editionarr[3],
                $editionarr[4],
                $editionarr[5],
                $editionarr[6],
                $editionarr[7],
                $editionarr[8],
                $editionarr[9],
                $editionarr[10],
                $editionarr[11],
                $editionarr[12],
                $editionarr[13],
                $editionarr[14],
                $editionarr[15],
                $editionarr[16],
                $editionarr[17],
                $editionarr[18],
            ),
            'primary'=>array(
                $editionarr[0],
                $editionarr[1],
                $editionarr[2],
                $editionarr[3],
                $editionarr[4],
                $editionarr[5],
                $editionarr[6],
                $editionarr[7],
                $editionarr[8],
                $editionarr[9],
                $editionarr[10],
                $editionarr[11],
                $editionarr[12],
                $editionarr[13],
                $editionarr[14],
                $editionarr[15],
                $editionarr[16],
                $editionarr[17],
                $editionarr[18],
            
            ),
            'middle'=>array(
                $editionarr[0],
                $editionarr[1],
                $editionarr[2],
                $editionarr[3],
                $editionarr[4],
                $editionarr[5],
                $editionarr[6],
                $editionarr[7],
                $editionarr[8],
                $editionarr[9],
                $editionarr[10],
                $editionarr[11],
                $editionarr[12],
                $editionarr[13],
                $editionarr[14],
                $editionarr[15],
                $editionarr[16],
                $editionarr[17],
                $editionarr[18],
             
              
            ),
            'senior'=>array(
                $editionarr[0],
                $editionarr[1],
                $editionarr[2],
                $editionarr[3],
                $editionarr[4],
                $editionarr[5],
                $editionarr[6],
                $editionarr[7],
                $editionarr[8],
                $editionarr[9],
                $editionarr[10],
                $editionarr[11],
                $editionarr[12],
                $editionarr[13],
                $editionarr[14],
                $editionarr[15],
                $editionarr[16],
                $editionarr[17],
                $editionarr[18],
            ),
            'campus'=>array(),
            'adult'=>array(),
            'vocational'=>array(),
            'skill'=>array(),
            'language'=>array(),
            'management'=>array(),
            'vocational'=>array(),
            );
        
        return $$name;
    }

    /**
     *根据分类获取年级<select>控件
     *@author zkq
     *@param int $catid
     *@param int $selected
     *@return String
     */
    public function getGradeSelect(){
        $catid = intval($this->input->post('catid'));
        $selected = intval($this->input->post('selected'));
        $cateInfo = $this->model('category')->getParentInfo(intval($catid));
        $s='<option>请选择年级</option>';
        $code = $cateInfo['code'];
        $grade = $this->getInfo('grade');
        if(!array_key_exists($code,$grade)){
             echo $s;
             exit;
        }
        $gradeArr = $grade[$code];
       
        foreach ($gradeArr as $gk=>$gv) {
            if($selected==$gk){
                $s.='<option value="'.$gk.'" selected=selected>'.$gv.'</option>';
            }else{
                $s.='<option value="'.$gk.'">'.$gv.'</option>';
            }
            
        }
        echo $s;
    }
    /**
     *根据分类获取课件版本<select>控件
     *@author zkq
     *@param int $catid
     *@param int $selected
     *@return String
     */
    public function getEditionSelect(){
        $catid = intval($this->input->post('catid'));
        $selected = intval($this->input->post('selected'));
        $cateInfo = $this->model('category')->getParentInfo(intval($catid));
        $code = $cateInfo['code'];
        $s='<option>请选择版本</option>';
        $edition = $this->getInfo('edition');
        if(!array_key_exists($code,$edition)){
             echo $s;
             exit;
        }
        $editionArr = $edition[$code];
        foreach ($editionArr as $ek=>$ev) {
            foreach ($ev as $k=>$v) {
                if($selected==$v){
                    $s.='<option value="'.$v.'" selected=selected>'.$k.'</option>';
                    }else{
                    $s.='<option value="'.$v.'">'.$k.'</option>';
                }
            }
           
            
        }
        echo $s;

    }

}
?>