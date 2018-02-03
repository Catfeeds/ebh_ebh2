<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=9">
		<title>我的</title>
		<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
        <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/forum/css/community.css?v=20171117002" />
        <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/forum/css/page.css" />
		<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>    
	</head>
	<body>
		<div class="postedfa postedfama">
			<div class="post-menu">
                <ul>
                    <?php if($list):?>
                    <li class="workcurrent"><a href="javascript:void(0)"><span>我的</span></a></li>
                    <?php endif;?>
                    <li><a href="/forum/index/lists.html"><span>全部</span></a></li>
                    <li><a href="/forum/index/my.html"><span>管理</span></a></li>
                     
                </ul>
                <div class="postdiles">
                    <form method="get" action="/forum/index.html">
                        <input class="postnewsou" type="text" name="keyword" value="<?=$this->input->get('keyword')?>"/>
                        <input class="postsoulico" type="submit" value=""/>
                    </form>
				</div>
            </div>
            <div class="postmanage">
            	<div class="default_img">
					<img src="http://static.ebanhui.com/forum/img/nodata.png" />
				</div>
            	<ul>
                    <?php foreach($list as $forum){?>
                	<li class="postmanageli1">
                    	<div class="postmalileft"><a href="javascript:;" onClick="Open(<?=$forum['fid']?>)" target="_top"><img src="<?=$forum['image']?$forum['image']:'http://static.ebanhui.com/forum/img/community1.jpg'?>" /></a></div>
                        <div class="postmalicenter postmalicenter1">
                        	<p><a href="javascript:;" onClick="Open(<?=$forum['fid']?>)" class="formtitle1" target="_top"><?=$forum['name']?>（<span class="postnum"><?=$forum['subject_count']?></span>）</a></p>
                            <p class="p2s"><?=$forum['notice']?></p>
                            <p class="moderator1">版主：<?=$forum['manager']?></p>

                            <?php if($forum['hot_subject']){ $index = 0;?>
                            <?php foreach($forum['hot_subject'] as $hotSubject){ $index++;?>
                            <p class="numlistp"><span class="numlist"><?=$index?></span><a href="/forum/subject.html?sid=<?=$hotSubject['sid']?>" target='_blank'><?=$hotSubject['title']?></a></p>
                            <?php }?>
                            <?php }?>
                        </div>
                        <?php if($forum['last_subject']){?>
                        <div class="postmalimidd">
                            <p class="p3s"><a href="/forum/subject.html?sid=<?=$forum['last_subject']['sid']?>" target='_blank'><?=shortstr($forum['last_subject']['title'],20)?></a></p>
                            <p class="datetime1"><span class="datetimespan1"><?=$forum['last_subject']['realname'] ? $forum['last_subject']['realname'] :$forum['last_subject']['username'] ?></span><span class="datetimespan2"><?=date('Y-m-d H:i:s',$forum['last_subject']['dateline'])?></span></p>
                        </div>
                        <?php } ?>
                        <div class="postmaliright postmaliright1">
                        	<span class="postnum1">
                             <?php
                                if($forum['all_reply_count'] < 10000){
                                    echo $forum['all_reply_count'];
                                }else{
                                    echo round($forum['all_reply_count']/10000,1).'万';
                                }
                            ?>   
                            </span>
                            <span class="postnum2"></span>
                            <span class="postnum3">
                            <?php
                                if($forum['all_view_count'] < 10000){
                                    echo $forum['all_view_count'];
                                }else{
                                    echo round($forum['all_view_count']/10000,1).'万';
                                }
                            ?>
                            </span>
                        </div>
                    </li>
                    <?php }?>
                </ul>
                <?=$pagestr?>
            </div>
		</div>
        <script type="text/javascript">
		$(function(){
			$("li.postmanageli1:last-child").css("border-bottom","none");
			$(window).load(function(){
				if($(".postmanageli1").length == 0){
					$(".default_img").show();
				}else{
					$(".default_img").hide();
				}
			});
			window.Open = function(id){
				window.open("/forum.html?fid=" + id);
			}
		})
		</script>
	</body>
</html>