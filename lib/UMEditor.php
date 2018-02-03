<?php

/**
 * 百度UMEditor的封装lib类
 */
class UMEditor {

    public function createEditor($name, $width, $height, $value = NULL) {
        $str = '<link href="http://static.ebanhui.com/um/themes/default/css/umeditor.min.css?version=2016032501" type="text/css" rel="stylesheet"></link>';
        $str .= '<script src="/lib/um/umeditor.config.js" type="text/javascript"></script>';
        $str .= '<script src="/lib/um/umeditor.js?v=2016032501" type="text/javascript"></script>';
        $str .= '<script type="text/javascript" src="/lib/um/lang/zh-cn/zh-cn.js"></script>';
        $str .= '<script type="text/plain" id="' . $name . '" style="width:' . $width . ';height:' . $height . '"></script>';
        $str .= '<script type="text/javascript">';
        $imagephp = geturl('uploadimage');
        $str .= 'var ue = UM.getEditor("' . $name . '",{textarea:"' . $name . '",imageUrl:"' . $imagephp . '",autoHeightEnabled:false,imagePath:""});';
        if (!empty($value)) {
            $msg = str_replace("\r\n", '', $value);   //替换多余的回车换行
            $msg = str_replace("\n", '', $msg);
            $msg = str_replace("'", "\'", $msg);
            $str .= "ue.setContent('" . $msg . "');";
        }
		$str .= "ue.focus();";
		$str .= "ue.execCommand( 'fontsize', '16px' );";
        $str .= '</script>';
        echo $str;
    }
    public function simpleEditor($name, $width, $height, $value = NULL) {
        $str = '<link href="http://static.ebanhui.com/um/themes/default/css/umeditor.min.css?version=2016032501" type="text/css" rel="stylesheet"></link>';
        
        $str .= '<script src="/lib/um/umeditor.config.js" type="text/javascript"></script>';
        $str .= '<script src="/lib/um/umeditor.js?v=2016032501" type="text/javascript"></script>';
        $str .= '<script src="http://static.ebanhui.com/ebh/js/formulav2.js" type="text/javascript"></script>';
        $str .= '<script src="http://static.ebanhui.com/ebh/js/imgeditor.js?version=2015042900" type="text/javascript"></script>';
		$str .= '<link href="http://static.ebanhui.com/ebh/tpl/default/css/public.bak.css" type="text/css" rel="stylesheet"></link>';
        $str .= '<script type="text/javascript" src="/lib/um/lang/zh-cn/zh-cn.js"></script>';
        $str .= '<script type="text/plain" id="' . $name . '" style="width:' . $width . ';height:' . $height . '"></script>';
        $str .= '<script type="text/javascript">';
        $imagephp = geturl('uploadimage');
        $str .= 'var ue = UM.getEditor("' . $name . '",{textarea:"' . $name . '",imageUrl:"' . $imagephp . '",autoHeightEnabled:false,imagePath:"",toolbar:[\'formula imgeditor emotion undo redo | bold italic underline strikethrough | forecolor backcolor | removeformat |\',
            \'insertorderedlist insertunorderedlist | fontsize\' ,
            \'| justifyleft justifycenter justifyright justifyjustify |\',
            \'image\'
        ]});';
        if (!empty($value)) {
            $msg = str_replace("\r\n", '', $value);   //替换多余的回车换行
            $msg = str_replace("\n", '', $msg);
            $msg = str_replace("'", "\'", $msg);
            $str .= "ue.setContent('" . $msg . "');";
        }
		$str .= "ue.focus();";
		$str .= "ue.execCommand( 'fontsize', '16px' );";
        $str .= '</script>';
        echo $str;
    }

    public function pEditor($name, $width, $height, $value = NULL) {
        $str = '<link href="http://static.ebanhui.com/um/themes/default/css/umeditor.min.css?version=2016032501" type="text/css" rel="stylesheet"></link>';
        
        $str .= '<script src="/lib/um/umeditor.config.js" type="text/javascript"></script>';
        $str .= '<script src="/lib/um/umeditor.js?v=2016032501" type="text/javascript"></script>';
        $str .= '<script src="http://static.ebanhui.com/ebh/js/formulav3.js" type="text/javascript"></script>';
        $str .= '<script src="http://static.ebanhui.com/ebh/js/imgeditorv2.js?version=20150429001" type="text/javascript"></script>';
        $str .= '<link href="http://static.ebanhui.com/ebh/tpl/default/css/public.bak.css" type="text/css" rel="stylesheet"></link>';
        $str .= '<script type="text/javascript" src="/lib/um/lang/zh-cn/zh-cn.js"></script>';
        $str .= '<script type="text/plain" id="' . $name . '" style="width:' . $width . ';height:' . $height . '"></script>';
        $str .= '<script type="text/javascript">';
        $imagephp = geturl('uploadimage');
        $str .= 'var ue = UM.getEditor("' . $name . '",{textarea:"' . $name . '",imageUrl:"' . $imagephp . '",autoHeightEnabled:false,imagePath:"",toolbar:[\'formula imgeditor emotion undo redo | bold italic underline strikethrough | superscript subscript | forecolor backcolor | removeformat |\',
            \'insertorderedlist insertunorderedlist | fontsize\' ,
            \'| justifyleft justifycenter justifyright justifyjustify |\',
            \'image\'
        ]});';
        if (!empty($value)) {
            $msg = str_replace("\r\n", '', $value);   //替换多余的回车换行
            $msg = str_replace("\n", '', $msg);
            $msg = str_replace("'", "\'", $msg);
            $str .= "ue.setContent('" . $msg . "');";
        }
		$str .= "ue.focus();";
		$str .= "ue.execCommand( 'fontsize', '16px' );";
        $str .= '</script>';
        echo $str;
    }

    public function xEditor($name, $width, $height, $value = NULL) {
        $str = '<link href="http://static.ebanhui.com/um/themes/default/css/umeditor.min.css?version=2016032501" type="text/css" rel="stylesheet"></link>';
        
        $str .= '<script src="/lib/um/umeditor.config.js" type="text/javascript"></script>';
        $str .= '<script src="/lib/um/umeditor.js?v=2016032501" type="text/javascript"></script>';
        $str .= '<script src="http://static.ebanhui.com/ebh/js/rangy-core.js"></script>';
        $str .= '<script src="http://static.ebanhui.com/ebh/js/formulav4.js?version=201602291030" type="text/javascript"></script>';
        $str .= '<script src="http://static.ebanhui.com/ebh/js/imgeditorv3.js?version=201602291030" type="text/javascript"></script>';
        $str .= '<link href="http://static.ebanhui.com/ebh/tpl/default/css/public.bak.css" type="text/css" rel="stylesheet"></link>';
        $str .= '<script type="text/javascript" src="/lib/um/lang/zh-cn/zh-cn.js"></script>';
        $str .= '<script type="text/plain" id="' . $name . '" style="margin-top:10px;width:' . $width . ';height:' . $height . '"></script>';
        $str .= '<script type="text/javascript">';
        $imagephp = geturl('uploadimage');
        $str .= 'var ue = UM.getEditor("' . $name . '",{textarea:"' . $name . '",imageUrl:"' . $imagephp . '",autoHeightEnabled:false,imagePath:"",toolbar:[\'formula imgeditor emotion undo redo | bold italic underline strikethrough | superscript subscript | forecolor backcolor | removeformat |\',
            \'insertorderedlist insertunorderedlist | fontsize\' ,
            \'| justifyleft justifycenter justifyright justifyjustify |\',
            \'image\'
        ]});';
        if (!empty($value)) {
            $msg = str_replace("\r\n", '', $value);   //替换多余的回车换行
            $msg = str_replace("\n", '', $msg);
            $msg = str_replace("'", "\'", $msg);
            $str .= "ue.setContent('" . $msg . "');";
        }
		$str .= "ue.focus();";
		$str .= "ue.execCommand( 'fontsize', '16px' );";
        $str .= '</script>';
        echo $str;
    }
	
	public function xEditorNoimport($name, $width, $height, $value = NULL) {
        
        $str = '<script type="text/plain" id="' . $name . '" style="margin-top:10px;width:' . $width . ';height:' . $height . '"></script>';
        $str .= '<script type="text/javascript">';
        $imagephp = geturl('uploadimage');
        $str .= 'var ue = UM.getEditor("' . $name . '",{textarea:"' . $name . '",imageUrl:"' . $imagephp . '",autoHeightEnabled:false,imagePath:"",toolbar:[\'formula imgeditor emotion undo redo | bold italic underline strikethrough | superscript subscript | forecolor backcolor | removeformat |\',
            \'insertorderedlist insertunorderedlist | fontsize\' ,
            \'| justifyleft justifycenter justifyright justifyjustify |\',
            \'image\'
        ]});';
        if (!empty($value)) {
            $msg = str_replace("\r\n", '', $value);   //替换多余的回车换行
            $msg = str_replace("\n", '', $msg);
            $msg = str_replace("'", "\'", $msg);
            $str .= "ue.setContent('" . $msg . "');";
        }
		$str .= "ue.focus();";
		$str .= "ue.execCommand( 'fontsize', '16px' );";
        $str .= '</script>';
        echo $str;
    }
}
