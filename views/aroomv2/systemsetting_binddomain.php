<?php $this->display('aroomv2/page_header'); ?>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css"/>
<style>
.ui-dialog{border:none; background-color: transparent;}
</style>
<div>
    <div class="ter_tit">
        当前位置 > <a href="<?=geturl('aroomv2/systemsetting')?>">系统设置</a> > <a href="<?=geturl('aroomv2/systemsetting/domain')?>">域名设置</a> > 域名绑定
    </div>
    <div class="nraddym mt10" style="background: #fff;">
        <div class="kindremin">
            <p class="kindremintit">温馨提示：</p>
            <p class="p1s">1.将独立域名与网校绑定后，即可通过独立域名直接打开网校。</p>
            <p class="p1s">2.请确认您的<span>域名已完成备案，才能进行绑定操作</span>。如尚未完成域名备案，请向域名服务商咨询相关事宜。</p>
            <p class="p1s">3.如需解除绑定，请到 系统设置＞独立域名设置 中手动解除即可。</p>
        </div>
        <div class="qdyydlym">
            <div class="tltle">第一步：确认拥有独立域名</div>
            <div class="fiscet">请先确认您已从<a href="http://www.net.cn" class="wwwweb" target="_blank">万网</a>、<a href="http://www.xinnet.com" class="wwwweb"target="_blank">新网</a>、<a href="http://www.ename.com" class="wwwweb"target="_blank">易名中国</a>等域名网站成功购买域名，并已完成相关备案工作</div>
        </div>
        <div class="qdyydlym">
            <div class="tltle">第二步：设置域名指向</div>
            <div class="fiscet">登录域名购买网站，将需要绑定的域名CNAME记录设置为<span style="color:#ffb233;"> domain.ebh.net</span>.</div>
        </div>
        <div class="qdyydlym">
            <div class="tltle">第三步：等待域名指向生效</div>
            <div class="fiscet">
                <p>成功完成上一步的域名指向设置后，需耐心等待域名指向生效</p>
                <p>注：1、不同的域名服务商，生效审核时长不同，一般最长不超过24小时。</p>
                <p>2、检查生效方法：电脑点击 "开始"，搜索cmd并运行，输入命令 ：<span style="color:#ffb233;">ping www.xxxxx.com</span></p>
                <p>（ping+空格+您的域名），运行结果若是 domain.ebh.net 或 一个新的IP地址，即为生效。</p>
            </div>
        </div>
        <div class="qdyydlym">
            <div class="tltle">第四步：提交域名信息</div>
            <input class="tjymxx"  id="fulldomain" name="fulldomain" />
        </div>
        <a class="savebtn savebtnxg" href="javascript:;" style="float:inherit;">提&nbsp;交</a>
    </div>
</div>
<script type="text/javascript">

    $(function(){
        $(".savebtn").click(function(){
            if(checkdomain()) {
                submitdomain();
            }
        });
    });

    function checkdomain () {
        var fulldomain = $("#fulldomain").val();
        var pattern =/^[\w\-\.]+(\.\w+)+$/;
        //var pattern =/^[^(ebh)(ebanhui)]+\.net\.com$/g;
        var t1=String(fulldomain);
        var t2=String(fulldomain);
        if( t1.indexOf('ebh.net') >= 0){
            var d = top.dialog({
                title: '提示',
                content: '域名不能包含ebh.net！',
                cancel: false,
                okValue: '确定',
                ok: function () {
                }
            });
            d.showModal();
            return false;
        };
        if( t2.indexOf('ebanhui.com') >= 0){
            var d = top.dialog({
                title: '提示',
                content: '域名不能包含ebanhui.com！',
                cancel: false,
                okValue: '确定',
                ok: function () {
                }
            });
            d.showModal();
            return false;
        };
        if(fulldomain == ''){
            var d = top.dialog({
                title: '提示',
                content: '域名不能为空！',
                cancel: false,
                okValue: '确定',
                ok: function () {
                }
            });
            d.showModal();
            return false;
        };

        if(!pattern.test(fulldomain)){
            var d = top.dialog({
                title: '提示',
                content: '请输入正确域名！',
                cancel: false,
                okValue: '确定',
                ok: function () {
                }
            });
            d.showModal();
            return false;
        }
        return true;
    }
    var submit_enabled = true;
    function submitdomain(){
        if (submit_enabled === false) {
            return false;
        }
        submit_enabled = false;
        $.ajax({
		type: 'POST',
		url: '/aroomv2/systemsetting/savebinddomain.html',
		data: {fulldomain:$("#fulldomain").val()},
		dataType: 'json',
		success: function(data){
            if(data != undefined && data != null && data.status == 1){

                var d = dialog({
                    title: '域名信息',
                    content: data.msg,
                    cancel: false,
                    okValue: '确定',
                    ok: function () {
                        setTimeout(function () {
                            document.location.href = "<?= geturl('aroomv2/systemsetting/domain') ?>";
                            d.close().remove();
                        }, 1000);
                  }
                });
                d.showModal();

            }  else{
                var d = dialog({
                    title: '域名信息',
                    content: data.msg,
                    cancel: false,
                    okValue: '确定',
                    ok: function () {
                        setTimeout(function () {
                            document.location.href = "<?= geturl('aroomv2/systemsetting/binddomain') ?>";
                            d.close().remove();
                        }, 1000);
                    }
                });
                d.showModal();

            }
        }
        });
    }



</script>

<?php $this->display('aroomv2/page_footer'); ?>