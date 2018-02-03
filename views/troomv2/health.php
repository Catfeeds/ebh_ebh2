<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"  content="user-scalable=no">
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css?v=20160810001" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/college/style.css<?=getv()?>" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/2016/css/health.css<?=getv()?>" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<title>无标题文档</title>
</head>
<!--判断是网校还是企业，企业$room_type变量输出1，0为网校-->
<?php $room_type = Ebh::app()->room->getRoomType();$room_type = ($room_type == 'com') ? 1 : 0;?>
<body>

<div class="maines">
    <div class="waitite">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso"><?=$pagemodulename?></span></a></li>
			</ul>
		</div>
        <div class="diles" style="top:8px;">
            <input id="title" class="newsou" type="text" value="<?php if(!empty($keywords)){echo $keywords;}else{echo ($room_type==1)?'请输入部门名称':'请输入班级名称';}?>" name="title" style="color: rgb(165, 165, 165);">
            <input id="ser" class="soulico" type="button" value="">
        </div>
    </div>
    <div class="teachercheck_top">
        <div class="aligncen">
        <?php if(!empty($classlist)){?>
            <table class="tables" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr class="first">
                        <td width="30%"><?= ($room_type==1)?'部门名称':'班级名称'?></td>
                        <td width="20%"><?= ($room_type==1)?'员工数量':'学生数量'?></td>
                        <td width="20%">体测数据</td>
                        <td width="30%">操作</td>
                    </tr>
                        <?php foreach ($classlist as $key=>$list){ ?>
                    <tr>
                        <td width="30%"><?php echo $list['classname'];?></td>
                        <td width="20%">
                        <?php echo $list['stunum'];?>
                        </td>
                        <td width="20%"><?php if(isset($list['count'])){echo $list['count'];}else{echo 0;}?>份</td>
                        <td width="30%">
                        <a class="lansere" href="/troomv2/health/student/<?php echo $list['classid']?>.html"><?= ($room_type==1)?'查看员工':'查看学生'?></a>
                        <a class="lansere" target="_blank" href="/troomv2/health/<?php echo $list['classid']?>.html"><?= ($room_type==1)?'部门统计':'班级统计'?></a>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            <?php }else{?>
                <div class="nodata"></div>
            <?php }?>
            <?php echo $page;?>
        </div>
    </div>
</div>
<div class="clear"></div>
<script type="text/javascript">
$(function(){
    $('#title').focus(function(){
        var title = $(this).val();
        if(title == '请输入班级名称'){
            $(this).val('');
        }
    });
    $('#title').blur(function(){
        var title = $(this).val();
        if(title == ''){
            $(this).val('请输入班级名称');
        }
    });
    $('#ser').click(function(){
        var keyword = $('#title').val();
        if(keyword == '请输入班级名称' || keyword == ''){
            location.href = '/troomv2/health.html';
        }else{
           location.href = '/troomv2/health.html?keywords='+keyword; 
        } 
    });
    $(".tables").find("tr").last().children('td').each(function(){
        $(this).css('border-bottom','none');
    });
})
</script>
</body>

</html>
