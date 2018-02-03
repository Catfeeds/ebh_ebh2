<?php $this->display('aroomv2/page_header');?>
<body>
<div >
    <div class="ter_tit">
        当前位置 > <a href="<?=geturl('aroomv2/selectcourse')?>">选课管理</a> > <?=empty($isnew)?'历年报名学生':'查看报名学生'?>
    </div>
    <div class="kechengguanli">
    	<div class="kechengguanli_top fr">
        	<ul>
            	<li class="fl "><a href="<?=geturl('aroomv2/selectcourse/doexcel').'?folderid='.$folderid.'&isnew='.$isnew?>">导出excel</a></li>
            </ul>
        </div>
        <div class=" clear"></div>
        <div class="kechengguanli_bottom">
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
				<tr>
			 		<td colspan="4" align="center" style="border-top:none;">暂无报名学生</td>
			 	</tr>
			<?php } ?>
            </table>
        </div>
    </div>
    <?php $rurl = $this->input->get('rurl');?>
	<div class="button5 fr"><a href="/<?=$rurl?>.html">返 回</a></div>
	<?=$pagestr?>
    
</div>
</body>
</html>
