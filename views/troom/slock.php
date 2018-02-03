<?php $this->display('troom/page_header');?>
<style>
 	.lefrig .work_mes .workBtn {display:block;float:left;width:100px;height:32px;line-height:32px;text-align:center;color:#FFFFFF;background:#18a8f7;text-decoration:none;cursor:pointer;border:none;font-size: 14px;font-weight: bold;}
 	.lefrig .work_mes .workBtn:hover{background:#0d9be9;color:#fff;text-decoration: none;font-size: 14px;font-weight: bold;}
</style>
<div class="ter_tit">
当前位置 > <a href="<?= geturl('troom/tools')  ?>">应用工具</a> > <a href="<?= geturl('troom/slock')  ?>">学生锁屏</a> > 我的锁屏

</div>

</div>
<div class="lefrig" style="background:#fff;float:left;margin-top:15px;">
<div class="work_mes">
	<ul>
		<li class="workcurrent"><a href="<?= geturl('troom/slock')  ?>"><span>我的锁屏</span></a></li>
		<li><a href="<?= geturl('troom/slock/add')?>"><span>添加锁屏</span></a></li>
	</ul>

</div>
    <table class="datatab" width="100%" STYLE="border:none;">
	   <thead class="tabheads">
		   <tr style="color:#666;border-bottom:1px solid #efefef;">
		       <th style="width:25%;padding-left:10px;text-align:left; ">锁屏说明</th> 
		       <th style="width:20%; text-align:left; ">开始时间</th> 
		       <th style="width:20%; text-align:left; ">结束时间</th> 
		       <th style="width:15%; text-align:left; ">添加老师</th> 
		       <th style="width:20%;text-align:left;">操作</th> 
	   	   </tr>
		</thead>
	</table>
	
	<table  width="100%" style="border-bottom:1px solid #efefef;">
		<tbody>
			<?php if(empty($valideList)) { ?>
				<?php if(empty($slockList)){?>
					<tr><td colspan="5" align="center" style="border-top:none;height:35px;">没有锁屏</td></tr>
		    	<?php }else{?>
		    		<tr><td colspan="5" align="center" style="border-top:none;height:35px;">没有有效锁屏</td></tr>
		    	<?php }?>
		    <?php }else{?>
		    	<tr><td colspan="5" align="center" style="border-bottom: 1px solid #efefef;height:35px;font-size:20px;font-weight:bold;">有　效</td></tr>
				<?php foreach ($valideList as $slock) {?>
				<tr onmouseout="this.bgColor='#ffffff'" onmouseover="this.bgColor='#f2f7ff'"  bgcolor="#ffffff">
		      	<td style="height: 35px;"><a href="/troom/slock/<?=$slock['lockid']?>.html" title="<?=$slock['title']?>" style="padding:5px 10px 5px;width:25%;color:blue; cursor: pointer;font-size:12px;"><?=shortstr($slock['title'],28,'')?></a></td> 
			   	<td style="padding:5px 0px;width:20%;text-align:left;  "><?=date('Y-m-d H:i',$slock['startdate'])?></td> 
			    <td style="padding:5px 0px;width:20%;text-align:left;  "><?=date('Y-m-d H:i',$slock['enddate'])?></td> 
			    <td style="padding:5px 0px;width:15%;text-align:left;  "><?=$slock['uid_name']?></td> 
			    <td style="text-align:left;width:20%;">
			    	<?php if($user['uid'] == $slock['uid']){?>
			    	<a href="javascript:void(0)" onclick="delSlock('<?=$slock['title']?>',<?=$slock['lockid']?>)"  class="workBtn">删除</a>
			    	<a href="/troom/slock/edit.html?lockid=<?=$slock['lockid']?>" class="workBtn">修改</a>
			    	<?php }?>
			    	<a class="workBtn" style="color:#fff;text-decoration: none;" href="/troom/slock/<?=$slock['lockid']?>.html">查看</a>
			   	</td>
				</tr>
				<tr style="border-bottom:1px solid #d9d9d9;">
					<td colspan="5" style="padding:0px 10px 0px;line-height:35px;color:#999999;">
						<?php if($slock['startdate'] <= time()){?>
								<span style="color:#ff0000">[正在锁屏]</span>
						<?php }?>
						<span>锁屏对象：
							<?php
								$key = 'lockid_'.$slock['lockid'];
								if(array_key_exists($key, $target_db)){
									echo implode(',', $target_db[$key]);
								}
							?>
						</span>
					</td>
				</tr>
				<?php }?>
			<?php }?>

			<?php if(empty($slockList)) { ?>
				<?php if(!empty($valideList)){?>
					<tr><td colspan="5" align="center" style="border-top:none;height:35px;">没有过期锁屏</td></tr>
				<?php }?>
		    <?php }else{?>
		    	<tr><td colspan="5" align="center" style="border-bottom: 1px solid #d9d9d9;height:35px;font-size:20px;font-weight:bold;">过　期</td></tr>
				<?php foreach ($slockList as $slock) {?>
				<tr onmouseout="this.bgColor='#ffffff'" onmouseover="this.bgColor='#f2f7ff'"  bgcolor="#ffffff">
		      	<td style="height: 35px;"><a href="/troom/slock/<?=$slock['lockid']?>.html" title="<?=$slock['title']?>" style="padding:5px 10px 5px;width:25%;color:blue; cursor: pointer;font-size:12px;"><?=shortstr($slock['title'],28,'')?></a></td> 
			   	<td style="padding:5px 0px;width:20%;text-align:left;  "><?=date('Y-m-d H:i',$slock['startdate'])?></td> 
			    <td style="padding:5px 0px;width:20%;text-align:left;  "><?=date('Y-m-d H:i',$slock['enddate'])?></td> 
			    <td style="padding:5px 0px;width:15%;text-align:left;  "><?=$slock['uid_name']?></td> 
			    <td style="text-align:left;width:20%;">
			    	<?php if($user['uid'] == $slock['uid']){?>
			    	<a href="javascript:void(0)" onclick="delSlock('<?=$slock['title']?>',<?=$slock['lockid']?>)"  class="workBtn">删除</a>
			    	<a href="/troom/slock/edit.html?lockid=<?=$slock['lockid']?>" class="workBtn">修改</a>
			    	<?php }?>
			    	<a class="workBtn" style="color:#fff;text-decoration: none;" href="/troom/slock/<?=$slock['lockid']?>.html">查看</a>
			   	</td>
				</tr>
				<tr style="border-bottom:1px solid #d9d9d9;">
					<td colspan="5" style="padding:0px 10px 0px;line-height:35px;color:#999999;">
						<span>锁屏对象：
							<?php
								$key = 'lockid_'.$slock['lockid'];
								if(array_key_exists($key, $target_db)){
									echo implode(',', $target_db[$key]);
								}
							?>
						</span>
					</td>
				</tr>
				<?php }?>
			<?php }?>
		</tbody>
	</table>
</div>
<?=$pagestr?>
<script type="text/javascript">
function delSlock(name,lockid) {
	$.confirm("您确定要删除锁屏 【" + name + "】 吗？",function(){
		$.ajax({
			url:"/troom/slock/delete.html",
			type:'post',
			data:{'lockid':lockid},
			dataType:'json',
			success:function(res){
				if(res.status == 0){
					document.location.href = document.location.href;
				}else{
					alert(res.msg);
				}
			}
		});
	});
}
</script>
</body>
</html>