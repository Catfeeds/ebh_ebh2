<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		
		<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/sns/css/ftroomv3.css?v=20171016" />
		<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/um/themes/default/css/umeditor.min.css?v=20151015001" />		
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/sns/js/showmessage/jquery.showmessage.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/snsv2/js/blog_change.js?v=20171020002"></script>
		<title></title>
	</head>
	<body>
		<div class="kegher">
			<div class="kjetgrt">
				<h2 class="egjrewe">写日志</h2>
				<div class="kuetds">
					<form id="blogform" onsubmit="return false">
						<div class="blogcntit">
							<input class="klwrf" placeholder="请在这里输入日志标题 " name="title" id="titletxt" value="<?=$blog['title']?>" type="text">
						</div>
						<div class="kretrtd">
						  	<?php EBH::app()->lib('UMEditor')->xEditor('content','958px','600px',$blog['content']);?>
						</div>
						<div class="lketjr">
						<span class="oertrf">设置权限：</span>
						<select class="drtgrt" name="permission" id="perselect">
						  <option value='0' <?php if($blog['permission'] == 0){?>selected="selected"<?php } ?>>公开日志</option>
						  <option value='4'	<?php if($blog['permission'] == 4){?>selected="selected"<?php } ?>>私密日志</option>
						</select>
						<span class="oertrf" style="margin-right: 20px;"><a href="javascript:;" class="addCate" id="addCate">添加分类</a></span>
						<span class="oertrf">日志分类：</span>
						<select class="drtgrt" name="cate" id="cateselect">
						<?php foreach($cates as $cate){ ?>
						  <option <?if($cate['cid'] == $blog['cid']){?>selected="selected"<?}?> value="<?=$cate['cid']?>"><?=$cate['catename']?></option>
						<?php } ?>
						</select>
						<div class="lstdit">
						<a href="/sns/blog.html" class="fewhrt" id="cancelpub">取 消</a>
						<a href="javascript:;" class="birugr" id="edit">保 存</a>
						</div>
						</div>
						<input name="action" value="edit" type="hidden">
						<input type="hidden" id = "_bid" name="bid" value="<?=$blog['bid']?>" />
					</form>
				</div>
			</div>
			<div class="clear"></div>
			<!-- 添加分类弹窗start -->
			<div class="overlay" style="display:none;background-color: #000;background:#000;opacity:0.2;filter:alpha(opacity=20);position: fixed; left: 0px; top: 0px; z-index: 6000; width: 100%; height:100%;">
			</div>
			<div class="etjdd win">
				<div class="qz_dialog_layer_title" style="cursor: move;">
					<h3>添加日志分类</h3>
					<button class="qz_dialog_btn_close" title="关闭">
						<span class="none">╳</span>
					</button>
				</div>
				<div class="add_sort_box" style="width:390px;">
					<div class="add_sort">
						<label>
							分类名称：
							<input id="catename" maxlength="12" type="text">
						</label>
						(最多12个字母或6个汉字)
					</div>
					<div class="global_tip_button" style="margin-top:25px;">
						<button class="gbbtb confirmbtnd">确定</button>
						<button class="gbbtb cancelbtnd">取消</button>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
