<?php $this->display('aroomv2/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css" type="text/css" rel="stylesheet">


<body>

<link href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css" type="text/css" rel="stylesheet">
<style type="text/css">
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
<div class="">
    <div class="ter_tit">
        当前位置 >
        <a href="/aroomv2/more.html">更多应用</a>
        >
        <a href="/aroomv2/xuanke.html">选课系统</a>
        >
        <a href="/aroomv2/xuankemanagermsg.html?xkid=<?php echo $activity['xkid']?>">查看</a>
    </div>
    <div class=" clear"></div>
    <div class="crightbottom">
        <div class="xktitles" style="border-bottom:none;height:inherit;"><?=htmlspecialchars($activity['name'],ENT_NOQUOTES)?></div>
        <div class="work_mes" style="margin-bottom:20px;">
            <ul class="extendul">
                <li class="workcurrent"><a href="/aroomv2/xuankemanagermsg.html?xkid=<?php echo $activity['xkid']?>" >活动动态</a></li>
                <li ><a href="/aroomv2/xuanke/view.html?xkid=<?php echo $activity['xkid']?>" >活动详情</a></li>
                <li ><a href="/aroomv2/xuanke/courselist.html?xkid=<?php echo $activity['xkid']?>">课程列表</a></li>
                
                <li><a href="/aroomv2/xuanke/baoming.html?xkid=<?php echo $activity['xkid']?>">报名结果</a></li>
                <?php if (($activity['status'] == 3 || $activity['status'] == 5) && $rule['start_t'] <= SYSTIME && $rule['end_t'] >= SYSTIME) { ?>
                    <li style="float:right;margin-right:30px;"><a class="btn-base btn-status" rel="<?=intval($activity['ispause'])?>" href="javascript:;"><?=empty($activity['ispause']) ? '暂停选课' : '继续选课'?></a></li>
                <?php } ?>
            </ul>
        </div>
        <?php if(isset($messages) === true && is_array($messages) === true){ 
				foreach($messages as $id => $msg){ ?>
        <div class="tsejier">
            <p class="dsirerd">
                <span class="huersde"><?=htmlspecialchars($msg['object'], ENT_NOQUOTES) ?></span>
                <?php if(isset($msg['int_arg'])){?><?php printf($msg['int_arg']['format'], "<span class=\"jliserw\">" . $msg['int_arg']['value'] . "</span>")?><?php }?>
            </p>
            <p class="huetwre"><?=htmlspecialchars($msg['msg_time'], ENT_NOQUOTES) ?></p>
            <p class="hjuiers" title="<?=htmlspecialchars($msg['msg'], ENT_COMPAT)?>"><?=htmlspecialchars(shortstr($msg['msg'], 70), ENT_COMPAT)?><?php if(isset($msg['str_arg'])):?><span class="huerses"><?php echo $msg['str_arg']?></span><?php endif;?></p>
            <?php if($id == 0){?>
            <p class="hjuiers">
                <?php if(isset($msg['guide']) === true && is_array($msg['guide']) === true){ 
					foreach ($msg['guide'] as $guide){
						echo $guide;
					}
				} ?>
            </p>
			<?php }?>
        </div>
		<?php }
		} ?>
    </div>
</div>
<script type="text/javascript">
    (function($) {
        var xkid = <?=$activity['xkid']?>;
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