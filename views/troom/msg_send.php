<?php $this->display('troom/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">当前位置> <a href="<?= geturl('troom/notify') ?>">通知管理</a> > 写私信</div>
<div class="lefrig"  style="background:#fff;float:left;margin-top:15px;width:788px;">
	<div class="work_mes" style="float:none; margin-bottom:15px;">
		<ul>
			<li><a href="<?= geturl('troom/msg/sendlist') ?>"><span>私信列表</span></a></li>
			<li class="workcurrent"><a href="<?= geturl('troom/msg/send') ?>"><span>写私信</span></a></li>
		</ul>
	</div>

<div class="waiyry clearfix" >
<div class="chouad" style="height:auto">
<span class="shyten">收件人：</span>
<div class="ewater" style="height:36px;">
<ul id="wrap2"></ul>
</div>
<a href="javascript:showWeixinDialog()" class="weticen" style="float:right"></a>
</div>
<textarea class="txttiantl" name="summary" style="position:relative; *left:-45px;"></textarea>
<div class="wtkkr" style="height:45px;">
内容不超过500字
<a id="sendmessage" class="msgsendbtn">发 送</a>
</div>

</div>

</div>

<!-- ================ -->
<div id="wxDialog" class="taneret" style="display:none">

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<style>
.choose_user_list{
    background: #fff none repeat scroll 0 0;
    border-bottom: 1px solid #f5f5f5;
    height: 475px;
    overflow-y: auto;
    padding: 10px 0 0 10px;
}
.titkets {
    border-bottom: 1px solid #f5f5f5;
    margin: 0 10px;
    min-height: 86px;
    overflow-y: auto;
}
.leftkes {
    color: #666;
    float: left;
    font-weight: bold;
    padding: 10px 0 0 10px;
    width: 100px;
}
.rigleis {
    float: left;
    padding: 2px 0;
    width: 820px;
}
.etklys {
    float: left;
    padding: 5px;
}
.etklys a.auttdss {
    color: #888;
    display: block;
    padding: 5px;
}
.auttdss img{width:50px;height:50px;}
.xuanz {
    background: #4fcffd none repeat scroll 0 0;
	color: #fff;
    float: left;
    height: 22px;
    line-height: 22px;
    margin-bottom: 8px;
    margin-right: 6px;
    padding: 0 7px;
}
.xuanz a{color:#fff}
.wxselected{background-color: #4fcffd;}
.atfwt{padding:0px; margin:0 5px 5px; display: block;}
</style>
<div class="rtyres">
<div class="workmet">
<ul>
<li id="chooseTeacherTag" class="workrent">
<a href="#">
选择教师
</a>
</li>
<li id="chooseStudentTag">
<a href="#">
选择学生
</a>
</li>
</ul>
<div class="etshout">
  <input class="txtshout" name="textarea" type="text" id="title" value="请输入关键字" />
  <a href="javascript:;" class="shoutbtn">搜 索</a>
</div>
</div>
<div id="banter" class="banter" style="display:none;">
<ul id="classchoose">
<?php foreach($classlist as $class){?>
<li cid="<?=$class['classid']?>">
<a href="#">
<?=$class['classname']?>
</a>
</li>
<?php }?>
</ul>
</div>
<div id="chooseStudent" class="choose_user_list" style="display:none;">
<!--学生列表-->
</div>
<div id="chooseTeacher" class="choose_user_list">
<?php foreach($grouparray as $group){
	if (!empty($group['teacherlist'])) {?>

	<div class="titkets">
		<div class="leftkes"><?=$group['groupname']?>：</div>
		<div class="rigleis">
			<ul>
			<?php foreach($group['teacherlist'] as $teacher){
                if(empty($teacher['face'])){
                    if($teacher['sex'] == 1) {
                        $teacher['face'] = 'http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
                    } else {
                        $teacher['face'] ='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
                    }
                }
		$teacher['face'] = getthumb($teacher['face'],'50_50');
		$teacher['showname'] = empty($teacher['realname']) ? $teacher['username'] : $teacher['realname'];
			?>
				<li class="etklys">
					<a id="face_<?=$teacher['uid']?>" class="auttdss" tid="<?=$teacher['uid']?>" tname="<?=$teacher['showname']?>"><img src="<?=$teacher['face']?>"></a>
					<a class="atfwt" tid="<?=$teacher['uid']?>" tname="<?=$teacher['showname']?>"><?=$teacher['showname']?></a>
				</li>
			<?php }?>
			</ul>
		</div>
	</div>
<?php    }
}?>
</div>

</div>

</div>
<script>
function showWeixinDialog(){
    parent.window.H.get('wxDialog').exec('show');
}

var wx = {searchtext : "请输入关键字"};
function wxsearch(){
  var uname = $("#title",parent.document).val().replace(/\s+/g,"");
  if(uname == wx.searchtext){
  	$(".atfwt",parent.document).removeClass('wxselected');
  	return;
  }
  $(".atfwt",parent.document).removeClass('wxselected');
  $.each($(".atfwt",parent.document),function(idx,obj){
  	if($(obj).html().replace(/\s+/g,"").indexOf(uname)!=-1){
  		parent.window.location.hash = $(obj).attr("tid");
  		$(obj).addClass('wxselected');
  	}
  });
}

$(function(){
	//切换到教师
    $("#chooseTeacherTag").click(function(){
      $("#chooseStudent",parent.document).hide();
      $("#chooseTeacher",parent.document).show();
      $("#banter",parent.document).hide();
      $("#chooseStudentTag",parent.document).removeClass('workrent');
      $(this).addClass('workrent');
    });

	//切换到学生
    $("#chooseStudentTag").click(function(){
        $("#chooseTeacher",parent.document).hide();
        $("#banter",parent.document).show();
        $("#chooseStudent",parent.document).show();
        $("#chooseTeacherTag",parent.document).removeClass('workrent');
        $(this).addClass('workrent');

        //仅第一次切换时加载
        if ($("#classchoose li.xuanz",parent.document).length == 0)
        {
			//获取第一个班级的学生
			$("#classchoose li",parent.document).removeClass('xuanz');
			$("#classchoose li:first",parent.document).addClass('xuanz');
			var cid = $("#classchoose li:first",parent.document).attr("cid");
			getStudents(cid);
		}
    });

	//选择班级
	$("#classchoose li").click(function(){
		var cid = $(this).attr("cid");
		getStudents(cid);
		$("#classchoose li",parent.document).removeClass('xuanz');
		$(this).addClass('xuanz');
	});

	//选择收件人，关闭dialog
	$('.rtyres').delegate(".auttdss,.atfwt",'click',function(){
		var tid = $(this).attr("tid");
		var tname = $(this).attr("tname");
		var contentli = '<li tid="'+tid+'" class="lvtewu">'+tname+'</li>';
		$("#wrap2").html(contentli);
		parent.window.H.get('wxDialog').exec('close');
	});

	//搜索
	$(".shoutbtn").click(function(){
		var uname = $("#title",parent.document).val().replace(/\s+/g,"");
		if(uname == wx.searchtext){
			$(".atfwt",parent.document).removeClass('wxselected');
			return;
		}
		$(".atfwt",parent.document).removeClass('wxselected');
		var faceid = '';//第一个搜索到的名字
		$.each($(".atfwt",parent.document),function(idx,obj){
			if($(obj).html().replace(/\s+/g,"").indexOf(uname)!=-1){
				if (faceid == '') faceid = "face_"+$(obj).attr("tid");
				$(obj).addClass('wxselected');
			}
		});
		parent.window.location.hash = faceid;//定位到第一个人的位置
	});

	//创建dialog
    parent.window.H.remove('wxDialog');
    $('#wxDialog',parent.window.document.body).remove();
    parent.window.H.create(new P({
        id:'wxDialog',
        title:'选择收信人',
        easy:true,
        content:$("#wxDialog")[0]
      }),'common');
    parent.window.initsearch("title",wx.searchtext);

	$("#sendmessage").click(function(){
		var msg =  $.trim($("textarea.txttiantl").val());
		var tid = $("#wrap2 li:first").attr("tid");

		if($("#wrap2").html() == ''){
			alert("请选择收件人");
			return;
		}
		if(msg.length==0){
			alert('请输入内容');
			return;
		} else if(msg.length>500){
			alert('内容不超过500字');
			return;
		}
		$.ajax({
			type: "POST",
		    url: "<?=geturl('troom/msg/do_send')?>",
		    data:{tid:tid, msg:msg},
		    success:function(res){
		        if(res=="1"){
					parent.window.showSendSuccess();
					window.location.href = '<?=geturl('troom/msg/sendlist')?>';
				}else{
					parent.window.showSendFail();
				}
		 	}
		});
	});
});

function getStudents(cid){
	if($("#class_choose_ul_"+cid,parent.document).length > 0){
		$("ul[id^=class_choose_ul_]",parent.document).hide();
		$("#class_choose_ul_"+cid,parent.document).show();
		return ;
	}

	$.ajax({
		type: "POST",
		url: "<?=geturl('troom/msg/getStudents')?>",
		data: {"classid":cid},
		dataType:"json",
		success:function(data){
			var html = '<ul id="class_choose_ul_'+cid+'">';
			for (var i = 0; i < data.length; i++) {
				html += '<li class="etklys">';
				html += '<a id="face_'+data[i].uid+'" class="auttdss" tid="'+data[i].uid+'" tname="'+data[i].showname+'"><img src="'+data[i].face+'"></a>';
				html += '<a class="atfwt" tid="'+data[i].uid+'" tname="'+data[i].showname+'">'+data[i].showname+'</a>';
				html += '</li>';
			}
			html += '</ul>';
			$("ul[id^=class_choose_ul_]",parent.document).hide();
			$("#chooseStudent",parent.document).append(html);
		}
	});
}
</script>
<!-- ================= -->
<?php $this->display('troom/page_footer'); ?>