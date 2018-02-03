<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/2016/css/health.css<?=getv()?>" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<title>无标题文档</title>
</head>
<style type="text/css">

</style>
<body>
<div>
    <div class="ter_tit">
        当前位置 >
        <a href="/aroomv2/more.html">更多应用</a>
        > 查看学生
    </div>
    <div class="teachercheck mt10">
        <div class="teachercheck_top">
            <div class="diles">
                <input id="searchkey" class="newsous" type="text" onblur="if($.trim($(this).val())==''){$(this).val('请输入账号或姓名');$(this).css('color','#999')}" onfocus="if($(this).val()=='请输入账号或姓名')$(this).val('');$(this).css('color','#333')" style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; color: rgb(153, 153, 153);" name="title" value="<?php if(!empty($keywords)){echo $keywords;}else{echo '请输入账号或姓名'; } ?>">
                <input class="soulico" type="button" onclick="_search()">            
            </div>
        	<div class="aligncen">
            <?php if(!empty($studentlist)){?>
                <table class="tables" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr class="first">
                            <td width="40%" style="text-align: left; text-indent: 50px;">学生</td>
                            <td width="18%">体测数据</td>
							<td width="17%">教师评语</td>
                            <td width="25%">操作</td>
                        </tr>
                        
                            <?php foreach ($studentlist as $list) { ?>
                        <tr>
                            <td width="40%">
                            	<a title="<?php echo $list['username']?>" href="javascript:;" style="float:left;margin-left:20px;">
                                <?php $face = !empty($list['face'])?$list['face']:'';?>
                                <?php if(empty($face)){
                                    $face = empty($list['sex'])?'http://static.ebanhui.com/ebh/tpl/default/images/m_man_50_50.jpg':'http://static.ebanhui.com/ebh/tpl/default/images/m_woman_50_50.jpg';
                                    ?>
                                    <?php }?>
                                <img class="imgyuans" src="<?php echo $face;?>" style="width:40px; height:40px;">
                                </a>
                                <p class="ghjut">
                                <?php echo $list['realname'];?>
                                <?php $sex = empty($list['sex'])?'http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png':'http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png';?>
                                <img src="<?php echo $sex;?>">
                                </p>
                                <p class="ghjut"><?php echo $list['username']?></p>
                            </td>
                            <?php if(!isset($list['count'])) $list['count'] = 0; if(!isset($list['commentcount'])) $list['commentcount'] = 0;?>
                            <td width="18%"><?php echo $list['count'];?>份</td>
							<td width="17%"><?php echo $list['commentcount'];?>份</td>
                            <td width="25%">
                            <a target="_blank" href="/aroomv2/health/student/detail/<?php echo $list['uid']?>.html" style="margin-right:15px;">体测统计</a>
							<a target="_blank" href="/aroomv2/health/student/comment/<?php echo $list['uid']?>.html">教师评语</a>
                            </td>
                        </tr>
                        
                        <?php }?>
                        
                    </tbody>
                </table>
                <?php }else{?>
                <div class="nodata">
				</div>
                <?php }?>
                <?php echo $pagestr;?>
        	</div>
        </div>
    </div>
</div>
</body>
<script>
//搜索功能
function _search(){
    var searchtext = $.trim($('.newsous').val());
    if(searchtext == '请输入账号或姓名' || searchtext == ''){
        location.href = '/aroomv2/health/student/<?php echo $classid?>.html';
    }
    location.href = '/aroomv2/health/student/<?php echo $classid?>.html?keywords='+searchtext;
}
$(function(){
    $(".tables").find('tr').last().children('td').each(function(){
        $(this).css('border-bottom','none');
    });
})
</script>
</html>
