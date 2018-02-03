<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
		<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
		<?php }?>
		<title><?= empty($subtitle) ? $this->get_title() : $subtitle.'-'. $this->get_title() ?></title>
		<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css?v=20170206103772"/>
		<link rel="stylesheet" href="http://static.ebanhui.com/js/dialog/css/dialog.css?v=20160913002" />
		<link rel="stylesheet" href="http://static.ebanhui.com/forum/css/invitation.css?v=20160913003" />
		<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
	</head>
	<body>
		<div class="ter_tit">
			当前位置 > <a href="/aroomv2/more.html">更多应用</a> > 帖子管理
		</div>
		<div class="forum">
			<div class="forum_tab">
				<ul>
					<li><a href="/aroomv2/forum.html" class="community">社区管理</a><span style="display: none;"></span></li>
					<li><a href="javascript:;" class="invitation">帖子管理</a><span></span></li>
				</ul>
			</div>
			<div class="title_list">
				<form method="get" action="/aroomv2/forumsubject.html">
				<div class="list_noce">
					<span class="describe">社区名称 :</span> 
					<div class="title_name">
						<input type="text" placeholder="全部" readonly="readonly"/>
						<input type="hidden" class="name_hide"  name="forum_id" value="<?=$this->input->get('forum_id')?>"/>
						<div class="name_list">
							<ul>
								
							</ul>
						</div>
						<span class="title_img"></span>
					</div>	
				</div>
				<div class="list_noce">
					<span class="describe">帖子分类 :</span>
					<div class="title_type">
						<input type="text" placeholder="全部" readonly="readonly"/>
						<input type="hidden" class="type_hide" name="cate_id" value="<?=$this->input->get('cate_id')?>"/>
						<div class="type_list">
							<ul>
								
							</ul>
						</div>
						<span class="title_img"></span>
					</div>
				</div>
				<div class="list_noce">
					<input class="search" type="text" name="keyword" value="<?=$this->input->get('keyword')?>" placeholder="请输入关键字"/>
				</div>
				<div class="list_noce">
					<input class="search_btn" type="submit" value="搜索"/>
				</div>	
				</form>
			</div>
			<div class="forum_bottom">
				<div class="default_img">
					<img src="http://static.ebanhui.com/forum/img/nodata.png" />
				</div>
				<table cellpadding="0" cellspacing="0" class="tables">
					<tr class="first">
						<td width="50">序列</td>
						<td width="70">社区名</td>
						<td width="68">帖子分类</td>
						<td width="130">标题</td>
						<td width="60">发帖人</td>
						<td width="110">发帖时间</td>
						<td width="97">查看/回复</td>
						<td width="48">热帖</td>
						<td width="48">置顶</td>
						<td width="89">操作</td>
					</tr>
					<?php 
						$number = 0;
						if($pageNum == 0 || $pageNum == 1){
							$pageNum = 0;
						}else if($pageNum >= 2){
							$pageNum = 20*($pageNum - 1);
						}
					?>
					<?foreach($list as $subject){?>
					<?php 
						$number++;
					?>
					<tr sid-id="<?=$subject['sid']?>">
						<td width="50" style="word-break: break-all; word-wrap:break-word;"><?php echo ($pageNum+$number);?></td>
						<td width="70" style="word-break: break-all; word-wrap:break-word;"><?=$subject['forum_name']?></td>
						<td width="68"><?=$subject['category_name']?></td>
						<td width="130" style="word-break: break-all; word-wrap:break-word"><?=$subject['title']?></td>
						<td width="60" style="word-break: break-all; word-wrap:break-word;"><?=$subject['realname']?$subject['realname']:$subject['username']?></td>
						<td width="110"><?=date('Y-m-d H:i:s',$subject['dateline'])?></td>
						<td width="97"><?=$subject['view_count']?>/<?=$subject['reply_count']?></td>
						<td width="48" style="word-break: break-all; word-wrap:break-word;"><span data-is_hot="<?=$subject['is_hot']?>" class="change_hot <?php if($subject['is_hot'] == 1){?>hot<?php }else{ ?>no_hot<?php } ?>" ></span></td>
						<td width="48" style="word-break: break-all; word-wrap:break-word;"><span data-is_top="<?=$subject['is_top']?>" class="change_stick <?php if($subject['is_top'] == 1){?>stick<?php }else{ ?>no_stick<?php } ?>"></span></td>
						<td width="89"><a href="javascript:;" class="loopUp">查看</a> <a href="javascript:;" class="manage_del" >删除</a></td>
					</tr>
					<?php } ?>
					
				</table>
			</div>
		</div>
		<?=$pagestr?>
<!--删除操作-->
	<div id="delete_operate" style="display:none;">
		<div class="operate_content">确定删除该贴？</div>
	</div>	
	</body>
	<script type="text/javascript" src="http://static.ebanhui.com/forum/js/invitation.js?v=20160913003"></script>
</html>

