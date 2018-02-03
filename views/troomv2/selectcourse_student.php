<?php $this->display('troomv2/page_header')?>
<body>
<style type="text/css">
a.btnx {
    background-color:#18a8f7;
    border: 1px solid #0d9be9;
    color: #fff;
    cursor: pointer;
    display: block;
    height: 20px;
    line-height: 20px;
    text-align: center;
    text-decoration: none;
    width: 82px;
}
a.btnx:hover {
	text-decoration: none;
	color:#fff;
    background-color: #0d9be9 ;
}
.tables tr.first:hover{
	background:none;
}
.tables tr.first td{
	background:none !important;
}
</style>
<div class="lefrig">
	<div class="waitite">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">查看报名学生</span></a></li>
			</ul>
		</div>
        <a href="<?=geturl('aroomv2/selectcourse/doexcel').'?folderid='.$folderid.'&isnew=1'?>" class="btnx" style="position:absolute; top:10px;right:10px;"> 导出excel</a>
	</div>
    <div class="selectcourse">
        <div class="selectcourse_bottom mt15">
        	<table cellpadding="0" cellspacing="0" class="tables">
            	<tr class="first">
                    <td width="180">学生</td>
                    <td width="100">班级</td>
                    <td width="100">邮箱</td>
                    <td width="100">联系电话</td>
                </tr>
			<?php if(!empty($studentlist)) {
			foreach($studentlist as $user){
					$face = '';
					$face = getthumb($user['face'],'50_50');
					if(empty($face))
						$face = 'http://static.ebanhui.com/ebh/tpl/default/images/'.(empty($user['sex'])?'m_man_50_50.jpg':'m_woman_50_50.jpg');
				?>
                <tr>
                	<td>
                		<div class="fl"><img style="width:50px;height:50px" src="<?=$face?>" /></div><div class="p2" style="line-height:18px;"><p style="width:180px;height:18px; overflow:hidden;"><b title="<?=$user['username']?>"><?=empty($user['realname'])?$user['username']:$user['realname']?>（<?=empty($user['sex'])?'男':'女'?>）</b></p><p style="width:120px;height:18px; overflow:hidden;"><?=$user['username']?></p></div>
                	</td>
                    <td><?=$user['classname']?></td>
                    <td><?=$user['email']?></td>
                    <td><?=$user['mobile']?></td>
                </tr>
            	<?php
            	}
            } else { ?>
				<tr style="background:#fff;">
			 		<td colspan="4" align="center" style="border-top:none;"><div class="nodata"></div></td>
			 	</tr>
			<?php } ?>
            </table>
        </div>
    </div>
    <?php $rurl = $this->input->get('rurl');?>
	<div class="button5 fr"><a href="/<?=$rurl?>.html" style="color:#fff;text-decoration:none;">返 回</a></div>
	<?=$pagestr?>
    
</div>
</body>
<script>
function _search(){
	var searchkey = $('#searchkey').val();
	if(searchkey == '请输入课程名称')
		searchkey = '';
	location.href = '<?=geturl('troomv2/selectcourse/courselist')?>?q='+searchkey;
}
</script>
</html>
