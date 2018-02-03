<?php
$this->display('common/header');
?>

<link href="http://static.ebanhui.com/ebh/tpl/2012/css/space.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<div class="topbaad" >
	<div class="user-main clearfix">
		<?php
		$this->assign('menuid',1);
		$this->display('member/left');
		?>
		
		<div class="user-cont" style="padding-left:0px;float:right;padding-top:0px;width:788px;">
			<div class="cright_cher" style="margin-left:0px;width:788px;">
				<div class="ter_tit">
				当前位置 > <a href="<?=geturl('member/space')?>">原创空间</a> > 查看详情<a style="color:#3095C6;margin-left:80px;" href="<?=geturl('member/space')?>">返回上级</a>	
				<div class="diles">
	<input name="courseware_search" class="newsou" style="color:<?= $defaultColor ?>" value="<?= isset($q) ? $q : '输入关键字搜索' ?>" onblur="if($('#search').val()==''){$('#search').val('输入关键字搜索').css('color','#d9d9d9');}" onfocus="if($('#search').val()=='输入关键字搜索'){$('#search').val('').css('color','#d9d9d9');}" id="title" value="输入关键字搜索"  />
	<input type="button" class="soulico" value="" id="room_search_btn" name="courseware_search">
</div>
				</div>
				
				<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;margin-top:15px;width:786px;float:left;">
					<div class="details">
						<div class="lef_bgxian"></div>
						<div class="mian_bg">
						<h3 class="tit_det" >
						<span style="width:230px; height: 26px;line-height:26px;float:left;" id="showtitle" onclick="shTextBox(this.innerHTML,<?=$item['id']?>)" onmouseover="this.style.border= '1px solid #BECEEB'" onmouseout="this.style.border= '#D1EDF7'""><?=$item['title']?></span>
							
						<span class="times" style="line-height:28px"><?= date('Y-m-d',$item['dateline']) ?></span></h3>
						<h2 class="xiugaibg">
						<a id="up" href="javascript:playspace(<?=$item['id']?>,'<?=$item['title']?>')" title="<?= $item['title'] ?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/large0702.jpg" /></a>
						<a id="xiugai" href="javascript:shTextBox(this.innerHTML,<?=$item['id']?>)"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/alter0702.jpg" /></a>
						<a id="del" href="javascript:deletespace('<?=$item['id']?>','<?=$item['title']?>')"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/delete0702.jpg" /></a>
						<a id="xiazai" href="/space/down.html?id=<?= $item['id'] ?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/xiazai0702.jpg" /></a>
						</h2>
							<div class="detlstu">
							<ul class="alignda"> 
							<li> 
							<a href="<?=$imgurl?>" title="<?=$item['title']?>">
							<img class="show_img" src="<?=getthumb($imgurl,'421_284')?>" />
							<img class="alpha_img" src="images/pixel.gif"/> 
							</a>
							</li>
							</ul>
							</div>
						</div>
						<div class="rig_bgxian"></div>
					</div>

				
					<div class="fotissue">
						<h3 class="titnew1">
						  <i class="tittu1"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/daid0713.jpg" /></i></h3>
						  <ul>
						
							<?php 
							if(!empty($reviewlist)){
								foreach($reviewlist as $rv){
							?>
							  <li>
								  <div class="tuxiang"><img src="$face" width="50px" height="50px" /></div>
								  <div class="pust">
									  <h2 style="color:#2b9bcd;"><?= $rv['username']?></h2>
									  <p style="height:50px;"><?= $rv['subject']?></p>
									  <p style="color:#999999;"><?= date('Y-m-d H:i:s',$rv['dateline'])?></p>  
								  </div>
								  <?php if(!empty($rv['good'])){ ?>
									<span class="ping"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/good0713.jpg" /></span>
								  <?php }elseif(!empty($rv['bad'])){ ?>
									<span class="ping"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/bad0713.jpg" /></span>
								  <?php }else{ ?>
									<span class="ping"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/naka0713.jpg" /></span>
								  <?php } ?>
							  </li>
							  <?php
							  }}else{?>
						<div align="center" style="padding-top: 10px;width: 746px;">暂 无 网 友 评 论</div>
						<?php }?>
						  </ul>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<div style="clear:both;"></div>
