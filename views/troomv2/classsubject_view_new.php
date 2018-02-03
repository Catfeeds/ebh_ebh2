<?php $this->display('troomv2/page_header'); ?>
<?php $classid = $this->input->get('classid');?>

<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<script src="http://static.ebanhui.com/ebh/js/playbar/playbar.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/zeroclipboard/dist/ZeroClipboard.js"></script>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/share/css/share.min.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.share.js"></script>
<script type='text/javascript' src='http://static.ebanhui.com/ebh/js/share/raphael-2.1.0-min.js'></script>
<script type='text/javascript' src='http://static.ebanhui.com/ebh/js/share/qrcodesvg.js'></script>

<style type="text/css">
	
	.auditiontime{
		float: left;
	}
	.audition{
		width:250px;
		height: 20px;
		position: relative;
		float: left;
	}
	.auditionall{
		float: left;
		height: 20px;
		line-height: 20px;
		margin-left: 10px;
	}
	.barnowtime{
		width:40px;
		height:20px;
		color:#000;
		font-size:14px;
		line-height:20px;
		position: absolute;
		bottom: -25px;
		left: 0;
	}
	.baralltime{
		height:20px;
		color:#000;
		font-size:14px;
		line-height:20px;
		float: left;
		margin-left: 15px;
	}
	.thebar{
		position:relative;
		height:20px;
		background:#f2f2f2;
		overflow:visible;
	}
	.thecolorbar{		/*颜色*/
		width:0px;
		height:100%;
		background:#199ed8;
		float:left;
	}
	.timeball{		/*这是那个显示的*/
		width:10px;
		height:26px;
		background:#cccccc;
		position:absolute;
		left:0px;
		top:-3px;
		z-index:2;
		cursor:pointer;
	}
	.singleprice{
		display: block;
		position: absolute;
		top: 10px;
		right: 65px;
		width: 105px;
		height: 30px;
		line-height: 30px;
		text-align: center;
		color: #FFFFFF;
		font-size: 14px;
		background: #ffa200;
		border-radius: 5px;
	}
	.auditionshow{
		display: block;
		position: absolute;
		top: 50px;
		right: 34px;
		width: 105px;
		height: 30px;
		line-height: 30px;
		text-align: center;
		color: #FFFFFF;
		font-size: 14px;
		background: #00cc00;
		border-radius: 3px;
	}
	.auditionshowtime{
		display: inline-block;
		height: 30px;
		line-height: 30px;
	}
	
	
.kejian {
	width: 784px;
	float:left;
	border: 1px solid #dcdcdc;
	background:white;
}
.kejian .showimg {
	margin-top: 6px;
	margin-left: 8px;
}
.kejian liss {
	width: 748px;
}
.kejian .liss .danke {
	width: 145px;
	float: left;
	margin-top: 8px;
	height: 218px;
}
.kejian .liss .danke .spne {
	text-align: center;
	width: 140px;
	height: 36px;
	overflow: hidden;
	word-wrap: break-word;
	display: block;
	color: #0033ff;
	float:left;
}
.kejian .liss .danke .sds {
	height: 184px;
	width: 145px;
	border: 1px solid #cdcdcd;
	background-image: url(http://static.ebanhui.com/ebh/tpl/2012/images/dise.jpg);
	background-repeat: no-repeat;
	background-position: center center;
	margin-bottom: 8px;
}

.showimg { background-color:#CBCBCB; float:left;}
.showimg img { background-color:#FFFFFF; border:1px solid #CDCDCD; padding:4px; position:relative; left:-4px; top:-5px;}
.hover .showimg { background-color:#0087B2;}
.hover .showimg img { border:1px solid #0087B2;}
.showimg .hover{border: 1px solid #0099cc;}
.datatab {
	margin-top:10px;
}
.cqliebiao {
	width: 786px;
	margin-top:15px;
	border: 1px solid #cdcdcd;
	background:#fff;
}
.liess{
	clear:both;
}
.fujianico {
	background: url(http://static.ebanhui.com/ebh/tpl/default/images/attachmen_ico.jpg) no-repeat;
	height: 16px;
	width: 16px;
	float:left;
}
.timingbox{
	margin-left:20px;
	color:#333;
}
.kuesr {
	width:20px;
	height:60px;
	position: absolute;
	top:50px;
	right:0px;
	display:none;
}
.kuesr a.toples {
	width:20px;
	height:20px;
	float:left;
	display:block;
	background: url(http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_up.png) no-repeat;
}
.kuesr a.bottomles {
	width:20px;
	height:20px;
	float:left;
	display:block;
	background: url(http://static.ebanhui.com/ebh/tpl/2014/images/cwarr_down.png) no-repeat;
}
.tabhead th {
	background:#fff;
	color:#18a8f7;
	font-size:16px;
	font-weight:bold;
}
.label-live{
	float:left; 
	padding:1px 5px;
	height: 18px;
	width: 30px; 
	border: 1px solid #dbdbdb;
    margin-right: 10px;
	margin-left:5px;
	background-color: #18a8f7;
	border-radius: 0.25em;
    color: #fff;
    display: inline;
    text-align: center;
	font-style: normal ;
}
a.fusrets {
    display: block;
    height: 103px;
    left: 0;
    position: absolute;
    top: 0;
    width: 178px;
    z-index: 9;
}
a.fusrets:hover {
    background: url(http://static.ebanhui.com/ebh/tpl/2014/images/kustgd1.png) no-repeat center ;
}
.ettyusr {
    float: left;
    height: 103px;
    margin-right: 10px;
    position: relative;
    width: 178px;
}
.ettyusr img {
	float:left;
	width:178px;
	height:103px;
}
.lsfbsj .fbsj{
	float:left;
	display:block;
	width:55px;
	line-height:25px;
}


.fbsj2{
	background:url(http://static.ebanhui.com/ebh/tpl/troomv2/images/renqi.png) no-repeat left center;
	padding-left:15px;
	height:25px;
	display:block;
	float:left;
}
.fbsj1{
	background:url(http://static.ebanhui.com/ebh/tpl/troomv2/images/pinglun.png) no-repeat left center;
	padding-left:15px;
	height:27px;
	display:block;
	float:left;
}
.fbsj3{
	background:url(http://static.ebanhui.com/ebh/tpl/troomv2/images/dianzan1.png) no-repeat left center;
	padding-left:15px;
	height:21px;
	display:block;
	float:left;
	line-height:21px;
}
a.qure {
    border: medium none;
    border-radius: 3px;
    display: block;
    float: left;
    font-family: 微软雅黑;
    font-size: 14px;
    height: 32px;
    line-height: 32px;
    margin-top: 30px;
    text-align: center;
    text-decoration: none;
    width: 112px;
}
a.quxi {
    border: 1px solid #d8d8d8;
    border-radius: 3px;
    display: block;
    font-family: 微软雅黑;
    font-size: 14px;
    height: 30px;
    line-height: 30px;
    margin-right: 10px;
    margin-top: 30px;
    text-align: center;
    text-decoration: none;
    width: 110px;
}
.datatab td{
	 padding: 6px 10px 6px 20px;
}
.tiezitool{
	position:absolute;
	top:3px;
	right:0;
}
.toaused{
	width:666px;
}
.hsidts1s{
	position:relative;
	right:0;
	left:0;
	line-height:18px;
}
.lsfbsj{
	margin-top:0;
	line-height:13px;
}
.kkjssj{
	line-height:24px;
}
.htit{
	text-align:left;
}
#noticediv{
	width:535px;
	height: 275px;
	display:none;
}
.noticetxt{
	width:480px;
	height: 180px;
	margin:20px 25px 0 25px;
	border:1px solid #ccc;
}
.noticetxt textarea{
	border:0;
	padding:10px 10px;
	resize:none;
}
#noticediv .noticenum{
	font-size: 12px;
	color:#ccc;
	margin:10px 40px 20px 0;
	overflow:hidden;
}
#noticediv .noticenum p{
	float:right;
}
#noticediv .noticenum p span{
	color:#ff9500;
}
#noticediv .noticebtn{
	width:405px;
	padding-left:130px; 
}
#noticediv .notice_confirm{
	width:110px;
	height: 33px;
	float:left;
	background:rgb(94, 140, 241);
	border:0;
	color:#fff;
	border-radius: 3px;
	cursor: pointer;
}
#noticediv .notice_cancel{
	width:110px;
	height: 33px;
	float:left;
	background:#fff;
	border:1px solid #ccc;
	color:#ccc;
	margin-left: 50px;
	border-radius: 3px;
	cursor: pointer;
}
.noticebtn{
	position:relative;
}
.noticebtn span{
	position: absolute;
	display: block;
	width:5px;
	height:5px;
	border-radius: 50%;
	background: red;
	right:0;
	top:-1px;
}
span.removebtn {
	width:105px;
	height:30px;
	line-height:30px;
	color:#fff;
	float:left;
	font-size:12px;
	background:#ffa200;
	border:none;
	border-radius:3px;
	text-decoration:none;
	font-family:微软雅黑;
	position: absolute;
	right:22px;
	top:10px;
	text-align:center;
}
.sizle {
	font-size:16px;
	margin-right:5px;
	font-weight:bold;
}
.uct th {
width: 90px;
text-align: right;
padding: 15px 5px 15px 0;
font-weight: lighter;
font-size: 12px;
}
.uploadbox {
	width:800px;
}
.btncancel{
	cursor:pointer;
}
.toolbar{
	margin-top:7px;
}
.user_config{
	width:100%;
}


.marginbott24{
	margin-bottom: 24px;
}
.urladdress{
	width: 350px;
	height: 25px;
	float: left;
	margin-right: 20px;
}
.clickcopy{
	margin-right: 10px;
	color: #4d4d4d;
	float: left;
	width: 56px;
	height: 25px;
	line-height:25px;
	border: 1px solid #DCDCDC;
	border-radius: 5px;
	cursor: pointer;
}

.sharetitle{
	text-align: left;
	font-size: 18px;
	margin-bottom: 16px;
}

.seeqrbox{
	width: 220px;
	height: 142px;
	float: left;
}
.seeqrbox div{
	width: 142px;
	height: 140px;
	border: 1px solid #666666;
	border-radius: 5px;
	padding: 1px
}
.showqr{
	width: 140px;
	height: 140px;
}
.qrcode img{
	width: 100px;
	height: 100px;
}
.qrbox{
	height: 20px;
	margin-bottom: 22px;
}
.qrload{
	margin-right: 15px;
	float: left;
	width: 80px;
	text-align: left;
	line-height: 20px;
}
.qrloadsvg{
	margin-right: 15px;
	float: left;
	width: 80px;
	text-align: left;
	line-height: 20px;
}
.qrtips{
	float: left;
	width: 125px;
	text-align: left;
	line-height: 20px;
}

.sharecourse .icon-wechat,.sharecourse .icon-weibo,.sharecourse .icon-qq,.sharecourse .icon-qzone{
	float: left;
	width: 72px;
	height: 72px;
	margin-right: 53px;
}
.sharecourse .icon-wechat{
	background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/wechaticon72.png);
}
.sharecourse .icon-wechat .wechat-qrcode{
	left: -65px;
}
.sharecourse .icon-wechat .help{
	border: 0 none;
	width: 100%;
	text-align: center;
}
.sharecourse .icon-weibo{
	background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/sinaicon72.png);
}
.sharecourse .icon-qq{
	background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/qqicon72.png);
}
.sharecourse .icon-qzone{
	margin-right: 0;
	background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/qzoneicon72.png);
}

.control .manage input.CP_a_fuc5{
	display:block;
	float:left;
	margin-left:8px;
	width:40px;
	border: 1px solid #CBD1DB;
    color: #999;
    margin-top: 5px;
    background: #fff;
    text-align: center;
}
#categoryList li span.control .manage{
	width:155px;
}
</style>
<script type="text/javascript">

