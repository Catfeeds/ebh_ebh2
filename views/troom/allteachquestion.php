<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
当前位置 > <a href="<?= geturl('troom/myask') ?>">学生答疑</a> > 所属问题</div>
<div class="lefrig">
<div class="workol">
	<div class="work_menuss">
		<ul>
			<li  class="workcurrent"><a href="<?= geturl('troom/myask/allteachquestion') ?>"><span>所属问题</span></a></li>
			<li><a href="<?= geturl('troom/myask') ?>"><span>全部问题</span></a></li>
			<li><a href="<?= geturl('troom/myask/myquestion') ?>"><span>我的问题</span></a></li>
			<li><a href="<?= geturl('troom/myask/myanswer') ?>"><span>我的回答</span></a></li>
			<li><a href="<?= geturl('troom/myask/myfavorit') ?>"><span>我的关注</span></a></li>
		</ul>
	</div>
<div class="annotate">
	<div class="tiezi_search" style="height:30px;">
			<label style="float:left;width:65px;">关键字：</label><input id="title" name="uname" type="text"  value="<?= $q ?>" style="width:300px;float:left;"/>

			<a  class="souhuang" id="ser">搜 索</a>
			<a style="color:#fff;margin-left: 20px;" class="questionbutton" href="javascript:addquestion('<?= $key ?>',<?= $crid ?>)">快速提问</a>
			<a class="questionbutton" style="color:#fff;margin-left: 10px;" href="<?= geturl('troom/myask/addquestion') ?>">提&nbsp;&nbsp;问</a>
			</div>
	</div>
			<div class="workdata">
				<table  width="100%" class="datatab">
			 	 <thead class="tabhead" >
			 	 <tr>
			  		<th width="43%">问题名称</th>
			    	<th width="17%">所属学科</th>
			    	<th width="10%">提问时间 </th>
			    	<th width="8%">回答数</th>
					<th width="22%">操作</th>
			  	</tr>
			  	</thead>
			
			  	<tbody>
                                <?php if(empty($asks)) { ?>
			  		<tr><td colspan="5" align="center">目前没有问题记录</td></tr>
                                <?php } else { ?>
                                        <?php foreach($asks as $akey=>$avalue) { ?>
				 		<tr>
				 			<td width="43%"><span style="width:280px;float:left;word-wrap: break-word;"><?= $avalue['title'] ?></span></td>
					  		<td width="17%"><?= $avalue['foldername'] ?></td>
					    	<td width="10%"><?= date('Y-m-d H:i:s',$avalue['dateline']) ?></td>
					    	<td width="8%"><?= $avalue['answercount'] ?></td>

                                                <?php if(empty($avalue['hasbest'])) { ?>
					    	<td width="22%"><a class="previewBtn" href="<?= geturl('troom/myask/'.$avalue['qid']) ?>">查看问题</a><a class="quxiaobutton" style="color: #8e8d8d;text-decoration: none;margin-left: 5px;" onclick="delask(<?= $avalue['qid'] ?>,'<?= $avalue['title'] ?>');" href="javascript:;">删除</a></td>
                                                <?php } else { ?>
							<td width="22%"><a class="previewBtn" href="<?= geturl('troom/myask/'.$avalue['qid']) ?>">查看详情</a><a class="quxiaobutton" style="color: #8e8d8d;text-decoration: none;margin-left: 5px;" href="javascript:delask(<?= $avalue['qid'] ?>,'<?= $avalue['title'] ?>');">删除</a></td>

                                                <?php } ?>
				    	</tr>
                                        <?php } ?>

                                <?php } ?>

			  	</tbody>
				</table>
				
			</div>
                        <?= $pagestr ?>
</div>
</div>
<script type="text/javascript">
var searchtext = "请输入关键字";
$(function() {
initsearch("title",searchtext);
   $("#ser").click(function(){
       var title = $("#title").val();
       if(title == searchtext) 
           title = "";
       var url = '<?= geturl('troom/myask/allteachquestion') ?>' + '?q='+title;
       document.location.href = url;
   });
   });
function delask(qid,title) {
    var url = '<?= geturl('troom/myask/delask') ?>';
    var successurl = '<?= geturl('troom/myask/myquestion') ?>';
	$.confirm("您确定要删除问题 【" + title + "】 吗？",function(){
		$.ajax({
			url:url,
			type:'post',
			data:{'qid':qid},
			dataType:'text',
			success:function(data){
				if(data=='success'){
					$.showmessage({message:'问题删除成功！'});
					document.location.href = successurl;
				}else{
					$.showmessage({message:'对不起，问题删除失败，请稍后再试！'});
				}
			}
		});
	});
}
</script>
<?php 
$this->display('common/player'); 
$this->display('troom/page_footer'); 
?>