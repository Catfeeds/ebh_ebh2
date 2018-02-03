<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/2016/css/health.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<title>无标题文档</title>
</head>

<body>
    <div class="ter_tit">
        当前位置 >
        <a href="/aroomv2/more.html"> 更多应用 </a>
        > 体质健康管理
    </div>

	<div class="teachercheck mt10">
        <div class="teachercheck_top">
            <a class="daoran" href="/aroomv2/health/input.html">数据导入</a>
            <div class="diles">
                <input id="searchkey" class="newsous" type="text" onblur="if($.trim($(this).val())==''){$(this).val('请输入班级名称');$(this).css('color','#999')}" onfocus="if($(this).val()=='请输入班级名称'){$(this).val('');$(this).css('color','#333')}" style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; color: rgb(153, 153, 153);" name="title" value="<?php if(!empty($keywords)){echo $keywords;}else{
                    echo '请输入班级名称';
                    }?>">
                <input class="soulico" type="button" onclick="_search()">            
            </div>
            <div class="aligncen">
            <?php if(!empty($classlist)){ ?>
                <table class="tables" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr class="first">
                            <td width="30%">班级名称</td>
                            <td width="20%">学生数量</td>
                            <td width="20%">体测数据</td>
                            <td width="30%">操作</td>
                        </tr>
                        
                            <?php foreach ($classlist as $list) { ?>
                        <tr>
                            <td width="30%"><?php echo $list['classname']?></td>
                            <td width="20%">
                            <?php echo $list['stunum'];?>
                            </td>
                            <td width="20%"><?php if(isset($list['count'])){echo $list['count'];}else{echo 0;}?>份</td>
                            <td width="30%">
                            <a href="/aroomv2/health/student/<?php echo $list['classid']?>.html">查看学生</a>
                            &nbsp;&nbsp;
                            <a href="/aroomv2/health/<?php echo $list['classid']?>.html" target="_black">班级统计</a>
                            </td>
                        </tr>

                        <?php } ?>
                    </tbody>
                </table>
                 <?php }else{ ?>
                    <div class="nodata">
                 <?php }?> 
                 <?php if(!empty($page)){
                    echo $page;
                    }?>
            </div>
            
        </div>
	</div>
</body>
<script>
//搜索功能
function _search(){
    var searchtext = $.trim($('.newsous').val());
    if(searchtext == '请输入班级名称' || searchtext == ''){
        location.href = '/aroomv2/health.html';
    }
    location.href = '/aroomv2/health.html?keywords='+searchtext;
}
$(function(){
    $(".tables").find('tr').last().children('td').each(function(){
        $(this).css('border-bottom','none');
    });
})
</script>
</html>
