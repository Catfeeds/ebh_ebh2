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
/*----下拉----*/
.kstdg {
    background: #fff url("http://static.ebanhui.com/ebh/tpl/aroomv2/images/huatlea.jpg") no-repeat scroll right center;
    border: 1px solid #c3c3c3;
    color: #5e5e5e;
    cursor: pointer;
    display: inline;
    float: left;
    height: 24px;
    line-height: 24px;
    min-width: 120px;
    padding: 0 25px 0 10px;
    position: relative;
    z-index: 999;
}
.kdhtyg .distd {
    background: #f0f0f0 url("http://static.ebanhui.com/ebh/tpl/aroomv2/images/huatlea1.jpg") no-repeat scroll right center;
    border: 1px solid #d9d9d9;
}
.liawtlet {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #d9d9d9;
    display: none;
    left: -1px;
    margin-bottom: 10px;
    position: absolute;
    top: 24px;
    width: 100%;
    max-height: 300px;
    overflow-y:auto;
    z-index: 1;
}
.liawtlet a,.noversiontip {
    color: #5e5e5e;
    display: block;
    float: left;
    overflow: hidden;
    padding: 3px 0;
    text-decoration: none;
    text-indent: 10px;
    text-overflow: ellipsis;
    white-space: nowrap;
    width: 100%;
}
.liawtlet a:hover {
    background: #376ede none repeat scroll 0 0;
    color: #fff;
}
#ctitle{display: none;}
</style>
</head>
<body>
<div>
    <div class="ter_tit">
        当前位置 &gt; <a href="<?=geturl('aroomv2/course')?>">课程管理</a> &gt; <a href="<?=geturl('aroomv2/course/courses')?>">本校课程</a> &gt; <a href="<?=geturl('aroomv2/chapter')?>">知识点管理</a> &gt; 知识点管理
    </div>


    <div class="kechengguanli">
		<div class="fl" style="padding:10px 0 10px;">
			<div class="kdhtyg">
				<div class="kstdg" id="versionselect">
                <?php if(empty($versionlist)){?>
					<span vid="0" class="xtitle" id="versionselecttitle">请选择模板</span>
                <?php }else{?>
                    <span vid="0" class="xtitle" id="versionselecttitle">请选择版本</span>
                <?php }?>
					<div class="liawtlet">
	<?php if(empty($versionlist)) {?>
	<?php }else {foreach ($versionlist as $version) {?>
						<a href="javascript:void(0)" vid="<?=$version['chapterid']?>"><?=$version['chaptername']?></a>
	<?php } }?>
					</div>
				</div>
			</div>
        </div>
    	<div class="kechengguanli_top fr">
        	<ul>
            	<li class="fl "><a href="javascript:void(0);" id="ctemplate">选择模板</a></li>
            </ul>
        </div>
    	<div class="kechengguanli_top fr" style="margin-top:8px;">
        	<ul>
            	<li class="fl "><a href="javascript:void(0);" id="ctitle" style="margin-top:0; padding:4px 10px;">创建主知识点</a></li>
            </ul>
        </div>
        <div class=" clear"></div>
        <div class="kechengguanli_bottom">
        	<table cellpadding="0" cellspacing="0" class="tables">
            	<tr class="first">
                	<td>知识点管理</td>
                </tr>
            </table>
			<div class="workdata"  style="background-color:#fff;margin-bottom: 10px;width: 788px; margin-top:0;">
				<div id='chapterdiv'>
					<div style="min-height: 790px;overflow-y:auto;">
						<div>
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

<div class="choosetemplate" style="display:none">
	<div style="padding:10px;width: 600px;height: 400px; overflow: auto ">
		<div class="kstdg" id="tplversionselect">
			<span vid="0" class="xtitle" id="tplversionselecttitle">请选择版本</span>
			<div class="liawtlet">
	<?php if(empty($tplversionlist)) {?>
				<div class="noversiontip">暂无版本，请先添加版本。</div>
	<?php }else {foreach ($tplversionlist as $version) {?>
					<a href="javascript:void(0)" vid="<?=$version['chapterid']?>"><?=$version['chaptername']?></a>
	<?php } }?>
				</div>
		</div>

		<div style="clear:both;min-height: 390px;">
			<div>
				<div id="categoryListx" style="height:300px;">
						<div class="zTreeDemoBackground left">
							<ul id="treeTemplate" class="ztree"></ul>
						</div>
					<div class="SG_j_linedot"></div>
				</div>
			</div>
		</div>

	</div>

</div>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/mychapternew.js?v=20160629001">
</script>
</body>
</html>
