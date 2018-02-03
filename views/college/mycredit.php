<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"  content="user-scalable=no">
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css?v=20160810001" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css<?=getv()?>" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/college/style.css?version=20160704001" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/2016/css/health.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<title>学分明细</title>
</head>

<body>
<div class="maines">
<div class="work_menu" style="width:1000px; position:relative;margin-top:0px;">
	<ul>
		 <li class="workcurrent"><a href="javascript:void(0)" style="font-size:16px;line-height: 33px;border:none;"><span>学分明细</span></a></li>
	</ul>
</div>
    <div class="bfenst">
    	<div class="hsreter">
        	<p class="lascolor"><?php echo $stuOkScore;?></p>
            <p class="tisrr">达标学分</p>
        </div>
        <div class="hsreter">
        	<p class="cascolor"><?php echo $totalScore;?></p>
            <p class="tisrr">您已获取</p>
        </div>
        <div class="hsreter1">
        <?php if(empty($stuOkScore)) $stuOkScore = 1;?>
        <?php if($totalScore >= $stuOkScore){$percent = 100;}else{$percent = round(($totalScore/$stuOkScore)*100 ,2);} ?>
            <span class="fsurer" style="left:<?php echo 63+$percent*2.23;?>px;"><?php echo $percent; ?>%</span>
            <div class="waisrtk">                
                <span class="lisrne" style="width:<?php echo $percent; ?>%;"></span>
            </div>
        </div>
    </div>
    <div class="teachercheck_top">
        <div class="aligncen">
            <table class="tables" cellspacing="0" cellpadding="0">
                <tbody>
                <?php if(!empty($creditlogList)){ ?>
                    <tr class="firstes">
                        <td width="30%">课件名称</td>
                        <td width="20%">所属课程</td>
                        <td width="20%">获取</td>
                        <td width="30%">获取时间</td>
                    </tr>
                    <?php foreach ($creditlogList as $list) { ?>
                    <tr>
                        <?php 
                            $list['title'] = empty($list['title'])?'课件已删除':$list['title'];
                            $list['foldername'] = empty($list['foldername'])?'课程已删除':$list['foldername'];
                        ?>
                        <td width="30%"><span class="hsurwed" title="<?php echo $list['title'];?>">
                        <?php echo shortstr($list['title'],50);?>
                        </span></td>
                        <td width="30%">
                        <span class="hsurwed" title="<?php echo $list['foldername'];?>">
                        <?php echo shortstr($list['foldername'],50);?>
                        </span>
                        </td>
                        <td width="20%"><?php echo $list['score']?>分</td>
                        <td width="20%">
                        <?php echo date('Y-m-d H:i:s',$list['dateline']);?>
                        </td>
                    </tr>
                    <?php } ?>
                <?php }else{ ?>
                    <div class="nodata"></div>
                <?php } ?>
                </tbody>
                
            </table>
            <?php echo $pageStr;?>
        </div>
    </div>
</div>
<script type="text/javascript">
$(".tables tr").last().children("td").css('border-bottom','none');//去掉最后一条记录的border
</script>
</body>
</html>
