<?php
	$this->display('admin/header');
?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>频道设置</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
				<tr>
					<td ><a href="#" class="view">频道设置</a></td>
					<td  class="active"><a href="/admin/channel/add.html?position=<?=$position?>" class="add">创建频道</a></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table cellspacing="2" cellpadding="2" class="helptable"><tr><td><ul>
	<li>系统内置了课件、平台平台、平台展示频道、资讯等频道。您可以为这些频道进行重新命名，并确定是否显示在站点菜单上面。</li>
	<li>如果您在站点<u>系统设置</u>里面未开启某个频道功能，则该频道不会显示在站点菜单上面。</li>
</ul></td></tr></table><form method="post" action="/admin/category/op.html" onsubmit="return checkAll()">
<input type="hidden" name="op" value="<?=$op?>" />
<input type="hidden" name="token" value="<?=$token?>" />
<input type="hidden" name="catid" value="<?=$catid?>">
<input type="hidden" name="tag" value="channel">
<input type="hidden" name="position" value="<?=$position?>">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
	<th>上级分类<p></p></th><td>
	<select name="upid" id="upid">
		<option value="0">根目录</option>
		<?php $this->widget('category_widget',array('where'=>array('position'=>$position),'tag'=>'upid','selected'=>$catinfo['upid'])); ?>
	</select>
	</td>
</tr>
<tr><th>频道名<span>＊</span></spam></th><td><input type="text" class="w300"  class="w150"id="name" name="name" value="<?=$catinfo['name']?>"   onblur="check_name()" ></td></tr>
<tr><th>频道类型<p>该频道下的所属分类属于哪种类型。</p></th><td>
<select id="type"  name="type">
<option value="courseware" <?php if($catinfo['type']=='courseware')echo 'selected=selected';?> >课件</option>
<option value="news"  <?php if($catinfo['type']=='news')echo 'selected=selected';?>>资讯</option>
<option value="folder"  <?php if($catinfo['type']=='folder')echo 'selected=selected';?>>目录</option>
<option value="ad"  <?php if($catinfo['type']=='ad')echo 'selected=selected';?>>广告</option>
<option value="link"  <?php if($catinfo['type']=='link')echo 'selected=selected';?>>友情链接</option>
<option value="poll"  <?php if($catinfo['type']=='poll')echo 'selected=selected';?>>投票</option>
<option value="promotion"  <?php if($catinfo['type']=='promotion')echo 'selected=selected';?>>促销</option>
</select>
</td>
</tr>
<tr>
	<th>英文ID<span>＊</span><p>不要包含下划线，且英文ID不能重复。</p></th>
	<td><input type="text" class="w300" id="code" name="code" value="<?=$catinfo['code']?>"   onblur="check_code()"   class="w150"></input>
	</td>
</tr>
<tr>
	<th>前台是否可见<p>频道在前台页面中是否可见</p></th>
	<td><input type="radio" name="visible"  value="1" <?php if($catinfo['visible']==1)echo 'checked=checked';?> />前台可见&nbsp;&nbsp;<input type="radio" name="visible" value="0" <?php if($catinfo['visible']==0)echo 'checked=checked';?> />前台不可见
	</td>
</tr>
<tr>
	<th>是否系统数据<p>设置为系统数据后，将不能修此状态</p></th>
	<td><input type="radio" name="system" id='system' value="1"  <?php if($catinfo['system']==1)echo 'checked=checked';?> />系统数据&nbsp;&nbsp;<input type="radio"  name="system" id="system2" value="0" <?php if($catinfo['system']==0)echo 'checked=checked';?> />非系统数据
	</td>
</tr>
<tr id="ischanneltr" style='display:none;'>
	<th>是否频道</th>
	<td><input type="radio" name="ischannel"  value="1" <?php if($catinfo['ischannel']==1)echo 'checked=checked';?> />是&nbsp;&nbsp;<input type="radio" name="ischannel" value="0" <?php if($catinfo['ischannel']==0)echo 'checked=checked';?> />否
	</td>
</tr>
<tr>
	<th>关键字<p>该关键字将显示在频道页面的 Meta Keywords 中。</p></th>
	<td><input type="text" class="w300" class="p98" id="keyword" name="keyword" value="<?=$catinfo['keyword']?>"></input></td>
</tr>
<tr>
	<th>描述<p>该描述将显示在频道页面的 Meta Description 中。</p></th>
	<td><input type="text" class="w300" class="p98" id="description" name="description" value="<?=$catinfo['description']?>"></input></td>
</tr>
<tr>
	<th>显示顺序</th>
	<td><input type="text" class="w50" id="displayorder" name="displayorder" value="<?=$catinfo['displayorder']?>"   onblur=""  ></input></td>
</tr>
<tr>
	<th>频道首页模版文件<p>您可以为该频道指定一个模板文件。模板文件必须放置在指定的目录下面，且后缀为 .html.php 。当指定的模板文件不存在的时候，则使用默认模板。</p>
	</th>
	<td>目录名：templates/default/<br>文件名：<input type="text" class="w150" id="tpl" name="tpl" value="<?=$catinfo['tpl']?>">.html.php</input></td>
