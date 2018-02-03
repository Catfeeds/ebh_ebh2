<?php $this->display('myroom/page_header'); ?>
<style>
	.datatab tr{
		cursor: default;
	}
	.datatab td {
		/*border: 1px solid #D2D2D2;*/
		color: #666666;
	}
	.alpha_img {
		height: 100%;
		width: 1px;
		vertical-align: middle;
	}
	.show_img {
		vertical-align: middle;
	}
	.newku {
		border: 1px solid #CDCDCD;
		float: left;
		font-size: 0;
		height: 126px;
		margin-left: 25px;
		display: inline;
		padding: 2px 0;
		text-align: center;
		width: 130px;
		background-color: #fff;
	}
	.noborder{
		border: 0;
	}
	div.iadetail{
		display: block;
		width: 100%;
		padding-left:40px; 
		height: 40px;
		line-height: 40px;
		overflow: hidden;
		position: relative;
	}
	.answerpanel{
		height:30px;
		text-align:center;
		float:left;
		padding:5px 22px;
	}
	.hasdo{
		background-position: 63px -13px;
	}
	.notdo{
		background-position: 104px -15px;
	}
	.dotag{
		background-image:url("http://static.ebanhui.com/ebh/tpl/2014/images/iatag.png");
		position: absolute;
		display: block;
		width: 36px;
		height: 36px;
		top:6px;
		left: 0;
	}
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<script src="http://static.ebanhui.com/ebh/js/file.js" type="text/javascript"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/artDialog/artDialog.js?skin=blue"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen">
<div class="ter_tit">
	当前位置 > 互动课堂记录
</div>
<div class="lefrig">
	<div class="diles">
		<?php
			$q= empty($q)?'':$q;
			if(!empty($q)){
			$stylestr = 'style="color:#000"';
			}else{
				$stylestr = "";
			}
		?>
		<input name="title" <?=$stylestr?> class="newsou" id="title" value="<?= $q?>" type="text" />
		<input type="button" class="soulico" value="" id="searchbutton">
	</div>

	<div class="workol">
		   
		    <div class="workdata" style="width:788px;border-bottom: 1px solid #D2D2D2;*border-bottom: none;">
		    	<table width="100%" class="datatab"  id="ialog">
					<thead class="tabhead">
						<tr style="border: 1px solid #D2D2D2;">
							<th style="text-align:center;">互动详情</th>
							<th style="text-align:center;">答题状况</th>
						</tr>
					</thead>
					 <tbody>

					 <?php if(!empty($ialogs)) { ?>
						 <?php foreach($ialogs as $ialog) { ?>
						  <tr id="icid_<?=$ialog['icid']?>" i_icid="<?=$ialog['icid']?>" i_resource="<?=$ialog['resource']?>"  i_img="<?=$ialog['img']?>" style="height:185px;">
							<td style="width:74%">
								<div class="iadetail"><span title="<?=!empty($ialog['img'])?'已答':'未答'?>" class="dotag <?=!empty($ialog['img'])?'hasdo':'notdo'?>">&nbsp;</span><span>互动标题:</span><?= shortstr($ialog['title'],70) ?></div>
								<div class="iadetail"><span>发布老师:</span><?= shortstr($ialog['uid_name'],70) ?></div>
								<div class="iadetail"><span>发布时间:</span><?= date('Y-m-d H:i:s',$ialog['dateline']) ?></div>
							</td>
							
						  <?php if(!empty($ialog['img'])){?>
								<td style="width:26%">
									<div class="newku">
										<a href="<?=$ialog['img']?>">
											<img class="show_img" src="<?=getthumb($ialog['img'],'126_126')?>">
											<img class="alpha_img" src="http://static.ebanhui.com/ebh/tpl/2012/images/pixel.gif"> 
										</a>
									</div>

									<div class="answerpanel">
										<a class="previewBtn" onclick="before_doanswer(<?=$ialog['icid']?>,1)" href="javascript:void(0)">修改</a>
										<a class="previewBtn" onclick="before_doanswer(<?=$ialog['icid']?>,2)" href="javascript:void(0)">重做</a>
									</div>
								</td>
						  	<?php }else{?>
								<!-- <td style="width:50%"><span style="display:block;width:41px;height:22px;float:left;text-align:center;margin-right:5px;"></span></td> -->
						  		<td style="width:26%">
									<div class="newku noborder">
										
									</div>
									<div class="answerpanel">
										<a class="previewBtn" style="margin-left:33px;" onclick="before_doanswer(<?=$ialog['icid']?>,1)" href="javascript:void(0)">答题</a>
										<!-- <a class="previewBtn" onclick="before_doanswer(<?=$ialog['icid']?>,2)" href="javascript:void(0)">重做</a> -->
									</div>
								</td>
						  	<? }?>
						  </tr>
						 <?php } ?>
						 
					 <?php } else { ?>
							 <tr>
					 		<td colspan="6" align="center">暂无记录</td>
					 	</tr>
					 <?php } ?>
						</tbody>
					</table>
		    </div>
	</div>
					<?= $pageStr ?>
