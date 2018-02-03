<?php
	$this->display('common/header');

	$sortmode = $this->uri->sortmode;
	$viewmode = $this->uri->viewmode;
	$q = $this->input->get('q');
	$beginprice = $this->input->get('beginprice');
	// $beginprice = (!empty($beginprice)||$beginprice===0)?intval($beginprice):'￥';
	$endprice = $this->input->get('endprice');
	// $beginprice = (!empty($endprice)||$endprice===0)?intval($endprice):'￥';
	$property = $this->input->get('property');
?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/wxlie.css" />
<link href="http://static.ebanhui.com/ebh/tpl/2014/css/joinlc.css" rel="stylesheet" type="text/css" />

<!-- <div class="toptitnew"><a href="/yun.html">云教学平台</a> > 平台搜索</div> -->
<div class="xianei" style="margin-top:15px;">
<div class="icategry">
<div class="rebiaoq">
<dt style="line-height:30px;height:31px;">热门标签：</dt>
<dd>
<div class="wtiedh">
<div>
<a class="<?= empty($q)?'lanbiao':''?>" href="/cloudlist-1-<?=$sortmode?>-<?=$viewmode?>-0.html?beginprice=<?=$beginprice?>&endprice=<?=$endprice?>">不限</a>
</div>
<?php 
	foreach($labellist as $label){
?>
<div>
<a  class="<?= ($q==$label['title'])?'lanbiao':''?>"  href="/cloudlist-1-<?=$sortmode?>-<?=$viewmode?>-0.html?q=<?=$label['title']?>&beginprice=<?=$beginprice?>&endprice=<?=$endprice?>&property=<?=$property?>"><?= $label['title']?></a>
</div>
<?php } ?>

</div>
</dd>
</div>

<div class="ptjia">
<dt style="line-height:30px;width:60px;">价格：</dt>
<dd>
<div class="wtiedh">
<div>
<a class="<?=(empty($beginprice)&&empty($endprice))?'lanbiao':''?>" href="/cloudlist-1-<?=$sortmode?>-<?=$viewmode?>-0-0.html?q=<?=$q?>&amp;beginprice=0&amp;endprice=0">免费</a>
</div>
<div>
<a class="<?=(($beginprice==1)&&($endprice==100))?'lanbiao':''?>" href="/cloudlist-1-<?=$sortmode?>-<?=$viewmode?>-0-0.html?q=<?=$q?>&amp;beginprice=1&amp;endprice=100">1-100元</a>
</div>
<div>
<a class="<?=(($beginprice==101)&&($endprice==300))?'lanbiao':''?>" href="/cloudlist-1-<?=$sortmode?>-<?=$viewmode?>-0-0.html?q=<?=$q?>&amp;beginprice=101&amp;endprice=300">101-300元</a>
</div>
<div>
<a class="<?=(($beginprice==301)&&($endprice==500))?'lanbiao':''?>" href="/cloudlist-1-<?=$sortmode?>-<?=$viewmode?>-0-0.html?q=<?=$q?>&amp;beginprice=300&amp;endprice=500">301-500元</a>
</div>
<div>
<a class="<?=(($beginprice==500)&&(empty($endprice)))?'lanbiao':''?>" href="/cloudlist-1-<?=$sortmode?>-<?=$viewmode?>-0-0.html?q=<?=$q?>&amp;beginprice=501&amp;endprice=">501以上</a>
</div>
<div style="width:150px;">
<input id="beginprice" class="iptxt" type="text" value="<?=$beginprice?>" onkeyup="this.value=this.value.replace(/\D/g,'')">
<span>-</span>
<input id="endprice" class="iptxt" type="text" value="<?=$endprice?>" onkeyup="this.value=this.value.replace(/\D/g,'')">
</div>
<div>
<a href="javascript:pricechange()" class="zhunbtn">确 定</a>
</div>
</div>
</dd>
</div>
<div class="etryk condi">
<dt style="line-height:30px;width:60px;padding-left:15px;">已选条件：</dt>
<dd>
<span class="ewiwtw" style="text-align:center;">
<a style="color:#18a8f7;" href="cloudlist-1-0-<?=$viewmode?>-.html">重置筛选条件</a>
</span>
<em class="termss">
<a href="cloudlist-1-<?=$sortmode?>-<?=$viewmode?>-.html?beginprice=<?=$beginprice?>&endprice=<?=$endprice?>"><?=empty($q)?'不限':$q?></a>
</em>
<em class="termss">
	<?php if(($endprice==='')&&(is_numeric($beginprice))){?>
		<a href="cloudlist-1-<?=$sortmode?>-<?=$viewmode?>-.html?q=<?=$q?>"><?=$beginprice?>元以上</a>
		
	<?php }else if(is_numeric($endprice)&&is_numeric($beginprice)){?>
		<?php if($endprice==$beginprice){?>
		<a href="cloudlist-1-<?=$sortmode?>-<?=$viewmode?>-.html?q=<?=$q?>"><?=$endprice?>元</a>
		<? }else{?>
		<a href="cloudlist-1-<?=$sortmode?>-<?=$viewmode?>-.html?q=<?=$q?>"><?=$beginprice?>-<?=$endprice?></a>
		<? }?>
	<?php }else if(($beginprice==='')&&is_numeric($endprice)){?>
		<a href="cloudlist-1-<?=$sortmode?>-<?=$viewmode?>-.html?q=<?=$q?>"><?=$endprice?>元以下</a>
	<?php }?>
