<?php $this->display('forum/head');?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/forum/css/community.css?v=20171117002" />
		<div class="postedfa">
			<div class="postedtop">
				<img src="<?=$forum['image']?$forum['image']:'http://static.ebanhui.com/forum/img/community1.jpg'?>" class="postedtopimg" />
                <div class="postedson">
                	<h2 class="posttitle"><?=$forum['name']?></h2>
                    <p class="joinposted joinedbtn" data-fid="<?=$forum['fid']?>" <?php if(!$joininfo){?>style="display:none;" <?php }?>>
                        <span class="joinpostedson">已加入</span>
                        <span class="canceled">取消</span>
                    </p>
                    <p class="post_join joinbtn" data-fid="<?=$forum['fid']?>" <?php if($joininfo){?>style="display:none;" <?php }?> >
                        <span class="join_img"></span>
                        加入
                    </p>
                    <p class="attentionpost">
                        <span class="attention">关注：</span>
                        <span class="attentionnum"><?=$forum['follow_count']?></span>
                        <span class="attention">帖子：</span>
                        <span class="attentionnum"><?=$forum['subject_count']?></span>
                    </p>
                    <p class="communitybrief">社区简介：<?=$forum['notice']?></p>

                    <p class="moderator">版主：<?php if(isset($forum['manager_name'])){echo implode(',', $forum['manager_name']);}?></p>
                </div>
			</div>
            <div class="postedbottom">
            <form action="" id="post-form">
                <input type="hidden" class="user_id" name="fid" value="<?=$forum['fid']?>">
                <span class="postlist">帖子分类：</span>
                <div class="chooselistfa">
                    <div class="chooselistson">
                    	<input type="text" placeholder="选择分类"/>
                        <input type="hidden" name="cate_id" id="cate_id">
						<div class="choose_list">
							<ul>
                                <?foreach($forum['category'] as $category){?>
                                <?php if($category['only_manager'] == 0 || $is_manager){?>
								<li data-cate_id="<?=$category['cate_id']?>"><?=$category['category_name']?></li>
                                <?php } ?>
                                <?php } ?>
							</ul>
						</div>
						<span class="choose_img"></span>
                    </div>
                </div>
                <input type="text" placeholder="请输入标题，30字以内" name="title" class="postlistinput"  />
                <br />
                <span class="postlist postlistmain">内容：</span>
                <div class="editor1">
                    <?php $editor->xEditor('content','970px','605px'); ?>
                </div>
                <a href="javascript:void(0)" class="postbtn">发帖</a>
            </form>
            </div>
		</div>
        <script type="text/javascript" src="http://static.ebanhui.com/forum/js/post.js?v=20170407001"></script>
        <script type="text/javascript" src="http://static.ebanhui.com/forum/js/front.js?v=20170407003"></script>
        <script type="text/javascript">
   			var timelag2;
			$.ajax({
				type: "GET",
				url: '/register/getbindstatus.html',
				dataType: 'json',
				async: false,
				success:function(json){
					timelag2 = json.data.post_interval;
				},
				error: function(){
					console.log("接口错误！");
				}
			});
			if(timelag2 == undefined){
				timelag2 = 0;
			}
			//设置cookie
			function setCookie(name, value, expiredays, path) {  
			    var Days = 30;  
			    var exp = new Date();  
			    exp.setTime(exp.getTime() + expiredays*1000); 
			    var path = (path == null) ? ";path=/" : ";path="+path;
			    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString() + path;  
			}
			//发布帖子
			$('.postbtn').on('click',function(){
				var userId = $(".user_id").val();
				var length = $(".postlistinput").val().length;
				var that = this;
				if(length > 30){
					tips("标题最多只能输入30个字");
					return;
				}else if($("#cate_id").val() == ""){
					tips("请选择分类");
					return;
				}else{
					$.ajax({
						type: "POST", //GET或POST,
						url: "/forum/index/publishAjax.html",
						data:$('#post-form').serialize(),
						dataType: "json",
						success: function(data) {
							if(data.status == 1){
								var timestamp = Date.parse(new Date())/1000;
								timelag2 = parseInt(timelag2);
								var timeend = timestamp + timelag2;
								setCookie('timefatie',timeend,timelag2,"/");
								window.location.href = "/forum.html?fid=" + userId;
							}else if(data.status == 0){
								tips(data.msg);
							}
						}
					});
				}
			});
       	</script>
	</body>
</html>