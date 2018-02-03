<?php

/**
 * 文本编辑器KindEditor lib类
 */
class KEditor {

    public static function createking($contentid, $content = FALSE, $isecho = TRUE) {
        $string = '<script charset="utf-8" src="http://static.ebanhui.com/ke/kindeditor.js"></script>';
        $string .= "<script>	KE.show({id : '" . $contentid . "',	resizeMode : 0,	urlType : 'absolute'});</script>";
        if ($isecho) {
            echo $string;
        }
        return $string;
    }

}
