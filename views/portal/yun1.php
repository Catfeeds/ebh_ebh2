<?php $this->display('common/header');?>
<?php
  $q = $this->input->get('q');
  $beginprice = $this->input->get('beginprice');
  $endprice = $this->input->get('endprice');
?>

<style>
  .curr {
    background: none repeat scroll 0 0 #f39800;
    color: #FFFFFF;
    padding: 4px;
    text-decoration: none;
  }

.jingti{
  width: 109px;
  margin-top: 10px;
}

.miantings {
    float: left;
    width: 251px;
}

.miantings a.linktings {
    display: block;
    height: 189px;
    width: 218px;
}
.miantings .kewents {
	height: 127px;
    margin-top: 15px;
    width: 208px;
}
.miantings .kewents img {
    float: left;
}
.miantings p {
    float: left;
    height: 20px;
    line-height: 20px;
    margin-top: 6px;
    overflow: hidden;
    text-align: left;
    width: 208px;
}
.miantings p span {
    background: none repeat scroll 0 0 #a7bb42;
    color: #fff;
    line-height: 18px;
    margin-right: 5px;
    padding: 4px;
    text-align: center;
}
.ksutgd {
	width:1000px;
	margin:0 auto;
}
</style>
<div class="ksutgd">
<div class="kaonews" style="margin-top:10px;">
<div class="lefyunind" style="position: relative;">
<div class="newkai" style="border:solid 1px #e3e3e3;background:#fff;">
<h2 class="thrkd" style="width:212px">最新开通平台</h2>
<ul>
<?php 
  foreach ($newroomlist as $key=>$newroom) {
  $newroomurl = 'http://'.$newroom['domain'].'.ebh.net';
?>
  <li class="kaiptl">
  <span class="liebiao lvcolor"><?=$key+1?></span>
    <a target="_blank"   href="<?=$newroomurl?>" title="<?=$newroom['crname']?>" ><?=$newroom['crname']?></a>
  </li>
<?php }?>
</ul>
</div>
<div class="xueyuand" style="border: solid 1px #e3e3e3;background:#fff;">
<h2 class="thrkd" style="width:212px">学员动态</h2>
<ul>
  <?php foreach($studyloglist as $slog) { ?>
      <li title="<?=$slog['title']?>"><?= shortstr($slog['username'], 2, '***')?><?= substr($slog['username'],-2)?>学习了<?= shortstr($slog['title'],12,'')?></li>
  <?php } ?>
</ul>
</div>
</div>
<div class="mianyunind">
<div class="adttop">
  <?php
    $this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 500, '_height' => 240));
  ?>
</div>
<div class="wangxx">
<a target="_blank"   class="yunwang" href="/intro/schooliswhat.html" ></a>
<a target="_blank"   class="xuesst" href="/intro/schoolfunction.html"></a>
<a target="_blank"   class="terkai" href="/intro/schoolcreate.html" ></a>
</div>
<div class="notifey">
  <?php if(!empty($newslist1)){?>
  <?php $url = empty($newslist1[0]['itemurl'])?'/yun/'.$newslist1[0]['itemid'].'.html':$newslist1[0]['itemurl']?>
  <h2>
      <a target="_blank"   href="<?=$url?>"  title="<?=$newslist1[0]['subject']?>"><?= shortstr($newslist1[0]['subject'],50,'')?></a>
  </h2>
  <p>
      <?= shortstr($newslist1[0]['note'],132,'……')?>
      <a target="_blank"   style="color:#0092ce;"  href=<?=$url?>>》查看详情</a>
  </p>
  <?php }?>
  <ul>
    <?php if(!empty($newslist2)){?>
       <?php foreach($newslist2 as $newskey=>$newsitem) {?>
        <?php $url = empty($newsitem['itemurl'])?'/yun/'.$newsitem['itemid'].'.html':$newsitem['itemurl']?>
        <li <?= ($newskey==10 || $newskey==11) ? 'style="border:none;"' : ''?>>
            <a target="_blank"   href="<?= $url?>" title="<?= $newsitem['subject']?>" >
                <span><?= shortstr($newsitem['subject'],32,'')?></span>
            </a>
        </li>
        <?php } ?>
    <?php }?>
  </ul>
