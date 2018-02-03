<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
		<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
		<?php }?>
		<title><?= empty($subtitle) ? $this->get_title() : $subtitle.'-'. $this->get_title() ?></title>
		<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
		<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
		<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css?v=20170206103772"/>
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css?v=20160913002"/>
		<link rel="stylesheet" href="http://static.ebanhui.com/forum/css/forum.css?v=20170407002" />
		<link rel="stylesheet" href="http://static.ebanhui.com/forum/css/jupload.css" />
		<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/forum/js/upload.js"></script>
	</head>
	<script>

	$(function(){
		<?php if(empty($notop)){?>
		if (top.location == self.location) {
			setCookie('ebh_refer',encodeURIComponent(self.location),10,'/','.<?=$this->uri->curdomain?>');
			
			top.location='/aroomv2.html';
	    }
		<?php }?>
	});
	</script>
	<body>
		<div class="ter_tit">
			当前位置 > <a href="/aroomv2/more.html">更多应用</a> > 社区管理
		</div>
		<div class="forum">
			<div class="kechengguanli_top fr">
				<ul>
					<li class="fl "><a href="javascript:;">新建社区</a></li>
				</ul>
			</div>
			<div class="forum_tab">
				<ul>
					<li><a href="javascript:;" class="community">社区管理</a><span></span></li>
					<li><a href="/aroomv2/forumsubject.html" class="invitation">帖子管理</a><span style="display: none;"></span></li>
				</ul>
			</div>
			<div class="forum_bottom">
				<div class="default_img">
					<img src="http://static.ebanhui.com/forum/img/nodata.png" />
				</div>
				<table cellpadding="0" cellspacing="0" class="tables">
					<tr class="first">
						<td width="76">序列</td>
						<td width="130">社区名</td>
						<td width="90">帖子数量</td>
						<td width="156">排序</td>
						<td width="80">版主</td>
						<td width="65">聊天室</td>
						<td width="176">操作</td>
					</tr>
					<?php 
						$number = 0;
						if($pageNum == 0 || $pageNum == 1){
							$pageNum = 0;
						}else if($pageNum >= 2){
							$pageNum = 20*($pageNum - 1);
						}
					?>
					<?php foreach($list as $key=>$forum){ ?>
					<?php 
						$number++;
					?>
					<tr>
						<td width="76" style="word-break: break-all; word-wrap:break-word;"><?php echo ($pageNum+$number);?></td>
						<td width="130" style="word-break: break-all; word-wrap:break-word;"><?=$forum['name']?></td>
						<td width="90"><?=$forum['subject_count']?></td>
						<td width="156"><div class="save"><span class="save_img"></span><span class="save_num"><?=$forum['sort']?></span></div><div class="sort" style="display:none;">

						<input type="txt" value="<?=$forum['sort']?>" class="sort_text" data-fid="<?=$forum['fid']?>" data-sort="<?=$forum['sort']?>"><a href="javascript:;" class="sort_confirm">确定</a><a href="javascript:;" class="sort_cancel">取消</a></div></td>
						<td width="80" style="word-break: break-all; word-wrap:break-word;"><?=$forum['manager']?></td>
						<td width="65"><span class="chat_btn <?php if($forum['open_chatroom'] == 1){?>chat<?php }else{ ?>chatclose<?php } ?>" data-fid="<?=$forum['fid']?>"></span></td>
						<td width="176"><a href="javascript:;" class="compile edit-btn" data-fid="<?=$forum['fid']?>">编辑</a><a href="javascript:;" class="delete" data-fid="<?=$forum['fid']?>">删除</a>

						<a href="javascript:;" class="close" data-fid="<?=$forum['fid']?>" data-isclose=<?=$forum['is_close']?>><?php if($forum['is_close'] == 1){?>开启<?php }else{ ?>关闭<?php } ?></a></td>
					</tr>
					<?php } ?>
					
				</table>
			</div>
		</div>
		<?=$pagestr?>
		<!--新建教社区-->
	<div id="addtgroups" class="addpopup" style="display:none">
	<form action="" id="forum_form">
		<input type="hidden" name="fid">
		<div class="comm_name">社区名称 ： <input type="text" name="name" value=""/></div>
		<input type="hidden" name="image" id="img_src">
		<div class="comm_img">图标 ：<input type="file" name="Filedata" class="jupload-file"><span class="img_fail">上传失败 ！</span><span class="img_browse">图片预览</span>&nbsp;&nbsp;&nbsp;<span class="img_success">上传成功 !</span><span class="img_effect"><img src=" " /></span></div>
		<div class="comm_call"><span>社区简介 ： </span><textarea name="notice"></textarea></div>
		<div class="comm_list"><span class="list_title">帖子分类 ：</span>
			<div class="list_box">
				
				<div class="list_once"><input type="text"/><span class="sign"><span class="sign_top"></span><span class="sign_bottom"></span></span><a href="javascript:;" class="comm_delete" onClick="Delete(this)">删除</a><a href="javascript:;" class="comm_add" style="display: inline-block;">添加</a></div>
			</div>
		</div>
		<div class="comm_user">
			<span class="user_title">版主 ：</span>
			<div class="add_user">
				<ul id="manager-list">

				</ul>
				<div class="addBtn"><span class="addImg"></span>添加版主</div>
			</div>
		</div>
	</form>
	</div>
<!--添加版主-->
	<div id="adduser" style="display:none;">
		<div class="adduser_top"></div>
		<div class="adduser_content">
			<div class="content_top">
				<ul id="select-manager-list">
					
				</ul>
			</div>
			<div class="content_bottom">
				<div class="search">
					<span>教师列表</span>
					<input type="text" placeholder="请输入老师姓名或账号" id="teachername"/>
					<button type="button" Onclick="allteacher($('#teachername').val())">搜索</button>
				</div>
				<div class="select_list">
					<ul>
						<?php foreach($teachers as $teacher) {?>
						<li><input class="search_btn" type="checkbox"  data-realname="<?php echo !empty($teacher['realname']) ? $teacher['realname'] : $teacher['username']?>" data-username="<?=$teacher['username']?>"  data-uid="<?=$teacher['uid']?>" /><span class="teach_name"><?php echo !empty($teacher['realname']) ? $teacher['realname'] : $teacher['username']?></span><span class="account_num">(<?=$teacher['username']?>)</span></li>
						<?php  } ?>
						
					</ul>
				</div>
			</div>
		</div>
	</div>
<!--删除操作-->
	<div id="delete_operate" style="display:none;">
		<div class="operate_content">确定删除该社区？</div>
	</div>	
	</body>
	<script type="text/javascript" src="http://static.ebanhui.com/forum/js/forum.js?v=20170407004"></script>
	<script>
		var test = window.location.href;
		if(test.indexOf("www.leblue") != -1){
			$('#tealist').text('讲师列表');
			$('#teainpname').attr('placeholder','请输入讲师姓名或账号');
		}else{
			$('#tealist').text('教师列表');
			$('#teainpname').attr('placeholder','请输入教师姓名或账号');
		};
	</script>
</html>
