<?php $this->display('aroomv2/page_header')?>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery.confirm.js"></script>

<link rel="stylesheet" href="http://static.ebanhui.com/ebh/js/xztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.core-3.5.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.excheck-3.5.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.exedit-3.5.js"></script>
<style type="text/css">
.button {float: none;}
.ztree *{
	font-size:14px;
}
.ztree li{
	padding: 2px;
}
.ztree li a{
	padding:5px;
	height: 16px;
	text-decoration: none;
	cursor: pointer;
}
.ztree li a.curSelectedNode,.ztree li a:hover{
	padding:5px;
	background-color: #FFE6B0;
	color: black;
	 height: 16px; 
	border: 0;
	opacity: 0.8;
	text-decoration: none;
	cursor: pointer;
}
.ztree li span.button.ico_docu {
    background-position: -110px 0;
}
.ztree li span.button.diy01_ico_open,.ztree li span.button.diy01_ico_close,.ztree li span.button.diy01_ico_docu{margin-right:2px; background-position:-110px -32px; vertical-align:top; *vertical-align:middle}
</style>
<div>
	<div class="ter_tit">
		当前位置 > <a href="/aroomv2/report.html">统计分析</a> > 课程浏览
	</div>
    <div class="curriculumviews mt15">
    	<div class="curriculumviews_l fl">
        	<div><h3>课程浏览</h3></div>
            <div style="width:260px;height:685px;overflow:auto">
            	<ul id="course_tree" class="ztree"></ul>
            </div>
        </div>
        <div class="curriculumviews_r fr">
        	<div><h3 id="coursename"></h3></div>
            <div class="curriculumviews_r_b">
            	<ul id="courserwarelist">
                </ul>
                <div class="cwlist_page"></div>
            </div>
        </div>
    </div>
</div>
<SCRIPT type="text/javascript">
<!--
var setting = {
	data: {
		simpleData: {
			enable: true
		}
	},
	callback: {
		beforeClick: beforeClick,
		onClick: onClick
	}
};
var zNodes = new Array();
var idstr;
function beforeClick(treeId, treeNode, clickFlag) {
	return (treeNode.click != false);
}
function onClick(event, treeId, treeNode, clickFlag) {
	$("#coursename").html(treeNode.name+'<span></span>');
	idstr = treeNode.id;
	getcwlist(1);
}
function getcwlist(page)
{
	$.post("<?=geturl('aroomv2/report/coursewarelistajax')?>",{idstr:idstr, page:page}, function(data){
		if(data != undefined)
		{
			$("#coursename span").html('（'+data.total+'）');
			$("#courserwarelist").empty();
			$.each(data.cwlist, function(i,n) {
				var strLi = '<li><div>';
                strLi += '<div class="fl touxiangs"><img src="'+n.face+'" /></div>';
                strLi += '<div class="fl kechengs">';
                strLi += '<div class="kechengs_t"><h4>'+n.title+'</h4></div>';
                strLi += '<div class="kechengs_b"><div class="kechengs_b_l fl"><p>'+n.date+'</p><p>大小：'+n.cwsize+'M  时长：'+n.cwlength+'  人气：'+n.viewnum+'</p></div><div class="kechengs_b_r fr"><a href="'+n.viewurl+'" target="'+n.target+'">查看</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'+n.logurl+'" target="_blank">学习监控</a></div></div>';
                strLi += '</div>';
                strLi += '</div></li>';
				$("#courserwarelist").append(strLi);
			});

			$(".cwlist_page").html(data.pagestr);
			//调整高度
			//window.parent.resetmain();
		}
	}, "json");
}

$(function(){
	$.post("<?=geturl('aroomv2/report/coursebrowsenodes')?>", function(data){
		if(data != undefined)
		{
			//初始化课程目录节点
			$.each(data.cataloglist, function(i,n){
				zNodes.push({
					id:n.catalogid,
					pId:n.pid,
					name:n.catalogname,
					click:false
				});
			});
			//初始化课程节点
			$.each(data.courselist, function(i,n){
				zNodes.push({
					id:"cnode_"+n.catalogid+"_"+n.folderid,
					pId:n.catalogid,
					name:n.foldername,
					iconSkin:"diy01",
					click:true
				});
				if(data.sectionlist[n.folderid] != undefined) {
					$.each(data.sectionlist[n.folderid], function(j, section){
						zNodes.push({
							id:"snode_"+n.catalogid+"_"+n.folderid+"_"+section.sid,
							pId:"cnode_"+n.catalogid+"_"+n.folderid,
							name:section.sname,
							iconSkin:"diy01",
							click:true
						});
					});
				}
			});

			$.fn.zTree.init($("#course_tree"), setting, zNodes);
		}
	}, "json");

	$(".cwlist_page").delegate("a[class!='none']", "click", function(){
		page = $(this).attr('rel');
		getcwlist(page);
	});
});
//-->
</SCRIPT>
</body>
</html>
