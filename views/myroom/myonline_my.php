<?php $this->display('myroom/page_header');?>
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
.datatab td {
    color: #666666;
    padding: 10px 6px;
}

 	.lefrig .work_mes .workBtn {display:block;float:right;width:100px;height:32px;line-height:32px;text-align:center;color:#FFFFFF;background:#18a8f7;text-decoration:none;cursor:pointer;border:none;font-size: 14px;font-weight: bold;}
 	.lefrig .work_mes .workBtn:hover{background:#0d9be9;color:#fff;text-decoration: none;font-size: 14px;font-weight: bold;}
</style>

<div class="ter_tit">
当前位置 > 在线直播 > 直播列表
<div class="diles">
	<?php
		$q = $this->input->get('q');
		$q= empty($q)?'':$q;
		if(!empty($q)){
			$stylestr = 'style="color:#000"';
		}else{
			$stylestr = "";
		}
	?>
	<input name="title" <?=$stylestr?> class="newsou" id="title" value="<?=$q?>" type="text">
	<input type="button" class="soulico" value="" onclick="_dosearch();">
</div>
</div>

</div>


<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;">
<div class="work_mes">
	<ul>
		<li class="workcurrent"><a href="<?= geturl('myroom/online')  ?>"><span>直播列表</span></a></li>
	</ul>
</div>
    <table class="datatab" width="100%" style="border:none;">
	   <thead class="tabheads">
	   <tr style="color:#666;border-bottom:1px solid #d9d9d9;">
       <th style="width:33%;padding-left:10px;text-align:left; ">课程名称</th>
       <th style="width:25%; text-align:left; ">直播时间</th> 
       <th style="width:10%; text-align:left; ">直播时长</th> 
       <th style="width:12%;text-align:left; ">主讲</th> 
       <th style="width:20%;text-align:left; ">操作</th> 
		</tr>
	</table>			
	<?php
		if(empty($user['realname'])) {
			$uname = $user['username'];
		} else {
			$u1 = substr($user['username'],0,2);
			$u2 = substr($user['username'],-2,2);
			$uname = $user['realname'].'('.$u1.'**'.$u2.')';
		}
	?>
	<table  width="100%" style="border-bottom:1px solid #d9d9d9;">
	<?php foreach ($courseList as $value) {?>
		<tr onmouseout="this.bgColor='#ffffff'"	onmouseover="this.bgColor='#f2f7ff'" style="border-bottom:1px solid #d9d9d9;">
	      <td style=" height: 35px;width:138px;"><span style="color:blue;margin-left:10px;"><?=$value['title']?></span></td> 
			<?php if(time()>($value['cdate']+$value['ctime']*60 + 3600)){?>
	       		<td style="padding:5px 0px;width:25%;text-align:left; "><span  style="color:red;"><?=date('Y-m-d H:i:s',$value['cdate'])?>（已过期）</span></td>
		   	<?php }else if((time()<($value['cdate']+$value['ctime']*60))&&(time()>($value['cdate']-$value['ctime']*60))){?>
		    	<td style="padding:5px 0px;width:25%;text-align:left; "><span style="color:green;">（正在直播）</span></td> 
			<?php }else{?>
				<td style="padding:5px 0px;width:25%;text-align:left; "><?=date('Y-m-d H:i:s',$value['cdate'])?></td>
			<?php }?>
		   <td style="padding:5px 0px;width:10%;text-align:left;  "><?=$value['ctime']?> 分钟</td> 
		   <td style="padding:5px 0px;width:12%;text-align:left;  "><?=$value['tname']?></td> 
		   <td style="text-align:left;width:20%;" >
		  
		   <?php 
				if($roominfo['crid'] == 10194 || $roominfo['crid'] == 10580) {
					$ourl = "http://ochat.ebh.net/room.htm?id=".$value['id']."&type=c";
				} else {
		   			$ourl = "http://chat.ebh.net/webconf/room.htm?id=".$value['id']."&user=".$uname."&teach=".$value['tname']."&type=u&key=".$key;
				}
		   ?>
		   <?php
		   		//开课结束后一小时
		   		$b_time = $value['cdate'] + $value['ctime']*60 +3600;
		   ?>
		   <?php if( time()<$b_time ){?>
		   		<a target=_blank href="<?=$ourl?>" class="btnsuo">进入</a>
		   <?php }?>
		   </td>
		 
		</tr>
	<?php }?>

	</table>
</div>
<?=$pagestr?>
<script type="text/javascript">
function _dosearch(){
	var q = $("#title").val();
	if(q=='请输入关键字'){
		q='';
	}		
	location.href='/myroom/online.html?q='+q;
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