</div>
</div>
<div class="rigyunind">
  <div class="loginsa">
      <h2 class="mertes"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/tityonghu0307.jpg" width="65" height="29" /></h2>
     <?php
     if(!empty($user)) {
          $sex = empty($user['sex']) ? 'man' : 'woman';
          $type = $user['groupid'] == 5 ? 't' : 'm';
          $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
          $face = empty($user['face']) ? $defaulturl : $user['face'];
          $facethumb = getthumb($face,'78_78');
     ?>    
      <div class="fanh">
          <div class="waikuang"><img src="<?= $facethumb ?>" width="78" height="78" /></div>
          <div class="grmingz">
              <p class="zi"><?= $user['username']?></p>
              <p>上次登录时间： <span class="col"><?= $user['lastlogintime']?></span></p>
          </div>
      </div>
      <div style="float:left;">
          <?php if($user['groupid'] == 6){ ?>
          <input type="button" class="loggrzx" onmouseover="this.className = 'loggrzx2'" onmouseout="this.className = 'loggrzx'" style="margin-bottom: 10px;" value="马上进入" onclick="window.location.href = '<?= geturl('member')?>'" />
          <?php } else { ?>
          <input type="button" class="loggrzx" onmouseover="this.className = 'loggrzx2'" onmouseout="this.className = 'loggrzx'" style="margin-bottom: 10px;" value="马上进入" onclick="window.location.href = '<?= geturl('teacher/choose')?>'" />
          <?php } ?>
      </div>
      <p class="eithe">
          <?php if($user['groupid'] == 6){ ?>
                    <a target="_blank"   class="lians"  href="<?= geturl('home')?>">个人中心</a>
          <?php } else { ?>
          <a target="_blank"   class="lians"  href="<?= geturl('teacher/choose')?>">个人中心</a>
          <?php } ?>
          <span class="clos">|</span>
          <a    class="lians" target="_self" href="<?=geturl('logout')?>">退出</a>
      </p>

      <?php } else {?>
      <form method="POST" action="<?= geturl('login')?>" id="form1"  onkeydown="keyLogin(event);">
          <div class="liteaa">
              <div class="vbfer">
                  <span class="yang">帐号</span>
                  <input class="uskt" type="text" value="" name="username" id="username"  maxlength="16">
              </div>
              <div class="vbfer">
                  <span class="yang">密码</span>
                  <input id="password" class="uskt" type="password" value="" name="password" id="password" maxlength="16" style="color: #000" >
              </div>
              <div id="lols">
                  <input class="check" type="checkbox" checked='checked' value="1" style="vertical-align:middle;" name="cookietime">
              </div>
              <div class="zz">下次自动登录</div>
              <div class="stylt">
                  <input id="loginsubmit" class="loginiu" onmouseover="this.className = 'loginiu2'" onmouseout="this.className = 'loginiu'" type="button" value="立即登录">
                  <input id="loginsubmit" type="hidden" value="1" name="loginsubmit">
              </div>

              <div class="qtlol">
                  <span style="color:#000;">用其他账号登录：</span>
                  <a target="_blank"   href="<?=geturl('otherlogin/qq')?>">
                      <img src="http://static.ebanhui.com/ebh/tpl/2012/images/qqico0925.jpg">
                  </a>
                  <a target="_blank"   href="<?=geturl('otherlogin/sina')?>">
                      <img src="http://static.ebanhui.com/ebh/tpl/2012/images/sianico0925.jpg">
                  </a>
              </div>

              <p class="eithe">
                  <a target="_blank"   class="lians"  href="<?=geturl('register')?>">用户注册</a>
                  <span class="clos">|</span>
                  <a target="_blank"   class="lians"  href="<?= geturl('forget')?>">忘记密码</a>
              </p>

          </div>

      </form>
      <? }?>
  </div>
<div class="locktian">
<a target="_blank"   class="qianglook"  href="/course/9107.html"></a>
</div>
<div class="xuere" style="height:auto;background:#fff;border:1px solid #e3e3e3;">
<h2 class="thrkd" style="width:212px">学习热门榜</h2>
<ul>
<?php foreach($hotcourselist as $ckey=>$course) { ?>
<li class="kaiptl">
  <span class="liebiao lvcolor"><?=1+$ckey?></span>
  <a target="_blank"    title="<?= $course['title']?>" href="<?= geturl('course/'.$course['cwid'])?>"><?= shortstr($course['title'],30)?></a>
</li>
<?php } ?>
</ul>
</div>
<!-- ==== -->
<div class="locktian">
<a target="_blank"   class="qianglook" style="background:url(http://static.ebanhui.com/portal/images/question0901.jpg) no-repeat"  href="/question.html"></a>
</div>
<!-- ==== -->
</div>
</div>
<div  class="admb">
<a target="_blank" href="/eq.html">
<img src="http://static.ebanhui.com/portal/images/adyun002.jpg" />
</a>
</div>

