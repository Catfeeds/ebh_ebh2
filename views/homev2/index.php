<?php $this->display('homev2/header');?>
<?php $this->display('homev2/top');?>
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
<!--暂时隐藏精品课程-->
<?php if(false && $user['groupid'] == 6 && !$is_zjdlr){?>
<div class="divcontent">
    <div class="topbaer">
        <div class="aagess">
            <div class="cuorer" style="width:220px; height:108px;">
                <a href="<?php if(!empty($count)){echo '/ke/myclass.html';}else{echo '/ke.html';};?>" title="精品课程" class="tophref">
                    <img width="220" height="108" src="http://static.ebanhui.com/ebh/tpl/2016/images/jinpinkctp.jpg" style="margin-top:2px; margin-left:2px;">
                </a>
            </div>
            <h2 class="couit">
                <a href="<?php if(!empty($count)){echo '/ke/myclass.html';}else{echo '/ke.html';};?>" class="tophref" style="font-size:22px; color:#666; float:left">我的精品课</a>
                <div class="jingpingke"><?php if(!empty($count)){echo $count;}?></div>
            </h2>
            <p class="yunjsh" style="font-family:微软雅黑;color:#999;font-size:13px;width:540px;">精品课堂中的所有课程来自于e板会网络学校中各个知名网校提取的最新优质课程，是具有一流教师队伍、教学内容、教学方法、精美制作等特点的实战性课程。课程种类丰富，价廉物美，选课操作简单，一键报名立即学习。</p>
            <div class="retrys" style="width:190px;">
            <?php if(!empty($count)){?>
                <a class="etewat" href="/ke/myclass.html" style=" margin-left:35px;">进入学习</a>
            <?php }else{?>
                <a class="etewat" href="/ke.html" style=" margin-left:35px;">进入学习</a>
            <?php }?>
            </div>
        </div>
    </div>
</div>
<?php }?>
<div class="divcontent">
    <div class="topbaer">
        <?php if(!empty($roomlist)){
            echo '<ul>';
            foreach ($roomlist as $room){
                $roomurl = $room['roomurl'];
                ?>
            <li class="aagess">
                <div class="cuorer">
                    <a class="tophref" title="<?=$room['crname']?>"  href="<?= $roomurl?>">
                    <?php $logo=empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$room['cface'];?>
                    <img width="100" height="100" style="margin-top:2px; margin-left:2px;" src="<?=$logo?>" />
                    </a>
                </div>
                <h2 class="couit">
                    <a class="tophref" title="<?=$room['crname']?>"    href="<?= $roomurl?>"><?=$room['crname']?></a>
                </h2>
                <p class="yunjsh" ><?php echo shortstr($room['summary'],250,'...')?>
                	<?php if(!empty($room['enddate'])){?>
		                <a href="javascript:;" class="edfast" style="right: 50px;">有效期：<?=date("Y-m-d",$room['enddate'])?></a>
                 	<?php }else{?>
                   	 	<a href="javascript:;" class="edfast" style="right: 50px;">长期有效</a>
                    <?php }?>
                    <a href="javascript:;" onfocus="this.blur()" class="edfast edfast_share" crid="<?= $room['crid']?>" domian="<?=$room['domain']?>" crname="<?=$room['crname']?>" sharekey = "<?=$room['sharekey']?>">分享</a>
                </p>
                <div class="retrys">
                <?php if($room['uid']==$user['uid']){?>
                    <a href="http://<?= empty($room['fulldomain']) ? $room['domain'].'.ebh.net' : $room['fulldomain']?>/aroomv3.html" class="etewat" style="margin-top:-15px;">进入管理平台</a>
					<div class="clear"></div>
					<a href="http://<?= empty($room['fulldomain']) ? $room['domain'].'.ebh.net' : $room['fulldomain']?>/troomv2.html" class="jrglypt">我是教师>></a>
                    <!--<a href="javascript:;" class="jrglypt" onclick="tostudent(<?= empty($room['fulldomain']) ? '\''.$room['domain'].'.ebh.net'.'\'' : '\''.$room['fulldomain'].'\'' ?>,<?php echo $room['crid'];?>)">我是学生>></a>-->
					<?php }else{?>
                     <a href="<?= $roomurl?>" class="etewat">进入网校</a>   
                        <?php } ?>
                </div>
            </li>    
                   
        <?php }
        echo '</ul>';
        }else{?>
        <div style="width:1000px;float:left;  padding-bottom:0;" class="lefrig">
            <div style="background:#fff;width:1000px;height:600px;text-align: center;" class="nojoin">
            <img src="http://static.ebanhui.com/ebh/tpl/2016/images/noneschool.png" style="padding-top:200px;">
        </div>
        </div>
        <?php }?>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/share/css/share.min.css">
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.share.js"></script>
<script type='text/javascript' src='http://static.ebanhui.com/ebh/js/share/raphael-2.1.0-min.js'></script>
<script type='text/javascript' src='http://static.ebanhui.com/ebh/js/share/qrcodesvg.js'></script>

