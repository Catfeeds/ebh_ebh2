<?php
$this->display('common/header');
?>
<style>
.datatab td {
	border:none;
	border-top:solid 1px #cdcdcd;
	border-bottom:solid 1px #cdcdcd;
}
</style>
<div class="topbaad">
<div class="user-main clearfix" >
	<?php
	$this->assign('menuid',5);
	$this->display('member/left');
	?>
		<div class="cright_cher">
	<div class="ter_tit">
	当前位置 > <a href="<?php echo geturl('member/myask')?>">我的答疑</a> > 全部问题
	<div class="diles">
	<input name="title" class="newsou" id="title" <?php if(!empty($q)){?>value="<?=str_replace("''","'",$q)?>" <?php }else{?>value="输入关键字搜索"<?php }?>  onblur="if($('#title').val()==''){$('#title').val('输入关键字搜索').css('color','#CBCBCB');}" onfocus="if($('#title').val()=='输入关键字搜索'){$('#title').val('').css('color','#000');}" style="<?php if(!empty($q)){?>color:#000<?php }?>" type="text" />
	<input type="button" class="soulico" value="" onclick="serc()">
	</div>
	</div>
	<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;margin-top:15px;width:786px;float:left;">
			
			<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />
			<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
			<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
			
			<div >
				<div class="work_mes">
					<ul>
						<li class="workcurrent"><a href="<?php echo geturl('member/myask');?>"><span>全部问题</span></a></li>
						<li><a href="<?php echo geturl('member/myask/myquestion');?>"><span>我的问题</span></a></li>
						<li><a href="<?php echo geturl('member/myask/myanswer');?>"><span>我的回答</span></a></li>
						<li><a href="<?php echo geturl('member/myask/myfavorit')?>"><span>我的关注</span></a></li>
					</ul>
				</div>
				<div class="tiezi_search" style="height:20px;float:right;margin-top:10px;margin-right:10px;">
						
						<div style="margin-left:10px;float:left;">
						<a style="margin-left:10px;" class="questionbutton" href="<?php echo geturl('member/myask/addquestion')?>">提&nbsp;&nbsp;问</a></div>
				</div>
						<div class="workdata" style="float:left;">
							<table  width="100%" class="datatab" style="border:none;width:786px;">

							<tbody>
	
                                <?php if(empty($myasklist)) { ?>
			  		<tr><td colspan="5" align="center">目前没有问题记录</td></tr>
                                <?php } else { ?>
			  	
                                        <?php foreach($myasklist as $akey=>$avalue) { ?>
                        <?php 
						//var_dump($avalue);
							if(!empty($avalue['face']))
								$face = getthumb($avalue['face'],'50_50');
							else{
								if($avalue['sex']==1){
									$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
								}else{
									$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
								}
							
								$face = getthumb($defaulturl,'50_50');
							} 
						?>	               
				 		<tr>
						<td>					
							<div style="float:left;margin-right:15px;"><img title="<?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?>" src="<?=$face?>" /></div>
							<div style="float:left;width:700px;font-family:Microsoft YaHei;">
								<p style="width:590px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">
									<a  href="<?=geturl("member/myask/$avalue[qid]")?>">
										<?= $avalue['title'] ?>
									</a>
								</p>
								<span style="width:55px;text-align:center;float:right;line-height:2;background:url(http://static.ebanhui.com/ebh/tpl/default/images/modu.png) no-repeat 0px 28px;">回答数<br/><?= $avalue['answercount'] ?></span>
								<div style="float:left;width:590px;">
								<span style="width:150px;float:left;"><?= Date('Y-m-d H:i:s',$avalue['dateline']) ?></span>
								<span class="huirenw" style="width:100px;float:left;"><?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?></span>
								<span style="width:200px;float:left;background:url(http://static.ebanhui.com/ebh/tpl/default/images/label.png) no-repeat;padding-left:24px;"><?= $avalue['foldername'] ?></span>
							</div>
						</div>

							</td>
				    	</tr>
                                        <?php } ?>
		
                                <?php } ?>
							
							</tbody>
							</table>
				
			</div>
			<?php
			echo show_page($myaskcount,$pagesize);
			?>
			
</div>
</div>
</div>
</div>
<script type="text/javascript">
<!--
function serc(){
	var title = $("#title").val();
		title = title.replace(/,/g,"");
		title = title.replace(/\'/g,"");
		title = title.replace(/\//g,"");
		title = title.replace(/%/g,"");
		title = title.replace(/_/g,"");
		title = title.replace(/#/g,"");
		title = title.replace(/\?/g,"");
		title = title.replace(/\\/g,"");
		title = title.replace(/>/g,"");
		
	var url = '/member/myask-0-0-0.html?q='+title;
  // alert(url);
	window.location.href=url;
}
//-->
</script>
<?php
$this->display('common/footer');
?>