<?php $this->display('aroomv2/page_header')?>
<body>
<div>
<div class="ter_tit">
		当前位置 > <a href="/aroomv2/report.html">统计分析</a> > <a href="/aroomv2/student/viewnav.html">学生查看</a> > <a href="/aroomv2/student/view.html">班级列表</a> > 学生列表
	</div>
<div class="studentlist">
	<table cellpadding="0" cellspacing="0" class="tables">
        <tr   class="first">
            <td width="170">学生</td>
        	<td width="86">班级名称</td>
            <td width="55">积分</td>
            <td width="105">联系方式</td>
            <td width="309">查看</td>
        </tr>
		<?php 
		$rurl = $this->input->get('rurl');
		if(!empty($roomuserlist)){
			foreach($roomuserlist as $user){
				$face = getthumb($user['face'],'50_50');
				if(empty($face))
					$face = 'http://static.ebanhui.com/ebh/tpl/default/images/'.(empty($user['sex'])?'m_man_50_50.jpg':'m_woman_50_50.jpg');
			?>
        <tr >
			<td width="170"><div class="fl"><img src="<?=$face?>" style="height:50px; width:50px;" /></div><p class="p2s" style="width:110px;"><b style="font-size:15px;" title="<?=$user['username']?>"><?=shortstr(empty($user['realname'])?$user['username']:$user['realname'],6,'')?>(<?=empty($user['sex'])?'男':'女'?>)</b><br /><?=$user['username']?></p></td>
            <td width="86"><p style="width:85px;word-wrap: break-word;float:left;"><?=$user['classname']?></p></td>
            <td width="55"><?=$user['credit']?></td>
            <td width="105"><?=$user['mobile']?></td>
            <td width="309">
                <a href="<?=geturl('aroomv2/astulog/astuloglist-0-0-0-'.$user['uid']).'?rurl='.$this->uri->path.'&rrurl='.$rurl?>">听课记录</a>&nbsp;
                <a href="<?=geturl('aroomv2/astuexam/astuexamlist-0-0-0-'.$user['uid']).'?rurl='.$this->uri->path.'&rrurl='.$rurl?>">历史作业</a>&nbsp;
                <a href="<?=geturl('aroomv2/review/'.$user['uid']).'?rurl='.$this->uri->path.'&rrurl='.$rurl?>">相关评论</a>&nbsp;
                <a target="_blank" href="/aroom/umanager/student.html?s=<?=urlencode(authcode($user['uid'],'ENCODE'))?>">进入学生首页</a>
            </td>
        </tr>
			<?php }
		}else{?>
		<tr><td colspan="5" style="text-align:center">暂无数据</td></tr>
		<?php }?>
    </table>
    <div class="button2 fr"><a href="/<?=$rurl?>.html">返 回</a></div>
    <?=$pagestr?>
</div>
</div>
</body>
</html>