</div>
<script>
	var searchText = "请输入搜索关键字";
	$(function(){
		initsearch("title",searchText);
		$("#searchbutton").click(function(){
			searchs();
		});
	});
	function searchs(){
		var title = $.trim($("#title").val());
		if(title == searchText){
			title = "";
		}
		var url = '/myroom/iaclassroom.html?q='+title;
		location.href = url;
	}

	$(function(){
		try{
			window.parent.showimage('#ialog .newku a');
		}catch(error){
			
		}
	});


	//从flash对话框点击了确定按钮的回调函数的调用函数
	function okCallback(swf){
		var submitD=top.dialog({
	        width:350,
	        content: "<p>正在提交，请耐性等待</p>"
		}).show();
		$.ajax({
			type	:'POST',
			url		:"/myroom/iaclassroom/answer.html",
			data:{'icid':H.get('hdkt').getData("icid"),'FileName':HTools.getFlash('hdktswf').swf.getImage()},
			dataType:'json',
			success	:function(data){
				H.get('hdkt').exec('destroy');
				if(data.status == 0){
					submitD.close().remove();
					top.dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='TPic'></div><p>提交成功</p>",
						onshow:function(){
							var that=this;
							setTimeout(function () {
								that.close().remove();
								location.reload();
							}, 1000);
						}
					}).show();
				}else{
					submitD.close().remove();
					top.dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='FPic'></div><p>"+data.msg+"</p>",
						onshow:function(){
							var that=this;
							setTimeout(function () {
								that.close().remove();
								location.reload();
							}, 2000);
						}
					}).show();
				}
			}
		});
	}


	var H = top.window.H;
	var P = top.window.P;
	var xButton = top.window.xButton;
	var HTools = top.window.HTools;
	var xFparam = {
		id:'hdktswf',
		uri:'http://'+window.location.host+'/static/flash/couseEditor.swf'
	}
	var button = new xButton();

	button.add({
        value: '提交',
        callback: function () {
           	okCallback(HTools.getFlash('hdktswf'));
           	return false;
        },
        autofocus: true
	});
	button.add({
        value: '取消',
        callback: function () {
        	H.get('hdkt').exec('close');
           	return false;
        }
	});

	H.create(new P({
		id:'hdkt',
		title:'互动课堂答题板',
		easy:true,
		flash:HTools.pFlash(xFparam),
		button:button
	},{'onshow':function(){
		showCallback();
	}}),'common');

	function doanswer(info){
		if(!info.i_icid){
			return;
		}
		H.get('hdkt').setData("icid",info.i_icid);
		if(info.i_img){
			H.get('hdkt').setData("img",info.i_img);
		}else if(info.i_resource){
			H.get('hdkt').setData("img",info.i_resource);
		}
		H.get('hdkt').exec('show');
	}

	function before_doanswer(icid,mode){
		H.get('hdkt').clearDatas();
		var i_info = {
				i_icid:$("#icid_"+icid).attr("i_icid"),
				i_resource:$("#icid_"+icid).attr("i_resource"),
				i_img:$("#icid_"+icid).attr("i_img")
			};
		if(mode == 1){//做题

		}else if(mode == 2){//重做
			delete i_info.i_img;
		}
		doanswer(i_info);
	}

	function showCallback(){
		var img = H.get('hdkt').getData('img');
		if(img){
			var swf = HTools.getFlash('hdktswf').swf;
			if(swf&&swf.pushImage){
				swf.pushImage(img);
			}else{
				setTimeout(function(){
					showCallback(swf);
				},200);
			}
		}
	}
</script>
<?php $this->display('myroom/page_footer'); ?>