<?php $this->display('aroomv2/page_header'); ?>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20160429001"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>

<body>
<style>
.allcou{
	width:788px;
}
</style>
<div class="ter_tit">
    当前位置 &gt; <a href="/aroomv2/more.html">更多应用</a>&gt; <a href="/aroomv2/activity.html">活动专区</a>  &gt; 活动详情
</div>
<div class="allcou lefrig lefrigs" style="width:788px;">
	<div class="matchtitle"><?php echo $info['subject']?></div>
	<div class="titles">
        <a href="/aroomv2/activity/view.html?aid=<?php echo $info['aid']?>"  class="aall" style="text-decoration: none">活动介绍</a>
		<a href="/aroomv2/activity/descriptions.html?aid=<?php echo $info['aid']?>"  class="aall" style="text-decoration: none">积分规则</a>
		<a href="javascript:;"  class="aall  curs" style="text-decoration: none">统计</a>
    </div>
    <div class="matchlists matchlists1">
        <div class="matchlistpics fl"><img src="<?php echo !empty($info['imgurl']) ? $info['imgurl'] : 'http://static.ebanhui.com/ebh/tpl/2016/images/matchlistpic.jpg' ?>" width="100" height="80" /></div>
        <div class="matchlistnrs fl">
            <div class="matchlistnrsons"><a href="/aroomv2/activity/view.html?aid=<?php echo $aid?>" class="hdnames"><?php echo $info['subject']?></a></div>
            <div class="gxqcj">
                <p class="gxqs"><span class="joinscj"><?php echo $info['parter']?></span>人参加</p>
                <p class="gxqs"><span class="joinscj"><?php echo $info['viewnum']?></span>人感兴趣</p>
            </div>
        </div>
    </div>
    <div class="tjlist">
        <table cellpadding="0" cellspacing="0">
            <tr class="tjfirst">
                <td width="15%">排名</td>
                <td width="15%">账号</td>
                <td width="15%">姓名</td>
                <td width="15%">积分</td>
                <td width="25%">班级</td>
                <td width="15%">操作</td>
            </tr>
            <?php if(!empty($stat)){ foreach($stat as $k=>$v){?>
            <tr>
                <td><?echo max(0,$page['page']-1)*$page['pagesize']+$k+1?></td>
                <td><?php echo $v['username']?></td>
                <td><?php echo $v['realname']?></td>
                <td><?php echo $v['credit']?></td>
                <td><?php echo $v['classname'] ? $v['classname'] : '--'?></td>
                <td><a href="javascript:;" onclick="gosee(<?php echo $v['uid']?>,<?php echo $info['starttime']?>,<?php echo $info['endtime']?>)" style="color:#315aaa;">查看</a></td>
            </tr>
            <?php }}else{?>
                <tr><td colspan="6" align="center">暂无记录</td></tr>
            <?php }?>
        </table>
        <?php echo $pagestr?>
    </div>
</div>
<div class="clear"></div>
</body>
<script>
    function gosee(uid,start,end){
        var uid = uid;
        var start = start;
        var end = end;
        var button = new xButton();
        H.create(new P({
            id : uid,
            title: '个人活动详情',
            easy:true,
            width:620,
            padding:5,
            content:'<iframe frameborder=0 width="620px" height="500px" src="/aroomv2/activity/details.html?uid='+uid+'&starttime='+start+'&endtime='+end+'">',
            button:button
        }),'common');
        H.get(uid).exec('show');
    }
</script>
</html>
