<?php $this->display('college/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<script type="text/javascript" src="http://static.ebanhui.com/js/soundManager2/js/voicePlayer.js"></script>
<link type="text/css" href="http://static.ebanhui.com/js/soundManager2/css/voicePlayer.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/collegestyle.css<?=getv()?>"/>

<style type="text/css">
    .voice-player{
        margin-top:0px ;
        margin-left:0px;
    }
    body{
        font: normal;
    }
</style>
<script type="text/javascript">
    var searchtext = "请输入关键字";
    $(document).ready(function(){
        $("#title").css('color','#999');
    })
    <?php
    if(!empty($q)){

    ?>
    var text = '<?=$q?>';

    $(document).ready(function(){
        $("#title").val(text);
    })
    <?php
    }else{
    ?>
    $(document).ready(function(){
        $("#title").val(searchtext);
    })
    $(document).ready(function(){
        $("#title").click(function(){
            var title = $("#title").val();
            if(title == searchtext){
                $("#title").val('');
            }
            $("#title").css('color','#333');

        })
        $("#title").blur(function(){
            var title = $("#title").val();
            if(title==''){
                $("#title").val(searchtext);
            }
        })

    })
    <?php
    }
    ?>
    $(document).ready(function(){
        $(".soulicos-1").click(function(){
            var title = $("#title").val();
            if(title == searchtext)
                title = "";
            var url = '<?= geturl("college/myarticle/{$method}") ?>'+ '?q='+title;
            document.location.href = url;
        });
        $('#content .li').last().css('border-bottom','0px');
    })

</script>
<?php
    $roominfo = Ebh::app()->room->getcurroom();
    $roominfo['crid'] = empty($roominfo['crid'])?0:$roominfo['crid'];
    if(!empty($roominfo['crid'])){
        $other_config = Ebh::app()->getConfig()->load('othersetting');
        $other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
        $other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
        $is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'],$other_config['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'],$other_config['newzjdlr']);
    }
?>
<div class="lefrig">
    <div class="lefrig-1" style="display: inline-block;width:100%; min-height:500px;">
        <!--问题导航-->
		<div class="navigations-1">
            <ul style="margin-left:0;width:1000px;">
                <li><a href="/college/review/showReview.html">学员评论</a></li>
                <li><a href="/college/myask/all.html">答疑专区</a></li>
				<li><a href="/college/myarticle.html" class="curr">原创文章</a></li>
				<div class="dile2s-1">
					<input name="txtname" class="newsous-1" id="title" placeholder="" type="text">
					<input class="soulicos-1" value="" type="button">
				</div>
				<a href="<?= geturl('college/myarticle/uploadArticle') ?>" class="iwantask" id="nonum">发表文章</a>
				<span class="iwantask" id="yesnum" style="display:none;line-height:28px;color:#fff;text-align:center;background: #999;width:84px;height:28px;float: right;margin-top: 5px;border-radius: 5px;">我要提问<span id="numback">999</span>s</span>
            </ul>
		</div>
        <div class="clear"></div>
        <!--问题列表-->
        <div class="problemslist ">
            <?php if($is_zjdlr){?>
            <div class="problemslist" >
                <div class="problemslistnav">
                    <a href="<?= geturl('college/myarticle/index') ?>" <?php if($method == 'index'){echo "class='curr'";}?>>全部文章</a>
                    <a href="<?= geturl('college/myarticle/my') ?>" <?php if($method == 'my'){echo "class='curr'";}?>>我的文章</a>
                    <a href="<?= geturl('college/myarticle/reviews') ?>" <?php if($method == 'reviews'){echo "class='curr'";}?>>我的评论</a>
                </div>
                <div class="clear"></div>
            </div>
            <?php }?>
            <?php
            if(empty($asks) && !$is_zjdlr){
                echo " <div class=\"nodata\"></div>";
            }else{
                ?>
                <ul id="content">
					<!--文章列表!-->
                    <?php if(!empty($list)) {
                        foreach ($list as $value) {
                    ?> 
					<li class="wenlist">
						<img class="wentu" src="http://static.ebanhui.com/ebh/tpl/newschoolindex/images/tongsre.png" />
                        <div class="flstrey">
								<h2 class="problemstitle">
									<span class="" title=""></span>
									<a href="/college/myarticle/articleDetail/<?=$value['itemid']?>.html" target="_blank"><?=$value['subject']?></a>
								</h2>
                                <div style="*clear:both;"></div>
								<div class="problemdetail">
									<a href="/college/myarticle/articleDetail/<?=$value['itemid']?>.html" target="_blank"><?=$value['comment']?></a>
								</div>
                            
								 <div class="questinformation-1">
									 <span class="questiontime-1"><?=timetostr($value['rdateline'])?></span>
									<img class="questionerhead" src="<?=getavater($value)?>" title="<?=$value['username']?>">
									<span class="questioner" title="<?=$value['realname']?>"><?=$value['realname']?></span>
									<p class="coursewarelink"><?=$value['class']?></p>
								</div>
							</div>
                            <div class="answernumber">
                                <span class="answernumberspan">评论数</span>
                                <span><b class="b1"><?=empty($value['review'])?0:$value['review']?></b><b class="b2">/</b><b class="b3"><?=empty($value['viewnum'])?0:$value['viewnum']?></b></span>
                                
                            </div>
                    </li>
                    <?php }}?>
                </ul>
                 <?php echo $pagestr; ?>
            <?php }?>
        </div>
    </div>
</div>
<script type="text/javascript">
	
	function delCookie(name){	//删除cookie
	    var exp = new Date();
	    exp.setTime(exp.getTime() - 1);
	    var cval=getCookie(name);
	    if(cval!=null)
	        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
	}
	function getCookie(name){	//读取cookie
	    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	    if(arr=document.cookie.match(reg))
	        return (arr[2]);
	    else
	        return null;
	}
	
    //过滤空数组
    function array_filter(param){
        var newArr = new Array();
        for (var i in param) {
            if(param[i] !=''){
                newArr.push(param[i]);
            }
        }
        return newArr;
    }

    //获取url
    function geturl(name) {
        if (name.indexOf( 'http://') !== false || name.indexOf('.html') !== false) {
            var url = name;
        } else{
            var url = '/' +name + '.html';
        }
        return url;
    }

</script>

</body>
</html>
