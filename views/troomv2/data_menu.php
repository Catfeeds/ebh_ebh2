<?php 
//教师后台 troomv2 数据中心 ->学生->查看 菜单栏
	$uid=$this->uri->itemid;
	$classid = $this->input->get('classid');
	$_index = empty($data_index) ? 1: $data_index;
	$menuArr = array(
		'1'=>array('title'=>'作业记录','url'=>geturl('troomv2/statisticanalysis/scorefind/'.$uid)),
		'2'=>array('title'=>'答疑记录','url'=>geturl('troomv2/statisticanalysis/question/'.$uid)),
		'3'=>array('title'=>'学习记录','url'=>geturl('troomv2/statisticanalysis/studylogs/'.$uid)),
		'4'=>array('title'=>'积分明细','url'=>geturl('troomv2/statisticanalysis/credit/'.$uid)),
		'5'=>array('title'=>'错题集','url'=>geturl('troomv2/statisticanalysis/errorlogs/'.$uid)),
		'6'=>array('title'=>'成长档案','url'=>geturl('troomv2/statisticanalysis/growlist/'.$uid)),
		'7'=>array('title'=>'基本信息','url'=>geturl('troomv2/statisticanalysis/profile/'.$uid)),
		'8'=>array('title'=>'统计分析','url'=>geturl('troomv2/statisticanalysis/statistical/'.$uid)),
	);
	//显示顺序
	$key_arr = array(7,3,1,2,5,6,4,8);
	$menuArrs = array();
	
	foreach($key_arr as $key){
		$menuArrs[$key] = $menuArr[$key];
	}
	//var_dump($menuArrs);
?>

<div class="luieres">
	<?=$name?>的<?=$menuArr[$_index]['title']?>
</div>
<div class="work_mes">
	<ul>
	<?php foreach($menuArrs as $kk=>$menu){?>
<!--	--><?php //if($kk==6){continue;}?>
		<li class="<?=($kk==$_index)?"workcurrent":""?>">
		<a href="<?= $menu['url']?><?=empty($classid)?'':'?classid='.$classid?>" style="color: <?php echo $kk==8?'#ff9500':''?>;<?php echo $kk==8&&$kk==$_index?'border-bottom:2px solid #ff9500;':''?>"><?=$menu['title']?></a>
		</li>
	<?php }?>
	<!-- 
		<li class="<?=($_index==7)?"workcurrent":""?>">
		<a href="<?= geturl('troomv2/statisticanalysis/profile/'.$uid) ?>">基本信息</a>
		</li>
		<li class="<?=($_index==3)?"workcurrent":""?>">
		<a href="<?= geturl('troomv2/statisticanalysis/studylogs/'.$uid) ?>">学习记录</a>
		</li>
		
		<li class="<?=($_index==1)?"workcurrent":""?>">
		<a href="<?= geturl('troomv2/statisticanalysis/scorefind/'.$uid) ?>">作业记录</a>
		</li>
		<li class="<?=($_index==2)?"workcurrent":""?>">
		<a href="<?= geturl('troomv2/statisticanalysis/question/'.$uid) ?>">答疑记录</a>
		</li>
		
		<li class="<?=($_index==5)?"workcurrent":""?>">
		<a href="<?= geturl('troomv2/statisticanalysis/errorlogs/'.$uid) ?>">错题集</a>
		</li>
		
		<li class="<?=($_index==4)?"workcurrent":""?>">
		<a href="<?= geturl('troomv2/statisticanalysis/credit/'.$uid) ?>">积分明细</a>
		</li>
 -->
		<!-- 
		<li class="<?=($_index==6)?"workcurrent":""?>">
		<a href="<?= geturl('troomv2/statisticanalysis/record/'.$uid) ?>">成长档案</a>
		</li> -->

	</ul>
	<?php if(($_index!=4) && ($_index!=7) && ($_index!=6) &&($_index!=8)){?>
		<div class="diles">
		<?php
			$q= empty($q)?'':$q;
			if(!empty($q)){
				$stylestr = 'style="color:#000"';
			}else{
				$stylestr = "";
			}
		?>
		<input name="search" <?=$stylestr?> class="newsou" id="search" value="<?=$q?>" type="text" />
		<input id="searchbutton" name="searchbutton" type="button" class="soulico" value="">
		</div>
	<?php }?>
</div>