</tr>
<tr>
	<th>频道分类页模版文件<p>您可以为该分类指定一个模板文件。模板文件必须放置在指定的目录下面，且后缀为 .html.php 。当指定的模板文件不存在的时候，则使用默认模板。</p>
	</th>
	<td>目录名：templates/default/<br>文件名：<input type="text" class="w150" id="categorytpl" name="categorytpl" value="<?=$catinfo['categorytpl']?>">.html.php</input>
	</td>
</tr>
<tr>
	<th>分类查看页面模版<p>您可以为该分类的内容指定一个模板文件。模板文件必须放置在指定的目录下面，且后缀为 .html.php 。当指定的模板文件不存在的时候，则使用默认模板。</p>
	</th>
	<td>目录名：templates/default/<br>文件名：<input type="text" class="w150" id="viewtpl" name="viewtpl" value="<?=$catinfo['viewtpl']?>">.html.php</input>
	</td>
</tr>
<tr>
	<th>频道封面<p>您可以为该频道设置一个介绍性的封面图片。</p></th>
	<td>
		<?php
		  if(empty($catinfo['thumb'])){
		    $Upcontrol->upcontrol('thumb',1,null,'pic');
		  }else{
		    $Upcontrol->upcontrol('thumb',1,array('upfilepath'=>$catinfo['thumb']),'pic');
		  }
		?>
	</td>
</tr>
<tr>
	<th>显示图</th>
	<td>
		<?php
		  if(empty($catinfo['image'])){
		    $Upcontrol->upcontrol('image',1,null,'pic');
		  }else{
		    $Upcontrol->upcontrol('image',1,array('upfilepath'=>$catinfo['image']),'pic');
		  }
		?>
	</td>
</tr>
<tr>
	<th>URL跳转地址<p>输入一个URL地址，则浏览该频道时，页面自动跳转到指定的链接地址。</p></th>
	<td><input type="text" class="w300" class="w300" id="caturl" name="caturl" value="<?=$catinfo['caturl']?>"></input></td>
</tr>
<tr>
	<th>打开方式<p>点击该频道时，页面的打开方式。</th>
	<td>
		<select id="target" name="target">
		<option value="" <?php if($catinfo['target']=='')echo 'selected';?>>本页打开</option>
		<option value="_blank" <?php if($catinfo['target']=='_blank')echo 'selected';?>>新窗口打开</option>
		</select>
	</td>
</tr>
<tr>
	<th>所属域名<p>所属的域名</p></th>
	<td><select id="domain" name="domain"></select></td>
</tr>
<tr>
	<th>频道位置<p>频道在页面中显示的位置</p></th>
	<td>
		<select id="position" name="position">
			<option value="0"  <?php if($position==0)echo 'selected';?>>未指定</option>
			<option value="1"  <?php if($position==1)echo 'selected';?>>页头栏目</option>
			<option value="2"  <?php if($position==2)echo 'selected';?>>页脚栏目</option>
			<option value="3"  <?php if($position==3)echo 'selected';?>>顶部栏目</option>
			<option value="4"  <?php if($position==4)echo 'selected';?>>云教育网校</option>
			<option value="5"  <?php if($position==5)echo 'selected';?>>答疑分类</option>
		</select>
	</td>
</tr>
<tr><th>适用操作</th><td>
<?php $this->widget('operation_widget',array('opvalue'=>$catinfo['opvalue'],'position'=>'1,3,5'))?>
</td></tr>
</table>

<div id="dialog"></div><div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit"/>
<input type="reset"	 name="valuereset" value="重置"/>
</div>
</form><br>
<script type="text/javascript">
  function check_name(){
    var $name = $("#name");
    var $area = $name.parent('td');
    $("em",$area).remove();
    $name.val($.trim($name.val()));
    if($name.val().length<1){
      $area.append('<em class="error">名称不能为空</em>');
      $("html,body:not(:animated)").animate({scrollTop:$name.offset().top-50},1000);
      return false;
    }
    return true;
  }

  function check_code(){
    var $code = $("#code");
    $code.prop('tag',true);
    $code.val($.trim($code.val()));
    var $area = $code.parent('td');
    $("em",$area).remove();
    if($code.val().length<1){
      $area.append('<em class="error">ID不能为空</em>');
      $("html,body:not(:animated)").animate({scrollTop:$code.offset().top-50},1000);
      return false;
    }else if(/_/.test($code.val())){
       $area.append('<em class="error">ID不能含有下划线</em>');
      $("html,body:not(:animated)").animate({scrollTop:$code.offset().top-50},1000);
       return false;
    }else{
      $.ajax({
        type:'post',
        url:'/admin/category/checkRepeatID.html',
        data:{code:$code.val(),op:"<?=$op?>"},
        success:function(message){
          if(message==0){
            $area.append('<em class="error">ID重复</em>');
            $("html,body:not(:animated)").animate({scrollTop:$code.offset().top-50},1000);
            $code.prop('tag',false);
          }
        },
        async:false
      });
      
    }
    return $code.prop('tag')&&true;
  }
  function checkAll(){
    return(check_name()&&check_code());
  }
</script>
</body>
<?php
  $this->display('admin/footer');
?>








