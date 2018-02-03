<?php $this->display('troomv2/page_header'); ?>
<link type="text/css" href="/static/tpl/default/css/dayi.css" rel="stylesheet" />
<link type="text/css" href="/static/css/upload.css" rel="stylesheet" />	
<script type="text/javascript" src="/static/js/upload.js"></script>

<div class="crights">
<div class="stu_crumb">
<div class="tit_search">您现在的位置： 修改问题</div>
</div>

<form action="" method="post" enctype="multipart/form-data" onsubmit="return checkquestion()">
	<input type="hidden" name="action" value="ask" />
	<input type="hidden" name="op" value="editquestion" />
	<input type="hidden" name="crid" value="$crid" />
	<input type="hidden" name="qid" value="$qid" />
<div class="biaowaim">
  <input class="titwenti" name="title" id="title" type="text" value="$value['title']" maxlength="50"/>
  <div class="txtxdaru">
		
		<textarea id="rich_message" name="rich_message" style="width:98%; height: 300px;" ></textarea>
  </div>
  <div style="float:left;margin-left:15px;width:70px;">上传图片：</div>
  <div style="float:left;width:850px;height:50px;">
 
  </div>
  <div style="float:left;margin-left:15px;width:70px;">上传音频：</div>
 <div style="float:left;width:850px;height:50px;">

  </div>
  <div class="fontfen">

  <span class="wenzid">分类</span>
  <select name="folderid" id="folderid" >
    <option value="$course['folderid']" $seltfolder[$course[folderid]]>$course['foldername']</option>
  </select>
  <input class="tijibtn" style="margin-left:265px;" type="submit" value="提交问题" />
  </div>
</div>
</form>
</div>
<script type="text/javascript">
var titletips = "请在这里输入问题标题";
$(function(){
	settips("title",titletips);
});
function settips(id,tips) {
	if($.trim($("#"+id).val()) == "") {
		$("#"+id).val(tips);
		$("#"+id).addClass("titwentigray");
	}
	$("#"+id).click(function(){
		if($.trim($(this).val()) == tips) {
			$(this).val("");
			$(this).removeClass("titwentigray");
		}
	});
	$("#"+id).blur(function(){
		if($.trim($(this).val()) == "") {
			$(this).val(tips);
			$(this).addClass("titwentigray");
		}
	});
}
function checkquestion() {
	if($.trim($("#title").val()) == "" || $.trim($("#title").val()) == titletips) {
			var d = dialog({
				title: '提示信息',
				content: '问题的标题不能为空！',
				okValue: '确定',
				cancel: false,
				ok: function () {}
			});
			d.showModal();
            return false;
        }
		return false;
	}
	if($.trim($("#rich_message").val()) == "") {
			var d = dialog({
				title: '提示信息',
				content: '问题内容不能为空！',
				okValue: '确定',
				cancel: false,
				ok: function () {}
			});
			d.showModal();
		return false;
	}
	return true;
}
</script>
<?php $this->display('troomv2/page_footer'); ?>