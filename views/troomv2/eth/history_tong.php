<?php $this->display('troomv2/page_header'); ?>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/modules/exporting.js"></script>
<div class="lefrig" style="padding-bottom:120px;">
    <div class="waitite">
        <div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">发信历史（查看）</span></a></li>
			</ul>
		</div>
    </div>
    <div class="work_mes" style="margin-bottom:40px;">
        <ul class="extendul">
            <li >
                <a href="<?=geturl("troomv2/eth/history/".$mid)?>">
                <span>发信历史</span>
                </a>
            </li>
            <li>
                <a href="<?=geturl("troomv2/eth/history/error/".$mid)?>">
                <span>发送状态</span>
                </a>
            </li>
            <li class="workcurrent">
                <a href="<?=geturl("troomv2/eth/history/tong/".$mid)?>">
                <span>统计分析</span>
                </a>
            </li>
            <li>
                <a href="<?=geturl("troomv2/eth/history/reply/".$mid)?>">
                <span>查看回复（<?=$replycount?>）</span>
                </a>
            </li>
        </ul>
    </div>
	<div style="clear:both;"></div>
    <div id="container" style="min-width: 310px; height: 260px; margin: 0 auto;"></div>
<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            min: 0,
            allowDecimals:false,
            title: {
                text: '人数'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} 人</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            column: {
            	pointWidth: 40,
                borderWidth: 0
            },
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    color: '#606060',
                    overflow: "none",
        			crop: false
                }
            }
        },
        series: [{
            name: '人数',
            colorByPoint: true,
            data: [{
            	color: '#7cb5ec',
                name: '已回复',
                y: <?=empty($message['reply_count'])? 0 : $message['reply_count']?>
            }, {
            	color: '#7cb5ec',
                name: '发送成功',
                y: <?=empty($message['send_success_num'])? 0 : $message['send_success_num']?>
            }, {
            	color: '#f45b5b',
                name: '发送失败',
                y: <?=empty($message['send_error_num'])? 0 : $message['send_error_num']?>
            }]
        }],
		credits:{
			enabled:false 
		},
		navigation: {
			buttonOptions: {
				enabled: false
			}
		}
    });
});
</script>
</div>
</body>
</html>