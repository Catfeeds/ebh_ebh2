<?php
$this->display('troomv2/page_header');
$roominfo = Ebh::app()->room->getcurroom();
$v = getv();
?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2016/css/covers.css<?=$v?>" />
<!-- 引入ztree -->
<link rel="stylesheet" href="http://static.ebanhui.com/ebh/js/xztree/css/zTreeStyle/zTreeStyle.css<?=$v?>" type="text/css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.core-3.5.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/js/template/template-native-debug.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/js/jqPaginator.js"></script>
<link rel="stylesheet" href="http://static.ebanhui.com/exam/js/jquery/jquery-ui-resizable/jquery-ui.min.css" />
<script type="text/javascript" src="http://static.ebanhui.com/exam/js/jquery/jquery-ui-resizable/jquery-ui.min.js"></script>
<style  type="text/css">
.kejian {
	width: 1000px;
	background:#fff;
	float:left;
	border:none;
}
.kejian .showimg {
	margin-top: 10px;
	margin-left: 14px;
}
.kejian liss {
	width: 748px;
}
.kejian .liss .danke {
	width: 145px;
	float: left;
	margin-left:20px;
	display:inline;
	margin-top: 8px;
	height: 218px;
}
.kejian .liss .danke .spne {
	text-align: center;
	width: 135px;
	height: 36px;
	line-height:15px;
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

.showimg { float:left;}
.showimg img {border:1px solid #CDCDCD; padding:4px; position:relative; left:-4px; top:-5px;}
.hover .showimg img { border:1px solid ;}
.showimg .hover{border: 1px solid;}


.noke {
	height: 480px;
	width: 786px;
	float: left;
	border: 1px solid #cdcdcd;
	background: #fff;
}
.noke p {
	background: url(http://static.ebanhui.com/ebh/tpl/2012/images/nokejianico.jpg) no-repeat;
	height: 120px;
	margin-top: 90px;
	margin-left: 170px;
	padding-left: 140px;
	font-size: 16px;
	padding-top: 30px;
    width: 307px;
}
.noke span {
	color: #e94f29;
}
.work_mes {
	height:auto;
	border-bottom:solid 1px #ffffff;
}
.danke:hover{ box-shadow:0 0 5px #ccc;}
.bordershadow{
	top:135px;
	height:24px;
}
#treeEnterprise .button{
	float: none;
}
#treeEnterprise .line{
	float: none;
	height: inherit;
}
#treeEnterprise li{
	padding: 5px;
}
#treeEnterprise .colorred{
	color: red;
}
#treeEnterprise li a{
	/*max-width: 180px;
	white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;*/
}
.enterprise{
	width: 100%;
	float: left;
}
.enterprise .left{
	width: 258px;
	float: left;
	border-top: 1px solid #f2f2f2;
	border-right: 1px solid #f2f2f2;
	overflow: hidden;
}
.enterprise .right{
	width: 740px;
	float: left;
	border-top: 1px solid #f2f2f2;
}
.enterprise .right ul{
	width: 100%;
}
#treeEnterprise{
	min-height: 600px; 
}
.work_tab li{
	cursor: pointer;
}
.work_tab li.work_tab_active{
	border-bottom: 3px solid #4c88ff;
}
.paginationbox{
	width: 500px;
	float: right;
}
.paginationbox .pagination{
	float: right;
	margin-right: 20px;
}
.enterprise .pagination li{
	float: left;
	list-style: none;
}
.enterprise .pagination>li>a {
  	margin-right: 5px;
  	border-radius: 2px;
  	background: #f9f9f9;
  	color: #767676;
  	border-color: #f9f9f9;
  	padding: 6px 15px;
  	font-weight: bold;
}
.enterprise .pagination>li>a:hover,
.enterprise .pagination>li>a:focus {
  	color: #FFFFFF;
  	background: #23a1f2;
  	border-color: #23a1f2;
  	font-weight: bold;
}
.enterprise .pagination>.active>a,
.enterprise .pagination>.active>a:hover,
.enterprise .pagination>.active>a:focus {
  	color: #FFFFFF;
  	background: #23a1f2;
  	border-color: #23a1f2;
  	font-weight: bold;
}
.enterprise .pagination .next{
  	background: none;
  	width: inherit;
  	height: inherit;
}
.enterprise .pagination li.disabled{
  	display: none;
}
</style>
<SCRIPT LANGUAGE="JavaScript">
<!--
	$(function(){
		$(".showimg").parent().hover(function(){
			$(this).siblings().find("img").stop().animate({opacity:'1'},1000);
			$(this).addClass("hover");
		},function(){
			$(this).siblings().find("img").stop().animate({opacity:'1'},1000);
			$(this).removeClass("hover");
		});
	});
