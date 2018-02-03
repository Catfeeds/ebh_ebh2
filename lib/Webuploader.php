<?php

/**
 * Webuploader上传控件类
 * @author eker
 * @see http://fex.baidu.com/webuploader/
 */
class Webuploader {
    private $count = 0;	//实例数
    //将字节数字转换成可读的KB MB GB 等格式
    private function  format_bytes($size) {
        if ($size == 0) return 0;
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
        return round($size, 2) . $units[$i];
    }
	/**
	 * 输出html标签
	 * @param unknown $classId
	 */
	public function renderHtml($classId='picker',$multi = false,$filelist = array(),$options=array()){
		header("Content-type:text/html;charset=utf-8");
		$this->count ++;
		//获取用户上传ukey
		$ukey = Ebh::app()->user->getUserKey();
		$ukey = urlencode($ukey);
		$multiple= ($multi==true) ? 'true' : 'false';
		$chunked = $this->count == 1 ? 'true' : 'false';	//实例数超过1  则 不进行切片
		$fileNumLimit = ($multi==true) ? 10 : 1;
        $fileSizeLimit = (empty($options['fileSizeLimit'])) ? 1048576000 : $options['fileSizeLimit'];
        $acceptextensions = (empty($options['acceptextensions'])) ? '\'jpg,doc,ppt,xls,flv,mp4,mp3,jpeg,png,gif,excel,wps,pdf,zip,rar,7z,docx,avi,mpg,flv,swf,pptx,xlsx,rmvb,mov\'' : '\''.implode($options['acceptextensions'],',').'\'';
		$filelisthtml = '';
		if(!empty($filelist)){
			$lik = 0;
			foreach($filelist as $file){
                $filesizestr = $this->format_bytes($file['filesize']);
                $idflag = '';
                $nameflag = '';
                if($multi) {    //多附件，则隐藏的值需要加上[]
                    $idflag = $lik;
                    $nameflag = '[]';
                }
				$filelisthtml.= '<li id="WU_FILES_'.$lik.'" class="normal  pass"><div class="uptitle">';
				$filelisthtml.= '<span class="name">'.$file['filename'].'</span><span class="size">'.$filesizestr.'</span>';
				$filelisthtml.= '<em fileid="WU_FILES_'.$lik.'" class="btndelete" title="删除" >删除</em></div>';
				$filelisthtml.=	'<div class="progress"><span class="progress-box"><span style="width: 100%;" class="progress-bar"></span></span>';
				$filelisthtml.= '<span class="progress-value">100%</span></div><div class="info">上传成功</div>';
				$filelisthtml.= '<input type="hidden" class="'.$classId.'_sid" id="'.$classId.'[sid]'.$idflag.'" value="'.$file['sid'].'" name="'.$classId.'[sid]" />';
				$filelisthtml.=	'<input type="hidden" id="'.$classId.'[checksum]'.$idflag.'" value="'.$file['checksum'].'" name="'.$classId.'[checksum]'.$nameflag.'" />';
				$filelisthtml.=	'<input type="hidden" id="'.$classId.'[filename]'.$idflag.'" value="'.$file['filename'].'" name="'.$classId.'[filename]'.$nameflag.'" />';
				$filelisthtml.= '<input type="hidden" id="'.$classId.'[filesize]'.$idflag.'" value="'.$file['filesize'].'" name="'.$classId.'[filesize]'.$nameflag.'" />';
				$filelisthtml.= '</li>';
				
				$lik++;
			}

		}
		$showboxcss = '';
        if(!$multi && empty($filelist))
            $showboxcss = "display:none;";
		$html = 
<<<EOF
<!-- uploader start -->
<div class="panel" >
<div class="bdtop">
<div class="toolbar">
<div class="uploadify" style="height:40px; width: 90px;">
<div id="{$classId}" class="uploadify-button-text">添加文件</div>
</div>
<div class="uppath" style="margin-left:30px;float:left">
<span  class="upcurpath">支持文件秒传、快速上传</span>
</div>
<div class="warnote">
<a onclick="return false" href="javascript:void(0)" style="display:none;" data-placement="bottom right" title="严禁存储、下载、传播任何非法、有害信息，已经发现将严格按照相关法律法规处理。">上传须知</a>
</div>
</div>
<div class="netbntip {$classId}_notice" style="display: none;">网络异常，上传暂停。请检查您的网络</div>
<!--中间内容!-->
<div class="uploadbox {$classId}_uploadbox" style="{$showboxcss}">
<ul class="uplist {$classId}_file_list">
	{$filelisthtml}
</ul>
</div>
</div>
</div>

<script type="text/javascript">

jQuery(function(){
	//初始化
	var $ = jQuery, uploader;
	var handleid = '{$classId}',isauto = true,resize = false,chunked=true,fileVal='Filedata',fileNumLimit={$fileNumLimit},fileSizeLimit={$fileSizeLimit};
	var ukey = '{$ukey}';
	var upserver = 'http://up.ebh.net/uploadv2.html';
	var	upcheckfile = upserver + "?type=checkfile&ukey=" + ukey;
	var	upcheckchunk = upserver + "?type=checkchunk&ukey=" + ukey;
	var pick = {id:'#{$classId}',multiple: {$multiple}};
	var accept = {title: '课件文件',extensions: {$acceptextensions},mimeTypes: ''};
    var chunked = {$chunked};
    if(chunked || window.Blob && window.FileReader && window.DataView)
        chunked = true;
    
    var formData = new Object();
        formData.ukey = ukey;
	//初始化上传插件	
    uploader = WebUploader.create({
        auto: true,
        // 不压缩image
        resize: resize,
        fileVal: fileVal,
        fileNumLimit :fileNumLimit,
        fileSizeLimit :fileSizeLimit,
		chunked :chunked,
		formData :formData,
        // swf文件路径
        swf: 'http://static.ebanhui.com/ebh/js/webuploader/Uploader.swf',

        // 文件接收服务端。
        server: upserver,
        checkfile: upcheckfile,
        checkchunk: upcheckchunk,

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: pick,
        accept:accept
    });
   // console.log(formData);
    // 当有文件被添加进队列的时候
    uploader.on( 'fileQueued', function( file ) {
        if(uploader.options.fileNumLimit == 1 && $("."+handleid+"_file_list .up_sid").length > 0) {
            var msg = '不允许上传多个文件。';
            $(".{$classId}_notice").text(msg).show();
            return false;
        }
		
		$(".{$classId}_notice").text("").hide();
		var aa = WebUploader.Base.guid();
		//检测文件是否已经存在 本打算验证md5 但是有点卡--这部分验证有问题
		var filename = file.name;
    	var checkexist = false;
    	$("."+handleid+"_file_list").find("input[name='upfile[filename]']").each(function(){
    		var fname = $(this).val();
    		if(fname==filename){
    			checkexist = true;
    			return false;
    		}
    	});
    	if(checkexist) 
    		return false;
    	$("."+handleid+"_uploadbox").show();
    	 var filesize = WebUploader.Base.formatSize(file.size, 2);
         $("."+handleid+"_file_list").append('<li class="normal " id="' + file.id + '">'+
                     '<div class="uptitle">'+
                         '<span class="name">' + file.name + '</span>'+
                         '<span class="size">'+filesize+'</span>'+
                         '<em title="取消" class="btncancel" fileid="' + file.id + '">取消</em>'+
                     '</div>'+
                     '<div class="progress">'+
                         '<span class="progress-box">'+
                             '<span class="progress-bar" style="width: 0%;"></span>'+
                         '</span>'+
                         '<span class="progress-value">0%</span>'+
                     '</div>'+
                     '<div class="info">等待上传中</div>'+
                 '</li>');
         $( '#'+file.id ).find('.btncancel').on("click",function(){
             uploader.cancelFile($(this).attr("fileid"));
             $('#'+handleid).find('.netbntip').hide();
 			uploader.enable();
         });
 		$('#'+handleid).find('.netbntip').hide();
    });
    uploader.on('fileDequeued',function(file) {
        $( '#'+file.id ).remove();
        if($("."+handleid+"_file_list").children().length == 0 ) 
            $("."+handleid+"_uploadbox").hide();
        uploader.enable();
        $(".{$classId}_notice").text("").hide();
    });
    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var li = $( '#'+file.id );
		if(percentage >= 1) {
			percentage = 1;
			li.find('.info').text('文件存储中');
		} else {
			li.find('.info').text('上传中');
		}
		
		var pervalue = Math.round(percentage * 100);
		//console.log(percentage);
		
		li.find('.progress-bar').css( 'width', pervalue + '%' );
        li.find('.progress-value').text(pervalue + '%');
    });
    uploader.on( 'uploadSuccess', function( file ,response) {
    	// console.log(file);
    	// console.log(response);
    	
		uploadSuccess(uploader, file, response);
    });
	

    uploader.on( 'uploadError', function( file,response ) {
        var li = $( '#'+file.id );
        li.find('.info').text('上传出错，请刷新后重试。');
        li.addClass("err");
        li.find('.progress-value').text('0%');
        li.find('.progress').hide();
    });

    uploader.on( 'uploadComplete', function( file ) {
    	//console.log('complete');
        // $( '#'+file.id ).find('.progress').fadeOut();
        // $( '#'+file.id ).find('.btncancel').hide();
    });
    uploader.on( 'error', function( type ) {
        // $( '#'+file.id ).find('.progress').fadeOut();
        // $( '#'+file.id ).find('.btncancel').hide();
        var msg = "";
        switch(type) {
            case 'Q_EXCEED_NUM_LIMIT':
                msg = "只允许上传 " + this.options.fileNumLimit + " 个文件";
                break;
            case 'Q_EXCEED_SIZE_LIMIT':
                var limitsize = WebUploader.Base.formatSize(this.options.fileSizeLimit, 0);
                msg = "文件大小不能超过 " + limitsize + "。";
                break;
            case 'Q_TYPE_DENIED':
                var allowexts = this.options.accept[0].extensions;
                allowexts = allowexts.substring(0,60);
                msg = "只允许上传 " + allowexts + " 等格式文件";
                break;
            default:
                msg = "文件已存在上传队列中或选择文件出错，请重新选择。";
                break;
        }
        if(msg != "") {
            $(".{$classId}_notice").text(msg).show();
        }
    });

    

            		
	//限制高度
	if(fileNumLimit<2){
		$("."+handleid+"_file_list").parent().css({height:'90px'})
		var lilen = $("."+handleid+"_file_list").find('li').length;
		if(lilen>0){
			//uploader.enable();
			var timer = setTimeout(function(){
				uploader.disable();
			},100);
		}
	}
	
	//绑定删除事件
	//console.log();
	$("."+handleid+"_file_list>li").find(".btndelete").bind("click",function(){
/*		if(confirm('确定要删除该文件吗?')){
			$(this).parent().parent().remove();
			uploader.enable();
            if($("."+handleid+"_file_list").children().length == 0 ) 
                $("."+handleid+"_uploadbox").hide();
            $(".{$classId}_notice").text("").hide();
		}*/
        var that=this;
        top.dialog({
            title:"提示信息",
            content:"确定要删除该文件吗?",
            okValue:"确定",
            ok:function(){
                $(that).parent().parent().remove();
                uploader.enable();
                if($("."+handleid+"_file_list").children().length == 0 ) 
                    $("."+handleid+"_uploadbox").hide();
                $(".{$classId}_notice").text("").hide();
                this.close().remove();
            },
            cancelValue:"取消",
            cancel:function(){
                this.close().remove();
            }
        }).showModal();	
	});
			
})
</script>

EOF;
	echo $html;
	}

}
