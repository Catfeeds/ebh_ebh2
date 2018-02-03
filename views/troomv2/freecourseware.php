<!--{eval $crid=$_SGLOBAL['crid']}-->
<!--{eval $folderid = $_SGET[attribarr][0]}-->
<!--{eval $cvalue = $_SGET[attribarr][1]}-->

<!--{if !empty($_SGET['attribarr'])}-->
	<!--{eval $isfree = $_SGET[attribarr][2]}-->
<!--{else}-->
	<!--{eval $isfree = 1}-->
<!--{/if}-->
<?php $this->display('troomv2/page_header')?>

<style type="text/css"> 
.select * { margin: 0; padding: 0; } 
.select { border:1px solid #cccccc; float: left; display: inline;font-size:14px; }
.select div { border:1px solid #f9f9f9; float: left; }
.select>div {height: 17px; overflow:hidden;} 
* html .select div select { display:block; float: left; margin: -2px; }
.select div>select { display:block; float:none; margin: -2px; padding: 1px; }
.select select>option { text-indent: 2px;} 
</style>
<div class="ter_tit">
<a href="#">当前位置</a> > <a href="<?=geturl('troomv2/subject')?>" >课程列表</a> > 免费课件
</div>
<div class="lefrig">
<div class="annotate"> 在此页面中,您可以把您的课件设置成免费,课件免费后,将在您的平台首页免费试听中显示这些课件,学生无需注册就可学习.</div>
<!--{block name="folder" parameter="cachename/folder/ttype/bycrid/crid/$crid/limit/0,1000/tpl/data"}-->
<!--{eval $sname[$folderid] ="selected='selected'"}-->
<!--{eval $sisfree[$isfree] ="selected='selected'"}-->
<?php $sname[$folderid] = "selected='selected'";
	$sisfree[$isfree] = "selected='selected'";
?>
<div class="annotate" style=" height: 22px;">

<span style="float:left;height:22px;line-height:22px;">所属课程：</span>
<div class="select"> <div> 
		<select name="cname" id="cname" style="width:240px;">
			<option value="">所有课程</option>
		<!--{loop $_SBLOCK['folder'] $fk $fv}-->
		<?php foreach($folderlist as $fl){?>
			<option value="<?=$fl['folderid']?>" <?=!empty($sname[$fl['folderid']])?$sname[$fl['folderid']]:''?>><?=$fl['foldername']?></option>
		<?php }?>
		<!--{/loop}-->
		</select>
</div> 
</div> 

	<span style="float:left;height:22px;line-height:22px;margin-left: 10px;">是否免费：</span>	
<div class="select"> <div> 
	<select name="isfree" id="isfree" style="width:auto;"><option value="">全部</option> <option value="1" <?=!empty($sisfree[1])?$sisfree[1]:''?> >免费</option><option value="0" <?=!empty($sisfree[0])?$sisfree[0]:''?>>收费</option></select>
 </div> </div> 
 
<span style="float:left;height:22px;line-height:22px;margin-left: 10px;">关键字：</span>
<input type="text" name="servalue"  onblur="if($('#servalue').val()==''){$('#servalue').val('请输入课件名称').css('color','#666');}" onfocus="if($('#servalue').val()=='请输入课件名称'){$('#servalue').val('').css('color','#000');}" id="servalue" <?php if(!empty($q)){?>value="<?=$q?>"<?php }else{?>value="请输入课件名称"<?php }?>  style="width: 130px;" class="shurulan" /> 

<a id="ser" class="souhuang" onclick="searchcour()">搜索</a>
</div>


<table width="100%" class="datatab">
			<tbody class="tabhead">
			<tr>
				<th>所属课程</th>
				<th>是否免费</th>
				<th>课件名称</th>
				<th>上传日期</th>
				<th colspan="3">修改操作</th>
			</tr>
			</tbody>
			
			<!--{eval $strsql =''}-->
			<!--{if !empty($folderid)}-->
				<!--{eval $strsql.="folderid/$folderid/"}-->
			<!--{/if}-->
			<!--{if !empty($cvalue)}-->
				<!--{eval $strsql.="title/$cvalue/"}-->
			<!--{/if}-->
			<!--{if !empty($isfree) || $isfree =='0'}-->
				<!--{eval $strsql.="isfree/$isfree/"}-->
			<!--{/if}-->
			<!--{if !empty($_SGET['attribarr'])}-->
			<!--{eval $strsql.='crid'}-->
				<!--{block name="classroom" parameter="cachename/classroom/ttype/roomcoursewares/status/0,1/$strsql/$crid/perpage/20/tpl/data/attrnum/0"}-->
			<!--{else}-->
				<!--{block name="classroom" parameter="cachename/classroom/ttype/roomcoursewares/isfree/1/status/0,1/crid/$crid/perpage/20/tpl/data/attrnum/0"}-->
			<!--{/if}-->
			<tbody>
			<!--{if !empty($_SBLOCK['classroom'])}-->
				<!--{loop $_SBLOCK['classroom'] $ck $cv}-->
				<!--{if $cv['isfree']==1}-->
			<?php if(!empty($cwlist)){
				foreach($cwlist as $cl){
				if($cl['isfree']==1){
			?>
				  <tr style="background-color:#F2F7FF" id="$cv['cwid']">
				<?php }else{
				?>
			  <!--{else}-->
				  <tr id="$cv['cwid']">
				<?php }
				?>
			  <!--{/if}-->
					<td style="width:140px;"><span style="line-height:1.8;float:left;"><?=$cl['foldername']?></span></td>
				    <td width="50px">
						<!--{if $cv['isfree']!=1}-->
						<?php if($cl['isfree']!=1){?>
						<em style="color:#EE2C2C" id="isf<?=$cl['cwid']?>">收费</em>
						<?php }else{?>
						<!--{else}-->
						<em style="color:#3366CC"  id="isf<?=$cl['cwid']?>">免费</em>
						<?php }?>
						<!--{/if}-->
				    </td>
					<?php $arr = explode('.',$cl['cwurl']);
							$type = $arr[count($arr)-1]; ?>
    				<td width="270px"><span style="line-height:1.8;float:left;"><a target="<?= (empty($cl['cwurl']) || $type == 'flv') ? '_blank' : '' ?>"  href="<?= (empty($cl['cwurl']) || $type == 'flv') ? geturl('troomv2/course/'.$cl['cwid']) : geturl('troomv2/classcourse/'.$cl['cwid']) ?>" ><?=$cl['title']?></a></span></td>
				    <td width="70px"><!--{eval echo  mydate('Y-m-d',$cv['dateline'])}--></td>

				    <td width="50px">
				    	<div class="fujian">
				    		<!--{if $cv[isfree]!=1}-->
							<?php if($cl['isfree']!=1){?>
					 			<input type="button" class="hongjinbtn" id="freebutton<?=$cl['cwid']?>" isfreet="1" onclick="isfree(<?=$cl['cwid']?>,this)" value="设为免费">
					 		<!--{else}-->
							<?php }else{?>
					 			<input type="button" class="previewBtn" id="freebutton<?=$cl['cwid']?>" isfreet="0" onclick="isfree(<?=$cl['cwid']?>,this)" value="取消免费">
							<?php }?>
					 		<!--{/if}-->
				    	</div>	
					</td>
				    
				  </tr>
				<?php }}else{?>
				<!--{/loop}-->
			  <!--{else}-->
		  		<tr>
		  			<td colspan="7" align="center" width="100%" >暂无记录</td>
		  		</tr>
				<?php }?>
			  <!--{/if}-->
		</tbody>
	</table>
	<?=$pagestr?>
<!--{eval echo $_SBLOCK[classroom_multipage]}-->
</div>
<script type="text/javascript">
function searchcour(){
	var folderid=$("#cname").val();
	var isfree=$("#isfree").val();
	var servalue = $("#servalue").val();

	if(servalue=='请输入课件名称'){
		servalue='';
	}
	
	servalue = replaceAll(servalue,'-','');
	servalue = replaceAll(servalue,"/",'');
	servalue = replaceAll(servalue,'\\','');
	servalue = replaceAll(servalue,'"','');
	servalue = replaceAll(servalue,'#','');
	servalue = replaceAll(servalue,'_','');
	servalue = replaceAll(servalue,'?','');
	servalue = replaceAll(servalue,'\'','');
	servalue = replaceAll(servalue,'%','');
	var url='<?=geturl('troomv2/subject/freecourseware-0-0-0-')?>';
	url = url+'?q='+servalue+'&isfree='+isfree+'&folderid='+folderid;
	window.location.href=url;
}


function isfree(cwid,isfreeobj){
		var isfree = $(isfreeobj).attr('isfreet');
		$.ajax({
			url:"<?=geturl('troomv2/subject/upisfree')?>?t="+Math.random(),
			type:'post',
			data:{'cwid':cwid,'isfree':isfree},
			dataType:'json',
			success:function(data){
				if(data.isfree=='1'){
					$("#"+cwid).css({ background: "#F2F7FF" });
					$("#freebutton"+cwid).val('取消免费');
					$("#freebutton"+cwid).css({background:"url('http://static.ebanhui.com/ebh/tpl/default/images/upload_accessory.jpg')"});
					$("#freebutton"+cwid).attr('isfreet','0');
					$("#isf"+cwid).html('免费');
					$("#isf"+cwid).css({color:"#3366CC"});
				}else{
					$("#"+cwid).css({ background: "" });
					$("#freebutton"+cwid).val('设为免费');
					$("#freebutton"+cwid).css({background:"url('http://static.ebanhui.com/ebh/tpl/default/images/worksearch_04.jpg')"});
					$("#freebutton"+cwid).attr('isfreet','1');
					$("#isf"+cwid).html('收费');
					$("#isf"+cwid).css({color:"#EE2C2C"});
				}
			}
		});
}


function replaceAll(str,find,rp){
	while(true){
		if(str.indexOf(find) == -1){
			break;
		}
		str = str.replace(find,rp);
	}
	return str;
}
</script>
<?php $this->display('troomv2/page_footer')?>