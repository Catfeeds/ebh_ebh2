<?php $this->display('mall/header') ?>
<script type="text/javascript" src="http://static.ebanhui.com/mall/js/sea.js" ></script>
<body>
<div class="buygoods">
	<div class="buygoodson">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">发货</span></a></li>
			</ul>
		</div>
        <div class="deliverylogisticsfa">
        	<div class="deliverylogistics">
            	<span class="mallspan mallspanwid100">物流方式：</span>
                <input type="radio" id="express" name="delivery" checked />
                <label for="express">快递</label>
                <input type="radio" id="toface" name="delivery" />
                <label for="toface">见面交易</label>
            </div>
            <div class="delivery_2">
                <div class="malltitle-1">
                    <span class="mallspan mallspanwid100 fl">物流公司名称：</span>
                    <a href="javascript:void(0)" class="chooselogistics" onclick="showchoose()" >选择</a>
                    <a href="javascript:void(0)" class="chooselogisticsafter" onclick="showchoose()" style="display:none;" >申通快递</a>
                    <input type="hidden" value="" id="logistics" />
                </div>
                <div class="malltitle-1">
                    <span class="mallspan mallspanwid100 fl">快递单号：</span>
                    <input class="nameinput blue expressnum" onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9]/g,'')" type="text" maxlength="15"> 
                </div>
            </div>
            <div class="delivery_1">
                <div class="malltitle-1">
                    <span class="mallspan mallspanwid100 fl">备注：</span>
                    <div class="txtxdaru" style="float:left;width:778px;display: inline;">
                    <?php 
                        $editor = Ebh::app()->lib('UMEditor');
                        $editor->xEditor('shop','100%','400px');
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <a href="javascript:void(0)" class="issued">确认发货</a>
    </div>
</div>
<div class="logistic" style="display: none;">
    <ul class="logistic_list">
        <?php if(!empty($logistics)){?>
        <?php foreach ($logistics as $loglist) {?>
        <?php 
            if(!is_array($loglist)){
                $loglist = (array)$loglist;
            }
        ?>
        <li class="logistic_way"  style="color: #333333;margin-bottom: 8px;">
            <input type="radio" id="logs<?=$loglist['lid'];?>" name="radiobutton" value="<?=$loglist['lid'];?>" />
            <label for="logs<?=$loglist['lid'];?>" class="logisticlist" val = "<?=$loglist['lid'];?>"><?=$loglist['lgname']?></label>
        </li>
        <?php }?>
        <?php }?>
    </ul>
</div>
<script type="text/javascript">
//选择发货方式
$(".deliverylogistics input").on('click',function(){
    var deliveryway = $(this).attr('id');
    if(deliveryway == 'express'){
        $(".delivery_2").show();
    }else{
        $(".delivery_2").hide();
    }
});
//确认发货
$(".issued").on('click',function(){
    var deliveryway = $(".deliverylogistics input[name='delivery']:checked").attr('id');
    var mark = UM.getEditor('shop').getContent();
    if(deliveryway == 'express'){//使用快递发货
        var lid = $("#logistics").val();
        var expnum = $(".expressnum").val();
        var exptype = 1;
        if(lid == '' || expnum == ''){
            top.dialog({
                id: "abc", //可选
                title: "提示",
                content: "快递单号或快递方式不能为空！",
                okValue: "确定",
                ok: function() {
                },
                cancel: false,
                onshow:function(){
                    var that=this;
                    setTimeout(function () {
                    that.close().remove();
                    }, 2500);
                },
                width : "400"
            }).showModal();
            return;
        }
    }else{//面对面交易
        var exptype = 2;
    }
    $(".issued").unbind('click');
    var is_real = <?= empty($is_real) ? 0 : $is_real;?>;
    $.ajax({
        url:'/mall/shop/delivery/'+<?=$ordernum;?>+'.html',
        dataType:'json',
        type:'post',
        data:{'exptype':exptype,'expnum':expnum,'lid':lid,'remark':mark},
        success:function(res){
            if(res.data==1){
                if(is_real == 2){
                    location.href= '/mall/order/all.html?type=2';
                }else{
                    location.href= '/mall/order/all.html';
                }
            }else{
                top.dialog({
                    title: "信息提示",
                    content: "未知错误，请重试",
                    cancelValue: "取消",
                    cancel: function() {
                        
                    },
                    width : "400"
                }).show();
            }
        }
    })
});
$('.logistic_way label').on('click',function(){
    var label = $(".logistic_way label",window.parent.document);
    $.each(label,function(){
        $(this).removeClass('onhover');
    });
    $(this).addClass('onhover');
})
var $logistic = $(".logistic")[0];
function showchoose(){
    top.dialog({
        title: "选择",
        content: $logistic,
        okValue: "确认",
        ok: function() {
            var lid = $('.logistic_way .onhover',window.parent.document).attr('val'); //获取选中对应的值
            var lname = $('.logistic_way .onhover',window.parent.document).html();
            $(".chooselogisticsafter").html(lname);
            $(".chooselogisticsafter").show();
            $(".chooselogistics").hide();
            $("#logistics").val(lid);
        },
        cancelValue: "取消",
        cancel: function() {
            
        }
    }).showModal();
}
</script>
<script src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<?php $this->display('mall/footer') ?>
