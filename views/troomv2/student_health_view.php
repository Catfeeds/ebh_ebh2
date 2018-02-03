<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"  content="user-scalable=no">
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css<?=getv()?>" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/college/style.css<?=getv()?>" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/2016/css/health.css<?=getv()?>" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<title>无标题文档</title>
</head>

<body>
<div class="maines">
    <div class="waitite">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">体质健康</span></a></li>
			</ul>
		</div>
        <div class="diles" style="top:8px;">
            <input id="title" class="newsou" type="text" value="<?php if(!empty($keywords)){echo $keywords;}else{echo '请输入账号或姓名';}?>" name="title" style="color: rgb(165, 165, 165);">
            <input id="ser" class="soulico" type="button" value="">
        </div>
    </div>
        <div class="teachercheck_top">
            <div class="aligncen">
            <?php if(!empty($studentlist)){?>
                <table class="tables" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr class="first" style="color:#333;">
                            <td width="40%" style="text-align: left; text-indent: 50px;">学生</td>
                            <td width="20%">体测数据</td>
							<td width="20%">教师评语</td>
                            <td width="20%">操作</td>
                        </tr>
                        
                            <?php foreach ($studentlist as $list) { ?>
                        <tr>
                            <td width="40%">
                                <a title="<?php echo $list['username']?>" href="javascript:;" style="float:left;margin-left:20px;">
                                <?php $face = !empty($list['face'])?$list['face']:'';?>
                                <?php if(empty($face)){
                                    $face = empty($list['sex'])?'http://static.ebanhui.com/ebh/tpl/default/images/m_man_50_50.jpg':'http://static.ebanhui.com/ebh/tpl/default/images/m_woman_50_50.jpg';
                                    ?>
                                <img class="imgyuans" src="<?php echo $face;?>" style="width:40px; height:40px;">
                                </a>
                                <p class="ghjut">
                                <?php echo $list['realname'];?>
                                <?php $sex = empty($list['sex'])?'http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png':'http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png';?>
                                <img src="<?php echo $sex;?>">
                                </p>
                                <p class="ghjut"><?php echo $list['username']?></p>
                            </td>
                            <?php if(!isset($list['count'])) $list['count'] = 0;if(!isset($list['commentcount'])) $list['commentcount'] = 0;?>
                            <td width="20%"><?php echo $list['count'];?>份</td>
							<td width="20%"><?php echo $list['commentcount'];?>份</td>
                            <td width="20%">
                            <a target="_blank" href="/troomv2/health/student/detail/<?php echo $list['uid']?>.html" class='lansere'>体测统计</a>
							<a target="_blank" href="/troomv2/health/student/comment/<?php echo $list['uid']?>.html" class='lansere'>查看评语</a>
                            </td>
                        </tr>
                        <?php }else{ ?>
                            <img class="imgyuans" src="<?php echo $face;?>" style="width:40px; height:40px;">
                                </a>
                                <p class="ghjut">
                                <?php echo $list['realname'];?>
                                <?php $sex = empty($list['sex'])?'http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png':'http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png';?>
                                <img src="<?php echo $sex;?>">
                                </p>
                                <p class="ghjut"><?php echo $list['username']?></p>
                            </td>
                            <?php if(!isset($list['count'])) $list['count'] = 0;if(!isset($list['commentcount'])) $list['commentcount'] = 0;?>
                            <td width="20%"><?php echo $list['count'];?>份</td>
							<td width="20%"><?php echo $list['commentcount'];?>份</td>
                            <td width="20%">
                            <a target="_blank" href="/troomv2/health/student/detail/<?php echo $list['uid']?>.html" class='lansere'>体测统计</a>
							<a target="_blank" href="/troomv2/health/student/comment/<?php echo $list['uid']?>.html" class='lansere'>查看评语</a>
                            </td>
                        </tr>


                        <?php }?>
                        <?php }?>
                        
                    </tbody>
                </table>
                <?php }else{?>
					<div class="nodata"></div>
                    <?php }?>
                <?php echo $pagestr;?>
            </div>
        </div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
$(function(){
    $('#title').focus(function(){
        if($(this).val() == '请输入账号或姓名'){
            $(this).val('');
        }
    });
    $('#title').blur(function(){
        if($(this).val() == ''){
            $(this).val('请输入账号或姓名');
        }
    });
    $('#ser').click(function(){
        var title = $('#title').val();
        if(title == '' || title =='请输入账号或姓名'){
            location.href = '/troomv2/health/student/<?php echo $classid;?>.html';
        }else{
            location.href = '/troomv2/health/student/<?php echo $classid;?>.html?keywords='+title;
        }
    });
})
$(function(){
    $(".tables").find('tr').last().children('td').each(function(){
        $(this).css('border-bottom','none');
    });
})
</script>
</body>
</html>
