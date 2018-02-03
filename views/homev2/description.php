<?php $this->display('homev2/header'); ?>
<?php $this->display('homev2/top'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/jfxt.css" rel="stylesheet" type="text/css" />
<div class="divcontent">
<div class="conentlft">
<div class="topbaad">
<div class="lefrig" style="background:#fff;margin-top:10px;float:left;">
	<div class="work_menu" style="width:786px; position:relative;margin-top:0px;margin-bottom:10px;">
		<ul>
			 <li><a href="/homev2/score/routinetask.html" style="font-size:16px;"><span>常规任务</span></a></li>
			 <li><a href="/homev2/score/credit.html" style="font-size:16px;"><span>积分明细</span></a></li>
			 <li><a href="/homev2/score/record.html" style="font-size:16px;"><span>兑换记录</span></a></li>
			<li class="workcurrent"><a href="/homev2/score/description.html" style="font-size:16px;"><span>积分说明</span></a></li>
			<!-- <li><a href="/homev2/score/lottery.html" style="font-size:16px;"><span>积分兑换</span></a></li> -->
		</ul>
	</div>

<?php if(empty($user['groupid']) || $user['groupid'] == 6){?>
<div style="float:left;">
<h2 class="xiaobtao">1.积分说明</h2>
<p class="paktss">新消息：即日起，所有学习、交易活动，均可赚取积分。登录、学习、做作业、提问、互助、活动、购买、出售......统统都可以获得积分
！亲爱的朋友们，赶紧来吧！</p>
<h2 class="xiaobtao">2.积分获取方式：</h2>
<p class="paktss">（1）注册 （2）登录 （3）上传头像 （4）开通服务 （5）听课（提交学习时间） （6）提交作业 （7）互动答疑 </p>
<h2 class="xiaobtao">3.积分规则表</h2>
<div class="workdata" style="margin:0px;">
<table class="datatabs" width="100%">
<thead class="tabhead">
<tr>
<th width="15%">说明</th>
<th width="35%">操作</th>
<th width="40%"><span style="width:270px;float:left;word-wrap: break-word;">获取上限</span></th>
<th width="10%">获取积分</th>
</tr>
</thead>
<tbody>
<tr>
<td>注册</td>
<td>用户注册</td>
<td>仅一次</td>
<td>10</td>
</tr>
<tr>
<td>签到</td>
<td>用户签到</td>
<td>每天仅一次</td>
<td>1</td>
</tr>
<tr>
<td>头像</td>
<td>上传头像</td>
<td>仅一次</td>
<td>5</td>
</tr>
<tr>
<td>购买服务</td>
<td>用户购买服务</td>
<td>仅一次</td>
<td>5</td>
</tr>
<tr>
<td>听课</td>
<td>每次听课完成后提交学习时间</td>
<td>每次10分,每天每个课件仅一次<br />
次数不限</td>
<td>无限制</td>
</tr>
<tr>
<td>作业</td>
<td>每次完成作业并提交</td>
<td>每次作业5分<br />
次数不限</td>
<td>无限制</td>
</tr>

<tr>
<td>互动答疑</td>
<td>回答问题</td>
<td>每次回答1分；<br />
一天最多10分；</td>
<td>10</td>
</tr>
<tr>
<td></td>
<td>回答被采纳为最佳答案</td>
<td>被采纳一次2分；一天最多10分；<br />
</td>
<td>10</td>
</tr>
<tr>
<td>网校商城</td>
<td>购买商品</td>
<td>每次购买10积分<br />
每天最多50积分</td>
<td>50</td>
</tr>
<tr>
<td></td>
<td>出售商品</td>
<td>每次出售10积分<br/>
每天最多50积分<br />
</td>
<td>50</td>
</tr>
<tr>
<td style="color:red">扣分</td>
<td>不得体的提问,回答,发言</td>
<td>视情况扣除10分至100分不等</td>
<td>无限制</td>
</tr>
</tbody>
</table>
</div>
<?php 
        $roominfo = Ebh::app()->room->getcurroom();
        $roominfo['crid'] = empty($roominfo['crid'])?0:$roominfo['crid'];
        if(empty($roominfo['crid'])){
        	$is_zjdlr = false;
        	$is_newzjdlr = false;
        }else{
	        $appsetting = Ebh::app()->getConfig()->load('othersetting');
	        $appsetting['zjdlr'] = !empty($appsetting['zjdlr']) ? $appsetting['zjdlr'] : 0;
	        $appsetting['newzjdlr'] = !empty($appsetting['newzjdlr']) ? $appsetting['newzjdlr'] : array();
	        $is_zjdlr = ($roominfo['crid'] == $appsetting['zjdlr']) || (in_array($roominfo['crid'],$appsetting['newzjdlr']));
	        $is_newzjdlr = in_array($roominfo['crid'],$appsetting['newzjdlr']);        	
        }
 ?>
<?php if(!$is_zjdlr){ ?>
<h2 class="xiaobtao">4.积分体系</h2>
<div class="workdata" style="margin:0px;">
<table class="datatabs" width="100%">
<thead class="tabhead">
<tr>
<th width="20%">积分等级</th>
<th width="40%">新积分体系</th>
<th width="40%">积分等级</th>
</tr>
</thead>
<tbody>
<tr>
<td>1</td>
<td>0 - 20</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv1tou.jpg" />书童</td>
</tr>
<tr>
<td>2</td>
<td>21 - 50</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv2tou.jpg" />书生</td>
</tr>
<tr>
<td>3</td>
<td>51 - 100</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv3tou.jpg" />秀才</td>
</tr>
<tr>
<td>4</td>
<td>101 - 150</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv4tou.jpg" />举人</td>
</tr>
<tr>
<td>5</td>
<td>151 - 200</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv5tou.jpg" />解元</td>
</tr>
<tr>
<td>6</td>
<td>201 - 300</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv6tou.jpg" />贡士</td>
</tr>

<tr>
<td>7</td>
<td>301 - 400</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv7tou.jpg" />会元</td>
</tr>
<tr>
<td>8</td>
<td>401-500</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv8tou.jpg" />同进士</td>
</tr>
<tr>
<td>9</td>
<td>501-600</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv9tou.jpg" />进士</td>
</tr>
<tr>
<td>10</td>
<td>	601-700</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv10tou.jpg" />探花</td>
</tr>
<tr>
<td>11</td>
<td>701-800</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv11tou.jpg" />榜眼</td>
</tr>
<tr>
<td>12</td>
<td>801-900</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv12tou.jpg" />状元</td>
</tr>
<tr>
<td>13</td>
<td>901-1000</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv13tou.jpg" />编修</td>
</tr>
<tr>
<td>14</td>
<td>1001-1500</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv14tou.jpg" />府丞</td>
</tr>
<tr>
<td>15</td>
<td>1501-2000</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv15tou.jpg" />翰林学士</td>
</tr>
<tr>
<td>16</td>
<td>2001-3000</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv16tou.jpg" />御史中丞</td>
</tr>
<tr>
<td>17</td>
<td>3001-4000</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv17tou.jpg" />詹士</td>
</tr>
<tr>
<td>18</td>
<td>4001-5000</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv18tou.jpg" />侍郎</td>
</tr>
<tr>
<td>19</td>
<td>5001-9999</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv19tou.jpg" />大学士</td>
</tr>
<tr>
<td>20</td>
<td>10000以上</td>
<td><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/tpl/2014/images/jifen/lv20tou.jpg" />文曲星</td>
</tr>
</tbody>
</table>
</div>
<?php }?>
</div>

<?php }else{?>

<div style="float:left;">
<h2 class="xiaobtao">1.积分说明</h2>
<p class="paktss">发福利啦~即日起,所有教学活动，均可获得积分。登录、上传课件、布置作业、讲解习题、互动答疑、教学竞赛……统统都可以获取积分！积分越多，越受同学们喜爱和尊敬哦~亲爱的老师们，赶紧动起来吧！</p>
<h2 class="xiaobtao">2.积分获取方式：</h2>
<p class="paktss">（1）注册 （2）签到 （3）上传头像 （4）发布课件 （5）互动答疑  </p>
<h2 class="xiaobtao">3.积分规则表</h2>
<div class="workdata" style="margin:0px;">
<table class="datatabs" width="100%">
<thead class="tabhead">
<tr>
<th width="15%">说明</th>
<th width="35%">操作</th>
<th width="40%"><span style="width:270px;float:left;word-wrap: break-word;">获取上限</span></th>
<th width="10%">获取积分</th>
</tr>
</thead>
<tbody>
<tr>
<td>注册</td>
<td>用户注册</td>
<td>仅一次</td>
<td>10</td>
</tr>
<tr>
<td>签到</td>
<td>用户签到</td>
<td>每天仅一次</td>
<td>1</td>
</tr>
<tr>
<td>头像</td>
<td>上传头像</td>
<td>仅一次</td>
<td>5</td>
</tr>
<tr>
<td>发布课件</td>
<td>发布课件</td>
<td>每次5分,一天最多10次</td>
<td>50</td>
</tr>


<tr>
<td>互动答疑</td>
<td>回答问题</td>
<td>每次回答1分；<br />
一天最多10分；</td>
<td>10</td>
</tr>
<tr>
<td></td>
<td>回答被采纳为最佳答案</td>
<td>被采纳一次2分；一天最多10分；<br />
</td>
<td>10</td>
</tr>
</tbody>
</table>
</div>
<?php 
        $roominfo = Ebh::app()->room->getcurroom();
        $roominfo['crid'] = empty($roominfo['crid'])?0:$roominfo['crid'];
        if(empty($roominfo['crid'])){
        	$is_zjdlr = false;
        	$is_newzjdlr = false;
        }else{
	        $appsetting = Ebh::app()->getConfig()->load('othersetting');
	        $appsetting['zjdlr'] = !empty($appsetting['zjdlr']) ? $appsetting['zjdlr'] : 0;
	        $appsetting['newzjdlr'] = !empty($appsetting['newzjdlr']) ? $appsetting['newzjdlr'] : array();
	        $is_zjdlr = ($roominfo['crid'] == $appsetting['zjdlr']) || (in_array($roominfo['crid'],$appsetting['newzjdlr']));
	        $is_newzjdlr = in_array($roominfo['crid'],$appsetting['newzjdlr']);        	
        }
?>
<?php if(!$is_zjdlr){ ?>
<h2 class="xiaobtao">4.积分体系</h2>
<div class="workdata" style="margin:0px;">
<table class="datatabs" width="100%">
<thead class="tabhead">
<tr>
<th width="20%">积分等级</th>
<th width="40%">新积分体系</th>
<th width="40%">积分等级</th>
</tr>
</thead>
<tbody>
<tr>
<td>1</td>
<td>0 - 20</td>
<td>训导</td>
</tr>
<tr>
<td>2</td>
<td>21 - 50</td>
<td>教谕</td>
</tr>
<tr>
<td>3</td>
<td>51 - 100</td>
<td>学正</td>
</tr>
<tr>
<td>4</td>
<td>101 - 150</td>
<td>学博</td>
</tr>
<tr>
<td>5</td>
<td>151 - 200</td>
<td>教习</td>
</tr>
<tr>
<td>6</td>
<td>201 - 300</td>
<td>先生</td>
</tr>

<tr>
<td>7</td>
<td>301 - 400</td>
<td>教员</td>
</tr>
<tr>
<td>8</td>
<td>401-500</td>
<td>助教</td>
</tr>
<tr>
<td>9</td>
<td>501-600</td>
<td>经师</td>
</tr>
<tr>
<td>10</td>
<td>601-700</td>
<td>讲师</td>
</tr>
<tr>
<td>11</td>
<td>701-800</td>
<td>教授</td>
</tr>
<tr>
<td>12</td>
<td>801-900</td>
<td>博士</td>
</tr>
<tr>
<td>13</td>
<td>901-1000</td>
<td>山长</td>
</tr>
<tr>
<td>14</td>
<td>1001-1500</td>
<td>外傅</td>
</tr>
<tr>
<td>15</td>
<td>1501-2000</td>
<td>司业</td>
</tr>
<tr>
<td>16</td>
<td>2001-3000</td>
<td>西席</td>
</tr>
<tr>
<td>17</td>
<td>3001-4000</td>
<td>祭酒</td>
</tr>
<tr>
<td>18</td>
<td>4001-5000</td>
<td>师保</td>
</tr>
<tr>
<td>19</td>
<td>5001-9999</td>
<td>宗师</td>
</tr>
<tr>
<td>20</td>
<td>10000以上</td>
<td>太保</td>
</tr>
</tbody>
</table>
</div>
<?php } ?>
</div>
<?php }?>
</div>
<div style="clear:both;"></div>
</div>
</div>
<script>
	$(function(){
		$('.margin a').attr('target','_blank');
	});
</script>
<div class="cotentrgt">
<img src="http://static.ebanhui.com/ebh/tpl/2016/images/rgtimg.jpg" />
</div>
</div>
<script type="text/javascript">
$(function(){
		$('.datatabs tr:last td').css('border-bottom','none');
	});
</script>
<?php $this->display('homev2/footer');?>