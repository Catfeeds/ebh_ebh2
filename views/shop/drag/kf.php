<div class="kflist">
    <div class="qqkf onhover"></div>
    <div class="dfkf"></div>
</div>
<div class="kfliston">
    <div class="qqkfson" style="overflow:auto;max-height:200px;">
        <div class="djqqlx" style="font-size: 13px;">点击QQ立即联系</div>
        <?php if(!empty($kefu)){foreach($kefu['kefuqq'] as $k=>$v){?>
        <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $v?>&site=qq&menu=yes" style="color: #fff"><div class="qqkfsonlist"><?php echo !empty($kefu['kefu'][$k])?ssubstrch($kefu['kefu'][$k],0,8):'在线客服'?></div></a>
<!--        <div class="qqkfsonlist"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=892357903&site=qq&menu=yes">在线客服2</a></div>-->
        <?php }}?>
    </div>
    <div class="lxdhson">
        <div class="djqqlx">联系电话</div>
        <?php if(!empty($phone)){ foreach($phone as $value){?>
        <p class="lxdhs1s"><?php echo $value?></p>
        <?php } }?>
    </div>
</div>
<script>
    $('.dfkf').on('click',function(){
        $("html,body").animate({scrollTop:0}, 500);
    })
    $('.kfliston').hide();
    $('.qqkf').on('click',function(){
        $('.kfliston').slideToggle();
    })
</script>