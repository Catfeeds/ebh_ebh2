<?php $this->display('aroomv2/page_header');?>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery.confirm.js"></script>

<link rel="stylesheet" href="http://static.ebanhui.com/ebh/js/xztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.core-3.5.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.excheck-3.5.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xztree/js/jquery.ztree.exedit-3.5.js"></script>
<style type="text/css">
.button {float: none;}
.ztree li span.button.add {
  margin-left: 10px;
  background-position: -144px 0;
  vertical-align: top;
}
.ztree li span.button.edit {
	margin-left: 10px;
}
.ztree li span.button.remove {
	margin-left: 10px;
}
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
.ztree li a input.rename{
	height:20px;
	font-size: 18px;
	padding: 2px;
	width: 500px;
	margin-left: 5px;
	margin-top: -4px;
	margin-right: -8px;
	border: 0;
}
.ztree li span.button.ico_docu {
    background-position: -110px 0;
}
.ztree li span.button.choose {
    background-position: -127px -16px;
    margin-left: 10px;
    vertical-align: top;
}
.ztree li span.button.diy01_ico_docu{margin-right:2px; background-position:-110px -32px; vertical-align:top; *vertical-align:middle}


.terlie li {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #B2D9F0;
    display: block;
    float: left;
    font-size: 14px;
    height: 20px;
    line-height: 20px;
    margin-bottom: 7px;
    margin-right: 5px;
    padding-top: 3px;
    width: auto;
}
.terlie li a.labelnode {
    color: #0078B6;
    display: inline;
    float: left;
    height: 18px;
    line-height: 18px;
    padding: 0 7px;
    text-decoration: none;
    vertical-align: 4px;
}

.terlie li a.labeldel {
    float: left;
}
.terlie .mylabel a.labeldel img {
    background: url("http://static.ebanhui.com/ebh/tpl/2012/images/closebg_01.png") no-repeat scroll 0 0 transparent;
    display: inline-block;
    height: 12px;
    margin: 3px 4px 2px 0;
    width: 12px;
}
.terlie .mylabelhover a.labeldel img {
    background: url("http://static.ebanhui.com/ebh/tpl/2012/images/closebg_02.png") no-repeat scroll 0 0 transparent;
    display: inline-block;
    height: 12px;
    margin: 3px 4px 2px 0;
    width: 12px;
}

.terwai {
    background-color: #FFF;
    border: 1px solid #DEDEDE;
    float: right;
    font-size: 14px;
    margin-right: 0px;
    margin-top: 10px;
    min-height: 153px;
    padding: 0 10px 10px;
    width: 590px;
}
.terwai .ternei {
    background: url("http://static.ebanhui.com/ebh/tpl/default/images/aroom/xiangtop0222.jpg") no-repeat scroll center top transparent;
    margin-top: -9px;
    min-height: 13px;
    width: 590px;
	position:static;
}
.terlie {
    border-bottom: 1px dashed #CDCDCD;
    float: left;
    margin-bottom: 15px;
    padding-bottom: 15px;
    padding-top: 10px;
    width: 590px;
}
.xianquan {
    float: left;
    width: 590px;
    max-height:290px;
    _height:290px;
    overflow-y:auto;
}


.xianquan li {
    float: left;
    height: 30px;
    line-height: 30px;
    width: 188px;
	overflow: hidden;
}

</style>
</head>
<body>
<div>
    <div class="ter_tit">
        当前位置 > <a href="<?=geturl('aroomv2/course')?>">课程管理</a> > 课程目录管理
    </div>

    <div class="kechengguanli">
    	<div class="kechengguanli_top fr">
        	<ul>
            	<li class="fl "><a id="ctitle" href="javascript:void(0);">创建主目录</a></li>
            </ul>
        </div>
        <div class=" clear"></div>
        <div class="kechengguanli_bottom">
        	<table cellpadding="0" cellspacing="0" class="tables">
            	<tr class="first">
                	<td>课程目录管理</td>
                </tr>
            </table>
			<div class="workdata"  style="border:solid 1px #e1e1e1;border-top:none;background-color:#fff;margin-bottom: 10px;width: 786px;">
				<div id='chapterdiv'>
					<div style="min-height: 790px;overflow-y:auto;">
						<div>
							<div style="padding:20px 0 0 9px">
								<span style="font-size:14px;font-weight:bold; font-family: Verdana,Arial,Helvetica,AppleGothic,sans-serif;color: #333;"><?=$roominfo['crname']?></span>
								<div id="errTips">
								</div>
							</div>
							<div id="categoryListx" style="height:700px;">
									<div class="zTreeDemoBackground left">
										<ul id="treeDemo" class="ztree"></ul>
									</div>
								<div class="SG_j_linedot"></div>
							</div>
						</div>
						<div style="clear:both;"></div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>

<!--选择课程-->
<div id="dialogcc" style="display:none">
<div class="choosecourse" style="display:none">
	<div class="terwai">
	<div class="ternei">
	</div>
	<span id="choosettitle" style="color:#0068b7;"></span>
	<div id="" class="terlie">
			<div id="nocourse">还未选择任何课程</div>
			<ul id="choosetsimp" style="display:none">
			</ul>
		</div>
		<div style="" class="xiansuoyout">
		<span style="float:left;margin-right:60px;line-height:22px;display: inherit;height:22px;"> 课程列表</span>
		<div style="height:26px;float:left;">
		<input type="text" onblur="if(this.value == ''){this.value = '请输入课程名称';}" onclick="if(this.value == '请输入课程名称'){this.value = '';}else {this.select();}" id="coursename" class="soutxt" value="请输入课程名称" name="search" style="width:180px;">
		<input type="button" onclick="allcourse()" class="souhuang" value="搜 索" name="searchbutton">
		</div>
		</div>
		<div class="xianquan">
		<ul style="" id="choosetall">
		<?php foreach($courselist as $course){?>
		<li id="all<?=$course['folderid']?>">
			<input type="checkbox" id="allcoursei<?=$course['folderid']?>" onclick="choose('<?=$course['folderid']?>','<?=$course['foldername']?>',this)" value="<?=$course['folderid']?>" style="top:2px;" ><label title="<?=$course['foldername']?>" id="coursename_<?=$course['folderid']?>" for="allcoursei<?=$course['folderid']?>" style="margin-left:4px;_margin-left:2px;"><?=$course['foldername']?></label></li>
		<?php }?>
		</ul>
		</div>
	</div>
</div>
</div>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/mycatalog.js"></script>
</body>
</html>
