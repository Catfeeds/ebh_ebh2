<?php $this->display('troomv2/page_header'); ?>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/modules/exporting.js"></script>
<div class="lefrig" style="padding-bottom:110px;">
<style>
    .category_cont1 div a {
        padding:3px 10px;
        font-size:14px;
    }

    .dialogcont{
        height: 100px;
        margin: 0 auto;
        text-align: center;
        width: 339px;
    }
    .dialogcont .tishi{
        background: url("http://static.ebanhui.com/ebh/tpl/aroomv2/images/ico.jpg") no-repeat scroll 40px center;
        height: 36px;
        margin-left: 0;
        text-align: left;
        width: 339px;
        padding: 0;
        font-weight: normal;
        color:#333;
    }
    .dialogcont .tishi p {
        padding-left: 90px; font-size: 16px; line-height: 35px;
    }
    .datatab a,.datatab a:visited {
        color: #666;
    }
    .work_menu ul li.viewclose{
            float: right;
            margin:10px;
            padding: 0 4px;
            font-size: 24px;
            font-weight: bold;
            line-height: 1;
            color: #000;
            text-shadow: 0 1px 0 #FFF;
            cursor: pointer;
            background: transparent;         
            border: 0;
            -webkit-appearance: none;
            top: 8px;
            font-family: sans-serif;
            opacity: .5;
            filter: alpha(opacity=50);
        }
        a.title-a{
            background: none;           
        }
        a.title-a .jnisrso{
            background: none;
            color: #000;
            font-size: 22px;
            font-weight: 600;
        }
        .work_mes{          
            padding-left: 20px;           
            box-sizing: border-box;
            -moz-box-sizing:border-box; /* Firefox */
            -webkit-box-sizing:border-box; /* Safari */
        }
        .huerdfr{
            height:280px;           
            overflow-y: auto;
        }
        body{
            min-height: 600px;
            background-color: #fff;
        }
</style>
    <div class="waitite">
        <div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">统计分析</span></a></li>
                <li class="viewclose" onclick="parent.window.H.get('dialogNotice').exec('close')">×</li>
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