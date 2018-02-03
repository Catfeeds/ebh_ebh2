
</div>
<div class="flotat" style="height:auto;overflow:hidden">
<div class="footer">
<div class="flelp">
<h3><a href="/help.html">新手帮助</a></h3>
<a class="helpink" rel="nofollow" target="_blank" href="http://static.ebanhui.com/help/cz_issue.htm">如何开通？</a>
<a class="helpink" rel="nofollow" target="_blank" href="http://static.ebanhui.com/help/dayiru.htm">如何答疑？</a>
<a class="helpink" rel="nofollow" target="_blank" href="/help.html">如何下载题库资源？</a>
<a class="helpink" rel="nofollow" target="_blank" href="/help.html">学生如何开通网校服务？</a>
</div> 
<div class="fdlink">
<div class="fdlink_title">
<h3>友情链接</h3>
<a class="dltuis" rel="nofollow" target="_blank" href="/cloudlist-1-0-0.html">更多>></a>
<a class="lxuwm" rel="nofollow" target="_blank" href="/conour.html">联系我们</a>
<a class="svnlan" rel="nofollow" target="_blank" href="/about.html">关于</a>


</div>
<?php 
	 //获取最新开通平台
		$num = 30;
        $roomparam = array('status'=>1,'upid'=>0,'limit'=>'0,'.$num,'order'=>'displayorder ASC,crid DESC');
        $newroomkey = $this->cache->getcachekey('classroom',$roomparam);
        $flink = $this->cache->get($newroomkey);
        $roommodel  = $this->model('Classroom');
        if(empty($flink)) {
            $roomselect = 'crname,domain,cface';
            $flink = $roommodel->getroomlist($roomparam,$roomselect);
            $this->cache->set($newroomkey,$flink,86400);
        }
?>
<?php foreach ($flink as  $room) {?>
 	<?php $roomurl = 'http://'.$room['domain'].'.ebh.net';?>
	<a class="gray" target="_blank" href="<?=$roomurl?>"><?=$room['crname']?></a>
<?php }?>
</div>
</div>
<?php if(($this->uri->uri_domain() == 'www' && ($this->uri->codepath == '' || $this->uri->codepath == 'index')) || ($this->uri->uri_domain() == 'hz') || ($this->uri->codepath== 'intro/schoolcreate')) { ?>
<div style="clear:both;height:0px;">&nbsp;</div>
<!-- ===== -->
<div style="text-aligh:center;width:1000px;margin:0 auto;">
<div style="text-align:center">
  <a target="_blank" href="http://www.miibeian.gov.cn/">浙B2-20160787</a>&nbsp;&nbsp;<span style="color:#666">Copyright &copy; <?= '2011-'.date('Y') ?>  ebh.net All Rights Reserved </span>&nbsp;&nbsp;<?php if($this->uri->codepath== 'intro/schoolcreate'){ ?>浙江新盛蓝科技有限公司版权所有 <?php } ?>
    <br>
    <br>
	<?php if($this->uri->codepath != 'intro/schoolcreate'){ ?>
    <a href="http://122.224.75.236/wzba/login.do?method=hdurl&amp;doamin=http://www.ebanhui.com&amp;id=330105000201409&amp;SHID=1223.0AFF_NAME=com.rouger.
       gs.main.UserInfoAff&amp;AFF_ACTION=qyhzdetail&amp;PAGE_URL=ShowDetail" target="_blank"> <img src="http://static.ebanhui.com/ebh/tpl/2012/images/gh.jpg" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a target="_blank" rel="nofollow" href="http://www.pingpinganan.gov.cn" title="杭州网络警察"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/hzjc.gif" alt="杭州网络警察" title="杭州网络警察"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.miibeian.gov.cn" target="_blank" rel="nofollow" title="网站备案">
      <img src="http://static.ebanhui.com/ebh/tpl/2012/images/beian.jpg" alt="网站备案"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://net.china.com.cn/" target="_blank" title="不良信息举报">
      <img src="http://static.ebanhui.com/ebh/tpl/2012/images/jubao.jpg" alt="不良信息举报"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.wenming.cn/" target="_blank" title="文明网站">
      <img src="http://static.ebanhui.com/ebh/tpl/2012/images/wenming.jpg" alt="文明网站"><?php } ?></a>
    <br>
    <br>
</div>
</div>
<!-- ===== -->
<?php }?>

<?php
debug_info();
?>
<!-- 统计代码开始 -->
<?php EBH::app()->lib('Analytics')->get('baidu')?>
<!-- 统计代码结束 -->
</body>
</html>