<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="http://static.ebanhui.com/checkin/css/common.css" />
		<style>
			.answer_box{
				width:600px;
				margin:0 auto;
				overflow:hidden;
			}
			.ask_once{
				overflow:hidden;
				margin-top:20px;
			}
			.explain{
				
				font-weight: bold;
    			color: #777;
    			text-align: left;
    			margin-right:18px;
    			float: left;
    			font-size:14px;
			}
			#title{
				float:left;
				width:530px;
				height:30px;
				font-size:14px;
				padding:0 10px;
				border:1px solid #ccc;
			}
			.updata{
				width:100%;
				margin-top:20px;
				text-align: center;
			}
			#up_btn{
    			width: 190px;
    			background: #18a8f7;
    			height: 32px;
    			font-size: 14px;
    			cursor: pointer;
    			border-radius: 4px;
    			color:#fff;
			}
			#up_btn:hover{
				background:#0d9be9;
			}
		</style>
		<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
		
	</head>
	<body>
		<?php 
			$folderid = $this->input->get("folderid");
			$cwid =  $this->input->get("cwid");
			$tid = $this->input->get("tid");
			$cwname = $this->input->get("cwname");
		?>
		<div class="answer_box">
			<form action="askform" id="askform">
				<input type="hidden" name="folderid" id="folderid" value="<?=$folderid?>"/>
				<input type="hidden" name="cwid" id="cwid" value="<?=$cwid?>"/>
				<input type="hidden" name="tid" id="tid" value="<?=$tid?>"/>
				<input type="hidden" name="cwname" id="cwname" value="<?=$cwname?>"/>
				<div class="ask_once"><span class="explain" style="line-height: 30px;">标题</span><input type="text" id="title" name="title" placeholder="请在这里输入问题标题" maxlength="50"/></div>
				<div class="ask_once">
					<span class="explain">内容</span>
					<div class="txtxdaru" style="float:left;width:550px;display: inline;">
						<?php $editor->xEditor('message','100%','342px'); ?>
					</div>
				</div>
				<div class="ask_once">
					<span class="explain">积分悬赏</span>
					<select name="reward" id="reward">
						<?php $askreward = EBH::app()->getConfig()->load('askreward');
							foreach($askreward as $k=>$reward){
								if($user['credit']>=$reward){
						?>
							<option value="<?=$k?>"><?=$reward?>积分</option>
						<?php }}?>
					</select>
				</div>
				<div class="updata">
					<input id="up_btn" type="button" value="提交问题"/>
				</div>
			</form>
		</div>
		<script type="text/javascript">
			$(function(){
	            var flag = true;
				$("#up_btn").on("click",function(){
					if(checkquestion() && flag){
						flag = false;
						addquestion();	
					}
				});
				$("#title").keyup(function () {
                    var value = this.value
                    var num = this.value.length;
                    if (num > 50) {
                        //截取前100个字符
                        value = value.substring(0, 50);
                        $("#title").val(value);
                    }
                });
				function checkquestion() {
					if($.trim($("#title").val()) == "") {
						top.dialog({
							title: '提示信息',
							content: '问题的标题不能为空！',
							width:300,
							cancel: false,
							okValue: '确定',
							ok: function () {
							}
						}).showModal();	
						return false;
					}
				    var message = UE.getEditor('message').getContent();
				    if(message == "") {
						top.dialog({
							title: '提示信息',
							content: '问题内容不能为空！',
							width:300,
							cancel: false,
							okValue: '确定',
							ok: function () {
							}
						}).showModal();	
						return false;
					}
					return true;
				}
				function addquestion(){
					$.ajax({
						type:"POST",
						url:"<?= geturl('college/myask/addquestion') ?>",
						data:$("#askform").serialize(),
						dataType:"json",
						success:function(data){
							if(data != null && data != undefined && data.status == 1) {
								//添加提问发包
								var myWs = window.parent.ws;
								var data = {type:"asksyncinit"};
								try{
									myWs.send(JSON.stringify(data));
									$("#ask",parent.document).remove();
								}catch(e){
									top.dialog({
										title: '提示',
										content: '添加失败',
										cancel: false,
										okValue: '确定',
										ok: function () {
											$("#ask",parent.document).remove();        
										}
									}).showModal();
								}
								
							}else if(data != null && data != undefined && data.status == -1){
								var str = '';
		                    	$.each(data.Sensitive,function(name,value){
		                    		str+=value+'&nbsp;';
		                    	});
		                    	top.dialog({
									title: '提示',
									content: '问题包含敏感词汇'+str+'！请修改后重试...',
									cancel: false,
									okValue: '确定',
									ok: function () {        
									}
								}).showModal();
								flag = true;
								return false;
							}else{
								var message = '提交问题失败，请稍后再试或联系管理员。';
								if(data != undefined && data.message != undefined)
									message = data.message;
								flag = true;
								top.dialog({
									title: '提交问题',
									content:message,
									cancel: false,
									okValue: '确定',
									ok: function () {        
									}
								}).showModal();
								return false;
							}
						}
					});
				}
				
			})
			
		</script>
	</body>
</html>
