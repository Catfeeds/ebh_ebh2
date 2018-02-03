<?php $this->display('admin/header');?>
<body id="main"><table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>更新缓存</h1></td>
	</tr>
</table>
<div class="colorarea01">
<table cellspacing="2" cellpadding="2" class="helptable"><tr><td><ul>
<li>系统使用特有的数据缓存机制，来加快站点速度，降低数据库负载。</li>
<li>更新模块类型(频道/广告等)之前，请确保模块是最新的，如不确定，请先清空"文件缓存>模板缓存"。
<li>清空缓存后，会自动进行缓存重建工作，短时间内增加负载，因此请不要频繁进行此操作。</li>
</ul></td></tr></table></div><form method="post" action="/admin/cache/clean.html">
<table id="cachetable" class="maintable" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr id="tr_cachekind">
<th>站点缓存<p>将更新对应的模块缓存（根据当前使用的缓存模式自动清楚文件缓存和内存缓存）</p></th>
<td>
<table class="freetable">
<tbody><tr><td>
<input name="modulecatid[]" id="modulecatidcategory" value="category" type="checkbox"><label for="modulecatidcategory">频道 &nbsp;</label>
<input name="modulecatid[]" id="modulecatidmember" value="member" type="checkbox"><label for="modulecatidmember">会员 &nbsp;</label>
<input name="modulecatid[]" id="modulecatidad" value="ad" type="checkbox"><label for="modulecatidad">广告 &nbsp;</label>
<input name="modulecatid[]" id="modulecatiditem" value="item" type="checkbox"><label for="modulecatiditem">资讯 &nbsp;</label>
<input name="modulecatid[]" id="modulecatidpoll" value="poll" type="checkbox"><label for="modulecatidpoll">投票 &nbsp;</label>
<input name="modulecatid[]" id="modulecatidcourseware" value="courseware" type="checkbox"><label for="modulecatidcourseware">课件 &nbsp;</label>
<input name="modulecatid[]" id="modulecatidclassroom" value="classroom" type="checkbox"><label for="modulecatidclassroom">同步学堂和电子教室课件 &nbsp;</label>
<input name="modulecatid[]" id="modulecatidroomcourse" value="roomcourse" type="checkbox"><label for="modulecatidroomcourse">教室课件 &nbsp;</label>
<input name="modulecatid[]" id="modulecatidproduct" value="product" type="checkbox"><label for="modulecatidproduct">产品 &nbsp;</label>
<input name="modulecatid[]" id="modulecatidfolder" value="folder" type="checkbox"><label for="modulecatidfolder">课程大纲 &nbsp;</label>
<input name="modulecatid[]" id="modulecatidlog" value="log" type="checkbox"><label for="modulecatidlog">日志(评论)缓存 &nbsp;</label>
<input name="modulecatid[]" id="modulecatidresource" value="resource" type="checkbox"><label for="modulecatidresource">资源缓存 &nbsp;</label>
<input name="modulecatid[]" id="modulecatidspace" value="space" type="checkbox"><label for="modulecatidspace">原创空间 &nbsp;</label>
<input name="modulecatid[]" id="modulecatidportal" value="portal" type="checkbox"><label for="modulecatidportal">门户网站 &nbsp;</label>
<br class="clear">
</td></tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="buttons">
<input type="submit" name="cachesubmit" value="提交保存" class="submit">
<input type="reset"	 name="valuereset" value="重置">
<input type="hidden" name="token" value="<?=$token?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>">
</div>
</form>
<br><div id="footer"><span>Zhejiang Svnlan Technologies 2011. </span></div>
</body>
<?php $this->display('admin/footer'); ?>