</em>

<?php
	$schoolname = array('_1'=>'教学平台','_3'=>'企业培训','_2'=>'网络学校');
	$currschool = array_key_exists('_'.$property,$schoolname)?$schoolname['_'.$property]:'';
?>
<?php if(!empty($currschool)){?>
<em class="termss">
<a href="cloudlist-1-<?=$sortmode?>-<?=$viewmode?>-.html?beginprice=<?=$beginprice?>&endprice=<?=$endprice?>&q=<?=$q?>"><?=$currschool?></a>
</em>
<?php }?>
</dd>
</div>
</div>

<div class="icategry" style="margin-top:15px;border-top:none;">
<div class="etryk" style="border-bottom:solid 1px #e3e3e3;">
<dt style="line-height:30px;width:60px;padding-left:15px;">排序：</dt>
<dd style="margin-top: 3px;">
<ul>
<?php $style='style="background:url(http://static.ebanhui.com/ebh/tpl/2014/images/lieico.jpg) no-repeat 42px center;"'; ?>
<li class="qwlean" <?=empty($sortmode)?$style:''?>><a href="/cloudlist-1-0-<?=$viewmode?>-.html?q=<?=$q?>&beginprice=<?=$beginprice?>&endprice=<?=$endprice?>&property=<?=$property?>">综合</a></li>
<li class="qwlean" <?=$sortmode==2?$style:''?>><a href="/cloudlist-1-2-<?=$viewmode?>-.html?q=<?=$q?>&beginprice=<?=$beginprice?>&endprice=<?=$endprice?>&property=<?=$property?>">人气</a></li>
<li class="qwlean" <?=$sortmode==4?$style:''?>><a href="/cloudlist-1-4-<?=$viewmode?>-.html?q=<?=$q?>&beginprice=<?=$beginprice?>&endprice=<?=$endprice?>&property=<?=$property?>">推荐</a></li>
<li <?=$sortmode==3?$style:''?>><a href="/cloudlist-1-3-<?=$viewmode?>-.html?q=<?=$q?>&beginprice=<?=$beginprice?>&endprice=<?=$endprice?>&property=<?=$property?>">最新</a></li>
<!-- <li class="wrktie"><a href="#">价格从低到高</a></li> -->
<!-- <li class="yemal"><a href="#" style="font-weight:bold;color:#ccc;text-decoration:none;">< </a><span style="color:#fd6b02;">1</span><span style="color:#999;">/4</span><a href="#" style="color:#c4c4c4;font-weight:bold;text-decoration:none;"> ></a></li> -->
<li class="hengxian<?=$viewmode==1?2:1?>"><a href="/cloudlist-1-<?=$sortmode?>-1-.html?q=<?=$q?>&beginprice=<?=$beginprice?>&endprice=<?=$endprice?>"></a></li>
<li class="fangxian<?=$viewmode==0?2:1?>"><a href="/cloudlist-1-<?=$sortmode?>-0-.html?q=<?=$q?>&beginprice=<?=$beginprice?>&endprice=<?=$endprice?>"></a></li>
</ul>
</dd>
</div>
<div class="ptjia">
<?php
	if(($q=='输入要搜索的平台名称')||empty($q)){
		$color = '#c8c8c8';
	}else{
		$color = '#000';
	}
