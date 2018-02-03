<?php $this->display('college/page_header'); ?>
<body>

	<div class="lefrig" style="margin-top:10px;">

		<table class="datatab"  width="100%" style="<?=(empty($roominfo['iscollege'])||$user['groupid']!=6)?'border:solid 1px #cdcdcd;':'border:none;'?>">
		
			<thead class="tabheads">
			
			<tr style="color:#666;">
			   <th style="font-size: 14px;text-indent:5px;width:8%;">全校老师</th> 
			   <th style="width:12%;"></th> 
			   <th style="width:80%;"></th> 
			</tr>
		</thead>			
		<tbody  width="100%">
	
		<?php foreach($teachers as $teacher) { 
			$defaulturl = $teacher['sex'] == 1 ? 't_woman.jpg' : 't_man.jpg';
			$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$defaulturl;
			$face = empty($teacher['face']) ? $defaulturl : $teacher['face'];
			$face = getthumb($face,'50_50');
		?>
			<tr>
				<td>
					<img src="<?= $face ?>" style="width:50px;height:50px;"/>
				</td>
				<td>
					<?= empty($teacher['realname']) ? $teacher['username'] : $teacher['realname'] ?>
				</td> 
				<td style="width:53%;">
				<?php foreach($teacher['folder'] as $folder) { ?>
				<a href="<?= geturl('myroom/college/study/cwlist/'.$folder['folderid'])?>" title="<?= $folder['foldername'] ?>"><?= $folder['foldername'] ?></a>&nbsp;&nbsp;
				<?php } ?>
				</td> 
			</tr>
		<?php } ?>
		</tbody>
		</table>
</div>

<?php $this->display('myroom/page_footer'); ?>