<div class="kaonews" style="float:left;">
<div class="ptsou" style="width:998px;border:1px solid #e3e3e3;background:#fff;height:250px;">
<h2 class="thrkd" style="width:936px">试听课件</h2>
<a class="rguefd" target="_blank" href="/free.html">更多>></a>
<ul>
<li class="miantings" style="margin-left:19px;">
<a target="_blank"   class="linktings" href="/course/14298.html" title="函数的最值 第17课（上）" >
<div class="kewents">
<img width="208px" height="127px" src="http://static.ebanhui.com/ebh/tpl/2014/images/tingke02.jpg">
</div>
<p>
<span>免</span>
函数的最值 第17课（上）
</p>
<p>函数的最值 第17课（上）</p>
</a>
</li>
<li class="miantings">
<a target="_blank"   class="linktings" href="/course/13354.html" title="The Sixth Lesson" >
<div class="kewents">
<img width="208px" height="127px" src="http://static.ebanhui.com/ebh/tpl/2014/images/tingke01.jpg">
</div>
<p>
<span>免</span>
The Sixth Lesson
</p>
<p>本节课主要讲解句子结构的相关知识</p>
</a>
</li>
<li class="miantings">
<a target="_blank"   class="linktings" href="/course/14140.html" title="直线运动图像" >
<div class="kewents">
<img width="208px" height="127px" src="http://static.ebanhui.com/ebh/tpl/2014/images/tingke03.jpg">
</div>
<p>
<span>免</span>
直线运动图像
</p>
<p>专题讲座，直线运动的图像。</p>
</a>
</li>
<li class="miantings" style="width:208px;">
<a target="_blank"   class="linktings" href="/course/14181.html" title="氧化还原反应" >
<div class="kewents">
<img width="208px" height="127px" src="http://static.ebanhui.com/ebh/tpl/2014/images/tingke04.jpg">
</div>
<p>
<span>免</span>
氧化还原反应
</p>
<p>本节课主要讲解氧化还原反应的相关知识。</p>
</a>
</li>
</ul>
</div>
</div>


<div class="kaonews">

<style>
  .yunjxlie ul li{
    width: 94px;
  }
</style>

  <!-- ========== -->
  <div class="lstgjy" style="width:998px;border:1px solid #e3e3e3;background-color:#fff">
    <h2 class="thrkd" style="width:936px">云教学平台</h2>
    <a class="rguefd" target="_blank" href="/cloudlist-1-4-0.html">更多>></a>
