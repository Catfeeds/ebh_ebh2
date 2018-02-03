<?php
$this->display('admin/header');
?>
<body>
<h1>添加文件</h1>
        <form id="form_rfile" method="post" novalidate action="<?php echo geturl('admin/rfile/edit');?>">
            <div class="fitem">
                <label>文件标题</label>
                <input name="title" class="easyui-validatebox" value="<?php echo $rfiledetail['title'];?>"/>
				<input name="rid" type="hidden" value="<?php echo $rfiledetail['rid'];?>"/>
            </div>
            <div class="fitem">
                <label>所属教师：</label>
                <input class="easyui-validatebox" required="true" validType="" missingMessage="选择教师" invalidMessage="2" id="teacher_input" readonly="true" value="<?php echo $rfiledetail['username'];?>">
				<input name="uid" id="teacher_hidden" readonly="true" value="<?php echo $rfiledetail['uid'];?>">
				
            </div>
            <div class="fitem">
                <label>所属分类</label>
                <input name="catid" class="easyui-validatebox" required="true" value="<?php echo $rfiledetail['name'];?>">
            </div>
			
			<div class="fitem">
                <label>所属标签</label>
                <input name="tag" class="easyui-validatebox" value="<?php echo $rfiledetail['tag'];?>">
            </div>
			<div class="fitem">
                <label>课件摘要</label>
                <input name="summary" class="easyui-validatebox" value="<?php echo $rfiledetail['tag'];?>">
            </div>
			<div class="fitem">
                <label>热门级别</label>
				<input type="radio" name="hot" class="easyui-validatebox" value=0 checked>非热门
                <input type="radio" name="hot" class="easyui-validatebox" value=1 >热门Ⅰ
				<input type="radio" name="hot" class="easyui-validatebox" value=2 >热门Ⅱ
				<input type="radio" name="hot" class="easyui-validatebox" value=3 >热门Ⅲ
            </div>
			<div class="fitem">
                <label>置顶级别</label>
				<input type="radio" name="top" class="easyui-validatebox" value=0 checked>非置顶
                <input type="radio" name="top" class="easyui-validatebox" value=1 >置顶Ⅰ
				<input type="radio" name="top" class="easyui-validatebox" value=2 >置顶Ⅱ
				<input type="radio" name="top" class="easyui-validatebox" value=3 >置顶Ⅲ
            </div>
			<div class="fitem">
                <label>精华级别</label>
				<input type="radio" name="best" class="easyui-validatebox" value=0 checked>非精华
                <input type="radio" name="best" class="easyui-validatebox" value=1 >精华Ⅰ
				<input type="radio" name="best" class="easyui-validatebox" value=2 >精华Ⅱ
				<input type="radio" name="best" class="easyui-validatebox" value=3 >精华Ⅲ
            </div>
			
			
			<div class="fitem">
                <label>排序号</label>
                <input name="displayorder" class="easyui-validatebox" required="true" value="500" value="<?php echo $rfiledetail['displayorder'];?>">
            </div>
        </form>
    </div>
	
	<div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="history.go(-1)">返回</a>
        
    </div>
	
	<script>
		$(function(){
			$('input[name=hot]').get(<?php echo $rfiledetail['hot'];?>).checked=true;
			$('input[name=best]').get(<?php echo $rfiledetail['best'];?>).checked=true;
			$('input[name=top]').get(<?php echo $rfiledetail['top'];?>).checked=true;
		})
		
		
	</script>
	<style>
		.fitem{
            margin-bottom:5px;
        }
        .fitem label{
            display:inline-block;
            width:80px;
        }
	</style>
</body>
<?php
$this->display('admin/footer');
?>