<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=9">
		<title>管理</title>
		
        <?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
		
        <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/forum/css/community.css?v=20171117002" />
		
        <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/forum/css/page.css" />
		<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
	</head>
	<body>
		<div class="postedfa postedfama">
			<div class="post-menu">
                <ul>
                    <?php if($hide):?>
                    <li><a href="/forum/index.html"><span>我的</span></a></li>
                    <?php endif;?>
                    <li><a href="/forum/index/lists.html"><span>全部</span></a></li>
                    <li class="workcurrent"><a href="javascript:void(0)"><span>管理</span></a></li>
                </ul>
                <div class="postdiles">
					<form method="get" action="/forum/index/my.html">
                        <input class="postnewsou" type="text" name="keyword" value="<?=$this->input->get('keyword')?>"/>
                        <input class="postsoulico" type="submit" value=""/>
                    </form>
				</div>
            </div>
            <div class="post-menu2">
            	<ul>
                	<li <?php if($chose=='new'){echo 'class="curr"';}?>><a href="/forum/index/my.html">最新</a><span class="line1">|</span></li>
                    <li <?php if($chose=='hot'){echo 'class="curr"';}?>><a href="/forum/index/my.html?is_hot=1">热门</a><span class="line1">|</span></li>
                    <li <?php if($chose=='del'){echo 'class="curr"';}?>><a href="/forum/index/my.html?is_del=1">已删除</a></li>
                </ul>
            </div>
            <div class="postmanage">
            	<div class="default_img">
					<img src="http://static.ebanhui.com/forum/img/nodata.png" />
				</div>
            	<ul>
                    <?foreach($list as $subject){?>
                    <?php
                        $userData['face'] = $subject['face'];
                        $userData['sex'] = $subject['sex'];
                        $userData['groupid'] = $subject['groupid'];
                        $avatar = getavater($userData);
                    ?>
                	<li class="postmanageli" sid="<?=$subject['sid']?>">
						<?php if($subject['is_del'] == 1){ ?>
							<div class="delete_end">已删除</div>
						<?php } else { ?>
							<?php if($subject['uid'] == $user['uid']){ ?>
								<div class="self_delete">删除</div>
							<?php } ?>
						<?php } ?>
                    	<div class="postmalileft"><a href="javascript:void(0)"><img src="<?=$avatar?>" /></a></div>
                        <div class="postmalicenter">
                        	<p><a href="javascript:void(0)" class="formtitle">【<?=$subject['category_name']?>】<?=$subject['title']?></a></p>
                            <p class="p1s"><a href="javascript:void(0)"><?=shortstr(strip_tags($subject['content']),50)?></a></p>
                            <p class="publishp"><span><?=$subject['realname']?$subject['realname']:$subject['username']?></span><span class="publishtime"><?=date('Y-m-d H:i:s',$subject['dateline'])?></span></p>
                        </div>
                        <div class="postmaliright">
                            <?php if($subject['is_del'] == 1){?>
                        	<p class="delp">已删除（原因：<?=$subject['del_reason']?>）</p>
                            <?php } ?>
                            <p><span class="postspan"><?=$subject['reply_count']?></span><span class="postspan1"><?=$subject['view_count']?></span></p>
                        </div>
                    </li>
                    <? } ?>

                </ul>
                <?=$pagestr?>
            </div>
		</div>
		<!--删除提示-->
		<div id="delete_tips" style="display:none;">是否删除此贴</div>
        <script type="text/javascript">
		$(function(){
			//弹窗
			function showaddgroup(id,ele,width,name,padding,submitFn){	
				$("#groupname").val("");
				$("#summary").val("");
				var _xform = new xForm({
					domid:id,
					errorcss:'cuotic',
					okcss:'zhengtic',
					showokmsg:false
				});
				var button = new xButton();
				button.add({
					value:"确定",
					callback:function(){
						//addgroups();
						$(".ui-dialog-autofocus").attr("disabled","disabled");
						//H.get('addtgroups').exec('close');
						if(typeof(submitFn) == 'function'){
							submitFn();
						}
						return false;
					},
					autofocus:true
				});
					
				button.add({
					value:"取消",
					callback:function(){
						// location.reload();
						H.get(id).exec('close');
						return false;
					}
				});	 
					
				if(!H.get(id)){
						H.create(new P({
							id : id,
							title: name,
							easy:true,
							width:width,
							padding:padding,
							button:button,
							content:$('#' + ele)[0]
						},{
							onclose:function(){
								H.remove(id);
								//location.reload();
							}
						}),'common').exec('show');	
					}else{
						H.get(id).exec('show');
					}
						
			}	
			//错误提醒
			var tips = function(txt){
				top.dialog({
					skin:"ui-dialog2-tip",
					content:"<div class='FPic'></div><p>"+ txt +"</p>",
					width:350,
					onshow:function () {
						var that=this;
						setTimeout(function () {
							that.close().remove();
						}, 2000);
					}
				}).show();
			}
			$("li.postmanageli:last-child").css("border-bottom","none");
			$(window).load(function(){
				if($(".postmanageli").length == 0){
					$(".default_img").show();
				}else{
					$(".default_img").hide();
				}
			});
			$(".self_delete").on("click",function(){
				var sid = $(this).parents(".postmanageli").attr("sid");
				var that = this;
				showaddgroup("delete_tips","delete_tips",400,"删除帖子",0,function(){
					
					$.ajax({
						type:"POST",
						url:"/forum/subject/delSelfSubject.html",
						data:{sid:sid},
						dataType:"json",
						success:function(data){
							
							if(data.status == 0){
								H.get('delete_tips').exec('close');
								window.location.reload();
								
							}else
							if(data.status == 1){
								tips(data.msg);
								H.get('delete_tips').exec('close');
							}
						}
					});
				});
			});
		})
		</script>
	</body>
</html>