$(function(){
	$('#searchbutton').click(function(){
		var href = '<?= geturl('troomv2/classsubject/'.$folder['folderid']) ?>';
		var searchvalue = $("#searchvalue").val();
		if(searchvalue=='请输入课件名称'){
			searchvalue='';
		}
		href=href+"?q="+encodeURIComponent(searchvalue);
		location.href = href;
	});
        
	H.create(new P({
		id : 'sectiondiv',
	    title: '课程目录管理',
	    padding:2,
	    easy:true,
	    content:$('#sectiondiv')[0]
	}),'common');
	
	
	H.create(new P({
		id : 'noticediv',
	    title: '发布公告',
	    padding:2,
	    easy:true,
	    content:$('#noticediv')[0]
	}),'common');

	var fid = $('#folderid').val();
	section();
	$("#addsection").click(function(){
		updatesection();
	});

	//课程输入
	$(document).on("click",'#sname',function(){
		if($(this).val()=="请输入课程目录"){
			$(this).val('');
			}
		$(this).on("blur",function(){
			if($.trim($(this).val())==''){
				$(this).val('请输入课程目录');
				}
			})
	});
	
$('.datatab tr:last td').css('border-bottom','none');
});
function replaceAll(str,find,rp){
	while(true){
		if(str.indexOf(find) == -1){
			break;
		}
		str = str.replace(find,rp);
	}
	return str;
}

function section(){
    var folderid = $('#folderid').val();
	$.ajax({
		url:"<?= geturl('troomv2/section') ?>",
		type:'post',
		data:{'folderid':folderid},
		dataType:'json',
		success:function(data){
			$('#dnone').css('display',"");
			$('#sectionid').empty();
			$.each(data,function(key,value){
				$('#sectionid').append('<option value="'+value.sid+'">'+value.sname+'</option>');
			});
			try{
			top.resetmain();
			}catch(error){}
		}
	});
}

function edittitle(val){
	var title = $("#"+val+"name").val();
	var displayorder = $("#"+val+"displayorder").val();
	$('#tr'+val).html('<span class="htit" style="color:#000000; width:auto;"><input class="categoryName" type="text" id="'+val+'title" value="'+title+'" maxlength="50" style="height:22px;line-height:22px;width:220px;margin-top:2px;padding:0px;"></span><input type="button" onclick="saction(\''+val+'\',\''+displayorder+'\');" class="bcun" value="确定"  style="margin-top:4px;"/>&nbsp<input type="button" onclick="editclose(\''+title+'\',\''+val+'\',\''+displayorder+'\')" class="bcun" value="取消" /><div></div>');
}
function editclose(title,val,displayorder){
	$("#tr"+val).html('<span class="htit" style="color:#000000" id="'+val+'catitle"><input type="hidden" id="'+val+'name" value="'+title+'" />'+title+'</span><span class="control"><div class="manage"><a class="CP_a_fuc1" href="javascript:void(0);" onclick="edittitle('+val+')">编辑</a><a class="CP_a_fuc4" href="javascript:void(0);" onclick="delsction('+val+')">删除</a><a class="CP_a_fuc2" href="javascript:void(0);" onclick="moveup('+val+')"></a><a class="CP_a_fuc3" href="javascript:void(0);" onclick="movedown('+val+')"></a><input type="text" value="'+displayorder+'" id="'+val+'displayorder" onblur="editdisplayorder('+val+')" class="CP_a_fuc5"></input></div></span><div></div>');
}
function editdisplayorder(val){
	let displayorder = $("#"+val+"displayorder").val();
	if(!displayorder){
		updatesection()
	}else{
		var reg = /^[1-9]\d*$/;
		if(!reg.test(displayorder)){
			updatesection()
		}else{
			$.ajax({
				url:"/troomv2/section/updateorder.html",
				type:'post',
				data:{'sid':val,'displayorder':displayorder},
				dataType:'json',
				success:function(data){
					updatesection()
				}
			});
		}
	}
}
//编辑章节
function saction(val,displayorder){
	var title =$('#'+val+'title').val();
	$.ajax({
		url:"<?= geturl('troomv2/section/edit') ?>",
		type:'post',
		data:{'sid':val,'title':title},
		dataType:'json',
		success:function(data){
			$("#tr"+val).html('<span class="htit" style="color:#000000" id="'+val+'catitle"><input type="hidden" id="'+val+'name" value="'+title+'" />'+title+'</span><span class="control"><div class="manage"><a class="CP_a_fuc1" href="javascript:void(0);" onclick="edittitle('+val+')">编辑</a><a class="CP_a_fuc4" href="javascript:void(0);" onclick="delsction('+val+')">删除</a><a class="CP_a_fuc2" href="javascript:void(0);" onclick="moveup('+val+')"></a><a class="CP_a_fuc3" href="javascript:void(0);" onclick="movedown('+val+')"></a><input type="text" value="'+displayorder+'" onblur="editdisplayorder('+val+')" id="'+val+'displayorder" class="CP_a_fuc5"></input></div></span><div></div>');
			$("#sname").val("");
		}
	});
}
//删除目录
function delsction(val){
	dialog({
		title:"提示信息",
		content:"确认要删除该目录？",
		cancel:function () {
			this.close().remove();
		},
		ok:function () {
			$.ajax({
				url:"<?= geturl('troomv2/section/del') ?>",
				type:'post',
				data:{'sid':val},
				dataType:'json',
				success:function(data){
					if(data.status==1){
						$("#tr"+data.sid).html('');
						updatesection();
						$("#sname").val("");
						section()
					}
				}
			});
		},
		okValue:"确定",
		cancelValue:"取消"
	}).showModal();
}
//添加章节
function addsction(val){
	var sname = $('#'+val).val();
	if(sname=='请输入课程目录'){
		$('#'+val).val('');
		$('#'+val).focus();
		return false;
	}
	
	if (sname.length>50 || sname.length<1) {
		$(".SG_txtc").html('<font color="red">1-50个字符，包括中文,字母,数字</font>');
		return false;
	};
        var folderid = $("#folderid").val();
	$.ajax({
		url:"<?= geturl('troomv2/section/add') ?>",
		type:'post',
		data:{'sname':sname,'folderid':folderid},
		dataType:'json',
		success:function(data){
			if(data.status==1){
				$("#tsection").append('<li class="" id="tr'+data.sid+'"><span class="htit" style="color:#000000" id="'+data.sid+'catitle"><input type="hidden" id="'+data.sid+'name" value="'+data.sname+'" />'+data.sname+'</span><span class="control"><div class="manage"><a class="CP_a_fuc1" href="javascript:void(0);" onclick="edittitle('+data.sid+')">编辑</a><a class="CP_a_fuc4" href="javascript:void(0);" onclick="delsction('+data.sid+')">删除</a><a class="CP_a_fuc2" href="javascript:void(0);" onclick="moveup('+data.sid+')"></a><a class="CP_a_fuc3" href="javascript:void(0);" onclick="movedown('+data.sid+')"></a><input type="text" value="'+data.displayorder+'" id="'+data.sid+'displayorder" onblur="editdisplayorder('+data.sid+')" class="CP_a_fuc5"></input></div></span><div></div></li>');
				$("#sname").val("");
				section();
			}
		}
	});
}

