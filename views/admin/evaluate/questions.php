<?php $this->display('admin/header');?>
<style>
.pagination-info{
	float:left;
	padding-left:50px;
}
.itspan{
	padding-left:200px;
}
.itspan a{
	font-size:26px;
	font-weigth:bold;
	width:30px;
	text-decoration:none;
}
.ittable{
	margin-top:20px;
}
.ithr {
	border:1px solid #ccc;
}
.ithr li{
	list-style-type:none;
}
.itemnum{
	margin-left:10px;
	margin-right:10px;
	width:50px;
}
.btnbg{
	background:#ccc;
}
.trbg{
	background:#63B8FF;
}
.edittrbg{
	background:#EE82EE;
}
</style>
<body id="main">
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>量表管理</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td  class="active"><a href="javascript:;">所有量表</a></td>
			<td ><a href="/admin/evaluate/add.html" class="add">添加量表</a></td>
			
			</tr>
			</table>
		</td>
	</tr>
</table>
		
    <div id="toolbar">
	<table cellspacing="0" cellpadding="0" class="toptable">
		<tr>
		<td>
		<label>请先选择要所属量表: </label>
		<select name="eid" onchange="selfunc()">
		<option value="0">请选择量表</option>
		<?php if($evaluates){foreach($evaluates as $eval){?>
		<option value="<?=$eval['eid']?>"
	
		 <?=($eval['eid']==$row['eid'])?"selected='selcted'":""?> ><?=$eval['title']?></option>
		<?php }}?>
		</select>
		<span style="color:red"> *</span>
		<span class="l-btn-empty pagination-load" onclick="location.reload()" style="display: inline-block;margin: 0;padding: 0;width: 16px;cursor:pointer">&nbsp;</span>
		
		<span style="display:block"><e style="background:#63B8FF;height:50px;width:100px;">&nbsp;&nbsp;&nbsp;</e>淡蓝色:标识新添加的问题,没有保存,如需保存,请保存</span>
		<span style="display:block"><e style="background:#EE82EE;height:50px;width:100px;">&nbsp;&nbsp;&nbsp;</e>紫色:标识修改的问题,没有保存,如需保存,请保存</span>
		</td>
		</tr>
	</table>
	</div>
	<?php if(!empty($row)){?>
    <table  cellspacing="0" cellpadding="0" style="width:80%;margin-left:10px"   class="listtable">
		<tbody class="reviewtbody">
			<tr>
			<th width="6%">选择</th>
			<th>问题列表</th>
			<th width="10%">操作</th>
			</tr>
			<?php if($questions){$i=1;foreach($questions as $question){?>
			<tr>
			<td><input type="checkbox"  name="qid[]" value="<?=$question['qid']?>" />问题 <span class="qnum"><?=$i?></span>.</td>
			<td>问题标题: <input type="text" name="qtitle[]" value="<?=$question['qtitle']?>" class="w300" /> 
				排序: <input type="text" name="sort[]" value="<?=$question['sort']?>" /><br />
				<ul class="ithr">
				<?php 
				$qitemarr = unserialize($question['qitemstr']);
				$k=1;
				foreach($qitemarr as $qitem){?>
					<li>
					备选项<span class="itemnum"><?=$k?></span>: <input type="text" name="item[]" value="<?=$qitem['item']?>" class="w150" /> 
					分值: <input type="text" value="<?=$qitem['iscore']?>" name="iscore[]" />
					<?php if($k==1){?>
					<span class="itspan"><a href="javascript:;" class="itemadd">+</a></span>
					<?php }else{?>
					<span class="itspan"><a href="javascript:;" class="itemdel">-</a></span>
					<?php }?>
					
					</li>
					<?php $k++;}?>
				</ul>
			</td>
			<td>
			<a href="javascript:;" class="qsave">[保存]</a>
			<a href="javascript:;" class="qadd">[追加]</a> 
			<a href="javascript:;" class="qdel">[删除]</a>
			</td>
			</tr>
			<?php $i++;}}else{?>
			<tr>
			<td><input type="checkbox" name="qid[]" value="0" autocomplete="off" />问题 <span class="qnum">1</span>.</td>
			<td>问题标题: <input type="text" name="qtitle[]" value="" class="w300" autocomplete="off" /> 
				排序: <input type="text" name="sort[]" value=""  autocomplete="off" /><br />
				<ul class="ithr">
					<?php if(!empty($row['itemstr'])){ $itemarr =unserialize($row['itemstr']); $k=1;foreach($itemarr as $item){?>
						<li>
						备选项<span class="itemnum"><?=$k?></span>: <input type="text" name="item[]" value="<?=$item['item']?>" class="w150" /> 
						分值: <input type="text" value="<?=$item['score']?>" name="iscore[]" />
						<?php if($k==1){?>
						<span class="itspan"><a href="javascript:;" class="itemadd">+</a></span>
						<?php }else{?>
						<span class="itspan"><a href="javascript:;" class="itemdel">-</a></span>
						<?php }?>
						</li>
					<?php $k++;}}else{?>
						<li>
						备选项<span class="itemnum">1</span>: <input type="text" name="item[]" value="" class="w150" /> 
						分值: <input type="text" value="" name="iscore[]" />
						<span class="itspan"><a href="javascript:;" class="itemadd">+</a></span>
						</li>
					<?php }?>
				</ul>
			</td>
			<td>
			<a href="javascript:;" class="qsave">[保存]</a>
			<a href="javascript:;" class="qadd">[追加]</a> 
			<a href="javascript:;" class="qdel">[删除]</a>
			</td>
			</tr>
			<?php }?>

		</tbody>
	</table>	
	<?php }else{?>
	<span style="margin-left:100px;color:red;">请先选择所属量表!</span>
	<?php }?>


