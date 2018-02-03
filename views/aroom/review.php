<?php $this->display('aroom/page_header')?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" />

<div class="ter_tit">
当前位置 > 评论查看</div>
<div class="lefrig">
<table  width="100%" class="datatab" style="margin-bottom:10px;margin-top:15px;">
	<tbody class="tabhead">
	<tr>
		<th style="width:30%">评论人</th>
		<th style="width:20%">评论对象</th>
		<th style="width:30%">评论内容</th>
		<th style="width:20%">评论时间 </th>
	</tr>
	</tbody>
	<tbody class="tabcont">
	<?php if(!empty($reviews)){
		foreach($reviews as $rl){
	?>
	<tr>
	<?php $arr = explode('.',$rl['cwurl']);
		$type = $arr[count($arr)-1]; 
		if($type != 'flv' && $rl['ism3u8'] == 1)
			$type = 'flv';
		if($type == 'mp3')
			$type = 'flv';
	?>
	<td><span style="width:120px;float:left;word-wrap: break-word;"><?=$rl['username']?>(<?=$rl['realname']?>)</span></td>
	<td><p style="width:110px;word-wrap: break-word;"><a target="<?= (empty($rl['cwurl']) || $type == 'flv') ? '_blank' : '' ?>" href="<?= (empty($rl['cwurl']) || $type == 'flv') ? geturl('aroom/course/'.$rl['cwid']) : geturl('aroom/review/classcourse/'.$rl['cwid'])?>"><?=$rl['title']?></a></p></td>			
	<td><p class="pltit" style="width:300px;"><?php if($rl['shield']==1){ ?><span style="color:red;">(该评论已被系统屏蔽)</span><?php }else{ ?><?=$rl['subject']?><?php } ?></p>
	   <?php if($rl['replysubject']!=''||!empty($rl['replysubject'])){?>
	   <p style="color:#D0304F; padding-top:5px;">回复内容：<?=$rl['replysubject']?></p>
	   <?php }?>
	</td>
	<td>
		<p class="plrq" style="width:80px;"><?=Date('Y-m-d H:i:s',$rl['dateline'])?></p>
	</td>
	
	</tr>
	<?php }}else{?>
	<tr><td colspan="5" align="center" class="plitem">暂无记录</td></tr>
	<?php }?>
	</tbody>
</table>
<?=show_page($reviewcount)?>
</div>
<?php $this->display('aroom/page_header')?>