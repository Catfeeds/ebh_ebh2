<?php $this->display('troom/page_header');?>
<style>
 	.work_menuss .workBtn {display:block;float:right;width:100px;height:32px;line-height:32px;text-align:center;color:#FFFFFF;background:#18a8f7;text-decoration:none;cursor:pointer;border:none;font-size: 14px;font-weight: bold;}
 	.work_menuss .workBtn:hover{background:#0d9be9;color:#fff;text-decoration: none;font-size: 14px;font-weight: bold;}
</style>
<div class="ter_tit">
当前位置 > <a href="<?= geturl('troom/online')?>" >在线直播</a> > 所有直播
<div class="diles">
	<?php
		$q= empty($q)?'':$q;
		if(!empty($q)){
			$stylestr = 'style="color:#000"';
		}else{
			$stylestr = "";
		}
	?>
	<input name="title" <?=$stylestr?> class="newsou" id="title" value="<?=empty($q)?'':$q?>" type="text" />
	<input id="ser" onclick="_search()" type="button" class="soulico" value="">
</div>
</div>
</div>
<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">

    <table class="datatab" width="100%" style="border:none;">
	   <thead class="tabheads">
	   <tr style="color:#666;border-bottom:1px solid #efefef;">
	   <th style="width:22%;padding-left:10px;text-align:left; ">主讲</th>
       <th style="width:30%;">课程名称</th> 
       <th style="width:23%; text-align:left; ">直播时间</th> 
       <th style="width:7%; text-align:left; ">直播时长</th> 
       <th style="width:18%;text-align:left; ">操作</th> 
		</tr>
	</table>			
	<table  width="100%" style="border-bottom:1px solid #efefef;">
	<?php $uname = $user['realname'];?>
	<?php foreach ($courseList as $value) {?>
		<tr style="border-bottom:1px solid #efefef;" onmouseout="this.bgColor='#ffffff'"onmouseover="this.bgColor='#f2f7ff'">
		<?php 
		//var_dump($avalue);
			if(!empty($value['face']))
				$face = getthumb($value['face'],'50_50');
			else{
				if($value['sex']==1){
					if($value['groupid']==5){
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
					}else{
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
					}
				}else{
					if($value['groupid']==5){
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
					}else{
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
					}
				}
			
				$face = getthumb($defaulturl,'50_50');
			} 
		?>	     
		<?php $name=empty($value['realname'])?$value['username']:$value['realname'] ?>
		  <td style="width:22%;"><span style="padding-top:10px;margin-left:10px;float:left;"><img title="<?= $name?>" src="<?=$face?>" /></span><span style="margin-top:20px;float:left;line-height:30px;margin-left:10px;"><?= $name ?></span></td>
	      <td style=" height: 35px;"><a  href="/troom/online/edit.html?op=view&id=<?=$value['id']?>" style="padding:5px 10px 5px;width:52%;color:blue; cursor: pointer;font-size:12px;" title="$value['title']"><?=$value['title']?></a></td> 
			<?php if(time()>($value['cdate'])+$value['ctime']*60){?>
	       		<td style="padding:5px 0px;width:23%;text-align:left; "><span  style="color:red;"><?=date('Y-m-d H:i:s',$value['cdate'])?>（已过期）</span></td>
		   	<?php }else if((time()<($value['cdate']+$value['ctime']*60))&&(time()>($value['cdate']-$value['ctime']*60))){?>
		    	<td style="padding:5px 0px;width:23%;text-align:left; "><span style="color:green;">（正在直播）</span></td> 
			<?php }else{?>
				<td style="padding:5px 0px;width:23%;text-align:left; "><?=date('Y-m-d H:i:s',$value['cdate'])?></td>
			<?php }?>
		   <td style="padding:5px 0px;width:7%;text-align:left;  "><?=$value['ctime']?> 分钟</td> 
		   <td style="text-align:left;width:18%;" >
		   <?php if($user['uid']==$value['tid']){?>
		   	<a href="javascript:" onclick="return degroup('<?=$value["id"]?>','<?=$value["title"]?>')" style="margin-left:0;margin-right:5px;" class="btnshan">删除</a>
		   		<?php if(time()<=($value['cdate'])+$value['ctime']*60){?>
		   			<a href="/troom/online/edit.html?pos=all&id=<?=$value['id']?>" class="workBtn" style="margin:0;">修改</a>
					<?php 
					if($roominfo['crid'] == 10194) {
						$ourl = "http://ochat.ebh.net/room.htm?id=".$value['id']."&type=c";
					} else {
						$ourl = "http://chat.ebh.net/webconf/room.htm?id=".$value['id']."&user=".$uname."&teach=".$uname."&type=t&key=".$key;
					}
					?>	
		   			<a target=_blank href="<?=$ourl?>" class="btnsuo" style="margin-left:5px;">进入</a>
		   		<?php }?>
		   <?php }?>
		   </td>
		</tr>
	<?php }?>

	</table>
</div>
<?=$pagestr?>
<script type="text/javascript">
function degroup(id,name) {
	$.confirm("您确定要删除在线直播课程 【" + name + "】 吗？",function(){
		$.ajax({
			url:"/troom/online/delete.html",
			type:'post',
			data:{'id':id},
			dataType:'text',
			success:function(data){
				if(data>0){
					alert("课程删除成功！");
					document.location.href = document.location.href;
				}else{
					alert("对不起，课程删除失败，请稍后再试或联系我们的客服！");
				}
			}
		});
	});
}
function _search(){
	var q = $("#title").val();
	if(q=='请输入关键字'){
		q='';
	}	
	location.href='/troom/online/allcourse.html?q='+q;
}
var searchtext = "请输入关键字";
$(function() {
initsearch("title",searchtext);
   $("#ser").click(function(){
       var title = $("#title").val();
       if(title == searchtext) 
           title = "";
      
   });
   });
</script>
</body>
</html>