<?php $this->display('troomv2/page_header'); ?>
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
    width: 950px;
}
.category_cont1 div a.curr, .category_cont1 div a:hover, .price_cont div a:hover, .price_cont div a.curr {
	background: none repeat scroll 0 0 #5e96f5;
	color: #FFFFFF;
	text-decoration: none;
	border-radius:2px;
	padding:2px !important;
	font-size:13px;
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
.workdata{
	width:1000px;
}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="lefrig">
<div class="waitite">
<span class="jnisrso">互动答疑</span>
<a href="<?= geturl('troomv2/myask/addquestion') ?>" class="jaddre">提个问题</a>
<div class="diles">
	<?php
		$q= empty($q)?'':$q;
		if(!empty($q)){
			$stylestr = 'style="color:#000"';
		}else{
			$stylestr = "";
		}
	?>
	<input name="uname" <?=$stylestr?> class="newsou" id="title" value="<?=$q ?>" type="text" />
	<input id="ser" type="button" class="soulico" value="">
</div>
</div>
<div class="workol">
	<div class="work_mes work_mesalone">
		<ul class="extendul">
			<li><a href="<?= geturl('troomv2/myask/askme') ?>"><span>提给我的</span></a></li>
			<li><a href="<?= geturl('troomv2/myask') ?>"><span>课程问题</span></a></li>
			<li class="workcurrent"><a href="<?= geturl('troomv2/myask/classquestion') ?>"><span>班级问题</span></a></li>
			<li><a href="<?= geturl('troomv2/myask/allquestion') ?>"><span>全部问题</span></a></li>
			<li><a href="<?= geturl('troomv2/myask/myquestion') ?>"><span>我的问题</span></a></li>
			<li><a href="<?= geturl('troomv2/myask/myanswer') ?>"><span>我的回答</span></a></li>
			<li><a href="<?= geturl('troomv2/myask/myfavorit') ?>"><span>我的关注</span></a></li>
			<!-- 新增 -->
			<li><a href="<?= geturl('troomv2/myask/settled') ?>"><span>已解决</span></a></li>
			<li><a href="<?= geturl('troomv2/myask/hot') ?>"><span>热门</span></a></li>
			<li><a href="<?= geturl('troomv2/myask/recommend') ?>"><span>推荐</span></a></li>
			<li><a href="<?= geturl('troomv2/myask/wait') ?>"><span>等待回复</span></a></li>
			<li><a href="/troomv2/myask/tjfx.html"><span style="color:#ff9500;">统计分析</span></a></li>
		</ul>
	</div>

	<div id="icategory" class="clearfix" style="border-top:none;">
		<dt></dt>
		<dd>
			<div class="category_cont1">
				<div>
					<a tag=0 onclick="_search(0)" <?= empty($checkclassid) ? 'class="curr"' : ''?> >所有班级</a>
				</div>
				
	                        <?php foreach ($tClasses as $tClasse) { ?>
				<div>
					<a  <?php  if(!empty($checkclassid)&&($checkclassid==$tClasse['classid'])){echo 'class=curr';}?> onclick="_search(<?=$tClasse['classid']?>)" tag="<?=$tClasse['classid']?>" ><?=$tClasse['classname']?></a>
				</div>
	                        <?php } ?>

			</div>
		</dd>
	</div>
			<div class="workdata" style="float:left;margin-top:0px;">
				<table  width="100%" class="datatab" style="border:none;">
			
			  		<tbody>
	
                                <?php if(empty($asks)) { ?>
			  		<tr><td colspan="5" align="center"><div class="nodata"></div></td></tr>
                                <?php } else { ?>
			  	
                     <?php foreach($asks as $akey=>$avalue) { ?>
                       <?php 
						//var_dump($avalue);
							if(!empty($avalue['face']))
								$face = getthumb($avalue['face'],'50_50');
							else{
								if($avalue['sex']==1){
									if($avalue['groupid']==5){
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
									}else{
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
									}
								}else{
									if($avalue['groupid']==5){
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
									}else{
										$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
									}
								}
							
								$face = getthumb($defaulturl,'50_50');
							} 
						?>	
				 		<tr>
				 			<td>
							<?php $name=empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?>
						<div style="float:left;margin-right:15px;width:50px;"><a href="http://sns.ebh.net/<?=$avalue['uid']?>/main.html" target="_blank"><img title="<?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?>的个人空间" src="<?=$face?>" class="imgyuan"  /></a></div>
							<div style="float:left;width:870px;font-family:Microsoft YaHei;">
								<p style="width:750px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">
								<?php if(!empty($avalue['reward'])){?>
									<span style="color:red;font-weight:bold" title="此题悬赏<?=$avalue['reward']?>积分">
									悬赏<?=$avalue['reward']?>
									<img src="http://static.ebanhui.com/ebh/tpl/2014/images/rewardcoin.png"/>
									</span>
								<?php }?>
									<?php if($avalue['status']==1){ ?>
									<img src="http://static.ebanhui.com/ebh/tpl/default/images/title.png" style="margin-right:5px;" title="已有最佳答案"/>
									<?php } ?>
									<a target="_blank"  href="<?= geturl('troomv2/myask/'.$avalue['qid']) ?>" style="color:#777;font-weight:bold;">
										<?= $avalue['title'] ?>
									</a>
									
								</p>
                                <span class="dashu" style="background:none">回答数<br/><?= $avalue['answercount'] ?>/<?=$avalue['viewnum']?></span>
                                <div style="float:left;width:750px;">
								<?php 
									//七天内的时间用红色显示
									$today_time = strtotime('today');
									$dateline_color = (($today_time - $avalue['dateline']) <= 604800 ) ? 'color:red;' : '';
                                ?>
                                <span style="width:200px;float:left;<?=$dateline_color?>"><?=timetostr($avalue['dateline'])?></span>
								<span class="huirenw" style="width:180px;float:left;"><?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?></span>
								<span style="width:270px;float:left;background:url(http://static.ebanhui.com/ebh/tpl/default/images/label.png) no-repeat;padding-left:24px;"><?= $avalue['foldername'] ?></span>
							</div>
						</div>
							</td>
				    	</tr>
                                        <?php } ?>
		
                                <?php } ?>

			  	</tbody>
				</table>
				
			</div>
                        <?= $pagestr ?>
</div>
</div>
<script type="text/javascript">
var searchtext = "请输入关键字";
$(function() {
initsearch("title",searchtext);
   $("#ser").click(function(){
       var title = $("#title").val();
       var classid = $("a.curr").attr('tag');
       if(title == searchtext) 
           title = "";
       var url = '<?= geturl('troomv2/myask/classquestion') ?>' + '?classid='+classid+'&q='+title;
       document.location.href = url;
   });
   });

function _search(classid){
       var title = $("#title").val();
       if(title == searchtext) 
           title = "";
       var url = '<?= geturl('troomv2/myask/classquestion') ?>' + '?classid='+classid+'&q='+title;
       document.location.href = url;
   }
function delask(qid,title) {
    var url = '<?= geturl('troomv2/myask/delask') ?>';
    var successurl = '<?= geturl('troomv2/myask/myquestion') ?>';
	$.confirm("您确定要删除问题 【" + title + "】 吗？",function(){
		$.ajax({
			url:url,
			type:'post',
			data:{'qid':qid},
			dataType:'text',
			success:function(data){
				if(data=='success'){
					$.showmessage({message:'问题删除成功！'});
					document.location.href = successurl;
				}else{
					$.showmessage({message:'对不起，问题删除失败，请稍后再试！'});
				}
			}
		});
	});
}
$(function(){
		$('.datatab tr:last td').css('border-bottom','none');
	});
</script>
<?php 
$this->display('troomv2/page_footer'); 
?>