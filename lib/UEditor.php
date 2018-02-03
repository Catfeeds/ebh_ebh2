<?php
/**
 * 百度UEditor的封装lib类
*/
class UEditor {
    
    /**
     * 创建一个完整的ueditor实例
     * @param $name 编辑器标识
     * @param string $width 宽度
     * @param string $height 高度
     * @param $value 默认编辑器内容
     */
    public function createEditor($name, $width='900px', $height='500px', $value = NULL) {
        if(!empty($value)){
            $value = str_replace(array("\r\n","\n","'"), array('','',"\'"), $value);   //替换多余的回车换行
        }
        $str =
<<<EOF
    <link rel="stylesheet" href="/static/ueditor/dialogsblue.css"><!-- 弹出框样式修改 -->  
 	<script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.all.min.js"> </script>   
    <script type="text/javascript" charset="utf-8" src="/static/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" charset="utf-8" src="/static/ueditor/formulav2Dialog.js"></script>  
    <script type="text/javascript" charset="utf-8" src="/static/ueditor/imgeditorDialog.js"></script>
	<script type="text/plain" id="{$name}" style="width:{$width};height:{$height};"></script>
    <style>
        #{$name}{
            position: relative;
            z-index: 1020;
        }
        .problemdetail{
            display:block;
        }
    </style>
	<script>
		var config_{$name} = { 
				textarea:'{$name}', //提交表单时，服务器获取编辑器提交内容的所用的参数
				autoHeightEnabled:false,//ture 编辑器区域根据内容自动长高。 
                toolbars: [[ 
		            'source','|','|','emotion','undo', 'redo', '|',
		            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall',  '|',
		            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
		            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',           
		            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 
		            'insertimage','|','link','unlink','|',
		            'time','fullscreen']]};

		var ue_{$name} = UE.getEditor("{$name}", config_{$name});

		ue_{$name}.addListener('ready',function() {
			ue_{$name}.setContent('{$value}', true);
			//初始化内容输入,第二参数若传入true，不清空原来的内容，在最后插入内容，否则，清空内容再插入
		});
	</script>
EOF;
        echo $str;
    }
    
    /**
     * 实例化一个精简版的ueditor
     * @param $name 编辑器标识
     * @param string $width 宽度
     * @param string $height 高度
     * @param $value 默认编辑器内容
     */
    public function simpleEditor($name, $width='900px', $height='500px', $value = NULL) {
        if(!empty($value)){
            $value = str_replace(array("\r\n","\n","'"), array('','',"\'"), $value);   //替换多余的回车换行
        }
        $str =
        <<<EOF
    <link rel="stylesheet" href="/static/ueditor/dialogsblue.css"><!-- 弹出框样式修改 -->
 	<script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/static/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" charset="utf-8" src="/static/ueditor/formulav2Dialog.js"></script>
    <script type="text/javascript" charset="utf-8" src="/static/ueditor/imgeditorDialog.js"></script>
	<script type="text/plain" id="{$name}" style="width:{$width};height:{$height};"></script>
    <style>
        #{$name}{
            position: relative;
            z-index: 1020;
        }
        .problemdetail{
            display:block;
        }
    </style>
	<script>
		var config_{$name} = {
				textarea:'{$name}', //提交表单时，服务器获取编辑器提交内容的所用的参数
				autoHeightEnabled:false,//ture 编辑器区域根据内容自动长高。
                toolbars: [['source','|','|','emotion','undo','redo','|','bold','italic','underline','strikethrough','|','subscript','superscript','|',
                'forecolor','backcolor','|','removeformat','|','insertorderedlist', 'insertunorderedlist','|',
                'fontsize','|','justifyleft','justifycenter','justifyright','justifyjustify','|','link','unlink','|','insertimage',
                'fullscreen']]};
		var ue_{$name} = UE.getEditor("{$name}", config_{$name});
		ue_{$name}.addListener('ready',function() {
			ue_{$name}.setContent('{$value}', true);
			//初始化内容输入,第二参数若传入true，不清空原来的内容，在最后插入内容，否则，清空内容再插入
		});
	</script>
EOF;
        echo $str;
 
    }

    /**
     * 兼容老版本 代码
     * @param unknown $name
     * @param string $width
     * @param string $height
     * @param unknown $value
     */
    public function xEditor($name, $width='900px', $height='500px', $value = NULL){
        $this->simpleEditor($name, $width, $height, $value);
    }
  
}
