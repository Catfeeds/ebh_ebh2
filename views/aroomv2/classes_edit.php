<?php $this->display('aroomv2/page_header');?>
<style>
.terlie li {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #B2D9F0;
    display: block;
    float: left;
    font-size: 14px;
    height: 20px;
    line-height: 20px;
    margin-bottom: 7px;
    margin-right: 5px;
    padding-top: 3px;
}
.terlie li a.labelnode {
    color: #0078B6;
    display: inline;
    float: left;
    height: 18px;
    line-height: 18px;
    padding: 0 7px;
    text-decoration: none;
    vertical-align: 4px;
}

.terlie li a.labeldel {
    float: left;
}
.terlie .mylabel a.labeldel img {
    background: url("http://static.ebanhui.com/ebh/tpl/2012/images/closebg_01.png") no-repeat scroll 0 0 transparent;
    display: inline-block;
    height: 12px;
    margin: 3px 4px 2px 0;
    width: 12px;
}
.terlie .mylabelhover a.labeldel img {
    background: url("http://static.ebanhui.com/ebh/tpl/2012/images/closebg_02.png") no-repeat scroll 0 0 transparent;
    display: inline-block;
    height: 12px;
    margin: 3px 4px 2px 0;
    width: 12px;
}
</style>
<SCRIPT LANGUAGE="JavaScript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></SCRIPT>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" rel="stylesheet" />	
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />


<div class="ter_tit">
		当前位置 > <a href="<?geturl('aroomv2/classes')?>">班级管理</a> > 修改班级
		</div>
	<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;width:766px;padding-left:20px;">
<form method="post" action="<?=geturl('aroomv2/classes/edit')?>">
<input id="classid" type="hidden" name="classid" value="<?=$classdetail['classid']?>" >
<div class="field">
	<span class="inpqian" style="font-size:14px;">班级名称：</span>
	<input class="shutxt" type="text" id="classname" maxlength="15" value="<?=$classdetail['classname']?>" name="classname" style="font-size:14px;font-weight:normal;" onblur="checkclassname()">
	