function moveup(val){
	if($("#tr"+val).prev().size()==0){
		return;
	}
	$.ajax({
		url:"<?= geturl('troomv2/section/moveup') ?>",
		type:'post',
		data:{'sid':val},
		dataType:'json',
		success:function(data){
			if(data.status==1){
				updatesection();
				$("#sname").val("");
			}
		}
	});

}

function movedown(val){
	if($("#tr"+val).next().size()==0){
		return;
	}
        var folderid = $("#folderid").val();
	$.ajax({
		url:"<?= geturl('troomv2/section/movedown') ?>",
		type:'post',
		data:{'sid':val},
		dataType:'json',
		success:function(data){
			if(data.status==1){
				updatesection();
				$("#sname").val("");
			}
		}
	});

}
var inputNum = function () {
	$("#noticediv").find("textarea").keyup(function () {
	    var value = this.value
	    var num = this.value.length;
	    htmlNum = 100 - num;
	    if (htmlNum <= 0) {
	        //截取前100个字符
	        value = value.substring(0, 100);
	        $("#noticediv").find("textarea").val(value);
	        htmlNum = 0
	    }
	       
	    $(".noticenum").find("span").html(htmlNum);
    });
};
function html_decode(str) 
{ 
	var s = ""; 
	if (str.length == 0) return ""; 
	s = str.replace(/&gt;/g, ">"); 
	s = s.replace(/&lt;/g, "<"); 
	s = s.replace(/&gt;/g,"&"); 
	s = s.replace(/&nbsp;/g, " "); 
	s = s.replace(/&#39;/g, "\'"); 
	s = s.replace(/&quot;/g, "\""); 
	s = s.replace(/<br>/g, "\n"); 
	return s; 
}
var callBoard = function(cwid){
	$.ajax({
		url:"<?= geturl('troomv2/classcourse/ajax_getnotice') ?>",
		type:'post',
		data:{'cwid':cwid},
		dataType:'json',
		success:function(data){
			if(data.status==1){
				$('#noticecwid').val(cwid);
				var val = html_decode(data.data);
				$('#noticetext').val(val);
				$('.notice_confirm').attr("cwid",cwid);
				H.get('noticediv').exec('show');
				var num = $("#noticediv").find("textarea").val().length
				$(".noticenum").find("span").html(100 - num);
				inputNum();
			}
		}
	});
	
}
var notice_publish = function(){
	var cwid = $('#noticecwid').val();
	$.ajax({
		url:"<?= geturl('troomv2/classcourse/ajax_notice') ?>",
		type:'post',
		data:{'cwid':cwid,notice:$('#noticetext').val()},
		dataType:'json',
		success:function(data){
			if(data.status==1){
				dialog({
							skin:"ui-dialog2-tip",
							content:"<div class='TPic'></div><p>发布公告成功</p>",
							width:350,
							onshow:function () {
								var that=this;
								setTimeout(function() {
									H.get('noticediv').exec('hide');
									that.close().remove();
								}, 1000);
							}
							}).show();
				if($("#noticediv").find("textarea").val() != ""){
					$(".noticebtn[cwid="+cwid+"]").find("span").css("display","block");
				}else{
					$(".noticebtn[cwid="+cwid+"]").find("span").css("display","none");
				}	

			}else{
				dialog({
							skin:"ui-dialog2-tip",
							content:"<div class='FPic'></div><p>发布失败，请稍后再试或联系管理员。</p>",
							width:350,
							onshow:function () {
								var that=this;
								setTimeout(function() {
									that.close().remove();
								}, 2000);
							}
							}).show();
			}
		}
	});	
}


var updatesection = function(){
    var folderid = $("#folderid").val();
	$.ajax({
		url:"<?= geturl('troomv2/section') ?>",
		type:'post',
		data:{'folderid':folderid},
		dataType:'json',
		success:function(data){
			var objhtml='<div style="width:550px;">'
				objhtml+='<div id="categoryBody" style="width:515px">'
				objhtml+='<div id="categoryHead">'
				objhtml+='<table>'
				objhtml+='<tbody>'
				objhtml+='<tr>'
				objhtml+='<td>'
				objhtml+='<input class="categoryName" value="请输入课程目录" type="text" name="sname" id="sname" maxlength="50">'
				objhtml+='</td>'
				objhtml+='<td width="80">'
				objhtml+='<a class="CJsub" href="javascript:void(0);" id="ctitle" onclick="addsction(\'sname\');">'
				objhtml+='<cite>创建目录</cite>'
				objhtml+='</a>'
				objhtml+='</td>'
				objhtml+='</tr>'
				objhtml+='<tr colspan="2">'
				objhtml+='<td>'
				objhtml+='<span class="SG_txtc" style="margin-left:5px;width:290px;display:block;color:#666; text-align:left;">输入1-50个中文、英文、数字字符！</span>'
				objhtml+='</td>'
				objhtml+='</tr>'
				objhtml+='</tbody>'
				objhtml+='</table>'
				objhtml+='<div id="errTips"></div>'
				objhtml+='</div>'
				objhtml+='<form name="form" method="post">'
				objhtml+='<div id="categoryList">'
				objhtml+='<ul class="clearfix" id="tsection">'
				$.each(data,function(k,v){
					objhtml+='<li id="tr'+v.sid+'">'
					objhtml+='<span class="htit" id="'+v.sid+'catitle" ><input type="hidden" id="'+v.sid+'name" value="'+v.sname+'" />'+v.sname+'</span>'
					objhtml+='<span class="control" STYLE="FLOAT:RIGHT">'
					objhtml+='<div class="manage">'
					objhtml+='<a class="CP_a_fuc1" href="javascript:void(0);" onclick="edittitle('+v.sid+')">'
					objhtml+='编辑</a>'
					objhtml+='<a class="CP_a_fuc4" href="javascript:void(0);" onclick="delsction('+v.sid+')">'
					objhtml+='删除</a>'
					objhtml+='<a class="CP_a_fuc2" href="javascript:void(0);" onclick="moveup('+v.sid+')">'
					objhtml+='</a>'
					objhtml+='<a class="CP_a_fuc3" href="javascript:void(0);" onclick="movedown('+v.sid+')">'
					objhtml+='</a>'
					objhtml+='<input type="text" value="'+v.displayorder+'" id="'+v.sid+'displayorder" onblur="editdisplayorder('+v.sid+')"  class="CP_a_fuc5">'
					objhtml+='</input>'
					objhtml+='</div>'
					objhtml+='</span>'
					objhtml+='</li>'
				});
				objhtml+='</ul>'
				objhtml+='<div class="SG_j_linedot"></div>'
				objhtml+='</div>'
				objhtml+='</form>'
				objhtml+='</div>'
				objhtml+='</div>'
				$("#sectiondiv").html(objhtml);
				H.get('sectiondiv').exec('show');
			return;
		}
	});	
}
//-->
</script>

<div class="lefrig" id="lefrig">
<?php $this->display("troomv2/course_menu");?>
<div id='sectiondiv' style="display: none;"></div>
<div id='showtimediv' style="display: none;"></div>
<div id="noticediv">
	<input type="hidden" id="noticecwid">
	<div class="noticetxt">
		<textarea id="noticetext" style="width:460px;height:160px;" ></textarea>
	</div>
	<div class="noticenum">
		<p>您还可输入<span>100</span>字</p>
	</div>
	<div class="noticebtn">
		<input class="notice_confirm" type="button" value="发布" onclick="notice_publish()" />
		<input class="notice_cancel" type="button" value="取消" onclick="H.get('noticediv').exec('hide');" />
	</div>
</div>
<input type="hidden" id="folderid" value="<?= $folder['folderid']?> "/>
<div class="tiezitool">

	<?php $search = $this->input->get('q');?>
	<?php if(empty($sectionlist) && $needsubfolder && empty($search)){?>
	<a class="mulubgbtns" style="margin-right:10px;" href="<?=geturl('troomv2/folder/add/'.$folder['folderid'])?>">添加目录</a>
	<?php }?>
	
	<!-- //判断是否有直播权限 -->
	<?php if(empty($nopermission)){//不是本校的课程,不是本校的服务项,没有这些权限
	if($haslive){?>
	<a class="mulubgbtns" href="<?=str_replace('[folderid]',$folder['folderid'],$live['url'])?>?classid=<?=$classid?>"><?=$live['modulename']?>课</a>
	<?php }?>
	
	<?php if(empty($subfolderlist)){?>
	<a class="mulubgbtns" href="<?= geturl('troomv2/classcourse/add-0-0-0-'.$folder['folderid'].'-course')?>?classid=<?=$classid?>">发布视频课</a><!--
	<a class="chuanbgbtn hongbtn marrig" href="<?= geturl('troomv2/classcourse/addmulti-0-0-0-'.$folder['folderid'])?>">批量上传</a>-->
	<input class="mulubgbtns" type="button" id="addsection" value="课程目录管理" />
	<?php }
	}?>
	
</div>
	<?php if(!empty($subfolderlist)) { ?>
<div class="kejian">
	<ul class="liss">
        <?php foreach($subfolderlist as $subfolder){ ?>
	<li class="danke" style="margin-left:10px; _margin-left:2px;list-style: none;">
	<div class="showimg"><a href="<?=geturl('troomv2/classsubject/'.$subfolder['folderid'])?>" title="<?=$subfolder['foldername']?>"><img src="<?= empty($subfolder['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' : $subfolder['img'] ?>" width="114" height="159" border="0" /></a></div>
	<span class="spne"><a href="<?= geturl('troomv2/classsubject/'.$subfolder['folderid']) ?>" style="text-decoration: none;" title="<?= $subfolder['foldername'] ?>"><?= shortstr($subfolder['foldername'],16,'') ?>(<?= $subfolder['coursewarenum'] ?>)</a></span>
	</li>
        <?php } ?>

	</ul>
	</div>
<?php }?>
	<?php if(empty($subfolderlist)){?>
	
		<?php if(!empty($sectionlist)) { ?>
                                <?php foreach($sectionlist as $k=>$section) { ?>
		<table width="100%" class="datatab" id="tb<?=$k?>">
			<thead class="tabhead">
				<tr>
					<th>
					<div class="biaotis"><a href="javascript:void(0)" style="color:#fff;text-decoration:none; font-size:14px; font-family:微软雅黑;" onclick="showcws('<?=$k?>')"><?=$section[0]['sname']?>(<?=$section[0]['sectioncount']?>)</a></div>
					</th>
				</tr>
			</thead>
			<?php 
			$mediatype = array('flv','mp4','avi','mpeg','mpg','rmvb','rm','mov','swf');
			
			$datenow = date('Y-m-d');
				foreach($section as $cw) { 
					
					
					//头像处理 eker 2016年1月28日16:40:55
					$base_url ='http://static.ebanhui.com/ebh/tpl/default/images/';
					if($iszjdlr){
						if(isset($cw['cwsex'])){
							$defaulturl = ($cw['cwsex'] == 1) ? $base_url."m_woman.jpg" : $base_url."m_man.jpg";
							$face = empty($cw['cwface']) ? $defaulturl : $cw['cwface'];
						}else{
							$defaulturl = ($cw['sex'] == 1) ? $base_url."m_woman.jpg" : $base_url."m_man.jpg";
							$face = empty($cw['face']) ? $defaulturl : $cw['face'];
						}
					}else{
						$defaulturl = ($cw['sex'] == 1) ? $base_url."t_woman.jpg" : $base_url."t_man.jpg";
						$face = empty($cw['face']) ? $defaulturl : $cw['face'];
					}
					$face = getthumb($face,'50_50');
					//直播与普通课件 eker
					$cwtype = ($cw['islive'] == 1 )? 'live' : 'course';
					
					getcwlogo($cw,$playimg,$logo);
					$date = date('Y-m-d',$cw['truedateline']);

				?>
			<tbody>
				<tr>
					<td style="position: relative;">
					<div class="ettyusr">
						<a class="fusrets" style="color:<?= $date==$datenow?'red':'#666'?>" target="_blank" href="<?=  geturl('troomv2/course/'.$cw['cwid']) ?>" title="<?=$cw['title']?>">
						<?php if($iszjdlr){?>
							<?php if(isset($cw['cwtoid']) && $cw['cwtoid'] == 1){?>
								<?php if(empty($cw['logo'])){?>
									<img src="http://static.ebanhui.com/ebh/tpl/2014/images/defaultcwimggray.png?v=20160504001" />
								<?php }else{?>
									<img src="<?= $cw['logo'];?>" />
								<?php }?>
							<?php }else{?>
							<img src="<?='http://static.ebanhui.com/ebh/tpl/2014/images/'.$playimg.'.png'?>"/>
							<?php }?>
						<?php }else{?>
							<img src="<?='http://static.ebanhui.com/ebh/tpl/2014/images/'.$playimg.'.png'?>"/>
						<?php }?>
						</a>
						<img src="<?=$logo?>" />
					</div>
					<div style="float:left;width:780px;position: relative;">
					<?php if(!empty($cw['cwpay'])){?>
					<span href="javascript:void(0)" class="removebtn"><span class="sizle"><?=($cw['cprice']==0)?'免费':('￥'.intval($cw['cprice']))?></span><?=$cw['paytime']?></span>
					<?php }?>
					<?php if(count($section)>1 && empty($nopermission)){?>
					<div class="kuesr" >
					<a href="javascript:void(0)" onclick="moveupcw(<?=$cw['cwid']?>)" title="上移" class="toples"></a>
					<a href="javascript:void(0)" onclick="movedowncw(<?=$cw['cwid']?>)" title="下移"  class="bottomles"></a>
					</div>
					<?php }?>
					<?php if($cw['attachmentnum'] > 0 ) { ?>
						<i class="fujianico" title="此课件包含附件"></i>
					<?php }  ?>
					
					<div>
					<h2 style="font-size:16px;font-weight:bold;height:25px; float:left;">
					<a style="font-size:16px;color:<?= ($cwtype=='live'&&$cw['truedateline']+$cw['cwlength']<=SYSTIME)?'#999':($date==$datenow?'red':'#333')?>;text-decoration:none" target="_blank" href="<?=geturl('troomv2/course/'.$cw['cwid'])?>" title="<?=$cw['title']?>"><?=shortstr($cw['title'],66,'')?></a>
					</h2>	
					<?php if($cwtype=='live'){?>
					<i class="label-live" title="直播课件" style="<?= ($cwtype=='live'&&$cw['truedateline']+$cw['cwlength']<=SYSTIME)?'background:#999999 !important':''?>">直播</i>
					<?php }?>
					</div>
					<div class="clear"></div>
					<p style="line-height:21px;color:#999;width:640px;height:43px; overflow:hidden;"><?=$cw['summary']?></p>
					<div>
						<div style="float:left;margin-right:15px;">
							<img style="width:30px;height:30px; border-radius:15px;float:left;" src="<?=$face?>">
						</div>
						<?php if($iszjdlr){?>
							<?php 
							if(empty($cw['cwusername']) && empty($cw['cwrealname'])){
								$cw['cwusername'] = $cw['username'];
								$cw['cwrealname'] = $cw['realname'];
							}
							if(empty($cw['cwrealname'])){
								$cw['cwrealname'] = $cw['cwusername'];
							}?>
							<p class="lsfbsj"><span style="width:75px; display:block;" title="<?=$cw['cwrealname']?>"><?=shortstr($cw['cwrealname'],8,'...')?></span>
						<?php }else{?>
							<p class="lsfbsj"><span style="width:75px; display:block;" title="<?=$cw['realname']?>"><?=shortstr($cw['realname'],8,'...')?></span>
						<?php }?>
						<span class="fbsj" style="width:145px; margin-left:0;"><?=timetostr($cw['dateline'])?>发布 </span>
						<span class="fbsj" ><span class="fbsj2"></span> <?=max(0,$cw['viewnum'])?></span>
						<span class="fbsj"><span class="fbsj1" style="padding-left:20px;"></span> <?=max(0,$cw['reviewnum'])?></span>
						<?php 
							$arr = explode('.',$cw['cwurl']);
							$type = $arr[count($arr)-1];
							if($type != 'flv' && $cw['ism3u8'] == 1) {
								$type = 'flv';		
						}?>
						<?php if($type == 'flv'){?>
						<span class="fbsj"><span class="fbsj3" style="padding-left:20px;"></span> <?php echo $cw['zannum']?></span>
						<?php }?>
						<?php if(!empty($cw['submitat']) || !empty($cw['endat'])){?>
						<span class="kkjssj"><?=!empty($cw['submitat'])?'开课：'.Date('Y-m-d H:i',$cw['submitat']):''?> <?=!empty($cw['submitat'])&&!empty($cw['endat'])?'&nbsp;':''?> <?=!empty($cw['endat'])?'结束：'.Date('Y-m-d H:i',$cw['endat']):''?></span>
						<?php }?>
						</p>
					</div>
					<?php if(!empty($roominfo['checktype'])){
						if($cw['status'] == 0){?>
							<p style="float:left;width:100px;color:blue">未审核</p>
						<?php }elseif($cw['status'] == -2){?>
							<p style="float:left;width:100px;color:red"><span style="color:red;cursor:pointer;" onclick="checkdetail(<?=$cw['cwid']?>)">审核未通过</span></p>
						<?php }?>
					<?php }?>
		</div>
		
		<?php if($cw['uid'] == $uid) { //自己发布的?>
			<div class="hsidts1s" style="margin-left:<?=$roominfo['isschool']==7?'0':($roominfo['isschool']==3?'0':'0')?>px;float:left;display:inline;width:100%; margin-top:2px; height:28px;" cwid="<?=$cw['cwid']?>">
				
				<!-- 布置作业 分新版和老版本布置-->
				<?php if ($exampower) {?>
					<a href="javascript:;" class="lasrnwe mt5" onclick="window.open('/troomv2/examv2/addexambycw-0-0-0-<?=$folderid?>-<?=$cw['cwid']?>.html?cwtitle=<?=urlencode(urlencode($cw['title']));?>','_blank')" >布置作业</a>
				<?php } else { ?>
				<a href="javascript:;" class="lasrnwe mt5" onclick="window.open('http://exam.ebanhui.com/enew/<?=$roominfo['crid']?>/0/<?=$folderid?>/<?=$cw['cwid']?>.html','_blank')" >布置作业</a>
				<!-- 上传附件/附件管理 -->
				<?php }
				if(!empty($cw['attachmentnum'])) { ?>
					 <a class="lasrnwe mt5" href="<?=  geturl('troomv2/course/'.$cw['cwid']) ?>#upduce" target="_blank">附件管理</a>
				<?php } else { ?>
					 <a class="lasrnwe mt5 upattach" url="<?= geturl('troomv2/classcourse/upattach-0-0-0-'.$cw['cwid']) ?>?classid=<?=$classid?>&dialog=1" href="javascript:;">上传附件</a>
				<?php } ?>
				<!-- 设置定时发布 -->
			<?php if($cw['islive'] != 1) { ?>
			<a href="javascript:;" class="lasrnwe mt5" onclick="showTimeDialog(this)" cwid="<?=$cw['cwid']?>"  submitat="<?=!empty($cw['submitat'])?Date('Y-m-d H:i',$cw['submitat']):''?>" endat="<?=!empty($cw['endat'])?Date('Y-m-d H:i',$cw['endat']):''?>">设置定时发布</a>
			<?php } ?>
			<!-- 学习监控 -->
			<?php if(($roominfo['isschool']==7 || $roominfo['isschool']==3) && ($type=='flv' || $cw['islive'] == 1)){?>
			<a href="<?= geturl('troomv2/classcourse/jkv2-0-0-0-'.$cw['cwid']) ?>?type=0&classid=<?=$classid?>" target="_blank" class="lasrnwe mt5" >学习监控</a>
			<?php }?>
			
			<!-- 统计分析 -->
			<?php if(($roominfo['isschool']==7 || $roominfo['isschool']==3) && ($type=='flv' || $cw['islive'] == 1)){?>
			<a href="<?=geturl('troomv2/classcourse/analysis/'.$cw['cwid'])?>?classid=<?=$classid?>" target="_blank" class="lasrnwe mt5" >统计分析</a>
			<?php }?>
			<!-- 学生反馈-->
			<?php if(in_array($type,$mediatype)){?>
			<a href="/troomv2/feedback/courses/<?=$cw['cwid']?>.html?classid=<?=$classid?>" target="_blank" class="lasrnwe mt5" >学生反馈</a>
			<?php }?>
				
			<?php if($cw['open_chatroom'] == 1 || $cw['islive'] == 1) { ?>
			<a href="javascript:;" class="lasrnwe mt5 noticebtn" cwid="<?=$cw['cwid']?>" onclick="callBoard(<?=$cw['cwid']?>)" >发布公告 <span style="display:<?php if($cw['notice'] == ''){?>none<?php }else{?>block<?php }?>;"></span></a>
			<?php }?>
			
			<!-- 试听设置-->
			<?php if ($cwtype == 'course' && $cw['cwpay'] && $cw['cprice']) {?>
			<a href="javascript:auditionfun($(this),'<?=$cw['cwid']?>')" class="lasrnwe mt5">试听设置</a>
			<?php }?>	
				
				
			<!--分享设置-->
			<?php if($cwtype!='live'||$cw['truedateline']+$cw['cwlength']>SYSTIME){?>	
			<a href="javascript:sharefun( $(this),'<?=$cw['cwid']?>','<?=$cw['title']?>','<?=$cw['submitat']?>','<?=$cw['realname']?>','<?=$cw['logo']?>','<?=$qrcodeconf?>' )" class="lasrnwe mt5">分享</a>
			<?php }?>
				
			<!-- 删除 -->
			<?php if($roominfo['isschool']!=7){?>
			<a href="javascript:;" class="lasrnwe mt2" style="float:right;display:inline;" onclick="delkj(<?= $cw['cwid'] ?>,'<?= str_replace('\'','\\\'',$cw['title']) ?>')"/><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/shanchu.png" /></a>
			<?php }?>
			<!-- 编辑 -->
			<a href="javascript:;" class="lasrnwe mt2" style="float:right;display:inline;" onclick="location.href='<?= geturl('troomv2/classcourse/edit-0-0-0-'.$cw['cwid']."-".$cwtype)?>?classid=<?=$classid?>'"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/xiugai.png" /></a>
			</div>
		<?php } else {//统计都可以看?>
			
			<div class="hsidts1s" style="margin-left:<?=$roominfo['isschool']==7?'0':($roominfo['isschool']==3?'0':'0')?>px;float:left;display:inline;width:100%; margin-top:2px; height:28px;" cwid="<?=$cw['cwid']?>">
				<!-- 学习监控 -->
				<?php if(($roominfo['isschool']==7 || $roominfo['isschool']==3) && $type=='flv'){?>
				<a href="<?= geturl('troomv2/classcourse/jkv2-0-0-0-'.$cw['cwid']) ?>?type=0&classid=<?=$classid?>" target="_blank" class="lasrnwe mt5" >学习监控</a>
				<?php }?>
				
				<!-- 统计分析 -->
				<?php if(($roominfo['isschool']==7 || $roominfo['isschool']==3) && $type=='flv'){?>
				<a href="<?=geturl('troomv2/classcourse/analysis/'.$cw['cwid'])?>?classid=<?=$classid?>" target="_blank" class="lasrnwe mt5" >统计分析</a>
				<?php }?>
				<!-- 学生反馈-->
				<?php if(in_array($type,$mediatype)){?>
				<a href="/troomv2/feedback/courses/<?=$cw['cwid']?>.html?classid=<?=$classid?>" target="_blank" class="lasrnwe mt5" >学生反馈</a>
				<?php }?>	
			</div>
		<?php }?>
			<?php if ($cw['cprice']>0) {?>
				<!--<span class="singleprice">￥<span><?=$cw['cprice']?></span></span>-->
			<?php }?>
			<?php if ($cw['looktime']>0) {?>
				<span class="auditionshow">试听：<span class="auditionshowtime"><?=$cw['looktime']?></span></span>
			<?php }?>
				
				
					</td>
				</tr>
	
			</tbody>
			<?php }}
			}elseif(empty($onlinelist)){
			?>
			<div style="padding:20px 0 20px 160px; font-size:14px;background:white;"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/stuhope.jpg" /></div>
			<?php }
			?>
		</table>
		
		
		

		
	<?php }?>
		
		<div id="sharediaog" style="display: none;">
			
			<div class="marginbott24" style="height: 70px;">
				<p class="sharetitle">链接</p>
				<p>
					<input type="text" name="" id="urladdress" class="urladdress" value="" />
					<span class="clickcopy">复制</span>
				</p>
			</div>
			
			
			<div class="marginbott24" style="height: 114px;">
				<p class="sharetitle">社交分享</p>
				<div style="height: 72px;" class="sharecoursebox">
					<!--<div class="sharecourse"></div>--><!--动态生成-->
				</div>
			</div>
			
			
			<div class="marginbott24" style="height: 185px;">
				<p class="sharetitle">二维码下载</p>
				<div>
					<div class="seeqrbox">
						<div>
							<img class="showqr" src=""/>
						</div>
					</div>
					<div style="float: left;height: 150px;">
						<p class="qrbox">
							<a href="javascript:void(0)" class="qrload">256*256</a>
							<span class="qrtips">适合插入文档</span>
						</p>
						<p class="qrbox">
							<a href="javascript:void(0)" class="qrload">512*512</a>
							<span class="qrtips">适合插入PPT</span>
						</p>
						<p class="qrbox">
							<a href="javascript:void(0)" class="qrload">1024*1024</a>
							<span class="qrtips">适合印刷出版物</span>
						</p>
						<p class="qrbox" style="margin-bottom: 0px;">
							<a href="javascript:void(0)" class="qrloadsvg">矢量图</a>
							<span class="qrtips">适合多样使用场景</span>
							<span style="display: none;" id="svg-wrap" class="svg-wrap"></span>
						</p>
					</div>
				</div>
			</div>
			
			<p>注：点击尺寸进行下载</p>
			
		</div>
		
		
		
		
	<script type="text/javascript">
		//配置swf文件的路径
		ZeroClipboard.config({swfPath: "http://static.ebanhui.com/ebh/js/zeroclipboard/dist/ZeroClipboard.swf"});
		
		var $auditionshowtime = $(".auditionshowtime");
		for(var i=0;i<$auditionshowtime.length;i++){
			$($auditionshowtime[i]).html(TransitionTime($($auditionshowtime[i]).html()));
		}
		function auditionfun(that , cwid){
			var auditionbox = "";
			auditionbox += '<div class="auditionbox" id="auditionbox'+cwid+'" style="display:none">';
			auditionbox += 	'<div class="auditiontime">试听时间：</div>';
			auditionbox += 	'<div id="audition'+cwid+'" class="audition">';
			
			auditionbox +=	'<div class="thebar"><div class="barnowtime" id="barnowtime'+cwid+'">00:00</div><div class="timeball" id="timeball'+cwid+'" cwid="'+cwid+'"></div><div class="thecolorbar" id="thecolorbar'+cwid+'"></div></div>'
							
			auditionbox +=	'</div>';
			auditionbox += 	'<div class="baralltime" id="baralltime'+cwid+'"></div>';
			auditionbox += 	'<div class="auditionall" id="auditionall'+cwid+'">';
			auditionbox += 		'<input type="checkbox" name="alltime" id="alltime'+cwid+'" style="float: left;height:20px;line-height:20px;" />';
			auditionbox += 		'<label for="alltime'+cwid+'" style="cursor:pointer;float: left;height:20px;line-height:20px;">全部</label>';
			auditionbox += 	'</div>';
			auditionbox += '</div>';
			
			$("#lefrig").append(auditionbox);
			
					
			dialog({
				title: '试听设置',
				content: $("#auditionbox"+cwid+"")[0],
				okValue: '确定',
				ok:function(){
					var showtime = $('#barnowtime'+cwid+'').html();
					var arrtime = showtime.split(":");
					if(arrtime.length == 3){
						var hourtime = parseInt(arrtime[0]) * 60 * 60;
						var minutetime = parseInt(arrtime[1]) * 60;
						var secondtime = parseInt(arrtime[2]);
						var totaltime = hourtime + minutetime + secondtime;
					}else{
						var minutetime = parseInt(arrtime[0]) * 60;
						var secondtime = parseInt(arrtime[1]);
						var totaltime = minutetime + secondtime;
					}
					$.ajax({
						type:"post",
						url:"/troomv2/classsubject/setcwLooktime.html",
						data: {"cwid": cwid,"looktime":totaltime},
						async:true,
						success: function(data){
							that.parent().parent().find($(".auditionshowtime")).html(showtime);
							window.location.reload();
						}
					});
				},
				cancelValue: '取消',
				cancel:function(){
					
				},
				onshow:function(){
					var looktime, cwlength;
					$.ajax({
						type:"post",
						url:"/troomv2/classsubject/setcwLooktime.html",
						data:{"cwid":cwid,"init":1},
						async:false,
						dataType:'json',
						success:function(json){
							looktime = parseInt(json.data.looktime);
							cwlength = parseInt(json.data.cwlength);
						}
					});
					$.playBar.addBar($('#audition'+cwid+''), cwlength, looktime ,cwid);//第一个参数是需要显示播放器的容器，第二个参数为时间，单位秒,第三个参数是表示当前已有时间，第四个参数为课程id	
					$("#auditionall"+cwid+"").click(function(){
				  		if($('#alltime'+cwid+'').get(0).checked){
				  			thewidth = $("#audition"+cwid+"").width();
							$('#barnowtime'+cwid+'').html($(".baralltime").html());
							$('#barnowtime'+cwid+'').css('left', thewidth - 15);
				       	 	$('#thecolorbar'+cwid+'').css( 'width',thewidth);
				       	 	$('#timeball'+cwid+'').css('left', thewidth);
						}else{
							
						}
				  		if($('#barnowtime'+cwid+'').html() == $('#baralltime'+cwid+'').html()){
				        	$("#alltime"+cwid+"").prop("checked",true);
				       	}else{
				        	$("#alltime"+cwid+"").prop("checked",false);
				        }
				  	});
				},
				onclose:function(){
					$(".auditionbox").empty();
					$(".auditionbox").remove();
					$(this).remove();
					auditionbox = "";
				}
			}).showModal();
		}
		
		function getLocalTime(nS) {
            var now = new Date(nS*1000),
               year = now.getFullYear(),
               month = (now.getMonth()+1) < 10 ? '0' + (now.getMonth()+1):now.getMonth()+1,
               date = now.getDate() < 10 ? '0' + now.getDate() : now.getDate(),
               hour = now.getHours() < 10 ? '0' + now.getHours() : now.getHours(),
               minute = now.getMinutes() < 10 ? '0' + now.getMinutes() : now.getMinutes();
            return   year+"-"+month+"-"+date+" "+hour+":"+minute;     
       	};


		var $sharediaog = $('#sharediaog')[0];
		function sharefun(that , cwid , title , time , name , img , url){
			dialog({
				title: '课件分享',
				content: $sharediaog,
				okValue: '关闭',
				ok:function(){
					ZeroClipboard.destroy();
				},
				onshow:function(){
					var $urladdress = $('#urladdress');	//复制的内容框
					var $clickcopy = $('.clickcopy'); 	//复制按钮
					var sharehref = 'http://'+window.location.host+'/course/share/'+cwid+'.html'; //分享的地址
					
					//复制地址操作
					$urladdress.val(sharehref);
					var client = new ZeroClipboard( $clickcopy );
			    	client.on( 'ready', function(event){
				        client.on( 'copy', function(event){
					      var txt = $urladdress.val();
				          event.clipboardData.setData('text/plain', txt);
				        });
				        client.on( 'aftercopy', function(event){
				        	alert('复制成功！');
				        });
			      	});
			    	client.on( 'error', function(event){
			        	ZeroClipboard.destroy();
			      	});
			      	
			      	
			      	
					//分享操作
					var description = "";
					var summary = "";
					if(time == 0){
						description = '分享学习，分享快乐！'+name+'讲师在网校平台开课了，一起来学习吧！';
						summary = ''+name+'讲师在网校平台开课啦，主讲'+title+'课程，快来一起参与吧！';
					}else{
						time = getLocalTime(time);
						description = '分享学习，分享快乐！'+name+'讲师在网校平台开课了，时间是'+time+'，一起来学习吧！';
						summary = ''+name+'讲师在网校平台开课啦，主讲'+title+'课程，时间是'+time+'，快来一起参与吧！';
					};
					if(!img){
						img = "http://static.ebanhui.com/portal/images/ebh_logo_qrcode.png";
					}else{
						img = img;
					}
					
					var sharecourse = "<div class='sharecourse'></div>";
					$('.sharecoursebox').append(sharecourse);
					$('.sharecourse').share({
						url: sharehref,
						source: 'e板会',
						title: ''+name+'讲师《'+title+'》',
						description: description,
						summary: summary,
						image: img,
						sites: ['wechat','weibo','qq','qzone']
					});


					//二维码操作
			      	var qrsharehref = encodeURIComponent(sharehref);
			      	$.ajax({
						type:"get",
						url: url,
						async:true,
						data:{'content':qrsharehref},
						dataType: 'json',
						success:function(res){
							res = res.showurl;
							$('.showqr').attr('src',res);
							$('.qrcode img').attr('src',res);
						}
					});
					var download256 = url+ '?content='+qrsharehref+'&down=1'+ '&size=8';
					var download512 = url+ '?content='+qrsharehref+'&down=1'+ '&size=16';
					var download1024 = url+ '?content='+qrsharehref+'&down=1'+ '&size=32';
					$($('.qrload')[0]).attr('href',download256);
					$($('.qrload')[1]).attr('href',download512);
					$($('.qrload')[2]).attr('href',download1024);
			      	//生成矢量图
			      	$('.qrloadsvg').click(function(){
			      		var qrcodesvg = new Qrcodesvg(sharehref, "svg-wrap", 250);
						qrcodesvg.draw();
						qrcodesvg.createSquare();
						
						var svgXml = $('.svg-wrap').html();
						var image = new Image();
						image.src = 'data:image/svg+xml;base64,' + window.btoa(unescape(encodeURIComponent(svgXml))); //给图片对象写入base64编码的svg流
						var a = document.createElement('a');
						a.href = image.src; //直接导出SVG
						a.download = mathRand(); //设定下载名称
						a.click(); //点击触发下载 
						
						// 随机生成数字
						function mathRand() {
							var num = "";
							for(var i = 0; i < 6; i++) {
								num += Math.floor(Math.random() * 10);
							}
							return num;
						}
			      	});
				},
				onclose:function(){
					ZeroClipboard.destroy();
					$('.sharecourse').empty();
					$('.sharecourse').remove();
				}
			}).showModal();
		}
		
		function TransitionTime(str) {		//时间转换，秒转换成00:00:00格式
	    	var totalstr;
	       	
	       	var second = str % 60;
	       	if(second < 10 && second > 0){
	       		second = "0"+ parseInt(second);
	       	}else if(second <= 0){
	       		second = "00";
	       	}else{
	       		second = parseInt(second);
	       	}
	       	var minute = parseInt(str / 60) % 60;
	       	if(minute < 10 && minute > 0){
	       		minute = "0"+ minute;
	       	}else if(minute <= 0){
	       		minute = "00";
	       	}else{
	       		minute = minute
	       	}
	       	var hour = parseInt(parseInt(str / 60) / 60);
	       	if(hour > 0 && hour < 10){
	       		hour = "0"+ hour;
	       		var totalstr = hour +":"+ minute +":"+ second;
	       	}else if(hour > 10){
	       		hour = hour;
	       		var totalstr = hour +":"+ minute +":"+ second;
	       	}else{
	       		var totalstr = minute +":"+ second;
	       	}
	       	return totalstr;
	    }
		
		
	(function($){
		$.confirm = function(params) {
		var settings = $.extend({
			title           : '删除确认',
			message         : '您确定要删除此条信息吗？',
			yes				: function(){}
			},params||{}
		);
		//设置传递参数时可以不用json格式
		if(arguments.length == 1){
			settings.yes = arguments[0];
		}else if(arguments.length == 2){
			if (arguments[0] != "") {
				settings.message = arguments[0];
			}
			settings.yes = arguments[1];
		}else if(arguments.length == 3){
			if(arguments[0] != "") {
				settings.title = arguments[0];
			}
			if(arguments[1] != ""){
				settings.message = arguments[1];
			}
			settings.yes = arguments[2];
		}
		 
		settings.width = 450;
		settings.height = 170;
		// alert($(window.parent.document).scrollTop());
		// alert(($(window.parent).height()+$(window.parent).scrollTop()-settings.height)/2);
		// alert(settings.height);
		// alert($(parent.document).scrollTop());
		// alert($(window.parent).scrollTop() + ($(window.parent).height() - settings.height)/2);
		// // settings.scrollTop = documenst.documentElement.scrollTop || document.body.scrollTop;

		settings.css = "position: absolute;background-color:white;width:450px;height:200px;z-index:1000; border-radius: 10px;";
		settings.css += 'left:' + ($(window.parent.document).scrollLeft() + ($(window.parent.document).width() - settings.width )/2 ) + 'px;';
		settings.css += 'top:' + (($(window.parent).height()+$(window.parent).scrollTop()-settings.height)/3) + 'px;';
		// alert($(window.parent.document).height()/2-170+":"+$(window.parent.document).scrollTop());
		// background:url(/static/images/ie.png) repeat 0 0;
		settings.confirm = "width:100%;position:absolute;left:0;top:0;background:#808080;filter:alpha(opacity=50);opacity:0.5; z-index:9;";
		settings.confirm += "height:"+$(parent.document).height()+"px;";
		settings.ketit = 'height:32px;line-height:32px;padding:0 10px; background:#f9f9f9;border-bottom:1px solid #dbdbdb; font-size:16px; font-weight:normal;';
		settings.blues = 'background:url(http://static.ebanhui.com/ebh/images/guanbtn0820.jpg) no-repeat; display: block; height:11px; left:425px; position:absolute; top:7px; width:11px;';
		settings.sckj = 'width:410px;height:100%;font-family:微软雅黑;margin-left:20px;background:none;';
		settings.xuanbtn2s = 'width:255px;margin-top:55px;';
		settings.xuanbtn2sajxxk = 'width:112px;height:32px;line-height:32px;float:left;';
		settings.xuanbtn2saqkks ='width:112px;height:32px;line-height:32px;float:right;';
		settings.kcxztsxx = 'font-size:16px;padding-top:25px;margin-top:0;';

		settings.html = '<div class="delcrm" style="position:absolute;top:0;left:0;width:100%;height:100%;">'
		settings.html += '<div class="confirm" style="'+settings.confirm+'">';
		settings.html += '</div>'
		settings.html += '<div class="tannew" style="'+ settings.css +'">';
		settings.html += '<h2 class="ketit" style="'+ settings.ketit +'">'+ settings.title +'<a href="#" class="blues" style="'+ settings.blues +'"></a></h2>';
		settings.html += '<div class="sckj" style="'+settings.sckj+'">';
		settings.html += '<div class="kcxztsxx" style="'+settings.kcxztsxx+'">'+settings.message+'</div>';
		settings.html += '<div class="xuanbtn xuanbtn2s" style="'+settings.xuanbtn2s+'">';
		settings.html += '<a href="#" class="jxxk" style="'+settings.xuanbtn2sajxxk+'">确认</a>';
		settings.html += '<a href="#" class="qkks" style="'+settings.xuanbtn2saqkks+'">取消</a>';
		settings.html += '</div>';
		settings.html += '</div>';
		settings.html += '</div>';
		$(window.parent.document.body).append(settings.html);
		

		$(".blues",window.parent.document).click(function(){
			$(".delcrm",window.parent.document).remove();
		});
		$(".qkks",window.parent.document).click(function(){
			$(".delcrm",window.parent.document).remove();
		});
		$(".jxxk",window.parent.document).click(function(){
			$(".delcrm",window.parent.document).remove();
			settings.yes();
		});
	};
})(jQuery)
	</script>
	<script type="text/javascript">
	/*******************设置定时发布****************************/
		//设置定时发布
		function showTimeDialog(obj){
			$('#submitat').attr("value",$(obj).attr('submitat'));
			$('#endat').attr("value",$(obj).attr('endat'));
			$('#cwid').attr("value",$(obj).attr('cwid'));
			var objhtml = $("#timingdiv").html();
			var dom = $(objhtml);
			//清空缓存
			dom.find("#endat").next().attr("id","_cwid");
			dom.find("#submitat").attr("id","_submitat");
			dom.find("#endat").attr("id","_endat");
			
			$("#showtimediv").empty();
			$("#showtimediv").append(dom);

			H.create(new P({
				id : 'showtimedivx',
			    title: '设置定时发布',
			    padding:2,
			    easy:true,
			    width:420,
			    height:230,
			    content:dom
			},{'onclose':function(){dialog.get('showtimedivx').remove();}}),'common');
			
			H.get('showtimedivx').exec('show');
		}

		//取消
		function closeTimeDialog(){
			//H.get('showtimediv').exec('close');
			//H.get('showtimediv').exec('remove');
			dialog.get('showtimedivx').remove();
		}
		//确定发布
		function settime(obj){
			var showobj = $(obj).parent().parent();
			var submitat = $(showobj).find('#_submitat').val();
			var endat = $(showobj).find('#_endat').val();
			var curcwid = $(showobj).find('#_endat').next().val();

			//console.log(submitat);
			//console.log(endat);
			//console.log(curcwid);
			//return false;
			
			$.ajax({
				type:'post',
				url:'/troomv2/classsubject/setcwtiming.html',
				data : {submitat:submitat,endat:endat,cwid:curcwid},
				success:function(data){
					if(data!=0){
						location.reload();
					}else{
						 dialog({
						 title:"提示信息",
						 content:"设置失败",
						 cancel:false,
						 okValue:"确定",
						 ok:function(){
						 this.close().remove();
						 }
						 }).show();
						}
				}
			});
		}
		/*******************设置定时发布****************************/

		
		function showcws(tbid){
			if($('#tb'+tbid+' tbody').css('display')=='none')
				$('#tb'+tbid+' tbody').show();
			else
				$('#tb'+tbid+' tbody').hide();
		}
		var showtd = false;
		var currenttimingbtn;
		var currentcw ;
		/*
		$('.settiming').click(function(e){
			// var offset = this.offset();
			$('#timingdiv').css('top',e.clientY+20);
			$('#submitat').val($(this).attr('submitat'));
			$('#endat').val($(this).attr('endat'));
			$('#timingdiv').show();
			showtd = true;
			currenttimingbtn = $(this);
			
		});
		
		$('body').click(function(e){
			obj = e.srcElement ? e.srcElement : e.target;
			if(obj.parentNode == $('#timingdiv')[0] || obj == $('#timingdiv')[0])
				;
			else if(showtd == false){
				$('#timingdiv').hide();
			}
			showtd = false;
		});
		*/

		$('.dbbtn').dblclick(function(){
			location.href="<?= geturl('troomv2/classcourse/addmulti-0-0-0-'.$folder['folderid'])?>";
		});
		
		function delkj(cwid,title){
			$.confirm("确认删除课件[ " + title +" ]吗？",function(){
				var url = "/troomv2/classcourse/del.html";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {'cwid':cwid},
                    dataType:"json",
                    success: function(data){
                      if(data.status == 1) {
						dialog({
				        skin:"ui-dialog2-tip",
				        width:350,
				        content: "<div class='TPic'></div><p>课件删除成功</p>",
                           onshow:function () {
                           	var that=this;
                           	setTimeout(function() {
                           		that.close().remove();
                                   location.reload();
                           	}, 1000);}
                           }).show();
                      } else {
						dialog({
						skin:"ui-dialog2-tip",
						width:350,
						content: "<div class='FPic'></div><p>课件删除失败</p>",
						onshow:function () {
							var that=this;
							setTimeout(function() {
								that.close().remove();
							}, 2000);}
						}).show();
                      }
                    }
                 }); 
			});
		
		}
