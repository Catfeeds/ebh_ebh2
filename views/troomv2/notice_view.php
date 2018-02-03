<?php $this->assign('notop',TRUE);
$this->display('troomv2/room_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/tzds.css?v=01" />
<style type="text/css">
		html {background:#f5f5f5;}
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
        
        .addrec{
        	width: 92px;
        	height: 30px;
        	background-color: #EEAA29;
		    display: block;
		    color: #fff;
		    float: left;
		    border-radius: 3px;
		    line-height: 30px;
		    text-decoration: none;
		    margin:15px 0 0 40px;
        }
        .addrec:hover{
        	color: #fff;
        }
        .addrecBc{
        	background-color: #18a8f7!important;
        }
        .receipt_box{
        	width: 605px;
        	height: 170px;
        	display: none;
        }
        .receipt_box .receipt_p{
        	font-size: 16px;
        	margin-bottom: 18px;
        }
        .receipt_txtarea_box{
        	float: left;
        	width: 547px;
        	height: 72px;
        	position: relative;
        }
        .receipt_txtarea, .seereceipt_txtarea{
        	width: 545px;
        	height: 70px;
        	border: 1px solid #ccc;
        	resize: none;
        }
        .receipt_txtarea_num{
        	position: absolute;
        	bottom: 0;
        	right: 5px;
        }
        .ui-dialog2-content{
        	text-align: left;
        }
        .enclosureName{
        	float: left;
        	max-width: 250px;
        	overflow: hidden;
        	text-overflow: ellipsis;
        	white-space: nowrap;
        }
        .suffix{
        	float: left;
        }
	</style>
	<style type='text/css' media='print'>
		.bottali {display: none;}
		.reviewnoitce {display: none;}
	</style>
	<div class="waimg" style="width:960px;padding-top:15px;">
		<div class="mseng" style="width:960px;">
			<h2 class="rlyop"><?= $notice['title'] ?></h2>
			<p class="stimes">发布者：<?=getusername($notice)?>　发送时间：<?= date('Y-m-d H:i',$notice['dateline']) ?>　阅读次数：<?=max(0,$notice['viewnum'])?>次</p>
			<div style="padding:0 30px;"><div class="twotsne huide"><?= $notice['message']?></div>
			</div>

			<div class="bottali" style="text-align:center;">
				
				<?php
				if(!empty($attfile)){
				?>
				<span style="float:left;margin-left:8px;margin-right:-150px;">
				<span style="float: left;">附件：</span>
					<a style="color:red;float: left;" href="<?=$attfile['source'].'attach.html?noticeid='.$notice['noticeid']?>">
						<span class="enclosureName"></span><span class="suffix"></span>
					</a>
				</span>
				<?php }?>
				
				<?php if (!empty($notice['isreceipt'])) {?>
					<a href="javascript:;" class="huangbbtn printnotice" style="display:inline;margin-left: 310px;">打 印</a>
					<?php if (!empty($notice['receiptInfo']) && !isset($notice['receiptInfo']['choice'])) {?>
						<a href="javascript:;" onclick="addReceipt(this)" class="addrec" style="font-size: 14px;">填写回执</a>
					<?php } else{?>
						<a href="javascript:;" onclick="seeReceipt(this)" class="addrec addrecBc" style="font-size: 14px;">查看回执</a>
					<?php }?>	
						
				<?php } else {?>
					<a href="javascript:;" class="huangbbtn printnotice">打 印</a>
				<?php }?>
				<a href="javascript:;" onclick="closew()" class="lanbbtn">关 闭</a>
				
			</div>
			
			<div id="receipt_box" class="receipt_box">
				<p class="receipt_p">
					<span>标题：</span>
					<span class="receipt_tit"><?php echo empty($notice['receipt'])?'':$notice['receipt']; ?></span>
				</p>
				<p class="receipt_p">
					<span>选项：</span>
					<input type="radio" name="receiptyesorno" id="checkyes" value="1" checked="checked" />
					<label for="checkyes">是</label>
					&nbsp;&nbsp;&nbsp;
					<input type="radio" name="receiptyesorno" id="checkno" value="0" />
					<label for="checkno">否</label>
				</p>
				<p class="receipt_p">
					<span style="float: left;">说明：</span>
					<div class="receipt_txtarea_box">
						<textarea class="receipt_txtarea" maxlength="50"></textarea>
						<span class="receipt_txtarea_num">
							<span class="receiptnum">0</span>/<span>50</span>
						</span>
					</div>
				</p>
			</div>
			
			<div id="seereceipt_box" class="receipt_box">
				<p class="receipt_p">
					<span>标题：</span>
					<span class="receipt_tit"><?php echo empty($notice['receipt'])?'':$notice['receipt']; ?></span>
				</p>
				<p class="receipt_p">
					<span>选项：</span>
					<input type="radio" disabled="disabled" name="seereceiptyesorno" id="seecheckyes" value="1" checked="checked" />
					<label for="seecheckyes">是</label>
					&nbsp;&nbsp;&nbsp;
					<input type="radio" disabled="disabled" name="seereceiptyesorno" id="seecheckno" value="0" />
					<label for="seecheckno">否</label>
				</p>
				<p class="receipt_p">
					<span style="float: left;">说明：</span>
					<div class="receipt_txtarea_box">
						<textarea class="seereceipt_txtarea" readonly="readonly"></textarea>
						<span class="receipt_txtarea_num">
							<span class="seereceiptnum">0</span>/<span>50</span>
						</span>
					</div>
				</p>
			</div>
			
		</div>
		
	</div>

	

	<script type="text/javascript">
		//附件名字太长截取，保留后缀
		var enclosure = "<?=$attfile['title']?>";
		var index1 = enclosure.lastIndexOf(".");
		var suffix = enclosure.substring(index1);//后缀名
		var enclosureName = enclosure.substring(0,index1);
		$(".enclosureName").html(enclosureName);
		$(".enclosureName").attr("title",enclosureName);
		$(".suffix").html(suffix);
		
		var noticeid = '<?php echo empty($notice['noticeid'])?'':$notice['noticeid'];?>';
		var seechoice = '<?php echo empty($notice['receiptInfo']['choice'])?0:1; ?>';
		var seeexplains = '<?php echo empty($notice['receiptInfo']['explains'])?'':$notice['receiptInfo']['explains']; ?>';
		
		$(".printnotice").click(function(){
			window.document.title="打印通知";
			window.print();
		});
		function closew(){
			if($(".addrec").length > 0){
				if($(".addrec").hasClass("addrecBc")){
					var opened=parent.window.open(' ','_self');
					opened.close();
				}else{
					dialog({
						title:"提示",
						content:"您还未填写回执，是否确认退出？",
						cancelValue:"否",
						cancel:function(){
							addReceipt();
						},
						okValue:"是",
						ok:function(){
							var opened=parent.window.open(' ','_self');
							opened.close();
						}
					}).showModal();
				}
			}else{
				var opened=parent.window.open(' ','_self');
				opened.close();	
			}
		}
		function addReceipt(that){
			var $receipt_box = $("#receipt_box")[0];
			dialog({
				id:"receiptdialog",
				title:"请填写回执",
				content:$receipt_box,
				cancelValue:"关闭",
				cancel:function(){
					
				},
				okValue:"提交",
				ok:function(){
					var choice = $('input[name="receiptyesorno"]:checked').val(),
					explains = $('.receipt_txtarea').val();
//					此处是说明验证（如果需要的话）
//					if(!explains){
//						alert("请填写说明！");
//						return false;
//					}
					$.ajax({
						type:"post",
						url:"/troomv2/notice/addReceipt.html",
						data:{noticeid:noticeid,choice:choice,explains:explains},
						async:true,
						dataType:"json",
						success:function(data){
							if(data.code == 0){
								window.location.reload();
							}
						}
					});
				}
			}).showModal();
		}
		
		function seeReceipt(that){
			var $seereceipt_box = $("#seereceipt_box")[0];
			$("input[type=radio][name=seereceiptyesorno][value="+seechoice+"]").attr("checked",'checked');
			$(".seereceipt_txtarea").val(seeexplains);
			$('.seereceiptnum').html($(".seereceipt_txtarea").val().length);
			dialog({
				id:"seereceiptdialog",
				title:"回执详细",
				content:$seereceipt_box,
				okValue:"确定",
				ok:function(){
					
				}
			}).showModal();
		}
		
		var maxCount = 50;  // 最高字数，这个值可以自己配置
		$(".receipt_txtarea").on('keyup', function() {
		    var len = getStrLength(this.value);
		    $(".receiptnum").html(len);
		})
		 
		// 中文字符判断
		function getStrLength(str) { 
		    var len = str.length; 
		    var reLen = 0; 
		    for (var i = 0; i < len; i++) {        
		        if (str.charCodeAt(i) < 27 || str.charCodeAt(i) > 126) { 
		            // 全角    
		            reLen += 1; 
		        } else { 
		            reLen++; 
		        } 
		    } 
		    return reLen;    
		}
	</script>
<?php $this->display('troomv2/page_footer'); ?>