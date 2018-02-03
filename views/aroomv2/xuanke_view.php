<?php $this->display('aroomv2/page_header'); ?>
    <link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
    <style type="text/css">

        .crightbottom table tr td {
            border-bottom: none;
        }
		.jiserlde{
			padding-right:10px;
		}
        a.btn-base{
            border-radius: 4px;
            color:#fff !important;
            font-size: 14px;
            padding: 3px 12px !important;
            text-decoration: none;
            margin-right:34px;
        }
        a.btn-status{
            background-color: #4E8CF1;
        }
    </style>


<body>
<div class="ter_tit">
    当前位置 > <a href="/aroomv2/more.html">更多应用</a> > <a href="/aroomv2/xuanke.html">选课系统</a> > 活动详情
</div>
<div class="crightbottom">
    <div class="xktitles" style="border-bottom:none;height:inherit"><?php echo $xuanke['name']?></div>
    <div class="work_mes">
        <ul class="extendul">
            <li><a href="/aroomv2/xuankemanagermsg.html?xkid=<?php echo $xkid?>"><span>活动动态</span></a></li>
            <li  class="workcurrent"><a href="/aroomv2/xuanke/view.html?xkid=<?php echo $xkid?>"><span>活动详情</span></a></li>
            <li><a href="/aroomv2/xuanke/courselist.html?xkid=<?php echo $xkid?>"><span>课程列表</span></a></li>
            <li><a href="/aroomv2/xuanke/baoming.html?xkid=<?php echo $xkid?>"><span>报名结果</span></a></li>
            <?php if (($activity['status'] == 3 || $activity['status'] == 5) && $rule['start_t'] <= SYSTIME && $rule['end_t'] >= SYSTIME) { ?>
                <li style="float:right;margin-right:30px;"><a class="btn-base btn-status" rel="<?=intval($xuanke['ispause'])?>" href="javascript:;"><?=empty($xuanke['ispause']) ? '暂停选课' : '继续选课'?></a></li>
            <?php } ?>
        </ul>
    </div>
    <div class=" clear"></div>
    <div class="lefrigs">
        <table width="100%" style="border:none;margin-top:15px;">
            <tbody>
            <tr>
                <td width="132" valign="top">
                    <span class="siznwer">选课活动名称：</span>
                </td>
                <td width="626" style="padding-left:0;"><span class="jiserlde" style="margin-left:0;"><?php echo $xuanke['name']?></span></td>
            </tr>
            <tr>
                <td width="132" valign="top">
                    <span class="siznwer">选课活动说明：</span>
                </td>
                <td width="626" style="padding-left:0;"><span class="jiserlde" style="margin-left:0;"><?php echo $xuanke['explains']?></span></td>
            </tr>
            <tr>
                <td width="132" valign="top">
                    <span class="siznwer">教师申报日期：</span>
                </td>
                <td width="626" style="padding-left:0;">
					<span class="jiserlde" style="margin-left:0;"><?php echo date('Y-m-d',$xuanke['starttime'])?></span>
                    <span style="display:block;float:left;color:#999;">至</span>
                    <span class="jiserlde" style="margin-left:10px;"><?php echo date('Y-m-d',$xuanke['endtime'])?></span>
				</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    (function($) {
        var xkid = <?=$xuanke['xkid']?>;
        $("a.btn-status").bind('click', function() {
            var t = $(this);
            var ispause = t.attr('rel');
            var cstatus = ispause == '1' ? '0' : '1';
            $.ajax({
                'url': '/aroomv2/xuanke/ajax_pause_activity.html',
                'type': 'post',
                'data': { 'xkid': xkid, 's': cstatus },
                'dataType': 'json',
                'success': function(ret) {
                    if (ret.errno > 0) {

                        return;
                    }
                    t.attr('rel', cstatus);
                    t.html(cstatus == '0' ? '暂停选课' : '继续选课');
                }
            });
        });
    })(jQuery);
</script>
</body>
</html>
