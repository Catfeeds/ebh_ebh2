<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $room['crname'] ?></title>
<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" />
<meta name="description" content="<?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?>" />
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/citytpl/stores/css/wxind.css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/rangy-core.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />   
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/course.js?version=20150528001"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/wavplayer.css" rel="stylesheet" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style type="text/css">

.dengtu {
    border:none;
    height: 195px;
    margin: 10px 0;
    width: 277px;
}
.dengtu li {
    border-style: solid;
    border-width: 1px;
    float: left;
    height: 195px;
    margin: 0 17px 40px 0;
    position: relative;
    width: 277px;
    z-index: 2;
    border-color: #CDCDCD;
}
.photo_photolist_inner {
    position: relative;
}
.photo_photolist_img {
    height: 195px;
    overflow: hidden;
    width: 277px;
}
.photo_photolist_img a {
    height: 195px;
    width: 277px;
}
fieldset, img, a img, iframe {
    border-style: none;
    border-width: 0;
}
.bofang {
    background:url(http://static.ebanhui.com/ebh/tpl/2012/images/download.png) no-repeat scroll ;
    color: #FFFFFF;
    float: left;
    height: 23px;
    line-height: 23px;
    text-align: center;
    width: 105px;
}
em{
    font-style: italic;
    
}
.huide strong em{
    font-weight: bold;
}
.huide em strong{
    font-style: italic;
}
strong{
    font-weight: bold;
}
.showtype{
    width: 200px;
    height: 34px;
    color: #787878;
    line-height: 34px;
    position: absolute;
    left: 120px;
    top:0;
}
.showtype input{
    position: relative;
    top:3px;
    cursor: pointer;
}
.showtype label{
    cursor: pointer;
}
.zhumai a.tijiaobtn {
    background:#18a8f7;
    display: block;
    float: right;
    height: 32px;
    line-height:32px;
    text-align:center;
    color:#fff;
    text-decoration:none;
    font-size:14px;
    font-weight:bold;
    margin-top:10px;
    width: 116px;
    cursor:pointer;
}
.etity .ansbth {
    color:#fff;
    background:#4fcffd;
    border:none;
    display:block;
    float:right;
    width:55px;
    height:22px;
    line-height:22px;
    margin-left:10px;
    margin-top:5px;
    text-decoration: none;
    text-align:center;
}
.playbtn{
  background: #18a8f7;
  padding: 6px;
  border: 1px solid #eee;
  -moz-border-radius: 4px;
  -webkit-border-radius: 4px;
  border-radius: 4px;
  color: #fff;
}
.qtlol .gekrjty {
	font-size:16px;
	font-family:微软雅黑;
	color:#808080;
	font-weight:bold;
	margin-left:45px;
}
.qtlol a {
	margin-top:3px;
}
.qtlol {
	height: 27px;
	padding-top: 8px;
	margin-left:12px; 
	display:inline;
}
</style>
<script>
$(function() {
    $('.photo_photolist_img a').lightBox();
});
</script>
<?php $this->display('common/public_header'); ?>
<?php $logo = empty($room['cface']) ? 'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg' : $room['cface']; ?>
<div class="toptem">
    <div class="keaie"><img width="100" height="100" src="<?= $logo ?>" alt="<?= $room['crname'] ?>"/></div>
    <div class="rigkic">
        <h2 class="kichtwo"><?= $room['crname'] ?></h2>
        <p class="dianhua"><?= $room['crphone'] ?></p>
        <?php $cremail=substr($room['cremail'],0,7); ?>
        <p class="elanbn"><?php if (!empty($room['cremail'])) { ?><a href="<?= ($cremail=='http://')?$room['cremail']:'http://'.$room['cremail'] ?>" target="_blank" style="color:#2aa0e6;"><?= $room['cremail'] ?></a><?php } ?></p>
        <p class="deteme"><?= $room['craddress'] ?></p>
    </div>
</div>

<div class="adsolma">
    <div class="recdis">
        <div class="reclef">
            <h2 class="gongs" title="<?= $send['message']?>">公告：<?= shortstr($send['message'],86)?></h2>
                        <div class="admamm">
                <?php
				$randindex = rand(0,5);
				$imgsrc = 'http://static.ebanhui.com/ebh/citytpl/stores/images/laistdg'.$randindex.'.jpg';
				if(!empty($adlist))
					$imgsrc = $adlist[0]['thumb'];
 
                ?>
<img width="640" height="132" src=" <?=$imgsrc?>">
            </div>
            <div class="thren">
            <object type="application/x-shockwave-flash" data="http://static.ebanhui.com/ebh/flash/circlefect.swf" width="639"
                height="106" id="blog_index_flash_ff">
                <param name="quality" value="high" />
                <param name="FlashVars" value="url=<?= !empty($url)?$url:""?>" />
                <param name="wmode" value="transparent" />
                <param name="menu" value="false">
                <param name="allowScriptAccess" value="sameDomain" />
                <param name="allowFullScreen" value="true" />
                <param name="movie" value="http://static.ebanhui.com/ebh/flash/circlefect.swf" /><!--兼容ie6-->
            </object>
        </div>
        </div>
        <!--登录后-->
        <?php if(!empty($user)) { 
            $sex = empty($user['sex']) ? 'man' : 'woman';
            $type = $user['groupid'] == 5 ? 't' : 'm';
            $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$type.'_'.$sex.'.jpg';
            $face = empty($user['face']) ? $defaulturl : $user['face'];
            $facethumb = getthumb($face,'78_78');
            $url = $user['groupid'] == 5 ? geturl('troom') : geturl('myroom');
            
        ?>
        <div class="recrig">
            <div class="usouter">
                <div class="figlef">
                    <img src="<?= $facethumb ?>" /></div>
                <div class="showrig">
                    <h2 style="font-weight:bold; font-size:14px; color:#3195c6;"><?= $user['username'] ?></h2>
                    <p>上次登录时间：</p>
                    <p><?= $user['lastlogintime']?></p>
                </div>
            </div>
            <input class="logbtn3" type="submit" onclick="window.location.href='<?= $url ?>'" value="" name="Submit">
            
            <?php $hszcrid = 10420; ?>
                <div class="jky"><p><?php if($user['groupid'] == 6 && $room['crid']!=$hszcrid) { ?><a href="<?= geturl('member') ?>">个人中心</a><em style="margin-left:20px; margin-right:20px;">|</em><?php }else{ ?><em style="margin-left:20px; margin-right:20px;"> </em><?php }?><a href="/logout.html">退出</a></p></div>
                <div class="eiwje">

                </div>
        <?php } else { ?>
                <form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit('/');return false;">
                    <input type="hidden" name="loginsubmit" value="1" />

                    <div class="recrig">
                        <span class="qianle">帐号：</span>
                        <input class="txtuser" id="username" name="username" type="text" value="" />
                        <span class="qianle">密码：</span>
                        <input class="txtpass" id="password" name="password" type="password" value=""/>
                        <p class="zidong">
                            <input type="checkbox" id="cookietime" style="vertical-align: middle;" name="cookietime" value="1"  checked='checked'/>
                            <label for="cookietime">下次自动登录</label>
							<a href="<?=geturl('forget')?>" class="lgaidst">忘记密码？</a>
                        </p>
                        <input class="denglubtn" type="submit" name="Submit" value="" />
                        <div class="eiwje">
                            <div class="qtlol" style="width:270px;float:left;">
                                <span class="gekrjty">用其他账号登录：</span>
                                <a href="<?=geturl('otherlogin/qq')?>">
                                    <img src="http://static.ebanhui.com/ebh/citytpl/stores/images/qqico0925.jpg">
                                </a>
                                <a href="<?=geturl('otherlogin/sina')?>">
                                    <img src="http://static.ebanhui.com/ebh/citytpl/stores/images/sianico0925.jpg">
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
        <?php } ?>
        </div>
    </div>
	<div style="clear:both;"></div>
	</div>
<?php 
    if(empty($user)){
        $this->display('common/footer');
        exit;
    }
    $cname = $user['groupid']==6?'myroom':'troom';
?>
<?php if($inRoom == true){?>
<div class="hudat">
<div class="tithut">
<span class="tittnet">互动答疑</span>
<div class="showtype" id="showtype" >
    <input onclick="dotypesearch(this,1)" <?php if($showtype==1 || $showtype == 3){echo 'checked=checked';}?> id="showtype1" name="showtype" value="1" type="checkbox" /><label for="showtype1">&nbsp;我的问题</label>&nbsp;&nbsp;
    <input onclick="dotypesearch(this,2)" <?php if($showtype==2 || $showtype == 3){echo 'checked=checked';}?> id="showtype2" name="showtype" value="2" type="checkbox" /><label for="showtype2">&nbsp;<?=$user['groupid'] == 5?'本学科':'本年级'?>问题</label>
</div>
<?php
    $checkedFolderName = "全部";
    $checkedFolderId = 0;
    if(!empty($checkedFolder)){
        $checkedFolderName = $checkedFolder['foldername'];
        $checkedFolderId = $checkedFolder['folderid'];
    }

    $qstyle = !empty($q)?'style="color:#000"':'';
    $q = empty($q)?'请输入关键字':$q;
?>
<a href="javascript:void(0)" id="folderid" folderid="<?=$checkedFolderId?>" class="fudiea"><?=$checkedFolderName?></a>
<input class="txtsiz" id="keywords" <?=$qstyle?> type="text" value="<?=$q?>" />
<a href="javascript:dosearch()" class="solees">搜 索</a>

    <?php if($user['groupid']==6){?>
    <a href="javascript:showAskDialog();" class="mtrte">我要提问</a>
    <?php }else{?>
    <a target="_blank" href="<?=geturl('troom/myask/addquestion')?>" class="mtrte">我要提问</a>
    <?php }?>

</div>
<div class="tanty" style="display:none">
<ul>
    <li class="wrote"><a folderid="0" href="javascript:void(0)">全部</a></li>
<?php foreach($folders as $folder){?>
    <li class="wrote"><a folderid="<?=$folder['folderid']?>" href="javascript:void(0)"><?=$folder['foldername']?></a></li>
<?php }?>
</ul>
</div>
<div class="tweytr">
<?php if(!empty($askList)){?>
<ul>
    <?php foreach ($askList as  $ask) {?>
    <li class="reeys">
        <div class="lefyten">
            <div class="jedaw <?=!empty($ask['hasbest'])?'zuidts':'';?>">
                <p class="shutle" id="qid_<?=$ask['qid']?>"><?=$ask['answercount']?></p>
                <p class="tdate">回 答</p>
            </div>
            <div class="rekwt">
                <p class="shutle"><?=$ask['viewnum']?></p>
                <p class="tdate">人 气</p>
            </div>
        </div>
        <div class="rigyten">
            <?php if($user['groupid']==6){?>
                <h2 class="etity"><a target="_blank" title="<?=$ask['title']?>" href="<?=geturl('myroom/myask/'.$ask['qid'])?>"><?=shortstr($ask['title'],110,'')?></a><?php if($user['uid'] != $ask['uid']){?><span><a href="javascript:showAnswerDialog('tandaandiv',<?=$ask['qid']?>);" class="ansbth">回 答</a></span><?php }?></h2>
            <?php }else{?>
                <h2 class="etity"><a target="_blank" title="<?=$ask['title']?>" href="<?=geturl('troom/myask/'.$ask['qid'])?>"><?=shortstr($ask['title'],110,'')?></a><?php if($user['uid'] != $ask['uid']){?><?php if($ask['tid'] == $user['uid']){?><span><a href="javascript:showpushQDialog(<?=$ask['qid']?>);" class="ansbth" style="width:78px;">关联问题</a></span><?php }?><span><a href="javascript:showAnswerDialog('tandaandiv',<?=$ask['qid']?>);" class="ansbth">回 答</a></span><?php }?></h2>
            <?php }?>

            <div class="gfhge">
                <span class="ewtkey"><?=date('Y-m-d H:i:s',$ask['dateline'])?></span>
                <span class="ketek">
                    <a href="javascript:dosearch('<?=$ask['folderid']?>')" style="color:#108ed4;"><?=$ask['foldername']?></a>
                </span>
                <span class="ewtkey">提问人：<?=$ask['uid_name']?></span>
                <?php if(!empty($ask['tid_name'])){?>
                    <span class="ewtkey">指定回答老师：<?=$ask['tid_name']?></span>
                <?php }?>
                <?php if(!empty($ask['lastansweruid_name'])){?>
                    <span class="ewtkey">最后回答：<?=$ask['lastansweruid_name']?></span>
                <?php }?>
            </div>
            <p class="syuft">
                <?=$ask['message']?>
            </p>
            <?php if(!empty($ask['audiosrc'])) { ?>
            <div class="waibo" style="overflow:hidden;" id="waibo_q_<?= $ask['qid'] ?>" status="0">
            <a id="start_q_<?= $ask['qid'] ?>" class="akaishi start" href="javascript:start('<?= $ask['audiosrc'] ?>','q_<?= $ask['qid'] ?>')"></a>
            <a id="pause_q_<?= $ask['qid'] ?>" class="azanting" href="javascript:pause('q_<?= $ask['qid'] ?>')"></a>
            <a id="stop_q_<?= $ask['qid'] ?>" class="atingzhi" href="javascript:stop('q_<?= $ask['qid'] ?>')"></a>
            <p class="pingtiao">
            <span class="bartebg">
            <span id="votebars_q_<?= $ask['qid'] ?>" class="votebars" style="width:0%;"></span>
            </span>
            </p>
            </div>
            <?php } ?>
            <?php if(!empty($ask['imagesrc'])) { ?>
            <div class="dengtu">
                <ul>
                    <li style="width:auto;height:auto;">
                        <div class="bg photo_photolist_inner">
                        <p class="photo_photolist_img" style="width:auto;height:auto;">
                        <a style="display:block;width: 100%;height: 100%;overflow: hidden;" href="<?= $ask['imagesrc'] ?>">
                        <img id="img1" src="<?= getthumb($ask['imagesrc'],'277_195')?>"  style="margin-top: 0px; margin-left: 0px;"/>
                        </a>
                        </p>
                        </div>
                    </li>
                </ul>
            </div>
            <?php }?>
        <?php 
            $key = 'req_'.$ask['reqid'];
            if(array_key_exists($key, $reqsDb)){?>
                <div style="clear:both">&nbsp;</div>
                <p style="color:#108ed4">关联问题：<a style="color:#108ed4" title="<?=$reqsDb[$key]['title']?>" href="javascript:void(0);" onclick="showReQDialog(<?=$reqsDb[$key]['qid']?>)"><?=shortstr($reqsDb[$key]['title'],110,'')?></a></p>
        <?php }?>
        </div>
    </li>
    <?php }?>
</ul>
<?=$pageStr?>
<?php }else{?>
    <div style="text-align:center;">没有找到对应的记录</div>
<?php }?>
</div>
</div>
<?php }?>
<div style="clear:both;"></div>
<script type="text/javascript">
    $(".dialogLogin").click(function(){
    	if ($(this).attr("name") != '') {
    		$.loginDialog($(this).attr("name"));
    	}else{
    		$.loginDialog();
    	}
    });

    function dosearch(folderid){
        if(!folderid){
            var folderid = $("#folderid").attr('folderid');
            var q = $("#keywords").val();
            if(q=='请输入关键字'){
                q = "";
            }
        }else{
            folderid = folderid;
            q = "";
        }
        if(q){
            var url = '/index-0-0-1-'+folderid+'-0-1.html?q='+q;
        }else{
            var url = '/index-0-0-1-'+folderid+'-0-1.html';
        }
        
        location.href = encodeURI(url);
    }

    $(function(){
        $("a.fudiea").click(function(){
            $("div.tanty").toggle();
        });
        $("li.wrote").click(function(){
            $("#folderid").html($(this).find("a:first").html());
            $("#folderid").attr('folderid',$(this).find("a:first").attr('folderid'));
            $("div.tanty").toggle();
            dosearch();
        });

        initsearch("keywords","请输入关键字");
    });

    var askDialog = null;
    function showAskDialog(){
        H.create(new P({
            title:'我要提问',
            id:'askDialog',
            content:document.getElementById('addquestion'),
            easy:true,
            padding:1
        }),'common').exec('show');
    }
    function closeDialog(){
        H.get('askDialog').exec('close');
        $.showmessage({
            img : 'success',
            message:'问题提交成功',
            title:'提交问题',
            callback :function(){
               location.reload();
            }
        });
    }
    function dotypesearch(e,gtype){
        var type = 0;
        if($("#showtype input:checked").length>0){
            var type = 0;
            if($(e).prop('checked')){
                type = gtype;
            }else{
                type = 3-gtype;
            }
        }
        var url = '/index-0-0-1-0-'+type+'-1.html';
        location.href = url;
    }

    function showAnswerDialog(dom,qid){
        window.dom = dom;
        window.qid = qid;
        $("#cwid").val(0);
        $("#cwsource").val("");
        $(".ejieda").attr('href','javascript:playask('+qid+')');

        H.create(new P({
            id:dom,
            title:"解答编辑器",
            width:820,
            height:620,
            content:$("#"+dom),
            easy:true
        },{
            onclose:function(){
                location.reload();
                return false;
            },
            onshow:function(){
                ue.focus();
                return false;
            }
        }),'common').exec('show');
    }

    function submitanswer(dom) {
        var tips = "提交解答";
        var message = UM.getEditor('message').getContent();
        var audio = document.getElementById('audio').value;
        var cwid = document.getElementById('cwid').value;
        var cwsource = document.getElementById('cwsource').value;
        if($.trim(HTMLDeCode(message)) == "") {
            alert("请输入回答内容");
            return false;
        }
        <?php
            $type = 'myroom';
            if(!empty($user)){
                $type = $user['groupid'] == 6? 'myroom':'troom';
            }
        ?>
        var url = "<?= geturl($type .'/myask/addanswer') ?>";
        $.ajax({
            url:url,
            type:'post',
            data:{'qid':qid,'message':message,'audio':audio,'cwid':cwid,'cwsource':cwsource},
            dataType:'text',
            success:function(data){
            if(data=='success'){
                    $.showmessage({
                    img      :'success',
                    message  :tips+'成功',
                    title    :tips,
                    callback :    function(){
                        H.get(dom).exec('close');
                    }
                    });
                }else{
                    $.showmessage({
                    img      :'error',
                    message  :tips+'失败',
                    title    :tips
                    });
                }
                
            }
        });
    }

    function sendMessage(){
        submitanswer("tandaandiv");
    }

</script>

<!-- =====回答弹框开始==== -->
<div style="display:none;">
    <div id="tandaandiv" class="tandaan" style="float:left;display:none;width:676px;padding:20px;height:900px;">
    <div class="zhumai">
    <?php
        EBH::app()->lib('UMEditor')->xEditor('message','775px','310px');
    ?>
<!--上传音频-->
    <div style="background:#fff;float:left;min-height: 53px;width:776px;height:auto;">
        <div style="float:left;margin-left:15px;width:70px;margin-top:16px; ">上传音频：</div>
        <div style="float:left;margin-left:0px;width:455px;margin-top:10px; " id="audio_float">
            <a href="javascript:void(0)" id="startrecord" style="width:63px;height:27px;line-height:27px;background:#E3F2FF;border:solid 1px #A2D1F1;display:block;text-align:center;text-decoration: none;font-size:14px;" >录制</a>
        </div>
 <div style="float:left;width:560px;height:200px;display:none" id="showrecorder">
            <object width="500" height="200" class="recoderSwf" data="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" type="application/x-shockwave-flash" >
            <param value="transparent" name="wmode">
            <param value="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" name="movie">
            <param value="high" name="quality">
            <param value="false" name="menu">
            <param value="always" name="allowScriptAccess">
            </object>
          </div>  
        <div style="float:left;width:455px;height:50px;_margin-top:20px;display:none" id="audio_show">
            <div class="upprogressbox" id="image_upprogressbox" style="display: block;width:475px;background-color:#fff;">
                <div class="upfileinfo" style="width:475px;">
                <span class="upstatusinfo">
                <img src="http://static.ebanhui.com/ebh/images/upload.gif"></span>
                <span class="spanUpfilename" id="audio_name"></span>
                <span id="image_spanUppercent">100%</span>
                <span><a onclick="deleteaudio()" href="javascript:void(0);">&nbsp;删除</a></span>
                </div>
                <div class="upprogressbar" style="width:475px;"><span class="upprogressstext">上传总进度：</span>
                <span class="spanUppercentBox" id="image_spanUppercentBox">
                <span class="spanUpShowPercent" id="image_spanUpShowPercent" style="width: 100%;"></span></span>
                <span class="spanUppercentinfo" id="image_spanUppercentinfo">100%</span></div>
            </div>
        </div>
        <?php if($user['groupid']==5){?>
        <div style="clear:both" id="showcourseware">&nbsp;</div>
        <div style="float:left;margin-left:15px;width:70px;margin-top:16px; ">上传附件：</div>
        <div id="courseware" style="float:left;margin-left:0px;width:455px;margin-top:10px; ">
            <!-- <a href="javascript:void(0)" id="uploadcw" onclick="course.uploadCourseware(1);">上传解析附件</a> -->
            <button id="uploadcw" class="playbtn" onclick="course.uploadCourseware(1);">上传附件</button>
            <span id="showcw"></span>
        </div>
        <?php }?>
    <a class="tijiaobtn" onclick="sendMessage()" style="margin-right:20px;">提  交</a>
    <div style="margin-bottom:20px;clear:both;">&nbsp;</div>
        
        <input type="hidden" value="" name="audio" id="audio" />
        <input type="hidden" value="" name="cwid" id="cwid" />
        <input type="hidden" value="" name="cwsource" id="cwsource" />
        

    </div> 
<!--结束-->
    </div>
   </div>
</div>
<!-- =====回答弹框结束==== -->
<script>
    //接受flash返回的audiosrc
function getURL(url){
    //alert(url);
    var audioname = url.substring(url.lastIndexOf('/')+1);
    $("#audio").attr("value",url);
    $("#showrecorder").hide();
    $("#audio_float").hide();
    
    $("#audio_name").html(audioname);
    $("#audio_show").show();
}
//删除录制上传的音频
function deleteaudio(){
    $("#audio_show").hide();
    $("#audio_float").show();
    $("#audio").attr("value",'');
}
$("#startrecord").click(function(){

      $('#showrecorder').toggle();
      $(".recoderSwf").remove();
      $("#showrecorder").html('<object width="500" height="200" class="recoderSwf" data="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" type="application/x-shockwave-flash" ><param value="transparent" name="wmode"><param value="http://static.ebanhui.com/ebh/flash/recoderSwf.swf" name="movie" id="recoder_url"><param value="high" name="quality"><param value="false" name="menu"><param value="always" name="allowScriptAccess"></object>');
});

function settips(id,tips) {
    if($.trim($("#"+id).val()) == "") {
        $("#"+id).val(tips);
        $("#"+id).addClass("titwentigray");
    }
    $("#"+id).click(function(){
        if($.trim($(this).val()) == tips) {
            $(this).val("");
            $(this).removeClass("titwentigray");
        }
    });
    $("#"+id).blur(function(){
        if($.trim($(this).val()) == "") {
            $(this).val(tips);
            $(this).addClass("titwentigray");
        }
    });
}
var showCourseware = function(source,cwid,qid,cwurl){
    H.get('upCoursewareDialog').exec('close');
    $('#showcw').html('<a id="playbutton" class="playbtn" onclick="course.userplay(\''+source+'\',\''+cwid+'\');return false;" href="javascript:void(0);">查看附件</a>&nbsp;<a id="delbutton" class="delbutton" title="删除解析附件" onclick="course.delCourseware(\''+qid+'\')" href="javascript:;">x</a>');
    $('#uploadcw').hide();
    $('#cwid').val(cwid);
    $('#cwsource').val(source);
}
var delCourseware = function(){
    H.get('upCoursewareDialog').exec('close');
    $("#uploadcw").show();
    $('#showcw').empty();
    $('#cwid').val(0);
    $('#cwsource').val("");
}
var course = new Course(showCourseware,delCourseware);
$(function(){
    // $('#uploadcw').button();
});

function doquestionpush(reqid){
   var tips = "关联问题";
   $.ajax({
        url:'/push/doQuestionPush.html',
        type:'post',
        data:{'qid':qid,'reqid':reqid},
        dataType:'text',
        success:function(data){
        if(data=='success'){
                $.showmessage({
                img      :'success',
                message  :tips+'成功',
                title    :tips,
                callback :    function(){
                   closePushQDialog();
                   location.reload();
                }
                });
            }else{
                $.showmessage({
                img      :'error',
                message  :tips+'失败',
                title    :tips
                });
            }
            
        }
    });
}
function showpushQDialog(qid){
    window.qid = qid;
    H.create(new P({
        id:'requestion',
        title:"关联问题",
        content:$("#requestion")[0],
        easy:true,
        padding:5
    }),'common').exec('show');
}
function closePushQDialog(){
    window.qid = 0;
    H.get('requestion').exec('close');
}
function showReQDialog(reqid){
    window.reqid = reqid;
    $("#reQ").attr('src','/push/'+reqid+'.html');
    H.create(new P({
        title:"查看关联问题",
        width:835,
        id:'reQdialog',
        content:$("#reQdialog")[0]
    }),'common').exec('show');
}
//播放课件或者下载附件
function showplayDialog(source,cwid){
    if(typeof courseObj == "undefined"){
        courseObj = new Course();
    }
    if(!source || !cwid){
        return false;
    }
    courseObj.userplay(source,cwid);return false;
}
</script>
<iframe style="display:none" src="/myroom/myask/addquestion_fordialog.html" id="addquestion" frameborder="0" width="790" height="800"></iframe>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/swfobject.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/wavplayer.js"></script>
<div style="display:none;width:880px;height:600px;overflow:hidden;" id="requestion">
    <iframe  src="/push/question.html"  frameborder="0" width="860" height="600"></iframe>
</div>
<div style="display:none;width:820px;overflow-x:hidden;" id="reQdialog">
    <iframe id="reQ"  src=""  frameborder="0" width="820" height="600"></iframe>
</div>
<div id="playercontainer">&nbsp;</div>
<?php $this->display('common/footer'); ?>