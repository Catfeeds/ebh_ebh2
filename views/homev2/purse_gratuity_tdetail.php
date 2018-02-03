<?php $this->display('homev2/header'); ?>
<?php $this->display('homev2/top');?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/share/css/share.min.css">
<style type="text/css">
   a {
    cursor: pointer;
   }
     .themes {
        position: absolute;
        top: 29px;
        left: 67px;
        width: 92px;
        height: 99px;
        background: #F2F2F2;
        box-shadow: 0 12px 15px 4px rgba(0, 0, 0, 0.2);
        z-index: 12;
    }
    .themes a.shuter {
        height: 32px;
        line-height: 32px;
        width: 92px;
        color: #666;
        float: left;
        text-align: center;
        font-size: 14px;
        border-bottom: solid 1px #e3e3e3;
    }
    .themes a.shuter:hover {
        background:#f0f6fc;
    }
</style>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/share/jquery.share.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
<body>
	<div class="maines" style="margin:0 auto;float:none;background:none;">
    <div class="jetke">
    <?php $this->display('homev2/purse_menu');?>
    	<div class="mainereward">
        	<a href="/homev2/purse/gratuity.html">赞赏记录</a>
            <a href="/homev2/purse/gratuitydetail.html" class="curr">打赏明细</a>
        </div>
        <div class="clear"></div>
        <p class="myreward" style="float: left;">课件数：<span class="coursetotal"><?php echo empty($rewardcount[1])?0:$rewardcount[1];?></span>个</p>
        <p class="myreward" style="float: left;">答疑数：<span class="coursetotal"><?echo empty($rewardcount[3])?0:$rewardcount[3];?></span>个</p>
        <div class="teachercheck_top">
        	<div class="aligncen">
                <table class="tables" cellspacing="0" cellpadding="0">
                    <tbody>
                    <?php if(!empty($cwlist)){ ?>
                        <tr class="first">
                        	<td width="20%"> </td>
                             <td width="20%" style="position: relative;" id='typep'> 
                            <a>主题</a>
                            <img src='http://static.ebanhui.com/ebh/images/itop.png' >
                            <div class="themes" id="type" style="display: none;">
                                 <a class="shuter" type='0'>全部</a>
                                 <a class="shuter" type='1'>课件</a>
                                 <a class="shuter" type='3'>答疑</a>
                            </div>
                            </td>
                            <td width="20%">发布时间</td>
                            <td width="20%">人次</td>
                            <td width="20%">金额/元</td>
                        </tr>
                        <?php foreach ($cwlist as $list) { ?>
                        <tr>
                         <?php if($list['type'] == 1) {?>
                        	<td width="20%"><a href="javascript:;"><img src="<?php echo $list['logo'];?>" class="courseimg" /></a></td>
                         <?php } else {?>
                            <td width="20%"><a href="javascript:;"><img src="http://static.ebanhui.com/ebh/images/wenda.png" class="courseimg" /></a></td>
                         <?php }?>
                            <td width="20%"><?php echo $list['title'];?></td>
                            <td width="20%"><?php echo date('Y-m-d H:i',$list['dateline']);?></td>
                            <td width="20%"><?php echo $list['rewardcount'];?></td>
                            <td width="20%" class="last">+<?php echo $list['rewardmoney'];?>&nbsp;&nbsp;<a onclick="onlickmore(<?php echo $list['cwid'];?>,$(this))" type="<?php echo $list['type'];?>" class="lansere">[更多]</a></td>
                        </tr>
                        <?php } ?>
                    <?php }else{ ?>
                        <div class="nodata"></div>
                      <?php }?> 
                    </tbody>

                </table>
                <?php echo $showpage;?>
        	</div>
        </div>
	</div>
    </div>
</div>
<!--赞赏明细弹窗-->
<div id="appreciatedetails" style="display:none;">
	<table class="tables" cellspacing="0" cellpadding="0">
		<tbody>
			<tr class="first">
				<td width="25%">时间</td>
				<td width="25%">来源</td>
				<td width="25%">金额(元)</td>
				<td width="25%">支付方式</td>
			</tr>        
		</tbody>
	</table>
</div>
<script type="text/javascript">
 $("#typep").click(function(){
        $("#type").toggle();
    });
   $(".shuter").click(function () {
        var type = $(this).attr('type');
        var seg = window.location.href.indexOf('?');
        if (seg > 0) {
            url = window.location.href.substr(0,seg);
        } else {
            url = window.location.href;
        }
        url = url + '?type='+type;
        window.location.href = url;
    })
function onlickmore(cwid,obj){
    var type = $(obj).attr('type');
    var url = '/homev2/purse/getGratuityByCwidAjax.html';
    $.ajax({
            type:'post',
            url:url,
            dataType:'json',
            data:{'cwid':cwid,'type':type},
            success:function(data){
                if(data.status == 1){
                    $("#appreciatedetails tr").each(function(){
                        $(this).remove();
                    });
                    var html = '<tr class="first"><td width="25%">时间</td><td width="25%">来源</td><td width="25%">金额(元)</td><td width="25%">支付方式</td></tr>';
                    $.each(data.data,function(i,item){
                        html+= '<tr><td width="25%">'+item['paytime']+'</td><td width="25%">'+item['name']+'</td><td width="25%">'+item['totalfee']+'</td><td width="25%">'+item['payfrom']+'</td></tr>';
                        $('#appreciatedetails tbody').html(html);
                    });
                }
            }
        });
	var d=dialog({
		title:"赞赏明细",
		content:document.getElementById("appreciatedetails"),
		width:550,
		padding:0,
	});
	d.showModal();

}
</script>
<?php $this->display('homev2/footer');?>
