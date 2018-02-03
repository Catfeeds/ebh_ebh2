<?php $this->display('admin/header');?>
<body id="main">
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	  <tr>
  		<td><h1>广告管理</h1></td>
  		<td class="actions">
  			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
    			<tr><td ><a href="/admin/ad.html">浏览广告</a></td>
    			   <td  class="active"><a href="/admin/ad/add.html" class="add">添加广告</a></td>
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

<form method="post" action="/admin/items/handle.html" onsubmit="return check();">
  <input type="hidden" name="op" value="<?=$op?>" />
  <input type="hidden" name="itemid" value="<?=$itemid?>">
  <input type='hidden' name='type' value="<?=$type?>" />
  <input type='hidden' name='token' value="<?=$token?>" />
  <table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
  <br /><br />
  <tr>
    <th>广告标题<span>＊</span></th>
    <td><input maxlength="200" class="w300" type="text" name="subject" id="subject"  value="<?=$item['subject']?>"   onblur="return checktext()" />
    </td>
  </tr>
  <tr><th>广告分类<span>＊</span></th>
    <td>
      <select name="category" id='category'    >
        <?php $this->widget('category_widget',array('where'=>array('type'=>'ad'),'tag'=>'category','selected'=>$item['catid'])); ?>
      </select>

    </td>
  </tr>
<tr>
  <th>投放频道*<p>可选择一个或多个</p></th>
  <td>
      <select name='channel[]' id="channel" class="h200" multiple="multiple" >
      <?php $this->widget('category_widget',array('where'=>array('type'=>'','ischannel'=>'1'),'isad'=>false,'tag'=>'channel','selected'=>$item['channel'])); ?>
      </select>
  </td>
</tr>
<tr>
  <th>所属城市</th>
  <td id="address">
    <?php $this->widget('cities_widget',array('citycode'=>$item['citycode'])) ?>
  </td>
</tr>
<tr>
    <th>所属同步学堂</th>
	<td>
	<input type="text" class="w300" readonly="readonly" value="<?=$item['crname']?>" id="crname" name="crname">
	<input type="button" id="drop" value="选择" />
	<input type="button" id="clear" value="清除" />
	<input type="hidden" name="crid" id="mediaid"  value="<?=$item['crid']?>" />
	</td>
</tr>
<tr>
  <th>投放时间<p>即该条广告投放的时间段，如果不指定投放时间段，则一直投放。</p></th>
  <td>从<input type="text" id="begintime" name="begintime" class="w100" value="<?php $item['begintime']=empty($item['begintime'])?time():$item['begintime']; echo date('Y-m-d H:i',$item['begintime']);?>" onfocus="$(this).datetimebox({showSeconds:false});" />
       开始到 <input type="text" id="endtime" name="endtime"   class="w100"  value="<?php $item['endtime']=empty($item['endtime'])?strtotime('+ 1 year'):$item['endtime']; echo date('Y-m-d H:i',$item['endtime']);?>" onfocus="$(this).datetimebox({showSeconds:false});" />
       结束
  </td>
</tr>

<tr>
  <th>广告图片<p></p></th>
  <td>
<?php
  if(empty($item['thumb'])){
    $Upcontrol->upcontrol('thumb',1,array(),'pic');
  }else{
    $Upcontrol->upcontrol('thumb',1,array('upfilepath'=>$item['thumb']),'pic');
}
?>
<br />
</td>
</tr>
<tr>
  <th>外部链接URL<p>如果填入外部链接，查看该资讯时，将自动跳转到该链接,如果没有外部链接请填入#号。</p></th>
  <td><input type="text"  name="itemurl" class="w300" value="<?=empty($item['itemurl'])?'#':$item['itemurl']?>"></input></td>
</tr>
<tr>
  <th>文件夹</th>
  <td>
    <input type="radio" name="folder" value="1" <?php if($item['folder']=='1') echo 'checked=checked' ?>>待审箱
    <input type="radio" name="folder" value="2" <?php if($item['folder']=='2' or empty($item['folder'])) echo 'checked=checked' ?>>发布箱
  </td>
</tr>                
  <?php $this->widget('bth_widget',array('hot'=>$item['hot'],'best'=>$item['best'],'top'=>$item['top'])) ?>
<tr>
  <th>广告详情</th>
  <td colspan="2" style="padding:0;">
    <?php $editor->createEditor('message',"100%","300px",$item['message']); ?>
  </td>
</tr>
</table>
<div id="dialog"></div>
<div class="buttons">

<input type="submit" name="nextsubmit" value="保存并继续" class="submit">
<input type="submit" name="valuesubmit" value="提交保存" class="submit">
<input type="reset"	 name="valuereset" value="重置">
</div>
</form>
<br>
<script type='text/javascript'>
	
	$('#drop').click(function(){
		$('#dialog').dialog({    
	    title: '选择教室',    
	    width:Math.ceil($(document).width()/2),
		height:450, 
	    closed: false,    
	    cache: false,    
	    href: '/admin/classroom/search.html',    
	    modal: true   
		});
		$("#ck").trigger('click');    
	});
	$('#clear').click(function(){
		$('#mediaid').val("");
		$('#crname').val("");
	});
      $.fn.datetimebox.defaults.formatter = function(date){
      var y = date.getFullYear();
      var m = date.getMonth()+1;
      var d = date.getDate();
      var h = date.getHours();
      var f = date.getMinutes();
      return y+'-'+m+'-'+d+' '+h+':'+f;
    }

    $("#begintime,#endtime").trigger('focus');


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

  function checkcity(){
    var city = $("#address");
    var len = ($("#address_sheng").val()+$("#address_shi").val()+$("#address_qu").val()).length;
    if(len<1){
        $("em.error,em.success",city).remove();
        city.append('<em class="error">请选择城市!</em>');
        $("html,body:not(:animated)").animate({scrollTop:city.offset().top-50},1000);
        return false;
    }else{
        $("em.error,em.success",city).remove();
        city.append('<em class="success">选择正确!</em>');
    }
  }

  function check(){
    $("em.error,em.success").remove();
    return checktext();
  }
  $(".datebox :text").attr("readonly","readonly");
</script>
</body>
