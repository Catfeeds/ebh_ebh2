<?php $this->display('college/page_header');?>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160429001"/>
<style>
.work_menu ul li a {
    color: #666;
    font-family: 微软雅黑;
    font-size: 16px;
}
.workcurrent a span {
    color: #4c88ff !important;
}
</style>
<body>
<div class="allcou">
	<?php $this->assign('index',4);
	$this->display('college/activity_menu');?>
    <div class="match">
    	<div class="jfsms">
        	<h2>1.积分说明</h2>
            <p>即日起,所有已报名注册用户在活动期间，通过电脑端和微信端均可赚取积分。学习、做作业、提问……统统都可以获得积分！根据积
分排名可获得相应奖品！</p>
        </div>
        <div class="jfsms">
        	<h2>2.积分获取方式</h2>
            <p>积分获取分为常规奖励和加倍奖励。</p>
            <p>常规奖励：</p>
            <p>（1）听课 （2）完成作业 （3）互动答疑 </p>
            <p>加倍奖励：</p>
            <p>认真做作业获得满分，奖励加倍。</p>
            <!--<p>回答问题，单个回答点赞数超过10次，奖励加倍。</p>
            <p>提出问题，单个提问点赞数超过10次，奖励加倍。</p>-->
        </div>
        <div class="jfsms">
        	<h2>3.积分规则表</h2>
            <div class="smczjf">
            	<table cellpadding="0" cellspacing="0">
                	<tr>
                    	<td width="171">说明</td>
                        <td width="270">操作</td>
                        <td width="358">获取积分</td>
                        <td width="171">获取上限</td>
                    </tr>
                    <tr>
                        <td>听课</td>
                    	<td colspan="2">
                        	<table cellpadding="0" cellspacing="0">
                            	
                                <tr class="tkjf2">
                                	<td width="270" style="border:none;">听课并看完视频</td>
                                    <td width="358" style="border:none;">每次10积分，每个课件仅一次</td>
                                </tr>
                            </table>
                        </td>
						<td>无限制</td>
					</tr>
                    <tr>
                        <td>作业</td>
                    	<td colspan="2">
                        	<table cellpadding="0" cellspacing="0">
                            	<tr class="tkjf1">
                                	<td width="270">每次完成作业</td>
                                    <td width="358">5积分</td>
                                </tr>
                                <tr class="tkjf3">
                                	<td width="270">每次完成作业，且正确率<br />60%-79%</td>
                                    <td width="358">6积分</td>
                                </tr>
                                <tr class="tkjf3">
                                	<td width="270">每次完成作业，且正确率<br />80%-99%</td>
                                    <td width="358">7积分</td>
                                </tr>
                                <tr class="tkjf2">
                                	<td width="270" style="border:none;">每次完成作业，且正确率<br />100%</td>
                                    <td width="358" style="border:none;">10积分</td>
                                </tr>
                            </table>
                        </td>
						<td>无限制</td>
					</tr>
                    <!--<tr>
                        <td>考试</td>
                    	<td colspan="2">
                        	<table cellpadding="0" cellspacing="0">
                            	<tr class="tkjf1">
                                	<td width="270">每次完成考试</td>
                                    <td width="358">每次5积分，每个考试仅一次<br />次数不限</td>
                                </tr>
                                <tr class="tkjf3">
                                	<td width="270">每次完成考试，且正确率<br />60%-79%</td>
                                    <td width="358">每次6积分，每个考试仅一次<br />次数不限</td>
                                </tr>
                                <tr class="tkjf3">
                                	<td width="270">每次完成考试，且正确率<br />80%-99%</td>
                                    <td width="358">每次10积分，每个考试仅一次<br />次数不限</td>
                                </tr>
                                <tr class="tkjf2">
                                	<td width="270" style="border:none;">每次完考试，且正确率<br />100%</td>
                                    <td width="358" style="border:none;">加倍奖励每次15积分，每个考试<br />仅一次，次数不限</td>
                                </tr>
                            </table>
                        </td>
						<td>无限制</td>
					</tr>-->
                    <tr>
                        <td>互动答疑</td>
                    	<td colspan="3">
                        	<table cellpadding="0" cellspacing="0">
                            	<tr class="tkjf1">
                                	<td width="270">提问</td>
                                    <td width="358">每次提问1积分<br />每天最多10积分</td>
                                    <td width="171">10</td>
                                </tr>
                                <!--<tr class="tkjf3">
                                	<td width="270">提问被答谢次数超过10</td>
                                    <td width="358">加倍奖励每次2积分<br />每天最多10积分</td>
                                    <td width="171">10</td>
                                </tr>-->
                                <tr class="tkjf3">
                                	<td width="270">回答问题</td>
                                    <td width="358">每次回答1积分<br />每天最多10积分</td>
                                    <td width="171">10</td>
                                </tr>
                                <tr class="tkjf2">
                                	<td width="270" style="border:none;">回答被采纳为最佳答案</td>
                                    <td width="358" style="border:none;">被采纳每次最多2积分<br />每天最多10积分</td>
                                    <td width="171" style="border:none;">10</td>
                                </tr>
                                <!--<tr class="tkjf2">
                                	<td width="270" style="border:none;">回答问题被赞数超过10</td>
                                    <td width="358" style="border:none;">加倍奖励被采纳每次最多2积分<br />每天最多10积分</td>
                                    <td width="171" style="border:none;">10</td>
                                </tr>-->
                            </table>
                        </td>
					</tr>
					<tr>
                        <td>扣分</td>
                    	<td colspan="3">
                        	<table cellpadding="0" cellspacing="0">
                            	<tr class="tkjf1">
                                	<td width="270">不得体的提问,回答</td>
                                    <td width="358">视情况扣除10积分至100积分<br />不等 </td>
                                    <td width="171">无限制</td>
                                </tr>
                                <tr class="tkjf2">
                                	<td width="270" style="border:none;">存在刻意刷分的情况</td>
                                    <td width="358" style="border:none;">视情况扣除10积分至100积分<br />不等</td>
                                    <td width="171" style="border:none;">无限制</td>
                                </tr>
                            </table>
                        </td>
					</tr>
				</table>
        	</div>
        </div>
    </div>
</div>
</body>
</html>
