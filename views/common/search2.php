<?php $this->display('common/header');?>
<?php ($q = $this->input->get('q')) or ($q = "");?>
<style>
    a:hover{
        text-decoration: none;
    }
    .xgwx_t .title,.xgkj_t .title{
        width: auto;
		min-width:308px;
    }
    .xgkj_b_son .images{
        width: 178px;
        height: 103px;
    }
   /* .images,.imgs{
        overflow: hidden;
    }
    .images img:hover,.imgs img:hover{
      -webkit-transform: scale(1.2);
      -moz-transform: scale(1.2);
      -ms-transform: scale(1.2);
      -o-transform: scale(1.2);
      transform: scale(1.2);
    }
    .images img,.imgs img{
      -moz-transition: all 1s ease 0s;
      -o-transition: all 1s ease 0s;
      -webkit-transition: all 1s ease 0s;
      transition: all 1s ease 0s;
    }*/
	.xgwx{
		float:left;
		display:inline;
		height:auto;
	}
	#tips{
		text-align:center;
		font-size:14px;
		line-height:32px;
	}
</style>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<script>
    function errorHandler(){
        var cwid = $(this).attr('cwid');
        var size = '167_100';
        var me = this;
        $.ajax({
            type: "POST",
            url: "<?=geturl('imghandler')?>",
            data: {cwid:cwid,size:size,type:'courseware_logo'},
            dataType: "json",
            success: function(data){
                if(data && (data.status == 0) ){
                    $(me).attr('src',data.url+'?v=1');//v=1 你猜这是干什么的 O(∩_∩)O哈哈~
                }
                $(me).removeAttr('onerror');//解绑onerror事件 防止死循环
                $(me).unbind('error');
            },
            error:function(){
                $(me).removeAttr('onerror');//解绑onerror事件 防止死循环
                $(me).unbind('error');
            }
        });
    }
</script>
<div class="center">
	<!--相关网校-->
    <?php if(!empty($showroom) || !empty($showall)){?>
	<div style="width:980px; margin:0 auto;">
    	<div class="xgwx ">
        	<div class="xgwx_t">
            	<div class="title fl">"<?=$q?>"相关的网校</div>
                <?php if(!empty($hasmore_room) && !empty($showall)){?>
                    <div class="more fr"><a href="/searchs-1-0-0-2.html?q=<?=urlencode($q)?>">更多&nbsp;》</a></div>
                <?php }?>
            </div>
            <div class="clear"></div>
            <div class="xgwx_b ">
                <?php if(empty($roomlist)){?>
                    <div id="tips">没有找到符合条件的网校</div>
                <?php }else{?>
                	<?php foreach ($roomlist as $rk => $room) {?>
                    <?php 
                        $roomurl = 'http://'.$room['domain'].'.ebh.net';
                        $room['cface'] = empty($room['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/xgkctb.png':$room['cface'];
                    ?>
                        <div class="xgwx_t_son mt15 fl <?=($rk%3!=0)?'ml5':''?>">
                        	<div class="imgs fl"><a target="_blank" title="<?=$room['crname']?>" href="<?=$roomurl?>"><img width="100px" height="100px" src="<?=$room['cface']?>"/></a></div>
                            <div class="jieshao fl">
                            	<div class="biaoti"><a target="_blank" title="<?=$room['crname']?>" href="<?=$roomurl?>"><span style="color:#333;"><?=str_replace($q,'<span style="color:#f00;">'.$q.'</span>',shortstr($room['crname'],20,''))?></span></a></div>
                                <div><p class="p1s"><?=shortstr($room['summary'],40)?><a target="_blank" title="<?=$room['summary']?>" href="<?=$roomurl?>">[详情]</a></p></div>
                                <div class="mores"><a target="_blank" title="<?=$room['crname']?>" href="<?=$roomurl?>">查看更多&nbsp;》</a></div>
                            </div>
                        </div>
                   <?php }?>
                <?php }?>
        	</div>
			<div class="clear"></div>
        <?=!empty($showroom)?$pagestr_room:''?>
        </div>
	</div>
    <?php }?>
    <div class="clear"></div>
    <!--相关课件-->
    <?php if(!empty($showcourse) || !empty($showall)){?>
        <div class="xgkj">
        	<div class="xgkj_t">
            	<div class="title fl">"<?=$q?>"相关的课件</div>
                  <?php if(!empty($hasmore_course) && !empty($showall)){?>
                    <div class="more fr"><a href="/searchs-1-0-0-1.html?q=<?=urlencode($q)?>">更多&nbsp;》</a></div>
                <?php }?>
            </div>
            <div class="clear"></div>
            <div class="xgkj_b ">
                <?php if(empty($courselist)){?>
                     <div id="tips">没有找到符合条件的课件</div>
                <?php }else{?>
                    <?php foreach ($courselist as $ck => $course) {?>
                    <?php
                        $defaultlogo = 'http://static.ebanhui.com/ebh/tpl/default/images/178_kete.jpg';
                        $logo = empty($course['logo']) ? $defaultlogo : $course['logo'];
                    ?>
                        <?=($ck%4==0)?($ck==0?'<div class="xgkj_b_son">':'<div class="xgkj_b_son mt20">'):''?>
                            <div class="fl xgkjs <?=$ck%4==0?'first':''?>">
                                <div class="images"><a title="<?=$course['title']?>" href="<?= geturl('course/'.$course['cwid'])?>" target="_blank"><img alt="<?=$course['title']?>" cwid="<?=$course['cwid']?>" onerror="errorHandler.call(this)" src="<?=$logo?>" /></a></div>
                                <div class="p2s"><a title="<?=$course['title']?>" href="<?= geturl('course/'.$course['cwid'])?>"><?=str_replace($q,'<span style="color:#f00;">'.$q.'</span>',shortstr($course['title'],24,''))?></a></div>
                                <div class="p3s"><?=$course['realname']?>&nbsp;&nbsp;<?=date('Y-m-d',$course['dateline'])?> </div>
                            </div>	
                        <?=($ck%4 ==3)?'</div>':''?>
                    <?php }?>
                <?php }?>
            </div>
            <?=!empty($showcourse)?$pagestr_course:''?>
        </div>
    <?php }?>
</div>
<?php $this->display('common/footer');?>