<div id="share_onlineschool" style="display: none;">
			
	<div class="marginbott24" style="height: 185px;">
		<p class="sharetitle">网校链接</p>
		<div>
			<div class="seeqrbox">
				<div>
					<img class="showqr" src=""/>
				</div>
			</div>
			<div style="float: left;height: 150px;">
				<p class="qrbox">
					<a href="javascript:void(0)" class="qrload">256*256</a>
					<span class="qrtips">适合插入文档</span>
				</p>
				<p class="qrbox">
					<a href="javascript:void(0)" class="qrload">512*512</a>
					<span class="qrtips">适合插入PPT</span>
				</p>
				<p class="qrbox">
					<a href="javascript:void(0)" class="qrload">1024*1024</a>
					<span class="qrtips">适合印刷出版物</span>
				</p>
				<p class="qrbox" style="margin-bottom: 0px;">
					<a href="javascript:void(0)" class="qrloadsvg">矢量图</a>
					<span class="qrtips">适合多样使用场景</span>
					<span style="display: none;" id="svg-wrap" class="svg-wrap"></span>
				</p>
			</div>
		</div>
	</div>
	<p>注：点击尺寸进行下载</p>
	
	<div style="height: 100px;margin-top: 40px;">
		<p class="sharetitle_send">发送到</p>
		<div style="height: 72px;float: left;" class="sharecoursebox">
			<!--<div class="sharecourse"></div>--><!--动态生成-->
		</div>
	</div>
	
</div>




<script type="text/javascript">
$(function(){
		$('li:last').css('border-bottom','none');
});
function tostudent(domain,crid){
    var url = '/homev2/default/getClassidByCrid.html';
    $.ajax({
        url:url,
        type:'post',
        data:{crid:crid},
        dataType:'json',
        success:function(data){
           if(data.status){
                var studenturl = 'http://'+domain+'/aroomv2/student/list_view.html?classid='+data.classid+'&rurl=aroomv2/student';
                location.href = studenturl;
           }
        }
    });
}


$(".edfast_share").on("click",function(){
	var crid = $(this).attr("crid");
	var domian = $(this).attr("domian");
	var crname = $(this).attr("crname");
	var sharekey = $(this).attr("sharekey");
	
	sharefun(crid,domian,crname,sharekey);
});

var $share_onlineschool = $("#share_onlineschool")[0];