function moveupcw(cwid){
	
	$.ajax({
		url:"<?= geturl('troomv2/classsubject/moveup') ?>",
		type:'post',
		data:{'cwid':cwid},
		dataType:'json',
		success:function(data){
			if(data==1){
				location.reload(true);
			}else{
				top.dialog({
				title:"提示信息",
				content:"已经在顶部,操作取消",
				cancel:false,
				okValue:"确定",
				ok:function(){
				this.close().remove();
				}
				}).showModal();
			}
		}
	});

}

function movedowncw(cwid){
	$.ajax({
		url:"<?= geturl('troomv2/classsubject/movedown') ?>",
		type:'post',
		data:{'cwid':cwid},
		dataType:'json',
		success:function(data){
			if(data==1){
				location.reload(true);
			}else{
				top.dialog({
				title:"提示信息",
				content:"已经在底部,操作取消",
				cancel:false,
				okValue:"确定",
				ok:function(){
				this.close().remove();
				}
				}).showModal();
			}
		}
	});

}

$(".datatab tr").mouseover(function(){
	$('.kuesr').hide();
	$(this).find('.kuesr').show();
});
$(".datatab tr").mouseleave(function(){
	$('.kuesr').hide();
});

	function checkdetail(toid) {
		var button = new xButton();
		button.add({
			value:"关闭",
			callback:function(){
				H.get('dialogremark').exec('close');
				return false;
			},
			autofocus:true
		});
		if(!H.get('dialogremark')){
			H.create(new P({
				id : 'dialogremark',
				title: '审核详情',
				easy:true,
				width:400,
				padding:5,
				content:$('#dialogremark')[0],
				button:button
			}),'common');
		}

		$.post("<?=geturl('troomv2/classsubject/getcheckdetail')?>",{toid:toid},function(data){
			if(data != null && data != undefined && data.code == 1){
				$("#teach_status").html(data.teach_status);
				$("#teach_dateline").html(data.teach_dateline);
				$("#teach_remark").html(data.teach_remark);
				H.get('dialogremark').exec('show');
			}
		},'json');

	}
