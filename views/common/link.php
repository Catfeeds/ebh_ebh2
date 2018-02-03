<?php
$this->display('common/siteinfo_header');
?>
<?php
		$catlib = Ebh::app()->lib('Category');
		$roominfo = Ebh::app()->room->getcurroom();
		$thecat = $catlib->getCateByPos(2);
	 ?>
<div class="pageright">
	    <div class="pagetit"><img src="http://static.ebanhui.com/ebh/tpl/default/images/link.png"  /></div>
		<div class="pagecont">
			<div class="textlink">
			<h1>文字链接:</h1>
			<?php
				$itemlib = Ebh::app()->lib('Items');
				$itemlists = $itemlib->getitemslink();
			?>
				
				<?php foreach($itemlists as $itemv) { ?>
					<div class="linkbox"><a href="<?= $itemv['itemurl']?>" title="<?= $itemv['itemurl']?>" target="_blank"><?= $itemv['subject']?></a></div>
				<?php } ?>
				<br style="clear:both;height:0; overflow:hidden;" />
			</div>
			<div class="link">
			<h1>图片链接:</h1>
				<ul>
				
				</ul>
				<div style="clear:both;height:0; overflow:hidden;"></div>
			</div>
			<div class="link">
				<ul>
				
			
				</ul>
				<div style="clear:both"></div>
			</div>
			<div class="mylink">
				<h1>e板会logo</h1>
				<ul>
					<li>文字链接：<a href="http://www.ebanhui.com" target="_blank" title="e板会 全球领先的网络在线教育资源有偿分享模式平台">e板会</a></li>
					<li>图片链接：<a href="http://www.ebanhui.com" target="_blank" title="e板会 全球领先的网络在线教育资源有偿分享模式平台"><img align="middle" src="/static/tpl/default/images/logolink.png" alt="e板会 全球领先的网络在线教育资源有偿分享模式平台"/></a></li>
					<li>链接地址：<a href="http://www.ebanhui.com">http://www.ebanhui.com</a></li>
					
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="65"><li>链接示例：</li></td>
    <td><textarea cols=""  style=" width:520px;  color:#A7A7A7; line-height:22px; float:left; height:55px; border:1px solid #C4C4C4;" rows=""><a href="http://www.ebanhui.com" target="_blank" title="e板会"><img src="http://www.ebanhui.com/static/tpl/default/images/logolink.png" alt="e板会" ></a></textarea></td>
  </tr>
</table>
				<h1>申请链接</h1>
				<p>申请链接请发送至邮箱：<a href="mailto:support@ebanhui.com">support@ebanhui.com</a></p>
				<h1>链接要求</h1>
				<p>一、网站运行必须符合我国现行的法律与规定，无色情、淫秽、反党、反政府以及其他非法性质内容。<br />
				  二、网站拥有独立域名，流量稳定，具有忠实的访问人群。<br />
				  三、网站不得含有损坏注册表、修改浏览器等恶意代码。<br />
				  四、e板会对友情链接合作伙伴的选择有最终决定权。<br />
				</p>
				</ul>
			</div>
		</div>
	  </div>
	</div>
	<div class="pagebot"></div>
</div>
<?php
$this->display('common/siteinfo_footer');
?>