<?php
		if(!empty($roominfo['grade'])){
	?>
	
	
	<div style="float:left;width:600px;margin-top:10px">
	<span style="font-size:14px;color: #535353;display: inline;height: 28px;line-height: 28px;vertical-align: middle;float: left;padding-left: 16px;">　年　级:</span>
	<label><input style="margin-top:8px;float:left;width:26px;" type="radio" value="0" name="grade" checked=""/><span style="float:left">不选</span></label>
	<?php
		$checkstr[$classdetail['grade']] = 'checked="checked"';
		if($roominfo['grade']==1){
			$gradearr = array('一年级','二年级','三年级','四年级','五年级','六年级');
			for($i=1;$i<7;$i++){
				echo '<label><input style="margin-top:8px;float:left;width:26px;margin-left:10px" type="radio" value="'.$i.'" name="grade" '.(empty($checkstr[$i])?'':$checkstr[$i]).'/><span style="float:left">'.$gradearr[$i-1].'</span></label>';
			}
		}elseif($roominfo['grade']==7){
			$gradearr = array('初一','初二','初三');
			for($i=7;$i<10;$i++){
				echo '<label><input style="margin-top:8px;float:left;width:26px;margin-left:10px" type="radio" value="'.$i.'" name="grade" '.(empty($checkstr[$i])?'':$checkstr[$i]).'/><span style="float:left">'.$gradearr[$i-7].'</span></label>';
			}
		}elseif($roominfo['grade']==10){
			$gradearr = array('高一','高二','高三');
			for($i=10;$i<13;$i++){
				echo '<label><input style="margin-top:8px;float:left;width:26px;margin-left:10px" type="radio" value="'.$i.'" name="grade" '.(empty($checkstr[$i])?'':$checkstr[$i]).'/><span style="float:left">'.$gradearr[$i-10].'</span></label>';
			}
		}
	?>
	</div>
	<p class="tishik" style="margin-top:5px;margin-bottom:5px;">
		<span style="float:left; height:20px;line-height:20px;">选择年级后,可以接收到年级课程、年级作业等</span>
	</p>
<?php }?>
<a class="borlanbtn marlef87" href="javascript:submituserform();">确　认</a>
<a class="borlanbtn marlef" href="javascript:history.go(-1);">返回上页</a>
</div>
</div>
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
	var classerr = 1;
	function removelabel(tid){
		$("#simp"+tid).remove();
		$("#allteacheri"+tid).removeAttr("checked");
		if($("#choosetsimp li").length == 0) {
			$("#choosetsimp").css("display","none");
			$("#noteacher").css("display","block");
		}
	}
	var showallteacher = function(){
		$('.yinsuoyout').hide();
		$('.xiansuoyout').show();
		$('#choosetall').show();
		$('#teachername').val();
		allteacher();
	}

	var hideallteacher = function(){
		$('.yinsuoyout').show();
		$('.xiansuoyout').hide();
		$('#choosetall').hide();
		top.resetmain();
	}


	$(document).ready(function(){
		$(".bjkuaij a").click(function(){
			$("#classname").val($.trim($(this).text()));
			selectspace();
		});
		$(".nfkuaij").click(function(){
			$('#year').val($.trim($(this).text()));
			checkyear();
		});

		$(".bjkuaij span").hover(function(){
			$(this).css('border','1px solid #3395CE').css('margin','0px');
		},function(){
			$(this).css('border','none').css('margin','1px');
		});

	});

	function selectspace(){
		var t=document.getElementById("classname");
		var index = t.value.indexOf(" ");
		if(index>0){
			selectLength(t,index,index+1);

		}
	}
	function dellabel(dom){
		var showtitle = $(dom).attr('showtitle');
		$.ajax({
			type: "POST",
			url: "#getsitecpurl()#?action=classes&op=dellabel&t="+(new Date()).getTime(),
			dataType:'json',
			data:{'crid':$crid,'title':showtitle},
			success: function(json){
				if(json.status==1){
					if($('.bjkuaij').size()==1){
						$(dom).parent('.bjkuaij').parent('.tishik').remove();
					}else{
						$(dom).parent('.bjkuaij').remove();
					}
					$.showmessage({message:'删除快捷选择成功!'})
				}else{
					$.showmessage({message:json.message})
				}
			}
		}); 
	}

	  function selectLength(dom,start, end)   //设置高亮(对象,开始位置,长度)
	  {

		var d = document, o = d.createElement("input");
		var isStandard = "selectionStart" in o;
		var isSupported = isStandard || (o = d.selection) && !!o.createRange();

		if(isStandard){
			dom.setSelectionRange(start, end);
		}else if(isSupported){
			var t = dom.createTextRange();
			end -= start + dom.value.slice(start + 1, end).split("\n").length - 1;
			start -= dom.value.slice(0, start).split("\n").length - 1;
			t.move("character", start), t.moveEnd("character", end), t.select();
		}
		dom.focus()

	}

	function mysubstr(inputString,len){
		var tmpstring = inputString.replace(/\*/g,'_').replace(/[\u0391-\uFFE5]/g,'**');
		if(tmpstring.length<=len){
			return inputString;
		}
		tmpstring = tmpstring.substr(0,len);
		chcount = Math.ceil((tmpstring.length-tmpstring.replace(/\*/g,'').length)/2);
		
		return inputString.substr(0,len-chcount);
	}

	function submituserform(){
		if(checkclassname()){
			$('form').submit();
		}
	}

	function checkclassname(){
		
		var tclassname = $('#classname').val();
		//var crid = '$crid';
		var classid = $('#classid').val();
		$('#classname').next('em').remove();
		if(tclassname==''){
			$('#classname').after('<em class="emacuo"><font color="red">班级名称不能为空</font></em>');
			classerr = 1;
			return false;
		}else{
			if (tclassname.length>15) {
				$('#classname').after('<em class="emacuo"><font color="red">班级名称太长，应该为15个字符以内!</font></em>');
				classerr = 1;
				return false;
			};
		}
		if(tclassname!="<?=$classdetail['classname']?>"){
		$.ajax({
			type:"POST",
			dataType:"JSON",
			url: "<?=geturl('aroomv2/classes/classnameexists')?>",
			data:{'classname':tclassname},
			success: function(data){
				if(data == 1) {
					$('#classname').next('em').remove();
					$('#classname').after('<em class="emacuo"><font color="red">班级已存在</font></em>');
					classerr = 1;
					return false;
				} else {
					classerr = 0;
					$('#classname').next('em').remove();
					$('#classname').after('<em class="emadui"></em>');
					$('#cform').submit();
				}
			}
		});
		}else{
			return true;
		}
		if(classerr == 1) {
			return false;
		}
		$('#classname').after('<em class="emadui"></em>');
		return true;
	}

	function checkyear(){
		var tyear = $('#year').val();
		$('#year').next('em').remove();
		if(isNaN(tyear) || parseInt(tyear)<2010 || parseInt(tyear)>2020){
			$('#year').after('<em class="emacuo"><font color="red">入学年份格式不正确</font></em>');
			return false;
		}
		$('#year').val(parseInt(tyear));
		$('#year').after('<em class="emadui"></em>');
		return true;
	}

	var allteacher = function(uname){
		url = '';
		var uid = $('.dilan :checked').val();
		if(uname){
			url='&uname='+encodeURIComponent(uname);
		}
		$.ajax({
		   type: "GET",
		   url: "#getsitecpurl()#?action=aroomteacher&op=getcourseteacher&crid=$crid"+url+"&t="+(new Date()).getTime(),
		   dataType:'json',
		   success: function(json){
			   $('.terwai').show();
			   $('#choosetall').empty();
			   $(json).each(function(index,item){
				   var tid = item['uid'];
				   var checkstatus = '';
					if($("#simp"+tid).length > 0)
						checkstatus = 'checked="checked"';
				   var itemstr = '<li><input type="checkbox" style="top:2px;position:relative;" value="'
				   +item['teacherid']+'" ' + checkstatus + ' onclick="choose(\''+item['uid']+'\',\''+item['realname']+'\',this)" id="allteacheri'
				   +item['teacherid']+'" '+checkstatus
					   +'/><label style="margin-left:4px;_margin-left:2px;" for="allteacheri'+item['uid']
					   +'" title="'+item['realname']+'('+item['username']+')">'+mysubstr(item['realname'],10)
					   +'('+mysubstr(item['username'],6)+')</label></li>';

					$('#choosetall').append(itemstr);

			   });
		   }
		}); 
	}

	var choose = function(teacherid,teachername,dom){
		if(dom.checked){
			$("#noteacher").css("display","none");
			$("#choosetsimp").css("display","block");
			var listr = '<li  id="simp'+teacherid+'" onmouseout="this.className=\'mylabel\'" onmouseover="this.className=\'mylabel mylabelhover\'" class="mylabel">';
			listr += '<a class="labelnode" title="'+teachername+'" href="#">'+teachername+'</a>';
			listr += '<a class="labeldel" title="删除标签" onclick="removelabel(\''+teacherid+'\')" href="javascript:void(0)">';
			listr += '<img src="/static/tpl/2012/images/transparent.gif">';
			listr += '</a>';
			listr += '<input type="hidden" value="'+teacherid+'" name="simteacher[]" />';
			listr += '</li>';
			$("#choosetsimp").append(listr);
		}else{
			$("#simp"+teacherid).remove();
			if($("#choosetsimp li").length == 0) {
				$("#choosetsimp").css("display","none");
				$("#noteacher").css("display","block");
			}
		}
	}
	function removelabel(tid){
		$("#simp"+tid).remove();
		$("#allteacheri"+tid).removeAttr("checked");
		if($("#choosetsimp li").length == 0) {
			$("#choosetsimp").css("display","none");
			$("#noteacher").css("display","block");
		}
	}
//-->
</SCRIPT>

<?php $this->display('aroomv2/page_footer')?>