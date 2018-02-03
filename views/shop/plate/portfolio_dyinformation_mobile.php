<?php $this->display('shop/plate/headernew');?>
<style type="text/css">
.denser{margin:0 !important;}
.see {
    background: #fff;
    display: inline-block;
    padding: 10px;
	width:100%;
}
.see .titled {
    font-size: 26px;
    color: rgb(51, 51, 51);
    text-align: center;
    font-family: 微软雅黑;
	word-wrap: break-word;
	line-height: 30px;
}
.timeb {
    line-height: 30px;
    display: inline-block;
    color: #999;
}
.timeb span {
    margin-left: 10px;
}
.mui-input-row img {
	margin: 0 auto;
    display: block;
}
.mui-input-row {
    word-wrap: break-word;
}
    </style>
<div style="width:100%; margin:0 auto;">
        <div class="see" style="min-height:550px;">

            <div class="titled"><?=$inner_data['subject']?></div>
<div style="text-align:center;width:100%;margin:10px 0;">
    <div class="timeb">
        <span>时间：<?=Date('Y-m-d H:i',$inner_data['dateline'])?></span>
        <span>人气：<?=$inner_data['viewnum']+1?></span>
    </div>
</div>

<div class="mui-input-row">
<?php if(empty($inner_data['isinternal']) || !empty($inner_data['isroomuser'])){?>
<p class="p1s"><?=stripslashes($inner_data['message'])?></p>
<?php } else {//非内部用户不可见?>
    <div style="text-align: center;"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/qsinformation.png"></div>
<?php }?></p>
    <div>

        <?php if(!empty($inner_data['attachlist']) && (empty($inner_data['isinternal']) || !empty($inner_data['isroomuser']))){//非内部用户不可见
            foreach($inner_data['attachlist'] as $attach){?>
                <div style="display:block;"><a style="color:#338bff" href="<?=$attach['source']?>attach.html?attid=<?=$attach['attid']?>&itemid=<?=$inner_data['itemid']?>&type=dyinformation"><?=$attach['filename']?></a></div>

            <?php }
        }?>
    </div>
</div>
</div>
</div>
<script src="http://static.ebanhui.com/design/js/getroominfo.js"></script>
<script src="http://static.ebanhui.com/design/js/player.js"></script>
<script type="text/javascript">
var _w = parseInt($(window).width());//获取浏览器的宽度
$(".mui-input-row img").each(function(i){
    var img = $(this);
    var realWidth;//真实的宽度
    var realHeight;//真实的高度
        //这里做下说明，$("<img/>")这里是创建一个临时的img标签，类似js创建一个new Image()对象！
        $("<img/>").attr("src", $(img).attr("src")).load(function() {
        realWidth = this.width;
        realHeight = this.height;
        //如果真实的宽度大于浏览器的宽度就按照100%显示
        if(realWidth>=_w){
            $(img).css("width","100%").css("height","auto");
        }
        else{//如果小于浏览器的宽度按照原尺寸显示
            $(img).css("width",realWidth+'px').css("height",realHeight+'px');
        } 
    });
});
</script>
<?php $this->display('shop/plate/footers');?>