<script type="text/javascript">
var purl = "<?=geturl('member/space')?>";
var surl = "<?=geturl('member/space-0-0-0-###')?>";
function deletespace(id,title) {
	var result = confirm("您确定要删除您的作品 "+title+" 吗?");
	if (result) {
		var aurl = "<?=geturl('member/space/del')?>";
		$.post(aurl,{"id":id},function(result){
			if (result == 1) {//.status
				//alert(result.msg);
				document.location.href = purl;
			} else {
				alert(result);
			}
		});
	}
}
$(function(){
	$("#room_search_btn").click(function(){
		var search = $('#title').val();
			search = search.replace(/,/g,"");
			search = search.replace(/\'/g,"");
			search = search.replace(/\//g,"");
			search = search.replace(/%/g,"");
			search = search.replace(/_/g,"");
			search = search.replace(/#/g,"");
			search = search.replace(/\?/g,"");
			search = search.replace(/\\/g,"");
			search = search.replace(/>/g,"");
		if($('#title').val()=='请输入您要搜索的作品名称'){
			search='';
		}
		var url = surl.replace("###",encodeURIComponent(search));
		location.href=url;
	});
	$("#title").focus(function(){
		if($('#title').val()=='请输入您要搜索的作品名称')
			$('#title').val('').css('color','#999999');
	});
	$("#title").blur(function(){
		if($('#title').val()=='')
			$('#title').val('请输入您要搜索的作品名称').css('color','#999999');
	});
	$("#bitimagebtn").lightBox();
	$('.detlstu a').lightBox();
});
</script>
<script type="text/javascript">
 
	function shTextBox(title,id){
		var oldtitle= document.getElementById("showtitle").innerHTML;
		if(oldtitle.toLocaleUpperCase().indexOf('INPUT')<0){document.getElementById("showtitle").innerHTML = 
				"<input id='showtextbox' value='"+oldtitle+"' onblur='changeTextBox("+id+",\""+oldtitle+"\")' maxlength='13' />" ;
			}
		}

	function changeTextBox(id,oldtitle){
		var newtitle= document.getElementById("showtextbox").value;
			newtitle = newtitle.replace(/,/g,"");
			newtitle = newtitle.replace(/\'/g,"");
			newtitle = newtitle.replace(/\//g,"");
			newtitle = newtitle.replace(/%/g,"");
			newtitle = newtitle.replace(/_/g,"");
			newtitle = newtitle.replace(/#/g,"");
			newtitle = newtitle.replace(/\?/g,"");
			newtitle = newtitle.replace(/\\/g,"");
			newtitle = newtitle.replace(/>/g,"");
		document.getElementById("showtextbox").value = newtitle;
		if(newtitle==''){
			return;
		}
		var urldata = {'title':newtitle,'id':id}
		if(oldtitle != newtitle){
			$.ajax({
				type	: "POST",
				url		: "<?=geturl('member/space/edittitle')?>",
				data	: urldata,
				datatype: 'html',
				success	: function(html){
					strarr = html.split('|');
					if(html==1){//strarr[0]
						$.showmessage({message:'成功',animatespeed:500,timeoutspeed:500});
						document.getElementById("showtitle").innerHTML=newtitle;
						var linkopen = document.getElementById("up");
			            var linkdel = document.getElementById("del");
			            linkopen.href = linkopen.href.replace(oldtitle, newtitle);
			            linkdel.href = linkdel.href.replace(oldtitle, newtitle);
					}
					else{
						$.showmessage({message:'失败',animatespeed:500,timeoutspeed:500});
					}
				}
			});
	    }
	}

</script>
<?php
$this->display('common/player');
$this->display('common/footer');
?>