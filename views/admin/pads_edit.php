<?php $this->display('admin/header');?>
<body id="main">
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	  <tr>
  		<td><h1>广告管理</h1></td>
  		<td class="actions">
  			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
    			<tr><td ><a href="/admin/pads.html">浏览广告</a></td>
    			   <td  class="active"><a href="/admin/pads/add.html" class="add">添加广告</a></td>
    			</tr>
  			</table>
  		</td>
	</tr>
</table>
<table cellspacing="2" cellpadding="2" class="helptable">
  <tr>
    <td>
      <ul>
	     <li>您可以添加不同格式的广告，包括文字链接和图片链接等格式。</li>
	     <li>通过点击广告代码链接，您可以获取指定广告的显示代码，请将该代码复制，并放置于站点模板文件要显示广告的位置，就可以显示您指定的广告了。 </li>
      <li>创建完成后可到模板模块向导中获取代码 。 </li>
      </ul>
    </td>
  </tr>
</table>

<form method="post" action="/admin/pads/edit.html" onsubmit="return check();">
  <input type="hidden" name='aid' value="<?=$ad['aid']?>" />
  <table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
  <br /><br />
  <tr>
    <th>广告标题<span>＊</span></th>
    <td><input maxlength="200" class="w300" type="text" name="subject" id="subject"  value="<?=$ad['subject']?>"   onblur="return checktext()" />
    </td>
  </tr>
  <tr><th>广告分类<span>＊</span></th>
    <td>
      <?=$ptypeselect?>
    </td>
  </tr>
<tr>
  <th>投放频道<span>＊</span><p></p></th>
  <td>
      <?=$pcateselect?>
  </td>
</tr>

<tr>
  <th>投放时间<p>即该条广告投放的时间段，如果不指定投放时间段，则一直投放。</p></th>
   <td>从<input type="text" id="begintime" name="begintime" class="w150" value="<?php $ad['begintime']=empty($ad['begintime'])?time():$ad['begintime']; echo date('Y-m-d H:i',$ad['begintime']);?>" onfocus="$(this).datetimebox({showSeconds:false});" />
       开始到 <input type="text" id="endtime" name="endtime"   class="w150"  value="<?php $ad['endtime']=empty($ad['endtime'])?strtotime('+ 1 year'):$ad['endtime']; echo date('Y-m-d H:i',$ad['endtime']);?>" onfocus="$(this).datetimebox({showSeconds:false});" />
       结束
  </td>
</tr>

<tr>
  <th>广告图片<p></p></th>
  <td>
<?php
  if(empty($ad['thumb'])){
    $Upcontrol->upcontrol('thumb',1,array(),'pic');
  }else{
    $Upcontrol->upcontrol('thumb',1,array('upfilepath'=>$ad['thumb']),'pic');
}
?>
</td>
</tr>
<tr>
  <th>外部链接URL<p>如果填入外部链接，查看该资讯时，将自动跳转到该链接,如果没有外部链接请填入#号。</p></th>
  <td><input type="text"  name="linkurl" class="w300" value="<?=$ad['linkurl']?>" /></td>
</tr>
<tr>
  <th>排列顺序</th>
  <td><input type="text"  name="displayorder" id="displayorder" class="w50" value="<?=$ad['displayorder']?>" onblur="return check_num()" /></td>
</tr>
           
<tr>
  <th>锁定状态</th>
  <td>
 <input type="radio" name="status" value="1" <?php if($ad['status']=='1') echo 'checked=checked' ?>>不锁定
    <input type="radio" name="status" value="2" <?php if($ad['status']=='2') echo 'checked=checked' ?>>锁定
  </td>
</tr> 
<tr>
  <th>广告详情</th>
  <td colspan="2" style="padding:0;">
     <?php $editor->createEditor('message',"100%","500px",$ad['message']); ?>
  </td>
</tr>
</table>
<div class="buttons">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"	 name="valuereset" value="重置">
</div>
</form>
<br>
<script type='text/javascript'>

    $(function(){
      $("#begintime,#endtime").trigger('focus');
    });
    


  function checktext(){
    var e = $("input[name=subject]");
    var area = e.parent('td');
    $(e).val($.trim($(e).val()));
    var len = $(e).val().length;
    if(len<4||len>200){
      $("em.error,em.success",area).remove();
      area.append('<em class="error">标题长度必须为4至200之间!'+'</em>');
      $("html,body").animate({scrollTop:e.offset().top-50},1000);
      return false;
    }else{
      $("em.error,em.success",area).remove();
      area.append('<em class="success">正确!</em>');
    }
    return true;
  }
  function check_num(){
      var $name = $("#displayorder");
      var $area = $name.parent('td');
      $("em",$area).remove();
      $name.val($.trim($name.val()));
      if(!(/^(([1-9][0-9]*)|([0]{1}))$/.test($name.val()))){
        $area.append('<em class="error">显示顺序为空或者格式不对</em>');
        $("html,body:not(:animated)").animate({scrollTop:$name.offset().top-50},1000);
        return false;
      }
      return true;
  }
  function check(){
    $("em.error,em.success").remove();
    return checktext()&&check_num();
  }
  $(".datebox :text").attr("readonly","readonly");
</script>
</body>
