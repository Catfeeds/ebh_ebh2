<?php $this->display('troom/page_header'); ?>
<script language="javascript" type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<style type="text/css">
.soutxts {
	width:200px;
	height:20px;
	float:left;
	line-height:22px;
	font-size:14px;
	padding-left:5px;
	color:#666;
	border: 1px solid #7F9DB9;
}
.wehek {
	background:#fff;
	padding: 10px 6px;
	border-bottom:solid 1px #cdcdcd;
}
.quito {
	padding:10px 6px;
	border-bottom:solid 1px #efefef;
	border-top:none;
	min-height:20px;
	line-height:20px;
	float:left;
	width:774px;
}
.eriek {
	width:690px;
	float:left;
	height:33px;
	line-height:33px;
	margin-left:40px;
	border-bottom:dashed 1px #e6e6e6;
	background:url(http://static.ebanhui.com/ebh/images/fujianico0106.jpg) no-repeat center left;
	padding-left: 20px;
}
.eriek img {
	float:left;
	margin:10px 0px 0px 6px;
}
.surebtn
{
	width:40px;
	border:1px solid #9a9999;
	font-size:9pt;
	background-color:#ffffff;
}
.file
{
	width:200px;
	border:1px solid #9a9999;
	font-size:9pt;
	background-color:#ffffff;
}
.hover
{
	background-color:#efffff;
}
</style>


<div class="ter_tit">
当前位置 > <a href="<?=geturl('troom/teachingplan')?>">电子教案</a> > 教案管理
	<div class="diles">
	<input class="newsou" type="text" onkeypress="entertosearch(event)" <?php if(!empty($search)){?>value="<?=$search?>" style="color:#000" <?php }else{?>value="请输教案名称"<?php }?> onblur="if($('#search').val()==''){$('#search').val('请输教案名称').css('color','rgb(203, 203, 203)');}" onfocus="if($('#search').val()=='请输教案名称'){$('#search').val('').css('color','#000');}" id="search" class="shurulan"/>
	<input onclick="search()"  id="searchbutton" name="searchbutton" type="button" class="soulico" value="">
	</div>
</div>

<div class="lefrig" style="background:#fff;float:left;margin-top:15px;width:786px;">

	<h2 class="wehek">
	<span style="width:424px;float:left;">教案名称</span>
	<span style="width:185px;float:left;">时间</span>
	<span>操作</span></h2>
	
	<ul>
		<?php if(empty($tplanlist)){
			if(empty($search)){?>
			您还没有教案，去创建吧。<a style="color:red" href="<?=geturl('troom/teachingplan/add')?>">点击这里</a>
			<?php }else{?>
			没有找到关于 <font color="red"><?=$search?></font> 的教案。
			<?php }}else{
				foreach($tplanlist as $tl){
			?>
			
			
			<li class="quito">
			<span style="float:left;width:424px;word-wrap: break-word;"><a href="<?=geturl('troom/teachingplan/'.$tl['tpid'])?>"><?=$tl['title']?></a></span><span style="float:left;width:185px;"><?=Date('Y-m-d H:i:s',$tl['dateline'])?></span><a href="<?=geturl('troom/teachingplan/edit/'.$tl['tpid'])?>" class="workBtn">编辑</a><a href="javascript:tplandelete(<?=$tl['tpid']?>)" class="workBtn">删除</a><a href="javascript:show_div(<?=$tl['tpid']?>)" class="previewBtn">上传附件</a>
			
			<?php if(!empty($tl['attlist'])){
				foreach($tl['attlist'] as $al){
				$url = geturl('troom/teachingplan/downloadatt').'?attid='.$al['attid'].'&tpid='.$tl['tpid'];
				?>
				<p class="eriek"><a href="<?=$url?>" style="float:left;color:#3366cc"><?=$al['name']?></a><a href="javascript:attachdelete(<?=$tl['tpid'].','.$al['attid']?>)"><img src="http://static.ebanhui.com/ebh/images/chuantu0106.jpg" /></a></p>
			<?php }}?>
			</li>
			<?php }}?>
			
		
	</ul>
	<div id="dialog"></div>
	<?=show_page($tplancount)?>
</div>
<script>

$(document).ready(function(){
    $("#showobj").hide();
    var txtpath= $("#attachment").val();
    if(txtpath!="")
    {
        $("#showobj").show();
    }
	$("li").hover(
    function () { $(this).addClass("hover") },
    function () { $(this).removeClass("hover") })
 });

function tplandelete(tpid){
	
	$.confirm("您确定要删除您的教案？这将同时删除您的附件。",function(){
	
		$.ajax({
			url:"<?=geturl('troom/teachingplan/deletetplan')?>",
			type:"post",
			data:{"tpid":tpid},
			dataType:"text",
			success:function(data){
				if(data=="1"){
					H.create(new P({
						content:'教案删除成功！',
						easy:true,
						padding:20
					},{
						'onclose':function(){location.reload();}
					}),'common').exec('show').exec('close',600);
				}else{
					H.create(new P({
						content:'教案删除失败！',
						easy:true,
						padding:20
					},{
					}),'common').exec('show').exec('close',600);
				}
			}
		});
	
	});
}

function search(){
	var key = $("#search").val();
	if(key == $.trim("请输教案名称"))
	key="";
	var url = '<?=geturl('troom/teachingplan/manage-0-0-0')?>';
	url = url+'?q='+key;
	window.location.href=url;
}
function entertosearch(event)
{
	if(event.keyCode==13)
		search();
}
var showdiv="dialog";
var path;
var _tpid;
function show_div(tpid)
{
	_tpid = tpid;
	//path="#getsitecpurl()#";
    opendialog();
    //$("#iframeid").attr("src",''+path+'?action=uploadtplanattach');
}

function opendialog()
{
    var objhtml="";
    objhtml = " <iframe id='iframeid' scrolling='no' width='400' height='168' frameborder=no src='<?=geturl('troom/teachingplan/uploadtplanattach')?>'></iframe>";
	$("#dialog").html(objhtml);
	H.create(new P({
		id:"dialog",
		title:'上传文件',
		width:430,
		height:235,
		easy:true,
		content:$("#"+showdiv)[0]
	}),'common').exec('show');
}
function closedialog()
{
	H.get('#'+showdiv).exec('close');
}
function attachdelete(tpid,attid)
{
	$.confirm("您确定要删除这个附件？",function(){
	
		$.ajax({
			url:"<?=geturl('troom/teachingplan/deleteattach')?>",
			type:"post",
			data:{"attid":attid,"tpid":tpid},
			dataType:"text",
			success:function(data){
				//alert(data);
				if(data=="1"){
					H.create(new P({
						content:'附件删除成功！',
						easy:true,
						padding:20
					},{
						'onclose':function(){location.reload();}
					}),'common').exec('show').exec('close',600);
				}else{
					H.create(new P({
						content:'附件删除失败！',
						easy:true,
						padding:20
					},{
					}),'common').exec('show').exec('close',600);
				}
			}
		});
	
	});
	
}
function datetime_to_unix(datetime){
	var tmp_datetime = datetime.replace(/:/g,'-');
	tmp_datetime = tmp_datetime.replace(/ /g,'-');
	var arr = tmp_datetime.split("-");
	var now = new Date(Date.UTC(arr[0],arr[1]-1,arr[2],arr[3]-8,arr[4],arr[5]));
	return parseInt(now.getTime()/1000);
}
function attachupload(returns)
{
	
	var url = returns.split('|')[0];
	var name = returns.split('|')[1];
	// var dateline = datetime_to_unix("#Date('Y-m-d H:i:s')#");
	
	$.ajax({
		url:"<?=geturl('troom/teachingplan/uploadtplanattach')?>",
		type:"post",
		data:{"tpid":_tpid,"name":name,"url":url},
		dataTpye:"text",
		success:function(data){
		//alert(data);
			if(data=="1"){
				H.create(new P({
					content:'附件上传成功！',
					easy:true,
					padding:20
				},{
					'onclose':function(){location.reload();}
				}),'common').exec('show').exec('close',600);
			}else{
				H.create(new P({
					content:'附件上传失败！',
					easy:true,
					padding:20
				},{
				}),'common').exec('show').exec('close',600);
			}
		}
	});
}
function attdownload(attid)
{
	$.ajax({
		url:"<?=geturl('troom/teachingplan')?>",
		type:"post",
		data:{"attid":attid,"op":"attdownload"},
		dataType:"text",
		success:function(data){
			alert(data);
		}
	});
}
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<?php $this->display('troom/page_footer'); ?>