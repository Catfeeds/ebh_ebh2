<?php $this->display('troom/page_header')?>
<body>
<div>
<div class="ter_tit">
        当前位置 > <a href="/troom/statisticanalysis.html">查询统计</a> > <a href="/troom/statisticanalysis/teach.html"> 教师统计 </a> > 任教班级
        
    </div>
<div class="teachclass">
	<table cellpadding="0" cellspacing="0" class="tables">
    	<tr  class="second">
        	<td  colspan="3">
            	<div>
                	<div class="teacher fl"><b style="font-size:16px;">教师:</b></div>
                    <div class="xingming_p fl" style="font-size:16px;"><?=$tuser[0]['realname']?>　(<?=empty($tuser[0]['sex'])?'男':'女'?>)　<?=$tuser[0]['username']?></div>
                </div>
            </td>
        </tr>
        <tr class="first">
            <td width="327">班级名称</td>
            <td width="200">班级人数</td>
            <td width="223">查看</td>
            </tr>
        <?php 
			$rrurl = $this->input->get('rurl');
			$rurl = $this->uri->path;
		foreach($classlist as $class){?>
		<tr >
            <td width="327"><b><?=$class['classname']?></b></td>
            <td width="200"><?=$class['stunum']?></td>
            <td width="223"><a href="<?=geturl('troom/student/list/'.$class['classid']).'?rurl='.$rurl.'&rrurl='.$rrurl?>">学生列表</a></td>
        </tr>
		<?php }?>
    </table>
    <div class="button2 fr"><a href="/<?=$rrurl?>.html">返 回</a></div>
</div>
</div>
</body>
</html>
