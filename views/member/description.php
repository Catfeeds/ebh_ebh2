<?php
$this->display('common/header');
?>
<div class="topbaad">
<?php
$this->assign('menuid',3);
$this->display('member/left');
?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/jfxt.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<style>
.datatab {
	border:none;
    border-collapse: collapse;
    width:786px;
	margin:0;
}
.tabhead th {
    background: none repeat scroll 0 0 #fff;
    font-weight: lighter;
    padding: 10px 6px;
    text-align: left;
}
.datatab td {
    background-color: #fff;
    color: #474747;
    padding: 10px;
    text-align: left;
	border:none;
	border-bottom: 1px solid #cdcdcd;
	border-top: 1px solid #cdcdcd;
	
}
</style>
<div class="cright_cher">
<div class="ter_tit">
当前位置 > <a href="<?=geturl('member/score/routinetask')?>">我的积分</a> > 积分说明
</div>
<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;margin-top:15px;width:786px;float:left;">
<div class="work_mes" style=" margin-bottom:10px;">
<ul>
<li>
<a href="/member/score/routinetask.html">
<span>常规任务</span>
</a>
</li>
<li>
<a href="/member/score/credit.html">
<span>积分明细</span>
</a>
</li>
<li>
<a href="/member/score/record.html">
<span>兑换记录</span>
</a>
</li>
<li class="workcurrent">
<a href="/member/score/description.html">
<span>积分说明</span>
</a>
</li>
</ul>
</div>
<div style="float:left;">
<h2 class="xiaobtao">1.积分说明</h2>
<p class="pakts">新消息：即日起,所有学习活动，均可赚取积分。登录、学习、做作业、提问、互助、活动……统统都可以获得积分！亲爱
的同学们，赶紧来学习吧。越学习，越积分，越快乐！</p>
<h2 class="xiaobtao">2.积分获取方式：</h2>
<p class="pakts">（1）注册 （2）登录 （3）上传头像 （4）开通服务 （5）听课（提交学习时间） （6）提交作业 （7）互动答疑 </p>
<h2 class="xiaobtao">3.积分规则表</h2>
<div class="workdata">
<table class="datatab" width="100%">
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
<td>50</td>
</tr>
<tr>
<td>登录</td>
<td>用户登录</td>
<td>每天仅一次</td>
<td>5</td>
</tr>
<tr>
<td>头像</td>
<td>上传头像</td>
<td>仅一次</td>
<td>50</td>
</tr>
<tr>
<td>开通</td>
<td>用户开通平台学习</td>
<td>仅一次</td>
<td>50</td>
</tr>
<tr>
<td>听课</td>
<td>每次听课完成后提交学习时间</td>
<td>每天一个课件仅一次；<br />
一天最多100分</td>
<td>10</td>
</tr>
<tr>
<td>作业</td>
<td>每次完成作业并提交</td>
<td>每天每项作业仅一次</td>
<td>10</td>
</tr>
<tr>
<td>互动答疑</td>
<td>发布问题</td>
<td>每次发布10分；
一天最多50分；<br />
问题被删除扣5分</td>
<td>10</td>
</tr>
<tr>
<td></td>
<td>回答问题</td>
<td>每次回答5分；<br />
一天最多50分；<br />
回答被删除扣5分</td>
<td>5</td>
</tr>
<tr>
<td></td>
<td>回答被采纳为最佳答案</td>
<td>被采纳一次5分；<br />
一天最多50分；<br />
原采纳的被取消则扣分；<br />
最佳答案被取消掉扣5分</td>
<td>5</td>
</tr>
</tbody>
</table>
</div>
</div>

</div>
</div>
<div style="clear:both;"></div>
<script>
	$(function(){
		$('.margin a').attr('target','_blank');
	});
</script>