function sharefun(crid,domian,crname,sharekey){
	dialog({
		title: '分享网校',
		content: $share_onlineschool,
		onshow:function(){
			//生产链接url
			var baseurl = '<?=$baseurl?>';
			var wapurl = 'http://wap.ebh.net/shop/school/courselist.html?domain='+domian+'&sharekey='+sharekey+'&1=1';
			var content = escape(encodeURIComponent(wapurl));
			//console.log(content)
			//console.log('http://wap.ebh.net/shop/school/courselist.html?domain='+domian)

			console.log(wapurl)
			
			var showsrc = baseurl+'?content='+content+'&show=1&size=6';
			$('.showqr').attr('src',showsrc);
			var download256 = baseurl+ '?content='+content+'&down=1'+ '&size=8';
			var download512 = baseurl+ '?content='+content+'&down=1'+ '&size=16';
			var download1024 = baseurl+ '?content='+content+'&down=1'+ '&size=32';
			$($('.qrload')[0]).attr('href',download256);
			$($('.qrload')[1]).attr('href',download512);
			$($('.qrload')[2]).attr('href',download1024);
			
			//分享操作
			var sharecourse = "<div class='sharecourse'></div>";
			$('.sharecoursebox').append(sharecourse);
			$('.sharecourse').share({
				url: wapurl,
				source: crname,
				title: crname,
				description: crname,
				summary: crname,
				image: showsrc,
				sites: ['wechat','weibo']
			});
		
	      	//生成矢量图
	      	$('.qrloadsvg').click(function(){
	      		var qrcodesvg = new Qrcodesvg(content, "svg-wrap", 250);
				qrcodesvg.draw();
				qrcodesvg.createSquare();
				
				var svgXml = $('.svg-wrap').html();
				var image = new Image();
				image.src = 'data:image/svg+xml;base64,' + window.btoa(unescape(encodeURIComponent(svgXml))); //给图片对象写入base64编码的svg流
				var a = document.createElement('a');
				a.href = image.src; //直接导出SVG
				a.download = mathRand(); //设定下载名称
				a.click(); //点击触发下载 
				// 随机生成数字
				function mathRand() {
					var num = "";
					for(var i = 0; i < 6; i++) {
						num += Math.floor(Math.random() * 10);
					}
					return num;
				}
	      	});
		},
		onclose:function(){
			$('.sharecourse').empty();
			$('.sharecourse').remove();
		}
	}).showModal();
}

</script>
<?php $this->display('homev2/footer');?>
	

<style type="text/css">
	.marginbott24{
		margin-bottom: 24px;
	}
	
	.sharetitle{
		text-align: left;
		font-size: 18px;
		margin-bottom: 16px;
	}
	.sharetitle_send{
		font-size: 20px;
		color: #333333;
		font-weight: bold;
		float: left;
		height: 72px;
		line-height: 72px;
		width: 180px;
		text-align: center;
	}
	.seeqrbox{
		width: 220px;
		height: 142px;
		float: left;
	}
	.seeqrbox div{
		width: 142px;
		height: 140px;
		border: 1px solid #666666;
		border-radius: 5px;
		padding: 1px
	}
	.showqr{
		width: 140px;
		height: 140px;
	}
	.qrcode img{
		width: 100px;
		height: 100px;
	}
	.qrbox{
		height: 20px;
		margin-bottom: 22px;
	}
	.qrload{
		margin-right: 15px;
		float: left;
		width: 80px;
		text-align: left;
		line-height: 20px;
	}
	.qrloadsvg{
		margin-right: 15px;
		float: left;
		width: 80px;
		text-align: left;
		line-height: 20px;
	}
	.qrtips{
		float: left;
		width: 125px;
		text-align: left;
		line-height: 20px;
	}
	
	.sharecourse .icon-wechat,.sharecourse .icon-weibo,.sharecourse .icon-qq,.sharecourse .icon-qzone{
		float: left;
		width: 72px;
		height: 72px;
		margin-right: 53px;
	}
	.sharecourse .icon-wechat{
		background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/wechaticon72.png);
	}
	.sharecourse .icon-wechat .wechat-qrcode{
		left: -65px;
	}
	.sharecourse .icon-wechat .help{
		border: 0 none;
		width: 100%;
		text-align: center;
	}
	.sharecourse .icon-weibo{
		background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/sinaicon72.png);
	}
	.sharecourse .icon-qq{
		background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/qqicon72.png);
	}
	.sharecourse .icon-qzone{
		margin-right: 0;
		background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/qzoneicon72.png);
	}
</style>