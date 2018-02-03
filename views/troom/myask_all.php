<?php $this->display('myroom/page_header'); ?>
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
    color: #808080;
}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<div class="ter_tit">
当前位置 > <a href="<?= geturl('myroom/myask') ?>">互动答疑</a> > 全部问题
<div class="diles">
	<?php
		$q= empty($q)?'':$q;
		if(!empty($q)){
			$stylestr = 'style="color:#000"';
		}else{
			$stylestr = "";
		}
	?>
	<input name="uname" <?=$stylestr?> class="newsou" id="title" value="<?= empty($aq)?$q:$aq ?>"  type="text" />
	<input type="button" id="ser" class="soulico" value="">
</div>
</div>
<div class="lefrig" style="border:solid 1px #cdcdcd;background:#fff;float:left;margin-top:15px;">
<div class="workol">
	<div class="work_mes">
		<ul>
			<li class="workcurrent"><a href="<?= geturl('myroom/myask/all') ?>"><span>全部问题</span></a></li>
			<li><a href="<?= geturl('myroom/myask/myquestion') ?>"><span>我的问题</span></a></li>
			<li><a href="<?= geturl('myroom/myask/myanswer') ?>"><span>我的回答</span></a></li>
			<li><a href="<?= geturl('myroom/myask/myfavorit') ?>"><span>我的关注</span></a></li>
		</ul>
	</div>

			<div class="workdata" style="margin-top:0px;float:left;">
				<table  width="100%" class="datatab" style="border:none;">
			 	 <thead class="tabhead" >
			  	</thead>
			  	<tbody>
						<?php if(empty($asks)) { ?>
			  			<tr>
							<td colspan="6" align="center" style="border-top:none;">目前没有问题记录</td>
						</tr>
                         <?php } else { ?>
									<?php foreach($asks as $akey=>$avalue) { ?>
										 <?php 
										//var_dump($avalue);
											if(!empty($avalue['face'])){
												$face = getthumb($avalue['face'],'50_50');
											}else{
												if($avalue['sex']==1){
													$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
												}else{
													$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
												}
											
												$face = getthumb($defaulturl,'50_50');
											} 
										?>                
																	
									<tr>
										<td style="border-top:none;">
											<?php $name=empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?>
												<div style="float:left;margin-right:15px;"><a href="all.html?aq=<?= $name?>"><img title="<?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?>" src="<?=$face?>" /></a></div>
													<div style="float:left;width:690px;font-family:Microsoft YaHei;">
														<p style="width:580px;word-wrap: break-word;margin-bottom:10px;font-size:14px;;float:left;line-height:2;">
															<a  href="<?= geturl('myroom/myask/'.$avalue['qid']) ?>">
															<?php if($avalue['status']==1){ ?>
																<img src="http://static.ebanhui.com/ebh/tpl/default/images/title.png" style="margin-right:5px;"/>
																<?php } ?>
															<?= shortstr($avalue['title'],40) ?>
															</a>
														</p>

														<span class="dashu">回答数<br/><?= $avalue['answercount'] ?></span>
													<div style="float:left;width:550px;">
													<span style="width:150px;float:left;"><?= Date('Y-m-d H:i:s',$avalue['dateline']) ?></span>
													<span class="huirenw" style="width:100px;float:left;"><?= empty($avalue['realname'])?$avalue['username']:$avalue['realname'] ?></span>
													<span class="ketek"><?= $avalue['foldername'] ?></span>
													
													
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
<script type="text/javascript">
var searchtext = "请输入关键字";
$(function() {
   initsearch("title",searchtext);
   $("#ser").click(function(){
       var title = $("#title").val();
       if(title == searchtext) 
           title = "";
       var url = '<?= geturl('myroom/myask/all') ?>' + '?q='+title;
       document.location.href = url;
   });
});
</script>
<?php $this->display('myroom/page_footer'); ?>