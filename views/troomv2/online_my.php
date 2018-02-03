<?php $this->display('troomv2/page_header');?>
<style>
#icategory {
    background: none repeat scroll 0 0 #F7FAFF;
    border-top: 1px solid #E1E7F5;
    padding: 6px 20px;
	_margin-bottom:-5px;
}
#icategory dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
}
#icategory dd {
    float: left;
    width: 645px;
}
.category_cont1 div a.curr, .price_cont div a:hover, .price_cont div a.curr {
	background: none repeat scroll 0 0 #FF5400;
	color: #FFFFFF;
	text-decoration: none;
}
.category_cont1 div a {
    color: #2C71AE;
    text-decoration: none;
    padding: 2px;
    cursor: pointer;
}
.category_cont1 div {
    float: left;
    height: 25px;
    line-height: 22px;
    overflow: hidden;
	padding:0 10px;
}
.key_word {
	padding: 6px 20px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	height:28px;
	border-bottom-color: #cdcdcd;
}
.key_word dt {
    float: left;
    line-height: 22px;
    padding-right: 5px;
    text-align: left;
}
.pbtns {
    background: url(http://static.ebanhui.com/ebh/tpl/2012/images/sunt0518.png) repeat scroll 0 0 transparent;
    border: medium none;
    color: #333333;
    height: 20px;
    vertical-align: middle;
    width: 40px;
	cursor:pointer;
}
 	.lefrig .work_mes .workBtn {display:block;float:right;width:100px;height:32px;line-height:32px;text-align:center;color:#FFFFFF;background:#18a8f7;text-decoration:none;cursor:pointer;border:none;font-size: 14px;font-weight: bold;}
 	.lefrig .work_mes .workBtn:hover{background:#0d9be9;color:#fff;text-decoration: none;font-size: 14px;font-weight: bold;}
</style>

<div class="ter_tit">
当前位置 > <a href="<?= geturl('troomv2/online')?>" >在线直播</a> > 我的直播
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
	<input id="ser" onclick="_dosearch()" type="button" class="soulico" value="">
</div>
</div>
<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:788px;">

<div id="icategory" class="clearfix" style="border:none;">
	<dt></dt>
	<dd>
		<div class="category_cont1">
			<div>
				<a tag=0 onclick="_search(0)" <?= empty($check) ? 'class="curr"' : ''?> >所有班级</a>
			</div>
				<?php foreach ($classes as $class) { ?>
			<div>
				<a  <?php  if(!empty($check)&&($check==$class['classid'])){echo 'class=curr';}?> onclick="_search(<?=$class['classid']?>,'classid')" tag="<?=$class['classid']?>" ><?=$class['classname']?></a>
			</div>
                <?php } ?>

		</div>
	</dd>
	<?php if(count($grades)>0){?>
	<dt></dt>
	<dd>
		<div class="category_cont1">
			<div>
				<a tag=0 onclick="_search(0)" <?= empty($check) ? 'class="curr"' : ''?> >所有年级</a>
			</div>
				<?php $tmp = array()?>
				<?php foreach ($grades as $grade) { ?>
			<div>
				<a  <?php  if(!empty($check)&&($check==$grade['grade'])){echo 'class=curr';}?> onclick="_search(<?=$grade['grade']?>,'grade')" tag="<?=$grade['grade']?>" ><?=$grade['gradename']?></a>
			</div>
                <?php } ?>

		</div>
	</dd>
	<?php }?>
</div>

<div class="lefrig" style="margin-top:10px;">
    <table class="datatab" width="100%" style="border:none;">
	   <thead class="tabheads">
	   <tr style="color:#666;border-bottom:1px solid #efefef;">
       <th style="width:33%;padding-left:10px;text-align:left; ">课程名称</th> 
       <th style="width:25%; text-align:left; ">直播时间</th> 
       <th style="width:10%; text-align:left; ">直播时长</th> 
       <th style="width:12%;text-align:left; ">主讲</th> 
       <th style="width:20%;text-align:left; ">操作</th> 
		</tr>
	</table>			
	<table  width="100%" style="border-bottom:1px solid #efefef;">
	<?php $uname = $user['realname'];?>
	<?php foreach ($courseList as $value) {?>
		<tr onmouseout="this.bgColor='#ffffff'"	onmouseover="this.bgColor='#f2f7ff'" style="border-bottom:1px solid #efefef;">
	      <td style=" height: 35px;"><a  href="/troomv2/online/edit.html?op=view&id=<?=$value['id']?>" style="padding:5px 10px 5px;width:52%;color:blue; cursor: pointer;font-size:12px;" title="$value['title']"><?=$value['title']?></a></td> 
			<?php if(time()>($value['cdate'])+$value['ctime']*60){?>
	       		<td style="padding:5px 0px;width:25%;text-align:left; "><span  style="color:red;"><?=date('Y-m-d H:i:s',$value['cdate'])?>（已过期）</span></td>
		   	<?php }else if((time()<($value['cdate']+$value['ctime']*60))&&(time()>($value['cdate']-$value['ctime']*60))){?>
		    	<td style="padding:5px 0px;width:25%;text-align:left; "><span style="color:green;">（正在直播）</span></td> 
			<?php }else{?>
				<td style="padding:5px 0px;width:25%;text-align:left; "><?=date('Y-m-d H:i:s',$value['cdate'])?></td>
			<?php }?>
		   <td style="padding:5px 0px;width:10%;text-align:left;  "><?=$value['ctime']?> 分钟</td> 
		   <td style="padding:5px 0px;width:12%;text-align:left;  "><?=$value['tname']?></td> 
		   <td style="text-align:left;width:20%;" >
		   <a href="javascript:" onclick="return degroup('<?=$value["id"]?>','<?=$value["title"]?>')" style="margin-left:0;margin-right:5px;" class="btnshan">删除</a>
		   <?php if(time()<=($value['cdate'])+$value['ctime']*60){?>
		   		<a href="/troomv2/online/edit.html?pos=my&id=<?=$value['id']?>" class="workBtn" style="margin:0;">修改</a>
		   		<?php 
				if($roominfo['crid'] == 10194 || $roominfo['crid'] == 10580) {
					$ourl = "http://ochat.ebh.net/room.htm?id=".$value['id']."&type=c";
				} else {
					$ourl = "http://chat.ebh.net/webconf/room.htm?id=".$value['id']."&user=".$uname."&teach=".$uname."&type=t&key=".$key;
				}
				?>
		  		<a target=_blank href="<?=$ourl?>" class="btnsuo" style="margin-left:5px;">进入</a>
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
			url:"/troomv2/online/delete.html",
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

function _search($classorgrade,$tag){
	var q = $("#title").val();
	if(q=='请输入关键字'){
		q='';
	}		
	location.href='/troomv2/online/my.html?q='+q+'&'+$tag+'='+$classorgrade;
}
function _dosearch(){
	$("div.category_cont1 a.curr").trigger('click');
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
</div>
</body>
</html>