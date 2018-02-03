<?php $this->display('aroomv2/page_header')?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<body>
<div class="ter_tit">
		当前位置 > <a href="/aroomv2/course.html">课程管理</a> > <a href="/aroomv2/course/courselist.html">课程列表</a> > 课程查看
	</div>
<div class="coursewareview">
	<table cellpadding="0" cellspacing="0" class="tables" >
        <tr   class="first">
            <td width="282" >课件名称</td>
            <td width="124">发布时间</td>
            <td width="39">大小</td>
            <td width="50">时长</td>
            <td width="47">人气</td>
            <td width="150">查看</td>
        </tr>
		<?php 
		$rurl = $this->input->get('rurl');
		if(!empty($cwlist)){
			$viewnumlib = Ebh::app()->lib('Viewnum');
		$sumsize = 0;
		$sumviewnum = 0;
		$sumlength = 0;
		foreach($cwlist as $cw){
			$face = getthumb($cw['face'],'50_50');
			if(empty($face))
				$face = 'http://static.ebanhui.com/ebh/tpl/default/images/'.(empty($cw['sex'])?'t_man_50_50.jpg':'t_woman_50_50.jpg');
			$cwsize = round($cw['cwsize']/1024/1024,1);
			$viewnum = $viewnumlib->getViewnum('courseware',$cw['cwid']);
			$viewnum = empty($viewnum)?$cw['viewnum']:$viewnum;
			$arr = explode('.',$cw['cwurl']);
			$type = $arr[count($arr)-1];
			$target = '_blank';
//			$coursetype = 'classcourse';
//			if(empty($cw['cwurl']) || in_array($type,array('flv','mp4','avi','mp3','mpeg','mpg','rmvb','rm','mov'))){
//				$target = '_blank';
				$coursetype = 'course';
			//}
			$sumsize += $cw['cwsize'];
			$sumviewnum += $viewnum;
			$sumlength += $cw['cwlength'];
			?>
        <tr >
			
			<td width="282"><div><img src="<?=$face?>" style="height:50px; width:50px; float:left;display:inline;"><div><p style="float:left;display:inline;padding-left:5px; width:225px;word-wrap: break-word;font-size:14px;height:35px; overflow:hidden;"><b ><?=$cw['title']?></b></p><p style="float:left;display:inline;padding-left:5px; width:225px;word-wrap: break-word;font-size:14px;height:23px; overflow:hidden; font-size:12px; color:#808080;"><?=$cw['realname']?>(<?=$cw['username']?>)</p></div></div></td>
			<td width="124"><?=Date('Y-m-d H:i:s',$cw['dateline'])?></td>
			<td width="39"><?=$cwsize?>M</td>
			<td width="50"><?=secondToStr($cw['cwlength'])?></td>
			<td width="47"><?=$viewnum?></td>
			<td width="150"><a target="<?=$target?>" href="<?=geturl('troomv2/'.$coursetype.'/view-1-0-0-'.$cw['cwid'])?>">查看</a>&nbsp;
			<a href="javascript:void(0);return false;" onclick="delcourse(<?= $cw['cwid'] ?>)">删除</a>&nbsp;<a href="<?=geturl('aroomv2/teacher/cwstudylog/'.$cw['cwid']).'?rurl='.$this->uri->path.'&rrurl='.$rurl?>">学习监控</a>&nbsp;</td>
		</tr>
		
        <?php }
		}else{?>
		<tr><td colspan="6" style='text-align:center'>暂无课件</td></tr>
        <?php }?>
    </table>
    <?=$pagestr?>
</div>
<script type="text/javascript">
function delcourse(courseid) {
	var button = new xButton();
	button.add({
		value:"删除",
		callback:function(){
			savedel(courseid);
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('dialogdel').exec('close');
			return false;
		}
	});
	if(!H.get('dialogdel')){
		H.create(new P({
			id : 'dialogdel',
			title: '删除课件',
			easy:true,
			width:400,
			padding:5,
			content:$('#dialogdel')[0],
			button:button
		}),'common');
	}
		
	H.get('dialogdel').exec('show');
}
function savedel(courseid){
	$.ajax({
		type:'post',
		url:'/aroomv2/course/delcw.html',
		dataType:'json',
		data:{'courseid':courseid},
		success:function(_json){
			if(_json.status == 1){
				$.showmessage({
					img : 'success',
                    message:'课件删除成功',
                    title:'课件删除成功',
                    callback :function(){
						location.reload();
					}
				});
			}else{
				alert(_json.message);
			}
		},
		error:function(){
			alert("服务器连接错误，请重试");
		}
	});
}

</script>
<!--删除课程-->
<div id="dialogdel" style="display:none">
<div class="deletecourse" style="height:70px;">
    <div class="tishi mt40"><p style="padding-left: 90px; font-size: 16px; line-height: 35px;">确定要删除该课件吗?</p></div>
    
</div>
</div>
</body>
</html>