//-->
</SCRIPT>
<script type="text/javascript">
<!--
function degroup() {
	if (!confirm("确认要删除该课程？")) {
		return false;
	}
	return true;
} 
function check_layer(_this)
{
	if(_this.foldername.value == ''){
		alert("课程名称不能为空");
		return false;
	}
	var reg =/^[1-9]\d*(\.0+)?$|^0(\.0+)?$/;
	if(_this.displayorder.value!=''){
		if(!reg.test(_this.displayorder.value)){
			alert("排序编号必须为数字");
			return false;
		}
	}else{
		alert("排序编号不能为空");
		return false;
	}
	return true;
}
function updategroup(crname,folderid,displayorder,upid)
{
	H.get('updiv').exec('show');
	$('#foldername').val(crname);
	$('#displayorder').val(displayorder);
	$('#upid').val(upid);
	$('#folderid').val(folderid);
	var ieset = navigator.userAgent;
}
function addgroup(foldername,folderid,upid){
	H.get('adddiv').exec('show');
	$('#upid').val(upid);
	if(!folderid){
		$('#upid1').val('');
		$("#folder").show();
		$("#folder1").hide();
	}else{
		$('#fname').html(foldername);
		$('#upid1').val(folderid);
		$('#upid').val('');
		$("#folder1").show();
		$("#folder").hide();
	}
	var ieset = navigator.userAgent;
}
$(function(){
	buttons = new xButton();
	buttons.add({
		value:'取消',
		callback:function(){
			H.get('updiv').exec('close');
			return false;
		},
		autoFocus:true
	});
	buttons.add({
		value:'确定',
		callback:function(){
			if(check_layer(document.getElementById('upform'))) document.getElementById('upform').submit();
			H.get('updiv').exec('close');
			return false;
		}
	});
	H.create(new P({
		id:'updiv',
		content:$("#updiv")[0],
		title:'修改课程',
		width: 360,
		height: 230,
		easy:true,
		button:buttons
	}),'common');




	buttons2 = new xButton();
	buttons2.add({
		value:'取消',
		callback:function(){
			H.get('adddiv').exec('close');
			return false;
		},
		autoFocus:true
	});
	buttons2.add({
		value:'确定',
		callback:function(){
			if(check_layer(document.getElementById('addform'))) document.getElementById('addform').submit();
			H.get('adddiv').exec('close');
			return false;
		}
	});

	H.create(new P({
		id:'adddiv',
		content:$("#adddiv")[0],
		title:'添加课程',
		width: 360,
		height: 230,
		easy:true,
		button:buttons2
	}),'common');

});
//-->
</script>
	
	<div class="lefrig">
	
	<div class="waitite">
			<div class="work_menu" style="position:relative;margin-top:0">
				<ul>
					<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso"><?=$pagemodulename?></span></a></li>
				</ul>
			</div>
		<?php $this->assign('currentindex',0);
		$this->display('troomv2/courselinkbar');?>
	</div>


<div class="work_mes">
	<ul class="work_tab">
	</ul>
</div>
<div class="enterprise">
	<div class="left" id="resizableleft">
		<ul id="treeEnterprise" class="ztree"></ul>
	</div>
	<div class="right studycourse studycourse-1" id="resizableright">
		<ul class="treecontent">
			
		</ul>
		<div class="paginationbox">
			<div id="paginator" class="pagination"></div>
		</div>
		
	</div>
</div>

</div>
<script type="text/html"  id="t:tabs">
	<%for(var i=0;i<tabs.length;i++){%>
		<li class="" onclick="getztreedata(<%=tabs[i].sourceid%>,<%=tabs[i].index%>)"><a href="javascript:void(0)"  title="<%=tabs[i].name%>"><span><%=tabs[i].name%></span></a></li>
	<% } %>
</script>

