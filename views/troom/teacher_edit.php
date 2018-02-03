<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script type="text/javascript">
	function loadReady() {
		var h = demoIframe.contents().find("body").height();
		if (h < 600) h = 600;
		demoIframe.height(h);
	}
  </script>
  <div class="ter_tit">
		当前位置 > <a href="<?= geturl('troom/teacher') ?>">教师管理</a> > 修改教师
  </div>
	<div class="lefrig">
<div class="annotate">请输入要加入本教室的教师账号,如该账号不存在,请输入该账号密码,同时请为该教师分配操作权限和授权范围.</div>
<form id="editform">
    <input type="hidden" name="tid" value="<?= $this->uri->itemid ?>" />
		<table class="addteacher_tab" width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<th><label>教师帐号：</label></th>
			<td><input class="uipt w340" name="tname" value="<?= $teacher['username'] ?>" readonly="readonly" id="ctname" type="text" /><span class="ts2" id="tname_msg"></span>
			</td>
		  </tr>
		  <tr>
			<th><label>教师权限：</label></th>
			<td>
			<?php foreach ($modulelist as $module) { ?>
				
                                <label><input type="checkbox" name="module[]" <?= in_array($module['catid'], $mymodules)? 'checked="checked"':''?> value="<?= $module['catid']?>" style="margin-top:2px;*margin-top:-2px;float:left;" /><span style="float:left;margin-left:2px;"><?= $module['name']?></span></label>
                                <?php } ?>
			</td>
		  </tr>
		  <tr>
			<th><label>授权范围：</label></th>
			<td>
				<div class="fenzu">
                                    <ul id="tree1" class="tree" style="width:356px; _height:293px; min-height:293px; overflow:auto; overflow-y:hidden; padding-bottom:15px;">
                                        <?php foreach($folders as $folder) { ?>
                                        <li style="float:left;width:320px;line-height: 28px;font-size: 14px;"><input type="checkbox" id="folderid_<?= $folder['folderid']?>" name="folder[]" <?= in_array($folder['folderid'], $myfolders)? 'checked="checked"':''?> value="<?= $folder['folderid']?>" style="margin-top:7px;*margin-top:3px;float:left;margin-left: 5px;"><span style="float:left;margin-left:2px;width:300px;"><label for="folderid_<?= $folder['folderid']?>" style="width:290px;"><?= $folder['foldername'] ?></label></span></li>
                                        <?php } ?>
                                    </ul>
				</div>							
			</td>
		  </tr>
		  <tr>
		  	<td></td>
		  	<td>
		  	<input class="lanbtn" type="button" value="保 存" style="cursor:pointer;" name="addteacher">
		 	<input class="huibtn marlef" type="button" onclick="window.history.back(-1);" value="返 回" />
		  	</td>
		  </tr>
		 </table>
		 
		</form>
		</div>
<script type="text/javascript">
var _bname = false;
var _bpwd = true;
var _bcpwd = true;
$(function(){
	$(".lanbtn").click(function(){
               var url = "<?= geturl('troom/teacher/edit') ?>";
		$.ajax({
			type:'post',
			url:url,
			dataType:'json',
			data:$("#editform").serialize(),
			success:function(data){
                            if(data != null && data != undefined && data.status == 1) {
                                $.showmessage({
                                   img : 'success',
                                   message:'修改添加成功',
                                   title:'修改教师',
                                   callback :function(){
                                        document.location.href = "<?= geturl('troom/teacher') ?>";
                                   }
                               });
                           } else {
                           var message = "教师修改失败，请稍后再试或联系管理员。";
                           if(data != null && data != undefined && data.message == undefined)
                            message = data.message;
                               $.showmessage({
                                   img : 'error',
                                   message:message,
                                   title:'修改教师'
                               });
                           }
                        }
                });
        });
});

</script>
<?php $this->display('troom/page_footer'); ?>