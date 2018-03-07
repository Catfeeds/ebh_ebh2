<?php
$this->display('admin/header');
?>
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?version=20160225001" rel="stylesheet" />
<title>批量导入</title>
</head>

<style>
    #user-window{
        width: 480px;
        height: 300px;
    }
    #refund {
        width: 380px;
        padding-left: 100px;
        margin-top: 20px;
    }
    #refund tr{
        height: 30px;
    }
	#drop{
		width: 60px;
		height: 25px;
		color: red;
	}
	#clear{
		width: 60px;
		height: 25px;
		color: red;
	}
	#crname{
		height: 25px;
	}
</style>
<body id="main" style="position:relative">
<div id="dd">

</div>
    <table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td><h1>服务订单管理 - 服务订单列表</h1></td>
        <td class="actions">
            <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
            <tr>
            <td><a href="<?php echo geturl('admin/sporder');?>">订单列表</a></td>
			<td  class="active"><a href="<?php echo geturl('admin/sporder/input');?>">批量开通</a></td>
                <td><a href="<?=geturl('admin/sporder/btachremove')?>">批量删除</a></td>
            </tr>
            </table>
        </td>
    </tr>
</table>
	<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">
<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;">
<a href="http://static.ebanhui.com/ebh/file/oinput.xls" class="mobancun" target="_blank">导入模板下载</a>
</div>
<div class="huidis" style="width:905px;">
<div class="neileft105" style="width:680px;">

<?php if(empty($inputresult['hasresult'])){?>
<form id="inputform" action="<?=geturl('admin/sporder/input')?>" method="post" enctype="multipart/form-data">
<div id="crwrap" style="display:none">
    <iframe id="cr" ></iframe>
</div>
<table cellspacing="0" cellpadding="0" class="toptable">

<tr>
<td>
        <label>开通方式:</label>
        <span id="">
        <select  name="payfrom" id="payfrom">
		<option value="4" >人工开通</option>
		<option value="5" >内部测试</option>
        <option value="3" >支付宝开通</option>
        <option value="6" >农行支付</option>
        <option value="7" >银联支付</option>
        <option value="8" >余额支付</option>
        <option value="9" >微信支付</option>
        </select>
        </span>

        <label for="catid">所属学校</label>
        <input type="text" class="w300" readonly="readonly" value="" id="crname" name="crname">
        <input type="button" id="drop" value="选择" />
        <input type="button" id="clear" value="清除" />
        <input type="hidden" name="crid" id="mediaid"  value="0" />
	</td>

</tr>
</table>
<br />
  <input style="float:left;width:350px;height:30px;cursor:pointer;" type="file" name="inputfile" />
  <input name="flag" type="hidden"/>
  <a style="float:right" href="<?=geturl('admin/sporder')?>" class="flhui">返回</a>
  <input style="float:right;" class="xuetjbtn" type="button" value="提　交" />
</form>
<p style="color:red;width:300px;"><?=empty($inputresult['errormsg'])?'':$inputresult['errormsg']?></p>
<p class="pzhuyi" style="float:left;">注意<span style="color:red;">(非常重要)</span>：<br />
1.导入系统目前只支持xls格式文件，暂不支持xlsx格式文件。<br />
2.导入的excel文件必须严格按照导入模板格式。<br />
3.excel文件中的必须包含登录账号、开通课程两个字段。<br />
4.登录账号只能为6-20位英文、数字的组合字符。<br />
5.开通课程如有多门,请以英文的逗号(,)隔开。<br />
6.开通课程中的科目名称必须和对应网校中的课程名称完全一致，并且已经开设服务项。<br />
7.所有导入的学生账号在系统中必须已存在。<br />
</p>
<?php }?>


<?php if(!empty($inputresult) && $inputresult['hasresult']){
		if($inputresult['result'] == true){?>
<p class="ptishi">批量开通成功，共处理 <?=$inputresult['rowcount']?> 条学生记录。</p>
<input class="xuetjbtn" type="button" value="继续导入" onclick="window.location.href='<?=geturl('admin/sporder/input')?>'" />
<a href="<?=geturl('admin/sporder')?>" class="flhui">返回</a>
	<?php }else{?>
<br />
<p class="ptishi" style="line-height:1.8;">很抱歉，导入失败，具体原因如下：<br />
<?=$inputresult['errormsg']?><br />
<?php if(!empty($inputresult['erroritems'])){
		foreach($inputresult['erroritems'] as $eitem){
			echo $eitem .'<br />';
}}?>

</p>
<input class="xuetjbtn" type="button" value="重新导入" onclick="window.location.href='<?=geturl('admin/sporder/input')?>'" />
<a href="<?=geturl('admin/sporder')?>" class="flhui" style="color:#065ed7;float:left;font-size:14px;margin:5px 0 0 10px;">返回</a>
</p>
<?php }}?>

</div>
</div>
</div>
<div id="loadparent" style="display:none;">
<div id="loadimg" style="width:100px;height:100px;margin:0 auto;margin-top:150px;"><img style="margin:0 auto;" title="加载中..." src="http://static.ebanhui.com/ebh/images/loading.gif"/>
</div>
<script type="text/javascript">
$(function(){
	$(".xuetjbtn").click(function(){
		$("#loadparent").css("display","");
		$("#inputform").submit();
	});
});
function showcr(){
        var url = '/admin/classroom/roomselect.html';
        var width = $(window).width();
        var height = $(window).height();
        $('#cr')
        .attr('width',width/5*3)
        .attr('height',height/5*3)
        .attr('src',url);
        $('#crwrap').show();
        $('#crwrap').dialog({    
            title: '请选择教室', 
            closed: false,    
            cache: false,   
            modal: true   
        });
        // $('#win').window('refresh', );  
        return false;
    }
    $('#drop').click(function(){
       showcr();  
    });
    $('#clear').click(function(){
        $('#mediaid').val("");
        $('#crname').val("");
    }); 
    var closedialog = function (){
        $("#crwrap").dialog('close');
    } 
function _search(){
   $('#pp').pagination({pageNumber:1});
   $(".pagination-page-list").trigger('change');
   return false;
}
$('#pp').pagination({
    pageSize:50,
    onSelectPage:function(pageNumber, pageSize){
        var curquee = ++quee;
        var query = $('#searchkey').val();
		var status = $('#status').val();
        var payfrom = $('#payfrom').val();
        var crid = $('#mediaid').val();
        $.post("/admin/sporder/getListAjax.html",
            {query:query,status:status,payfrom:payfrom,crid:crid,pageNumber:pageNumber,pageSize:pageSize},
            function(message){
                message = JSON.parse(message);
                if(curquee!=quee){
                    return;
                }
				$('#pp').pagination('refresh',message.shift());
				_render(message);
                
            }
            );
        return false;
    }
});

</script>
<script src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<div id="orderwrap">
<iframe id="orderinfo" width=720px height=460px src="" frameborder="0"></iframe>
</div>
<?php
$this->display('admin/footer');
?>