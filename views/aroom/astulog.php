<?php $this->display('aroom/page_header');
	$classid = !empty($classid)?$classid:0;
?>

<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
		当前位置 > 学生听课监察
		<div class="diles">
	<input name="title" class="newsou" id="search" <?php if(!empty($search)){?>value="<?=str_replace("''","'",$search)?>" <?php }else{?>value="输入关键字搜索"<?php }?>  onblur="if($('#search').val()==''){$('#search').val('输入关键字搜索').css('color','#CBCBCB');}" onfocus="if($('#search').val()=='输入关键字搜索'){$('#search').val('').css('color','#000');}" style="<?php if(!empty($search)){?>color:#000<?php }?>"/>
	<input type="button" class="soulico" value="" id="searchbutton">
</div>
		</div>
	<div class="lefrig">
<div class="annuato" style="line-height:28px;padding-left:20px;background:#fff;position: relative;">
本网校共有班级&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['classnum']?></span>&nbsp;个，共有教师&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['teanum']?></span>&nbsp;个，学生&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['stunum']?></span>&nbsp;名，课件&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['coursenum']?></span>&nbsp;个，课程&nbsp;<span style="color:blue;font-weight:bold;"><?=$roomdetail['foldernum']?></span>&nbsp;个

</div>

<div id="icategory" class="clearfix" style="background:#fff;">
	<dt>所属班级：</dt>
	<dd style="width:680px;">
		<div class="category_cont1">
			<div>
				<a <?php if(empty($classid)){?>class="curr"<?php }?> href="<?=geturl('aroom/astulog-0-0-0-0')?>">所有学生</a>
			</div>
			<?php foreach($classlist as $cl){?>
			<div>
				<a <?php if($classid==$cl['classid']){?>class="curr"<?php }?>href="<?=geturl('aroom/astulog-0-0-0-'.$cl['classid'])?>"><?=$cl['classname']?></a>
			</div>
			<?php }?>
		</div>
	</dd>
</div>
<table class="datatab" width="100%" style="margin-top:10px;">
<thead class="tabhead">
<tr>
<th>学生班级</th>
<th>登录账号</th>
<th>学生姓名</th>
<th>性别</th>
<th>邮箱</th>
<th>电话</th>
<th>操作</th>
</tr>
</thead>

<tbody>
		<?php
			if(!empty($roomuserlist)){
			foreach($roomuserlist as $v){?>
		<tr>
			<td width="15%"><span style="word-wrap: break-word;float:left;width:75px;"><?=$v['classname']?></span></td>
			<td width="15%"><?=$v['username']?></td>
			<td width="13%"><?=ssubstrch($v['cnname'],0,20)?></td>
			<td width="5%"><?=$v['sex']==1?'女':'男'?></td>
			<td width="18%"><span style="word-wrap: break-word;float:left;width:135px;"><?=$v['email']?></span></td>
			<td width="12%"><?=$v['mobile']?></td>
			<td style="width:300px;">
				<a title="班级作业" class="previewBtn" href="<?=geturl('aroom/astulog/astuloglist-0-0-0-'.$v['uid'])?>">听课监察</a>
			</td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="7" align="center">暂无记录</td></tr>
		<?php }?>
</tbody>
</table>
</div>

<div id="dialog"></div>
<?=$pagestr?>
<script type="text/javascript">


$(function(){
	$('#searchbutton').click(function(){
		<?php $classid = empty($classid)?'0':$classid?>
		var url = '<?=geturl('aroom/astulog-0-0-0-'.$classid)?>';
		

		if($("#search").val()=='输入关键字搜索'){
			var searchvalue = '';
		}else{
			var searchvalue = $("#search").val();
		}
//		if(searchvalue=='输入关键字搜索'){
//			searchvalue='';
//		}
		
		searchvalue = searchvalue.replace(/,/g,"");
		searchvalue = searchvalue.replace(/\'/g,"");
		searchvalue = searchvalue.replace(/\"/g,"");
		searchvalue = searchvalue.replace(/\//g,"");
		searchvalue = searchvalue.replace(/%/g,"");
		searchvalue = searchvalue.replace(/_/g,"");
		searchvalue = searchvalue.replace(/#/g,"");
		searchvalue = searchvalue.replace(/\?/g,"");
		searchvalue = searchvalue.replace(/\\/g,"");
		
		
		href = url + '?q=' + searchvalue;
		
		//href=href.replace('searchvalue',encodeURIComponent(searchvalue));
		location.href = href;
	});

});

function replaceAll(str,find,rp){
	while(true){
		if(str.indexOf(find) == -1){
			break;
		}
		str = str.replace(find,rp);
	}
	return str;
}
</script>
<?php $this->display('aroom/page_footer')?>
