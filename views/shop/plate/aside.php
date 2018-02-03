<?php if(!isApp()){?>
	<!--侧滑菜单部分-->
	<aside id="offCanvasSide" class="mui-off-canvas-left">
		<div id="offCanvasSideScroll" class="mui-scroll-wrapper">
			<div class="mui-scroll">
				<?php if($user){ ?>
				<div class="content-pot">
					<a href="http://wap.ebh.net/setting.html">
						<div class="left-pot-box">
							<img class="content-img" src="<?=$user->face?>" />
						</div>
					</a>
					<a href="http://wap.ebh.net/setting.html">
						<div class="right-pot-box">
							<p class="content-name"><span class="lfname"><?=shortstr($user->realname,6,'...')?></span><?php if($user->sex  == '女'){ ?><i class="content-nv"></i><?php }else {?><i class="content-nan"></i><?php } ?></p>
							<p class="content-user"><?=$user->username ?></p>
						</div>
					</a>
					
				</div>
				<?php } ?>
				
				<ul class="mui-table-view mui-table-view-chevron mui-table-view-inverted" style="margin-top:100px;">
					<?php if($roomInfo){ ?>
					<?php foreach ($appmodules as $appmodule) {

						if($appmodule['available'] != 1){
							continue;
						}
						
						if($user->groupid == 6){
							$appname = $appmodule['nickname'];

							if(isset($appmodule_config['student'][$appmodule['modulecode']])){
								$appurl = 'http://wap.ebh.net'. $appmodule_config['student'][$appmodule['modulecode']];
							}else{
								$appurl = 'http://'.$roomInfo->domain.'.ebh.net/proxy/wap/load?code='.$appmodule['modulecode'];
							}
						}else{
							$appname = $appmodule['nickname'];
							if(isset($appmodule_config['teacher'][$appmodule['modulecode']])){
								$appurl = 'http://wap.ebh.net'. $appmodule_config['teacher'][$appmodule['modulecode']];
							}else{
								$appurl = 'http://'.$roomInfo->domain.'.ebh.net/proxy/wap/load?code='.$appmodule['modulecode'];
							}
						}

						if(!empty($appname) && !empty($appurl) && $appurl != 'http://wap.ebh.net' && $appmodule['ismore']==0){
					?>
					<li class="mui-table-view-cell">
						<a class="mui-navigate-right" href="<?=$appurl?>">
							<?=$appmodule['nickname']?>
						</a>
					</li>
					<?php } }?>
					<?php } ?>
				</ul>
				
				<p style="margin:15px;">
					<a id="jb_button" type="button" class="mui-btn mui-btn-danger mui-btn-block" style="padding: 5px 20px;" href="http://wap.ebh.net/logout.html" >安全退出</a>
				</p>
			</div>
		</div>
	</aside>
<?php } ?>