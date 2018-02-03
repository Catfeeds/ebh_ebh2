<?php
$this->display('common/header');
?>
<?php
	$q = $this->input->get('q');
	$beginprice = $this->input->get('beginprice');
	$endprice = $this->input->get('endprice');
?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/joinlc.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/cloudlist.css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/cloud.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/wxlie.css" />
<div class="yiping">
    <div class="lefping" style="position: relative;">
        <div class="lefcai">
            <h2 class="topfen">云教学网校分类</h2>
            <ul>
                <?php
                $count = 0;
                foreach ($catlist as $ckey => $cat) {
                    $catid = $cat['catid'];
                    $count ++;
                    $curl = geturl('cloudlist-1-0-0----' . $catid, FALSE);
                    ?>
                    <li><a href="<?= $curl; ?>" class="huaga<?php echo $count; ?>" target="_blank"><?= $cat['name'] ?></a></li>
                    <? } ?>
                </ul>
            </div>
            <div class="catshow"></div>
            <div class="adttop">
                <?php
                $this->widget('ad_widget', $adlist, array('_id' => 'actor', '_width' => 500, '_height' => 240));
                ?>
            </div>
            <div class="wangxx">
                <a class="yunwang" target="_blank" href="http://www.ebanhui.com/help/1426.html"></a>
                <a class="xuesst" href="http://static.ebanhui.com/help/free_first.htm"></a>
                <a class="terkai" target="_blank" href="http://www.ebanhui.com/help/1444.html"></a>
            </div>
            <div class="xueyuand">
                <h2><img src="http://static.ebanhui.com/ebh/tpl/2012/images/titxuedong0307.jpg" width="65" height="28" /></h2>
                <ul>
                    <?php foreach($studyloglist as $slog) { ?>
                    <li title="<?=$slog['title']?>"><?= shortstr($slog['username'], 2, '***')?><?= substr($slog['username'],-2)?>学习了<?= shortstr($slog['title'],12,'')?></li>
                    <?php } ?>

                </ul>
            </div>
            <div class="notifey">
                <h2><?php $newslisturl = empty($newslist1['itemurl']) ? geturl($newslist1['code'].'/'.$newslist1['itemid']) : $newslist1['itemurl']?>
                    <a href="<?= $newslisturl?>" target="_blank" title="<?= $newslist1['subject']?>"><?= shortstr($newslist1['subject'],50,'')?></a>
                </h2>
                <p>
                    <a href="<?= $newslisturl?>" target="_blank"><?= shortstr($newslist1['note'],132,'……')?></a>
                    <a style="color:#0092ce;" target="_blank" href="<?= $newslisturl?>">》查看详情</a>
                </p>
                <ul>
                    <?php foreach($newslist2 as $newskey=>$newsitem) { 
                        $url = empty($newsitem['itemurl']) ? geturl($newsitem['code'].'/'.$newsitem['itemid']) : $newsitem['itemurl'];
                    ?>
                    <li <?= ($newskey==10 || $newskey==11) ? 'style="border:none;"' : ''?>>
                        <a href="<?= $url?>" title="<?= $newsitem['subject']?>" target="_blank">
                            <span><?= shortstr($newsitem['subject'],30,'')?></span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="rigping">
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
                    <a class="lians" target="_blank" href="<?= geturl('member')?>">个人中心</a>
					<?php } else { ?>
					<a class="lians" target="_blank" href="<?= geturl('teacher/choose')?>">个人中心</a>
					<?php } ?>
                    <span class="clos">|</span>
                    <a class="lians" target="_self" href="<?=geturl('logout')?>">退出</a>
                </p>

                <?php
               } else {
                ?>
                <form method="POST" action="<?= geturl('login')?>" id="form1"  onkeydown="keyLogin(event);">
                    <div class="liteaa">
                        <div class="vbfer">
                            <span class="yang">帐号</span>
                            <input class="uskt" type="text" value="帐号" name="username" id="username" onblur="if ($.trim(this.value).length == 0){this.value = '帐号'; this.style.color = '#A5A5A5'; }" onfocus="if (this.value == '帐号')this.value = ''; this.style.color = '#000';" maxlength="16">
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
                            <a href="<?=geturl('otherlogin/qq')?>">
                                <img src="http://static.ebanhui.com/ebh/tpl/2012/images/qqico0925.jpg">
                            </a>
                            <a href="<?=geturl('otherlogin/sina')?>">
                                <img src="http://static.ebanhui.com/ebh/tpl/2012/images/sianico0925.jpg">
                            </a>
                        </div>

                        <p class="eithe">
                            <a class="lians" target="_blank" href="<?=geturl('register')?>">用户注册</a>
                            <span class="clos">|</span>
                            <a class="lians" target="_blank" href="<?= geturl('forget')?>">忘记密码</a>
                        </p>

                    </div>

                </form>
                <?
                }
                ?>
            </div>
            <div class="tianlock">
                <a href="http://svnlan.ebanhui.com/course/9107.html" class="qianglook" target="_blank"></a>
            </div>
            <div class="newst">
                <h2><img src="http://static.ebanhui.com/ebh/tpl/2012/images/titxuelib0307.jpg" width="80" height="28" /></h2>
                <ul style="margin-top:8px;" id="newtop">
                    <?php foreach($hotcourselist as $ckey=>$course) { ?>
                    <li class="new<?= $ckey + 1?>">
                        <a target="_blank" title="<?= $course['title']?>" href="<?= geturl('course/'.$course['cwid'])?>"><?= shortstr($course['title'],26)?></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
		<?php
            if(!empty($centeradlist)) {
				$centerad0 = $centeradlist[0];
                $ad1url = $centerad0['itemurl'];
                if($ad1url == '#') 
					$aurl = '<a href="javascript:;">';
				else
					$aurl = '<a href="'.$centerad0['itemurl'].'" target="_blank">';
                ?>
		<div class="foot_ad" style="margin-bottom:0px;height:120px;">
				<?= $aurl ?>
				<img width="960" src="<?= empty($centerad0['thumb'])?'http://static.ebanhui.com/ebh/tpl/2012/images/ad0521.png':$centerad0['thumb'] ?>"></a>
		</div>
		<?php 
				}
		?>
        <div class="xinwang">
            <h2 class="groom">
                <img class="lef" src="http://static.ebanhui.com/ebh/tpl/2012/images/titwangxiao0307.jpg" width="98" height="30" />
                <a class="mores" href="<?= geturl('cloudlist')?>">
                    <img src="http://static.ebanhui.com/ebh/tpl/2012/images/gengduo0307.jpg" width="39" height="30" />
                </a>
            </h2>
            <ul class="list1">
                <?php
                foreach($newroomlist as $newroom) {
                    $newroomurl = 'http://'.$newroom['domain'].'.ebanhui.com';
                    $newroomimg = empty($newroom['cface']) ? 'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$newroom['cface'];
                ?>
                <li class="">
                    <a class="img-shadow" href="<?= $newroomurl ?>" title="<?= $newroom['crname'] ?>">
                        <img src="<?= $newroomimg ?>" width="90" height="90" /> </a>
                    <h4 class="wangjie">
                        <a href="<?= $newroomurl ?>" title="<?= $newroom['crname'] ?>"><?= $newroom['crname'] ?></a>
                    </h4>
                </li>
                <?php } ?>
            </ul>
        </div>
        <div class="seek">
            <?php $tagarray=array('杭州','绘画','少儿','简笔画','初中','日语','高数','专升本','成人');?>
            <p class="tags">关键字：<?php foreach($tagarray as $tag) {?><a href="/cloudlist-1-0-0.html?q=<?= urlencode($tag)?>"><?= $tag ?></a><? } ?></p>
            <input id="keywords1" name="textfield2" type="text" class="txt_seek" value="请输入您要搜索的云教育网校" onblur="if($.trim(this.value).length==0){this.value='请输入您要搜索的云教育网校';this.style.color='#A5A5A5';}" onfocus="if(this.value=='请输入您要搜索的云教育网校')this.value='';this.style.color='#000';" maxlength="13" />

            <input type="submit" name="Submit3" value="" class="seekbtn" onclick="listsearch('keywords1')"/>
        </div>
        <div class="foot_ad">
            <?php
            if(!empty($centeradlist) && count($centeradlist) > 1) {
                $centerad1 = $centeradlist[1];
                $ad1url = $centerad1['itemurl'];
                if($centerad1['itemurl'] == '#') {
                ?>
                <a href="javascript:;">
                <?php } else {
                ?>
                <a href="<?= $centerad1['itemurl'] ?>" target="_blank">
                <?php } ?>
                    <img height="60" width="960" src="<?= $centerad1['thumb']?>"></a>
            <?php } ?>
        </div>

        <div class="xianei">
            <div class="soles">
                <div class="lefsole">
                    <input id="keywords" class="soutxt" name="textarea" type="text" value="" maxlength="13" />
                    <a class="soubtn" href="javascript:listsearchs();">搜　索</a>
                    <p class="soujie">您可以在关键词搜索框中输入想要进入的学习平台名称，或者按照类别或价格等筛选出符合自己要求的学习平台！</p>
                </div>
                <div class="rigsole">
                    <div id="icategory" class="clearfix">
                        <dt>按标签：</dt>
                        <dd>
                            <div class="category_cont1">
                                <div>
                                    <a class="curr" href="<?= geturl('cloudlist') ?>">不限</a>
                                </div>
                               
								<?php 
								foreach($labellist as $label){
								?>
                                <div>
                                    <a class="<?php ($q==$label['title'])?'curr':'' ?>" href="<?= geturl('cloudlist-1-0-0--')?><?='?q='.$label['title'].'&beginprice='.$beginprice.'&endprice='.$endprice?>"><?= $label['title'] ?></a>
                                </div>
								<?php }?>

                            </div>
                        </dd>
                        <div class="clear"></div>
                    </div>
                    <div class="price_filter clearfix">
                        <dt>按价格：</dt>
                        <dd>
                            <div class="price_cont">
                               <div>
								<a class="<?= ($beginprice==''&&$endprice=='')?'curr':''?>" href="<?= '/cloudlist-1-0-0.html?q='.$q?>">不限</a>
								</div>
								<div>
								<a class="<?= ($beginprice=='0'&&$endprice=='0')?'curr':''?>" href="<?= '/cloudlist-1-0-0-0-0.html?q='.$q.'&beginprice=0&endprice=0'?>">免费</a>
								</div>
								<div>
								<a class="<?= ($beginprice=='1'&&$endprice=='100')?'curr':''?>" href="<?= '/cloudlist-1-0-0-1-100.html?q='.$q.'&beginprice=1&endprice=100'?>">1-100元</a>
								</div>
								<div>
								<a class="<?= ($beginprice=='101'&&$endprice=='300')?'curr':''?>" href="<?= '/cloudlist-1-0-0-101-300.html?q='.$q.'&beginprice=101&endprice=300'?>">101-300元</a>
								</div>
								<div>
								<a class="<?= ($beginprice=='301'&&$endprice==='500')?'curr':''?>" href="<?= '/cloudlist-1-0-0-301-500.html?q='.$q.'&beginprice=301&endprice=500'?>">301-500元</a>
								</div>
								<div style="width:70px;"> 
								<a class="<?= ($beginprice=='501'&&$endprice=='')?'curr':''?>" href="<?= '/cloudlist-1-0-0-501.html?q='.$q.'&beginprice=501&endprice='?>">501元以上</a>
								</div>
                                <div class="pipt">
                                    <input id="beginprice" class="iptxt" type="text" name="" value="" onkeyup="this.value = this.value.replace(/\D/g, '')">
                                    <span style="color: #2FA4EB;">-</span>
                                    <input id="endprice" class="iptxt" type="text" name="" value="" onkeyup="this.value = this.value.replace(/\D/g, '')">
                                    <input class="pbtn" onmouseover="this.className = 'pbtn2'" onmouseout="this.className = 'pbtn'" type="button" name="" value="确 定" onclick="pricechange()">
                                </div>
                            </div>
                        </dd>
                        <div class="clear"></div>
                    </div>
                    <div id="conditions">
                        <dt>已选条件：</dt>
                        <dd>
                            <span>
                                <a href="/cloudlist.html">重置筛选条件</a></span>
                        </dd>
                    </div>
                </div>
            </div>
            <div class="wangxue">
                <ul>
                    <?php foreach($allroomlist as $aroom) { ?>
                    <li><a href="<?= 'http://'.$aroom['domain'].'.ebanhui.com' ?>" class="xuelink" title="<?= $aroom['crname'] ?>"><?= shortstr($aroom['crname'],28,'') ?></a></li>
                    <?php } ?>
                </ul>
                <div class="page">
                    <a class="current">1</a>
                    <a href="/cloudlist-2.html">2</a>
                    <a href="/cloudlist-3.html">3</a>
                    <a href="/cloudlist-4.html">4</a>
                    <a href="/cloudlist-5.html">5</a>
                    <a href="/cloudlist-6.html">6</a>
                    <a href="/cloudlist-7.html">7</a>
                    <a href="/cloudlist-8.html">8</a>
                    <a href="/cloudlist-9.html">9</a>
                    <a href="/cloudlist-2.html">下一页</a>
                    <a href="/cloudlist-9.html">尾页</a>
                </div>
            </div>
        </div>
        <div style="clear: both"></div>
    </div>
    </div>
    <div style="clear:both;"></div>
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
                    type	:'POST',
                    dataType:'json ',
                    success	:function(json){                       
                        if (json['code'] == 1){
                            if (json["returnurl"] == '/member.html') {
                                location.href = "<?= geturl('member/cloud')?>";
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
          var beginprice = $.trim($("#beginprice").val());
          var endprice = $.trim($("#endprice").val());
          if (parseInt(beginprice) > parseInt(endprice)){
              var tmpprice = beginprice;
              beginprice = endprice;
              endprice = tmpprice;
          }
          var keywords = encodeURIComponent($.trim($("#keywords").val() =='请输入您要搜索的云教育网校'? '' :$("#keywords").val()));
          var url = '/cloudlist-1-0-0.html?q='+keywords+'&beginprice='+beginprice+'&endprice='+endprice;
          window.location.href = url;
      }

		function listsearch(keyid){
			var beginprice = $.trim($("#beginprice").val());
			var endprice=$.trim($("#endprice").val());
			var citycode = $.trim($("#address_sheng").val());
			if (parseInt(beginprice) > parseInt(endprice)){
				var tmpprice = beginprice;
				beginprice = endprice;
				endprice = tmpprice;

		}
		var keywords=$.trim($("#"+keyid).val()=='请输入您要搜索的云教育网校'?'':$("#"+keyid).val());
			var url = '/cloudlist-1-0-0.html?q='+keywords+beginprice+endprice;
		window.location.href=url;
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
    </script>
    <?php
	$this->display('common/player');
    $this->display('common/footer');
    ?>
</body>
</html>
