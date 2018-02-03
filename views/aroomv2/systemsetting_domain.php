<?php $this->display('aroomv2/page_header'); ?>
<div>
    <div class="ter_tit">
        当前位置 > <a href="<?=geturl('aroomv2/systemsetting')?> ">系统设置</a> > 域名设置
    </div>
    <div class="xitongshezhis mt10" style="background: none;">
		<a href="<?=geturl('aroomv2/systemsetting/binddomain')?>" <?php if( (!empty($fulldomain['fulldomain']) || (!empty($roominfo['fulldomain'])))){echo 'style="display:none"' ;}else{} ?> class="addyum">添加域名</a>
		<div class="clear"></div>
		<div class="dlsbjl mt10" style="background:#fff;"

			<table cellpadding="0" cellspacing="0" class="dlsbables dlsbable1s">
				<table cellspacing="0" cellpadding="0" class="tables addym">
					<tbody>
					<tr class="first">
						<td width="30%">域名</td>
						<td width="45%">说明</td>
						<td width="25%" class="caozuo">操作</td>
					</tr>
					<tr>
						<td><?=$roominfo['domain']?>.ebh.net</td>
						<td>该域名由e板会平台提供，永久存在。</td>
						<td class="caozuo"> </td>
					</tr>
					<?php if(empty($roominfo['fulldomain'])){ ?>
						<?php if(!empty($fulldomain['fulldomain'])){ ?>
							<?php if( $checkresult['admin_status'] == 1|| $checkresult['teach_status'] == 1){ ?>
								<tr>
									<td><?= $fulldomain['fulldomain'] ?></td>
									<td>域名审核通过，待指向生效后，即可通过此网址访问您的网校。</td>
									<td class="caozuo"><a id="unbinddomain" class="ckqb" href="javascript:;">删除域名</a></td>
								</tr>
							<?php }elseif($checkresult['admin_status'] == 0 && $checkresult['teach_status'] == 0){ ?>
								<tr>
									<td><?= $fulldomain['fulldomain'] ?></td>
									<td>域名审核中，请耐心等待...</td>
									<td class="caozuo"><a class="ckqb" href="javascript:;"></a></td>
								</tr>
							<?php }else{ ?>
								<tr>
									<td><?= $fulldomain['fulldomain'] ?></td>
									<td>域名审核未通过</td>
									<td class="caozuo"><a id="modifydomain" class="ckqb" href="javascript:;">修改域名</a></td>
								</tr>
							<?php } ?>
						<?php }else{ ?>

					<?php	} ?>
				<?php }else{ ?>
						<tr>
							<td><?= $roominfo['fulldomain'] ?></td>
							<td>审核通过,可通过此网址访问您的网校。</td>
							<td class="caozuo"><a id="unbinddomain" class="ckqb" href="javascript:;">删除域名</a></td>
						</tr>
				<?php } ?>

					</tbody>
			</table>
		</div>
    </div>
</div>


<!--解除域名-->
<div id="dialogunbind" style="display:none;height:120px;">
    <div class="seeallbot">
    	<p class="zhxms zhxm1s">解除绑定后将不能通过独立域名访问网校<br>是否解除绑定?</p>
    </div>
</div>

<!--修改域名-->
<div id="dialogmodify" style="display:none;height:120px;">
    <div class="seeallbot1s">
    	<div class="zhxms">
        	<span>输入新域名：</span>
            <input type="text" id="newdomin" class="srxym" value=""/>
        </div>
        <p class="mt10" style="color:#999;">注：新域名也必须有效域名才能正常使用</p>
    </div>
</div>


<script type="text/javascript">
$("#unbinddomain").click(function(){
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			unbinddomain();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('dialogunbind').exec('close');
			return false;
		}
	});
	if(!H.get('dialogunbind')){
		H.create(new P({
			id : 'dialogunbind',
			title: '解除绑定',
			easy:true,
			width:412,
			padding:5,
			content:$('#dialogunbind')[0],
			button:button
		}),'common');
	}

	H.get('dialogunbind').exec('show');

});


$("#modifydomain").click(function(){
	var button = new xButton();
	button.add({
		value:"修改",
		callback:function(){
			modifydomain();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('dialogmodify').exec('close');
			return false;
		}
	});
	if(!H.get('dialogmodify')){
		H.create(new P({
			id : 'dialogmodify',
			title: '修改域名',
			easy:true,
			width:412,
			padding:5,
			content:$('#dialogmodify')[0],
			button:button
		}),'common');
	}

	H.get('dialogmodify').exec('show');

});


function unbinddomain(){
	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/systemsetting/unbinddomain')?>',
		dataType:'json',
		success:function(data){
			if(data.status == 1){
				setTimeout(function () {
                            window.top.location.href = "http://<?=$roominfo['domain']?>.ebh.net";

                        }, 1000);
			}else{
				setTimeout(function () {
					windowt.top.location.href = "http://<?=$roominfo['domain']?>.ebh.net";

				}, 1000);

			}
		},
		error:function(){
			alert("服务器连接错误，请重试");
		}
	});
}

function modifydomain(){
	var newdomin = $("#newdomin").val();
	//validate
	var pattern =/^[\w\-\.]+(\.\w+)+$/;
    var t1=String(newdomin);
    var t2=String(newdomin);
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
	if(newdomin == ''){
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
   if(!pattern.test(newdomin)){
       if(!pattern.test(newdomin)){
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
	};
	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/systemsetting/modifydomain')?>',
		data:{fulldomain:newdomin},
		dataType:'json',
		success:function(data){
			if(data.status == 1){
                        setTimeout(function () {
                           document.location.href = "<?= geturl('aroomv2/systemsetting/domain') ?>";
                        }, 1000);

			}else{
                var d = dialog({
                    title: '域名信息',
                    content: data.msg,
                    cancel: false,
                    okValue: '确定',
                    ok: function () {
                    }
                });
                d.showModal();
				//alert(data.msg);
			}
		},
		error:function(){
			alert("服务器连接错误，请重试");
		}
	});
}



</script>




<?php $this->display('aroomv2/page_footer'); ?>