<script type="text/javascript">
function selfunc(){
	var eid = $("select[name=eid]").val();
	if(eid>0){
		location.href= "<?=geturl('admin/questions')?>?eid="+eid;
	}
}

$(function(){
	//添加备选项
	$(document).on("click",".itemadd",function(){
		var parul = $(this).parent().parent().parent();
		var ptr =$(parul).parent().parent();
		var len = $(parul).find("li").length;
		var lis = $(parul).find("li:first").clone();
		var qid = $(ptr).find(":checkbox").val();
		
		//清空表单
		$(lis).find(":input").val(""); 
		
		$(lis).find(".itemnum").html((len+1));
		$(lis).find(".itspan").html('<a href="javascript:;" class="itemdel">-</a>');
		$(parul).append(lis);
		//切换按钮
		changesave($(ptr).find(".qsave"),'save');
		//切换背景颜色
		if(qid>0){
			$(ptr).addClass('edittrbg');
		}

	});
	//删除备选项
	$(document).on("click",".itemdel",function(){
		if(delconfirm()==false) 
			return false;
		var parli = $(this).parent().parent();
		var parul = $(parli).parent();
		var ptr =$(parul).parent().parent();
		var qid = $(ptr).find(":checkbox").val();
		$(parli).remove();
		resetitemnum(parul);
		//切换按钮
		changesave($(ptr).find(".qsave"),'save');
		//切换背景颜色
		if(qid>0){
			$(ptr).addClass('edittrbg');
		}
	  });

	//问题追加
	$(document).on("click",".qadd",function(){
		var len = $(".reviewtbody>tr").length;
		var trs = $(".reviewtbody>tr:nth-child(2)").clone();
		//清空表单 清空克隆行的数据
		var nums = '<?=$row['nums']?>';
		if(nums>0){
			$(trs).find("input[name^=qid]").val(""); 
			$(trs).find("input[name^=qtitle]").val(""); 
			$(trs).find("input[name^=sort]").val(""); 
		}else{
			$(trs).find(":input").val(""); 
			}
		
		
		//增加背景
		$(trs).addClass('trbg');
		$(trs).removeClass('edittrbg');
		changesave($(trs).find(".qsave"),"save");
		$(trs).find(".qnum").html(len);
		$(".reviewtbody").append(trs);
		}); 
	//问题删除
	$(document).on("click",".qdel",function(){
		var len =$(".reviewtbody>tr").length;
		var ptr = $(this).parent().parent();
		var qid = $(ptr).find(":checkbox").val();
		if(len<=2){
			return false;
			}
		if(delconfirm()==false) 
			return false;

		if(qid>0){
			//删除一条记录
			$.post("<?=geturl("admin/questions/delone")?>",{qid:qid},function(json){
				if(json.code){
					alert('成功删除一条记录');
					$(ptr).remove();
					resetqnum();
					}else{
						alert('删除失败');
						return false;
						}
				},'json');
			}else{
				$(ptr).remove();
				resetqnum();
				}
		}); 
	//问题保存
	$(document).on("click",".qsave",function(){
		var obj = $(this);
		var ptr = $(this).parent().parent();
		var qtitle =$(ptr).find("input[name^=qtitle]").val();
		var sort = $(ptr).find("input[name^=sort]").val();
		var eid = $("select[name=eid]").val();
		var qid = $(ptr).find(":checkbox").val();
		var itemarr = new Array();
		var checkitem = false;
		
		$(ptr).find('.ithr>li').each(function(k,v){
			var item = $(v).find("input[name^=item]").val();
			var iscore = $(v).find("input[name^=iscore]").val();
			if(item!=''||iscore!=''){
				itemarr.push({'item':item,'iscore':iscore});
				checkitem = true;
			}else{
				checkitem = false;
				return false;
				}
				
			});

		//问题检测
		if($.trim(qtitle)==''){
			alert('请输入问题标题');
			return false;
			}
		if(!checkitem){
			alert('请输入备选项');
			return false;
			}
		$.post("<?=geturl('admin/questions/addone')?>",{qid:qid,qtitle:qtitle,sort:sort,eid:eid,itemarr:itemarr},function(json){
			if(json.code){
				alert('保存成功');
				changesave(obj,'hassave');
				if(!(qid>0)){
					//添加成功后
					$(ptr).find(":checkbox").attr("value",json.qid);
					$(ptr).removeClass('trbg');
				}else{
					//编辑成功后
					$(ptr).removeClass('edittrbg');
					}
				}else{
					alert('保存失败');
					return false;
					}
			},'json');
	});
});

//重置排序问题序号
function resetqnum(){
	$(".qnum").each(function(k,v){
		$(this).html((k+1));
		});
}
//重置排序备选项序号
function resetitemnum(obj){
	$(obj).find(".itemnum").each(function(k,v){
		//console.log(v);
		$(this).html((k+1));
		});
}

//删除确认
function delconfirm(){
	if(!confirm('确定要删除该项吗?')){
		return false;
	}else{
		return true;
		}
}
//已保存/保存按钮切换
function changesave(obj,b){
	b = typeof(b) == 'undefined' ? "hassave" : b; 
	if(b=='hassave'){
		$(obj).addClass("btnbg");
		$(obj).html("[已保存]");
	}else{
		$(obj).removeClass("btnbg");
		$(obj).html("[保存]");	
	}
}
</script> 
</body>
<?php
$this->display('admin/footer');
?>