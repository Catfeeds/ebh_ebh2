<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" type="text/css" rel="stylesheet">
    <link href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>" type="text/css" rel="stylesheet">
    <link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css" />
	<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
</head>

<body>
<div class="">
    <div class="ter_tit">
        当前位置 >
        <a href="/aroomv2/more.html">更多应用</a>
        >
        <a href="xuanke.html">选课系统</a>
    </div>
    <div class="kechengguanli_top fr">
        <ul>
            <li class="fl">
                <a class="nuifase" href="/aroomv2/xuanke/xuanke_add.html" style="font-family:微软雅黑;font-size:13px;">发起选课</a>
            </li>
        </ul>
    </div>
    <div class=" clear"></div>
    <div class="lefrig">
        <table class="tables datatab2s bmlist" cellspacing="0" cellpadding="0">
            <tbody>
            <tr class="first" width="100%">
                <td width="45%" style="text-align:left;">活动名称</td>
                <td width="15%">发布时间</td>
                <td width="22%">选课状态</td>
                <td width="18%">操作</td>
            </tr>
            <?php if(!empty($xuankelist)){ foreach($xuankelist as $v){?>
            <tr>
                <td style="text-align: center">
                    <p class="kebitit"><?php echo $v['name']?></p>
                    <p class="nsires" style="width: 350px;"><?php echo $v['explains']?></p>
                </td>
                <td><?php echo date('Y-m-d',$v['datetime'])?></td>
<!--                --><?php //$status=array('0'=>'申报','1'=>'申报','3'=>'第一轮选课','5'=>'第二轮选课','7'=>'选课结束','8'=>'问卷发布')?>
                <td><span class="chencolor"><?php echo $v['statusmsg']?></span></td>
                <!--<td><a class="nuifase" href="xuanke/gosee.html?xkid=<?php echo $v['xkid']?>" style="margin-left:20px;">查 看</a></td>-->
                <td>
                	<a class="nuifase-1" href="/aroomv2/xuankemanagermsg.html?xkid=<?php echo $v['xkid']?>" style="margin-left:5px;color:#ffb319 !important; font-size:14px;">查看</a>
                	<a class="nuifase-1 delact" xkid="<?php echo $v['xkid']?>" href="javascript:void(0)" style="margin-left:5px;color:#ffb319 !important; font-size:14px;">删除</a>
                </td>
            </tr>
            <?php }}else{?>
                <tr class="zwnr1s"><td colspan="4" style="border:none;"><div class="nodata"></div></td></tr>
            <?php }?>
            </tbody>
        </table>
        <?php echo $pagestr?>
    </div>

</div>
<script type="text/javascript">
	$(".delact").on("click",function(){
		var $xkid = $(this).attr("xkid");
		dialog({
			title: '提示',
			content: '是否确认删除该选课？',
			okValue: '确定',
			ok: function () {
				$.ajax({
					type:"post",
					url:"/aroomv2/xuanke/xuanke_del.html",
					data:{xkid:$xkid},
					dataType:'json',
					success:function(res){
						if(res.status == 1){
							var diasuccess = dialog({
								title:'提示',
								content:'删除成功！',
								width: '150',
								height: '50',
								onclose:function(){
									window.location.reload();
								}
							});
							diasuccess.showModal();
							setTimeout(function(){
								diasuccess.close().remove();
							},2000);
						}else{
							var diaerror = dialog({
								title:'提示',
								content:'删除失败！',
								width: '150',
								height: '50'
							});
							diaerror.showModal();
							setTimeout(function(){
								diaerror.close().remove();
							},2000);
						}
					}
				});
			},
			cancelValue: '取消',
			cancel: function () {},
			width: '200'
		}).showModal();
	});
</script>
</body>
</html>