<div class="yunjxlie" style="margin-top:1px;float:left;padding-left:15px;">
      <ul>
      <?php foreach ($allschoollist as $key => $netschool) {?>
        <?php
          $roomurl = 'http://'.$netschool['domain'].'.ebh.net';
          $netschool['cface'] = empty($netschool['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$netschool['cface'];
        ?>
         <li <?=$key%8==0?'style="margin-left:0"':''?> <?=(1+$key)%8==0?'style="margin-right:0"':''?>>
        <a target="_blank" title="<?=$netschool['crname']?>" href="<?=$roomurl?>">
        <!-- <img src="http://static.ebanhui.com/portal/images/adadada.jpg" /> -->
        <img width="100px" height="100px"  src="<?=$netschool['cface']?>" />
        </a>
        <h4 class="wangjie">
        <a target="_blank"   title="<?=$netschool['crname']?>" href="<?=$roomurl?>"><?=$netschool['crname']?></a>
        </h4>
        </li>
      <?php }?>
      </ul>
    </div>
  </div>
<!-- === -->
</div>
<!-- ==== -->
<div class="lstgjy" style="width:998px;border:1px solid #e3e3e3;background:#fff;">
  <h2 class="thrkd" style="width:936px">精品题库</h2>
  <a class="rguefd" target="_blank" href="/epaper.html">更多>></a>
<div class="clearbox">
<div class="xindong" style="width:auto;padding-left:18px;height:155px;border:none;margin-top:0;background:#fff;">
<ul>
<?php
  $count = count($free);
  $start = rand(0,$count-9);
  $free = array_slice($free,$start,9);
?>
<?php foreach ($free as $key => $tk) {?>
<?php if($key>8)break;?>
<li class="jingti" <?php if($key==8){echo 'style="width:88px"';}?> >
<a target="_blank"   class="linkti"  href="/epaper/eplist-1-0-0-<?=$tk['grade']?>-<?=$tk['gid']?>.html"><div class="went"><img width=87px height=90px src="http://static.ebanhui.com/ebh/<?=$tk['img']?>" /></div>
<span>试卷数：<?=$tk['lnum']?></span>
<span><?=$tk['groupname']?></span>
</a>
</li>
<?php }?>
</ul>
</div>
</div>
</div>
<!-- ==== -->
<div class="kaonews">
<div class="ptsou" style="border:1px solid #e3e3e3;background:#fff;">
 <h2 class="thrkd" style="width:982px;">平台搜索</h2>
<div class="soukuang" style="margin:10px 40px;">
<input id="keywords1" class="soutxt" style="width:815px;*width:745px;color:#A5A5A5;" type="text" value="" />
<a class="soubtn" href="javascript:void(0)" onclick="listsearch('keywords1')">搜 索</a>
</div>
<div class="icategry">
<div class="rebiaoq">
<dt style="line-height:30px;">热门标签：</dt>
<dd>
<div class="wtiedh">
<div>
<a target="_blank"   <?php if($q==''){echo 'class=lanbiao';}?> href="<?= geturl('cloudlist-1-0-0--')?>" >不限</a>
</div>
<?php foreach ($labellist as $label) {?>
  <div><a target='_blank' <?php if($q==$label['title']){echo "class=lanbiao";}?> href="<?= geturl('cloudlist-1-0-0--')?><?='?q='.$label['title'].'&beginprice='.$beginprice.'&endprice='.$endprice?>"><?= $label['title'] ?></a></div>
<?php }?>
</div>
</dd>
</div>

<div class="ptjia">
<dt style="line-height:30px;width:60px;">价格：</dt>
<dd>
<div class="wtiedh">
<div>
<a target="_blank" class="<?= ($beginprice==''&&$endprice=='')?'lanbiao':''?>" href="<?= geturl('cloudlist-1-0-0--')?>">不限</a>
</div>
<div>
<a target="_blank" class="<?= ($beginprice=='1'&&$endprice=='100')?'lanbiao':''?>" href="<?= '/cloudlist-1-0-0-0-0.html?q='.$q.'&beginprice=1&endprice=100'?>">1-100元</a>
</div>
<div>
<a target="_blank" class="<?= ($beginprice=='101'&&$endprice=='300')?'lanbiao':''?>" href="<?= '/cloudlist-1-0-0-0-0.html?q='.$q.'&beginprice=101&endprice=300'?>">101-300元</a>
</div>
<div>
  <a target="_blank" class="<?= ($beginprice=='301'&&$endprice=='500')?'lanbiao':''?>" href="<?= '/cloudlist-1-0-0-0-0.html?q='.$q.'&beginprice=301&endprice=500'?>">301-500元</a>
</div>
<div>
  <a target="_blank"  class="<?= ($beginprice=='501'&&$endprice=='0')?'lanbiao':''?>" href="<?= '/cloudlist-1-0-0-0-0.html?q='.$q.'&beginprice=501&endprice'?>">501元以上</a>

<a target="_blank"   href="#">501以上</a>
</div>
<div style="width:150px;">
<input id="beginprice" class="iptxt" type="text" value="￥" onblur="if($.trim(this.value).length==0){this.value='￥';this.style.color='#A5A5A5';}" onfocus="if(this.value=='￥')this.value='';this.style.color='#000';" maxlength="13" style="color: rgb(165, 165, 165);">
<span>-</span>
<input id="endprice" class="iptxt" type="text" value="￥" onblur="if($.trim(this.value).length==0){this.value='￥';this.style.color='#A5A5A5';}" onfocus="if(this.value=='￥')this.value='';this.style.color='#000';" maxlength="13" style="color: rgb(165, 165, 165);">
</div>
<div>
<a target="_blank"   href="javascript:void(0)" onclick="pricechange()" class="zhunbtn">确 定</a>
</div>
</div>
</dd>
</div>
<div class="etryk">
<dt style="line-height:30px;width:60px;padding-left:15px;">排序：</dt>
<dd style="margin-top: 3px;">
<ul>
<li class="qwlean"><a target="_blank" href="/cloudlist-1-0-0-.html">综合</a></li>
<li class="qwlean" style="background:url(http://static.ebanhui.com/portal/images/lieico.jpg) no-repeat 42px center;"><a target="_blank" href="/cloudlist-1-2-0-.html">人气</a></li>
<li class="qwlean"><a target="_blank" href="/cloudlist-1-4-0-.html">推荐</a></li>
<li><a target="_blank"  href="/cloudlist-1-3-0-.html">最新</a></li>
<!-- <li class="wrktie"><a target="_blank"   href="/cloudlist-1-1-0-.html">价格从低到高</a></li> -->
<li class="ewiwtw"><a target="_blank"   href="javascript:location.reload()" style="color:#18a8f7;">重置筛选条件</a></li>
</ul>
</dd>
</div>
</div>
</div>
<style>
  .wangxue {
  float:left;
  width:998px;
  background: #fff;
  border: solid 1px #e3e3e3;
  border-top: 0;
  padding-bottom: 10px;
}
.wangxue li {
  float:left;
  padding-left: 12px;
  width:186px;
  height:33px;
  line-height:33px;
  /*background-color: #F4F4F4;*/
}
.wangxue li a.xuelink {
  color:#5b5b5b;
  background:url(http://static.ebanhui.com/ebh/tpl/2012/images/bg20131122.gif) no-repeat left center;
  padding-left:10px;
}
.wangxue li a.xuelink:visited {
    color: #3095C6;
    text-decoration: none;
}
.wangxue li a.xuelink:hover {
    color: #3095C6;
    text-decoration: underline;
}
</style>

<div class="wangxue" >
    <ul>
      <?php 
        foreach ($allroomlist as $key=>$room) {
        $roomurl = 'http://'.$room['domain'].'.ebh.net';
      ?>
        <li><a target="_blank"   href="<?=$roomurl?>" class="xuelink" title="<?=$room['crname']?>"><?=ssubstrch($room['crname'],0,24)?></a></li>
      <?php }?>
    </ul>
</div>
</div>
</div>
</div>
</div>
 <script type="text/javascript">
    <!--

     $(function(){
          $("#loginsubmit").click(function(){
               if ($('#username').val() == '' || $('#username').val() == "帐号"){
                    alert('账号不能为空');
                    $('#username').focus();
                    return;
               }
               if ($("#password").val() == ''){
                    alert('密码不能为空');
                    $('#password').focus(); return;
               }
               $.ajax({
                    url:'/login.html?inajax=1',
                    data:$("#form1").serialize(),
                    type  :'POST',
                    dataType:'json ',
                    success :function(json){                       
                        if (json['code'] == 1){
                            if (json["returnurl"] == '/member.html') {
                                location.href = "<?= geturl('yun')?>";
                            } else{
                                location.href = json["returnurl" ];
                            }
                        } else{
                            alert(json["message"]);
                        }
                        return false;
                    }
                });
            });
      });
      function pricechange (){
          var param = $("#s2").serialize();
          var beginprice = $.trim($("#beginprice").val());
          if(beginprice=='￥')beginprice=0;
          var endprice = $.trim($("#endprice").val());
          if(endprice=='￥')endprice=0;
          if (parseInt(beginprice) > parseInt(endprice)){
              var tmpprice = beginprice;
              beginprice = endprice;
              endprice = tmpprice;
          }
          var keywords = encodeURIComponent($.trim($("#keywords").val() =='请输入您要搜索的云教育网校'? '' :$("#keywords").val()));
          var url = '/cloudlist-1-0-0.html?q='+keywords+'&beginprice='+beginprice+'&endprice='+endprice+'&'+param;
          window.open(url,'_blank');
      }

    function listsearch(keyid){
      var beginprice = $.trim($("#beginprice").val());
          if(beginprice=='￥')beginprice=0;
          var endprice = $.trim($("#endprice").val());
          if(endprice=='￥')endprice=0;

      // var citycode = $.trim($("#address_sheng").val());
      if (parseInt(beginprice) > parseInt(endprice)){
        var tmpprice = beginprice;
        beginprice = endprice;
        endprice = tmpprice;

    }
    var keywords=$.trim($("#"+keyid).val()=='输入平台关键字'?'':$("#"+keyid).val());
      var url = '/cloudlist-1-0-0.html?q='+keywords;
      window.open(url,'_blank');
  }

    function listsearchs(){
      var beginprice=$.trim($("#beginprice").val());
      var endprice=$.trim($("#endprice").val());
      var citycode=$.trim($("#address_sheng").val());
      if(parseInt(beginprice)>parseInt(endprice)){
          var tmpprice=beginprice;
          beginprice=endprice;
          endprice=tmpprice;
      
      }
      var keywords=$.trim($("#keywords").val());
      var url='/cloudlist-1-0-0.html?q='+keywords+beginprice+endprice;
      window.location.href=url;
    }
    
    function keyLogin(e){  
      var event = window.event || e;
      if (event.keyCode==13)   //回车键的键值为13  
        document.getElementById("loginsubmit").click(); //调用登录按钮的登录事件  
    } 
      
    //-->

    $(function(){
      $('h2.titqiye,h2.titptwang,h2.titptyun,h2.xiaotit')
      .click(function(){
        var href = $(this).find('a').attr("href");
        window.open(href,'_blank');
      })
      .css({cursor:'pointer'});
    });

  $(function(){
    initsearch("username","账号");
    initsearch("keywords1","输入平台关键字");
  });
</script>

<?php $this->display('common/footer');?>