<script type="text/html"  id="t:treecontent">
	<%for(var i=0;i<treecontent.length;i++){%>
		<li>
			<a href="/troomv2/classsubject/<%=treecontent[i].folderid%>.html?classid=<%=treecontent[i].classid%>" title="<%=treecontent[i].foldername%>(<%=treecontent[i].coursewarenum%>)">
				<% if(treecontent[i].img){%>
					<img class="courseimg-2" src="<%=treecontent[i].img%>" width="212" height="125">
				<%}else{%>
					<img class="courseimg-2" src="http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_247_147.jpg" width="212" height="125">
				<%}%>
			</a>
			<a href="/troomv2/classsubject/<%=treecontent[i].folderid%>.html?classid=<%=treecontent[i].classid%>" title="<%=treecontent[i].foldername%>(<%=treecontent[i].coursewarenum%>)" class="coursrtitle-2"><%=treecontent[i].foldername%>(<%=treecontent[i].coursewarenum%>)
			<div class="bordershadow" title="<%=treecontent[i].foldername%>(<%=treecontent[i].coursewarenum%>)"></div></a>
		</li>
	<% } %>
</script>
<script>
var pagesize = 20;
var nodata = '<div class="nodata"></div>';
var setting = {
	data: {
		simpleData: {
			enable: true,
			idKey: "classid",
			pIdKey: "superior",
			
		},
		key: {
			title: "fullname"
		}
	},
	callback: {
		onClick: onClick,
		beforeClick: zTreeBeforeClick,
		onCollapse: zTreeOnCollapse,  
        onExpand: zTreeOnExpand
	},
	view: {
        selectedMulti: false,
        nameIsHTML: true,
        fontCss: setFontCss,
        dblClickExpand: false
        
  	}
};
function zTreeBeforeClick(treeId, treeNode, clickFlag){
	var haspower = treeNode.haspower;
	if(!haspower){
		return false;
	}
}
function onClick(event, treeId, treeNode, clickFlag) {
	$('#paginator').empty();
	$('.treecontent').empty();
	$.ajax({
		url:'/troomv2/enterprise/deptcourse.html?classid='+treeNode.classid,
		method:'get',
		dataType:'json',
		data : {
			pagesize : pagesize,
			page : 1,
			sourceid : treeNode.sourceid
		}
	}).done(function(res){
		var code = res.code;
		var datas = res.data;
		if(code == 0){
			if(!isEmptyObject(datas)){
				if(datas.coursecount){
					if(datas.coursecount <= pagesize){
						for(var i=0;i<datas.courselist.length;i++){
							datas.courselist[i].classid = treeNode.classid;
						}
						var data = {
							'treecontent' :datas.courselist
						}
						if(datas.courselist){
							var $dom = $(template('t:treecontent',data));
							$(".treecontent").html($dom);
							
						}
						parent.resetmain()
					}else{
						setTimeout(function(){
							$('#paginator').jqPaginator({
							    totalCounts: parseInt(datas.coursecount),
							    pageSize : pagesize,
							    visiblePages: 10,
							    currentPage: 1,
							    disableClass :'disabled',
							    first: '',
							    prev: '<li class="prev"><a href="javascript:void(0);">上一页</a></li>',
							    next: '<li class="next"><a href="javascript:void(0);">下一页</a></li>',
							    last: '',
							    page: '<li class="page"><a href="javascript:void(0);">{{page}}</a></li>',
							    onPageChange: function (num) {
							    	var treeObj = $.fn.zTree.getZTreeObj("treeEnterprise");
									var nodes = treeObj.getSelectedNodes();
									getpagedeptcourse(nodes,num)
							    }
							});
						},0)
					}
				}else{
					$(".treecontent").append(nodata);
				}
				
			}else{
				$(".treecontent").append(nodata);
				$('#paginator').empty();
			}
			
			
		}
	}).fail(function(){
		//console.log('req err');
	});
}
function getpagedeptcourse(treeNode,pagenum){
	var haspower = treeNode[0].haspower;
	if(!haspower){
		return false;
	}
	$('.treecontent').empty();
	$.ajax({
		url:'/troomv2/enterprise/deptcourse.html?classid='+treeNode[0].classid,
		method:'get',
		dataType:'json',
		data : {
			pagesize : pagesize,
			page : pagenum,
			sourceid : treeNode[0].sourceid
		}
	}).done(function(res){
		var code = res.code;
		var datas = res.data;
		if(code == 0){
			if(!isEmptyObject(datas)){
				for(var i=0;i<datas.courselist.length;i++){
					datas.courselist[i].classid = treeNode[0].classid;
				}
				var data = {
					'treecontent' :datas.courselist
				}
				if(datas.coursecount){
					var $dom = $(template('t:treecontent',data));
					$(".treecontent").html($dom);
				}else{
					$(".treecontent").append(nodata);
				}
				parent.resetmain()
			}else{
				$(".treecontent").append(nodata);
			}
			
			
		}
	}).fail(function(){
		//console.log('req err');
	});
}
function setFontCss(treeId, treeNode) {
	return !treeNode.haspower? {color:"#bfcbd9",cursor:"not-allowed",background:"#eef1f6",border:"1px solid #fff",height:" 17px",padding:"1px 3px 0 0"} : {};	
};
function zTreeOnCollapse(event, treeId, treeNode) {
    parent.resetmain()
};
function zTreeOnExpand(event, treeId, treeNode) {
    parent.resetmain()
};
function tabworks(gettabs){
	gettabs();
}
function isEmptyObject(e) {  
    var t;  
    for (t in e)  
        return !1;  
    return !0  
}  
function gettabdata(){
	$('.work_tab').empty();
	var tabdata = {
		'tabs' : [{
			name : '本校课程',
			sourceid :0,
			index : 0
		}]
	}
	var $dom = $(template('t:tabs',tabdata));
	$(".work_tab").append($dom);
	getztreedata();
	$('.work_tab li').eq(0).addClass('work_tab_active');
	$.ajax({
		url:'/troomv2/enterprise/schsource.html',
		method:'get',
		dataType:'json',
		data : {
		}
	}).done(function(res){
		var code = res.code;
		var datas = res.data;
		if(code == 0){
			for(var i=0;i<datas.length;i++){
				datas[i].index = i+1;
			}
			var newtab = {
				'tabs' : datas
			}
			var $doms = $(template('t:tabs',newtab));
			$(".work_tab").append($doms);
		}
	}).fail(function(){
		//console.log('req err');
	});
}
function getztreedata(tabid,index){
    parent.window.layer.load();
	$(".treecontent,#paginator").empty();
	$('.work_tab li').removeClass('work_tab_active').eq(index).addClass('work_tab_active');
	$.ajax({
		url:'/troomv2/enterprise/department.html',
		method:'get',
		dataType:'json',
		data : {
			sourceid : tabid
		}
	}).done(function(res){
		var code = res.code;
		var datas = res.data;
		if(code == 0){
			for(var i=0;i<datas.length;i++){
				datas[i].sourceid = tabid;
				datas[i].name =  datas[i].classname+"(<span class='colorred'>"+ datas[i].coursecount +"</span>)";
				datas[i].fullname = datas[i].classname+"("+ datas[i].coursecount +")";
			}
			$.fn.zTree.init($("#treeEnterprise"), setting, datas);
			var treeObj = $.fn.zTree.getZTreeObj("treeEnterprise");
			treeObj.expandAll(true);
			setTimeout(function(){
				var nodes = treeObj.getNodes();
				$(".treecontent").html(nodata);
				for(var i=0;i<nodes.length;i++){
					if(nodes[i].coursecount){
						if(nodes[i].haspower){
							treeObj.selectNode(nodes[i]);
							onClick(null,null,nodes[i],null)
							return false;
						}
					}else{
						if(nodes[i].children.length){
							for(var j=0;j<nodes[i].children.length;j++){
								if(nodes[i].children[j].coursecount){
									if(nodes[i].children[j].haspower){
										treeObj.selectNode(nodes[i].children[j]);
										onClick(null,null,nodes[i].children[j],null)
										return false;
									}
								}else{
									if(nodes[i].children[j].haspower){
										treeObj.selectNode(nodes[i].children[j]);
										onClick(null,null,nodes[i].children[j],null)
										return false;
									}
								}
							}
						}
					}
				}
			},0);
			setTimeout(function(){
				parent.resetmain();
				parent.layer.closeAll();
				$( "#resizableleft" ).resizable({
			    	handles: 'e',
			    	maxWidth: 504,
			    	minWidth:258,
			    	start: function(event, ui) {
			    		//console.log(event)
			    	},
			    	resize :function(event, ui) {
			    		//console.log(ui.size.width)
			    		$('#resizableright').width(1000-ui.size.width-2)
			    	},
			    	stop : function(event, ui) {
			    		parent.resetmain();
			    		//console.log(event)
			    	},
			    });
			},200)
		}
	}).fail(function(){
		//console.log('req err');
	});
}
$(function(){
	tabworks(gettabdata);
})
</script>
<?php $this->display('troomv2/page_footer'); ?>