?>
<div style="float:right;">
<input class="iptsou" style="color:<?=$color?>" type="text" value="<?=empty($q)?'输入要搜索的平台名称':$q?>"><a href='javascript:void(0)' onclick="return dosearch()" class="alinkbtn">确 定</a>
</div>
</div>
</div>

<!-- 横行显示平台列表 -->
<div class="wanglie" <?php if($viewmode==0){echo 'style="display:none"';}?>>
<div class="wanglef" >
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/adtop103295.jpg" />
<div class="biaoqian">
<h2 class="fhrm">热门关键词</h2>
<ul class="waimdik">
<?php foreach($labelshow as $lab){ ?>
<li><a href="<?= geturl('/cloudlist-1-0-0.html?q='.$lab['title'])?>"><?= $lab['title']?></a></li>
<?php } ?>
</ul>

</div>
<img src="http://static.ebanhui.com/ebh/tpl/2014/images/ad3130329.jpg" />
</div>
<div class="wangrig">
<div class="topwangbg">

<ul>

<?php foreach($classroomlist as $clkey=>$clroom){ ?>

<?php 
	$cloudurl='http://'.$clroom['domain'].'.ebh.net';
	$cloudimg=empty($clroom['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$clroom['cface'];
?>

<?php 
if(empty($user)){ 
	$cloudaddurl = '/login.html?returnurl='.$_SERVER['REQUEST_URI'];
		// $cloudaddurl="tologin('".'/login.html?returnurl=__url__'."');";
	
}else{
	
		$cloudaddurl='http://'.$clroom['domain'].'.ebh.net/classactive.html';
		$target = '';
}
?>
<li class="xiaolie">
<div class="borddes"  onmouseout="this.className='borddes'" onmouseover="this.className='borddes1'">
<div class="lefttke">
<div class="lefke">
<a href="<?= $cloudurl?>" <?php if(!empty($user)){ ?>
target="<?= $target?>"
<?php } ?>>
<img style="width:100px;height:100px;" src="<?= $cloudimg?>"  width="100" height="100">
</a>
</div>
<h2 class="chuang">创建于:<?= date('Y-m-d',$clroom['begindate'])?></h2>
</div>
<div class="rigsize">
<a style="cursor: pointer;" href="<?= $cloudurl?>">
<span class="titke" title="<?= $clroom['crname']?>" <?php if(!empty($user)){ ?>target="<?= $target?>"<?php } ?>><?= ssubstrch($clroom['crname'],0,26)?></span>
</a>
<!--
<p class="pingf">
<a style="cursor: pointer;" href="http://<?= $clroom['domain']?>.ebanhui.com/cloudscore.html">
<span class="barbg">
<span class="votebar" style="width:<?= round($clroom['score'])?>0%;"></span>
</span>
</a>
</p>
-->
<p class="kuanpa"><?= htmlspecialchars(ssubstrch($clroom['summary'],0,116),ENT_QUOTES)?>...</p>
<p class="fotssis">
地址：<?= $clroom['craddress']?>
</p>
<p class="fotssis">
网址：<a href="<?= $cloudurl?>" title="<?= $clroom['crname']?>" <?php if(!empty($user)){ ?>target="<?= $target?>"<?php } ?> style="color:#299de6;"><?= $cloudurl?></a>
</p>
</div>
<?php if($clroom['ispublic']==1){
		if(!empty($clroom['in'])){
?>
	<input onclick="javascritp:location.href='<?= $cloudurl?>'" class="kaitongbtn2" type="submit" value="马上学习" name="Submit2" />
	<?php }else{?>

		<input class="kaitongbtn" type="button" value="申请加入" onclick="location.href='<?= $cloudaddurl?>'" />
<?php }} ?>


</div>
</li>
<?php } ?>
</ul>
<?php if(empty($classroomlist)){ ?>
<div style="width: 94%; height:30px; padding:20px; font-size:14px;">
抱歉,没有找到相关的结果！
</div>
<?php } ?>
</div>
<?= $pagestr ?>
</div>
</div>
<!-- 方形显示平台列表 -->
<div class="wanglie" <?php if($viewmode==1){echo 'style="display:none"';}?>>
<ul class="append_new">
<?php foreach($classroomlist as $clkey=>$clroom){ ?>

<?php 
	$cloudurl='http://'.$clroom['domain'].'.ebh.net';
	$cloudimg=empty($clroom['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$clroom['cface'];
?>

<?php 
if(empty($user)){ 
	$cloudaddurl = '/login.html?returnurl='.$_SERVER['REQUEST_URI'];
		// $cloudaddurl="tologin('".'/login.html?returnurl=__url__'."');";
	
}else{
	
		$cloudaddurl='http://'.$clroom['domain'].'.ebh.net/classactive.html';
		$target = '';
}
?>
	<li class="kefbuy" <?php if(($clkey+1)%4==0){echo 'style="margin-right:0;"';}?> >
	<div class="leich" onmouseout="this.className='leich'" onmouseover="this.className='leich1'">
	<a style=" text-decoration:none;" href="<?= $cloudurl?>" <?php if(!empty($user)){ ?>
		target="<?= $target?>"
	<?php } ?>>
	<h3 class="ketit"><?= ssubstrch($clroom['crname'],0,20)?></h3>
	</a>
	<div class="kewaik">
	<a href="<?= $cloudurl?>">
	<img style="width:100px;height:100px;" src="<?= $cloudimg?>">
	</a>
	</div>
	<div class="rigxiaox">
	<p class="botthui">
	<?= htmlspecialchars(ssubstrch($clroom['summary'],0,50),ENT_QUOTES)?>...
	</p>
	<?php if($clroom['ispublic']==1){
		if(!empty($clroom['in'])){
	?>
	<input onclick="javascritp:location.href='<?= $cloudurl?>'" class="kaitongbtn2" type="submit" value="马上学习" name="Submit2" style="margin:0;" />
	<?php }else{?>
	
	<input onclick="javascritp:location.href='<?= $cloudaddurl?>'" class="kaitongbtn" type="submit" value="申请加入" name="Submit2" style="margin:0;" />
	<?php }}?>
	</div>
	<p class="fottpp" style="margin-top:8px;">创建时间:<?= date('Y-m-d',$clroom['begindate'])?></p>
	<p class="fottpp">地址：<?= ssubstrch($clroom['craddress'],0,22)?></p>
	<p class="fottpp">网址：<a href="<?= $cloudurl?>" title="<?= $clroom['crname']?>" <?php if(!empty($user)){ ?>target="<?= $target?>"<?php } ?>  style="color:#299de6;"><?= shortstr($cloudurl,26)?></a></p>

	</div>
	</li>

<? }?>


</ul>
<div style="clear:both"></div>
<?= $pagestr ?>
</div>

</div>
</div>
<div style="clear: both"></div>

<!-- 申请加入教室 -->
<div id="join2" name="join" style="display:none">
<div class="classconfirm" id="joinform2">
	<form action="" method="post" id="sform2" name="sform" onsubmit="return checkform('rname','mobile','email')">
		<input type="hidden" id="crid2" name="crid" />
    	<input type="hidden" id="teacherid2" name="teacherid" />
			<div class="joinlc">
				<p class="tit_cue">请填写您真实的和人信息，带*号的内容必须填写。</p>
				<ul>
				
				<li class="current fifx">
				<span>*</span><em>姓&nbsp;名：</em>
				<input type="text" class="txt_box" name="rname" maxlength="25"  id="rname2" onblur="checkrname2(this.value)" value="{eval echo $_SBLOCK['member'][0]['rname2']}" />
				<span id="rnamemsg2"></span></li>
				
				<li class="current fify">
				<span>*</span><em>邮&nbsp;箱：</em>
				<input type="text" class="txt_box" name="email" maxlength="60"  id="email2" onblur="checkemail2(this.value)" value="{eval echo $_SBLOCK['member'][0]['email2']}"  />
				<span id="emailmsg2"></span></li>
				<li class="current fifz">
				<span></span><em class="em2">手&nbsp;机：</em>
				<input type="text" class="txt_box" name="mobile2 maxlength="11" onblur="checkmobile2(this.value)"  id="mobile2" value="{eval echo $_SBLOCK['member'][0]['mobile2']}"/>
				<span id="mobilemsg2"></span>
				</li>
				
				<li class="current fifc">
				<span></span><em class="em2">Q&nbsp;&nbsp;&nbsp;Q：</em>
				<input type="text" class="txt_box" name="qq2" id="qq" maxlength="15"  value="{eval echo $_SBLOCK['member'][0]['qq2']}"/>
				</li>
				
				<li class="currs fifa">
				<span style=""></span><em style="margin-left: 38px;_margin-left:28px;_margin-right:2px;font-size: 14px;">留&nbsp;言：</em>
				<textarea id="remarks2" name="remarks" class="txt_duobox"></textarea>
				</li>
				</ul>
				<p class="sadew">
				  <input id="sendbtn2" type="button" class="operate" name="Submit" value="确&nbsp;&nbsp;认" />
				  <input type="button" name="Submit2" class="cancer" onclick="$('#join2').dialog('close');" value="取&nbsp;&nbsp;消" />
				</p>
			</div>
	</form>
</div>
	<div id="joinmessage2" style="display:none;align:center;" >
    </div>
</div>

<script type="text/javascript">
	var tologin = function(url){
            url = url.replace('__url__',encodeURIComponent(location.href));
            location.href=url;
    }
	$(function(){
		var buttons = {};
		$("#join2").dialog({
			autoOpen: false,
			resizable:false,
			title:"申请加入教室",
			buttons:buttons,
			width: 520,
			height:430,
			modal: true,
			open:function(){
				$('#remarks2').val('');
			},
			beforeclose:function(){
				$( "#join2" ).dialog( "option", "buttons",buttons);
				$("#joinform2").css('display','block');
				$("#joinmessage2").css('display','none');
			}
			});
			$("#sendbtn2").click(function(){
				if(checkform2('rname','mobile','email')){
					
					var crid = $("#crid2").val();
					var rname = $("#rname2").val();
					var mobile = $("#mobile2").val();
					var email = $("#email2").val();
					var qq = $("#qq2").val();
					var teacherid = $("#teacherid2").val();
					var remarks = $("#remarks2").val();

					$("#joinmessage2").html("正在发送请求");
					$("#joinform2").hide();
					$("#joinmessage2").show();
					$.ajax({
						url:"<?= geturl('member')?>",
						type:'post',
						data:{'crid':crid,'rname':rname,'mobile':mobile,'email':email,'teacherid':teacherid,'qq':qq,'remarks':remarks,'op':'application','inajax':1},
						dataType:'text',
						success:function(msgs){
							if(msgs!=''){
//								$("#join").dialog("close");
//								$("#dialogmsg").dialog('open');

								$("#joinmessage2").html('<div style=" width:74px; height:62px; float:left; display:inline; margin-top:100px; margin-left:70px;"><img src="http://static.ebanhui.com/ebh/tpl/default/images/access_bg.png" width="74" height="62" /></div><div style=" width:305px; float:left; display:inline; margin-top:100px; margin-left:10px;"><b style="font-size:14px;">'+msgs+'</b><p>3秒关闭</p><div class="skip"><a style="cursor:pointer;" onclick="javascript:$(\'#join2\').dialog(\'close\');">立即关闭。</a></div></div>');
								buttons = $( "#join2" ).dialog( "option", "buttons" );
								//$("#dialogmsg").html('<span style="color:red">'+msg+'</span>');
								$( "#join2" ).dialog( "option", "buttons", [    ]);
								$("#op"+$("#join2").data('crid')+"2").html('<input type="button" name="button" class="yisq" value="" />');
								setTimeout(function(){$("#join2").dialog('close')},3000);
							}
						}
					})
				}
			});
		
		});
	
		var showdialog2 = function(crid,crname,teacherid){
			$("#crid2").val(crid);
			$("#teacherid2").val(teacherid);
			$("#join2").dialog('option','title',"申请加入"+crname);
			$("#join2").data('crid',crid);
			$("#join2").dialog('open');
		}
	
		function checkrname2(rname){
			if(rname ==""){
				$("#rnamemsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2014/images/error.png" />');
				return false;
			}
			$("#rnamemsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2014/images/righttip.png" />');
			return true;
			
		}
	function checkmobile2(mobile){
		if(mobile!=''){
			var ab = /^(1[3-9]{1}[0-9]{9})$/;
			if(!ab.test(mobile)){
				$("#mobilemsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2014/images/error.png" />');
				return false;
			}	
			$("#mobilemsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2014/images/righttip.png" />');	
		}
		return true;
	}
	function checkemail2(email){
		if(email == ""){
			$("#emailmsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2014/images/error.png" />');
			return false;
		}else{
			var emailreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
			if(!emailreg.test(email)){
				$("#emailmsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2014/images/error.png" />');
				return false;
			}
		}
		$("#emailmsg2").html('<img class="cue" src="http://static.ebanhui.com/ebh/tpl/2014/images/righttip.png" />');
		return true;
	}
	
	function checkform2(rname,mobile,email){
		var rname = $("#"+rname+"2").val();
		var email = $("#"+email+"2").val();
		if(checkrname2(rname)!=true||checkemail2(email)!=true){
			return false;
		}
		return true;
	}
	
	 
	function pricechange(){
		var beginprice=$.trim($("#beginprice").val());
		var endprice=$.trim($("#endprice").val());
		if(!beginprice&&endprice){
			beginprice = 0;
		}
		if(parseInt(beginprice)>parseInt(endprice)){
			var tmpprice=beginprice;
			beginprice=endprice;
			endprice=tmpprice;
			
		}
		var keywords=$.trim($("#keywords").val());
		var url='cloudlist-1-0-0.html?q='+keywords+'&beginprice='+beginprice+'&endprice='+endprice;
		window.location.href=url;
	}
	function listsearch(){
		var beginprice=$.trim($("#beginprice").val());
		var endprice=$.trim($("#endprice").val());
		if(parseInt(beginprice)>parseInt(endprice)){
			var tmpprice=beginprice;
			beginprice=endprice;
			endprice=tmpprice;
			
		}
		var keywords=$.trim($("#keywords").val());
		var url='cloudlist-1-0-0.html?q='+keywords+'&beginprice='+beginprice+'&endprice='+endprice;
		window.location.href=url;
	}
	
	function dosearch(){
		var q = $("input.iptsou:first").val();
		if(q=='输入要搜索的平台名称'){
			var url='cloudlist-1-0-0.html';
			window.location.href=url;
			return false;
		}else{
			var url='cloudlist-1-0-0.html?q='+q;
			window.location.href=url;
			return false;
		}
		
	}

	$(function(){
		$("input.iptsou:first")
		.blur(function(){
			if($(this).val()==''){
				this.style.color = '#c8c8c8';
				$(this).val('输入要搜索的平台名称');
			}
		})
		.focus(function(){
			if($(this).val()=='输入要搜索的平台名称'){
				this.style.color = '#000';
				$(this).val('');
			}
		})
	})
	</script>
<?php
    $this->display('common/footer');
?>