//弹窗上传附件
	$(function() {
        $(".upattach").on("click", function() {
            top.dialog({
				id:"coleck",
                title: "上传附件",
                url: $(this).attr('url'),
				width: 960,
                height: 460,
                padding: 10
            }).showModal(); //show:无遮罩层,showModal:有遮罩层，需要全屏显示请在dialog前加上top,例：top.dialog({....}).showModal()
        });
	});
		
	</script>
	<div style="margin-top:20px;"><?= $page ?></div>
</div>

<!--备注信息-->
<div id="dialogremark" style="display:none;height:160px;">
	<div style="height:160px;width:350px;padding-left:50px;">
	    <div class="mt15">
	    	<span>审核结果：</span>
	    	<span id="teach_status"></span>
	    </div>
	    <div class="mt15">
	    	<span style="vertical-align:top;">审核时间：</span>
	        <span id="teach_dateline"></span>
	    </div>
	    <div class="mt15">
	    	<span style="vertical-align:top;">备注信息：</span>
	        <span id="teach_remark"></span>
	    </div>
	</div>
</div>

<!-- 定时发布 弹窗 -->
<div id="timingdiv" class="timingdiv" style="display:none;">
	<div class="timingbox" >
	<span style="display:inline;line-height:45px;">开课时间：</span>
	<input type="text" id="submitat" value="" readonly="readonly" style="text-indent:15px;height:32px;line-height:32px;border:1px solid #CBD1DB;width:250px;margin:5px;" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'%y-%M-%d %H:%m:%s'});"/>
	</div>
	<div style="clear:both;"></div>
	<div class="timingbox" >
	<span style="display:inline;line-height:45px;">截止时间：</span>
	<input type="text" id="endat" value="" readonly="readonly" style="text-indent:15px;height:32px;line-height:32px;border:1px solid #CBD1DB;margin:5px;width:250px;" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:'#F{$dp.$D(\'submitat\',{H:1})||\'%y-%M-%d {%H+1}:%m:%s\'}'});"/>
	<input id="cwid" name="cwid" type="hidden"  value="" />
	</div>
	<span style="margin-left:95px; margin-left:5px\9; color:#666;width:190px">学生在此时间段内才能学习该课件</span>
	<div class="qdqx">
		<a href="javascript:;" class="qure" style="color:#fff; background:#5e96f5;margin-left:80px;"  onclick="settime(this)">确认</a>
		<a href="javascript:;" class="quxi" style="color:#999;float:left;margin-left:20px;" onclick="closeTimeDialog()">取消</a>
	</div>
</div>
<?php $this->display('troomv2/page_footer'); ?>