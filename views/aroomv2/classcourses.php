<?php $this->display('aroomv2/page_header')?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<style>
	.terwai {
    background-color: #fff;
    border: 1px solid #dedede;
    float: right;
    font-size: 14px;
    margin-right: 0;
    margin-top: 10px;
    min-height: 153px;
    padding: 0 10px 10px;
    width: 590px;
}
.terwai .ternei {
    background: transparent url("http://static.ebanhui.com/ebh/tpl/default/images/aroom/xiangtop0222.jpg") no-repeat scroll center top;
    margin-top: -9px;
    min-height: 13px;
    position: static;
    width: 590px;
}
.terlie {
    border-bottom: 1px dashed #cdcdcd;
    float: left;
    margin-bottom: 15px;
    padding-bottom: 15px;
    padding-top: 10px;
    width: 590px;
}
.xianquan {
    float: left;
    max-height: 290px;
    overflow-y: auto;
    width: 590px;
}
.xianquan li {
    float: left;
    height: 125px;
    line-height: 30px;
    overflow: hidden;
    width: 105px;
	margin-left:35px;
	margin-top:15px;
}
.xianquan li.first{
	margin-left:0;
}
.terlie li {
    background: #ffffff none repeat scroll 0 0;
    border: 1px solid #b2d9f0;
    display: block;
    float: left;
    font-size: 14px;
    height: 20px;
    line-height: 20px;
    margin-bottom: 7px;
    margin-right: 5px;
    padding-top: 3px;
    width: auto;
}
.terlie li a.labelnode {
    color: #0078b6;
    display: inline;
    float: left;
    height: 18px;
    line-height: 18px;
    padding: 0 7px;
    text-decoration: none;
    vertical-align: 4px;
}
.terlie li a.labeldel {
    float: left;
}
.terlie .mylabel a.labeldel img {
    background: transparent url("http://static.ebanhui.com/ebh/tpl/2012/images/closebg_01.png") no-repeat scroll 0 0;
    display: inline-block;
    height: 12px;
    margin: 3px 4px 2px 0;
    width: 12px;
}
.terlie .mylabelhover a.labeldel img {
    background: transparent url("http://static.ebanhui.com/ebh/tpl/2012/images/closebg_02.png") no-repeat scroll 0 0;
    display: inline-block;
    height: 12px;
    margin: 3px 4px 2px 0;
    width: 12px;
}
p.p1s{
	font-size:13px;
	color::#666;
	width:105px;
	text-align:center;	
	font-family:微软雅黑;
}
</style>
<body>
<div>
    <div class="ter_tit">
        当前位置 > 班级课程
    </div>
    <div class="kechengguanli"  style="width:788px;">
    	<div class="kechengguanli_top fr">
        	<ul>
            	<li class="fl "><a href="javascript:addclass()">创建班级</a></li>
            </ul>
        </div>
        <div class=" clear"></div>
        <div class="kechengguanli_bottom">
        	<table cellpadding="0" cellspacing="0" class="tables">
        		<tr class="first">
                	<td width="222">班级</td>
                	<td width="413">课程</td>
                	<td width="117">操作</td>
                </tr>
            	<?php if(!empty($classlist)){ ?>
            	<?php foreach ($classlist as $class){ ?>
               	<tr>
                	<td class="subject"><?=$class['classname']?></td>
                    <td><p style="width:329px;word-wrap: break-word;float:left;"><?=$class['sfname']?></p></td>
                    <td>
                        <a data-fids="<?=$class['sfids']?>" href="javascript:selectcourses(<?=$class['classid']?>,'<?=$class['sfids']?>')" class="selectcourses">选课</a>
                        <a data-fids="<?=$class['sfids']?>" href="javascript:clearcoursesw(<?=$class['classid']?>)" class="clearcourses">清空</a>
                    </td>
                </tr>
                <?php } ?>
                <?php } ?>
            </table>
        </div>
    </div>
</div>

<!--添加班级-->
<div id="dialogadd" style="display:none;height:90px">
<div class="addclass">
    <div class="mingcheng mt15" style="text-align:left;">
    	<span style="margin-left:15px;">班级名称：</span>
        <input id="class_add_classname" class="text input mt20" style="margin-top:0;" type="text" value="" x_hit="请输入班级名称"/>
        <p class="p3" id="addclassmsg" style="margin-left:45px; padding-left:45px !important;"></p>
    </div>
	<?php if(!in_array($roominfo['isschool'],array(1,2)) && !empty($roominfo['grade'])){?>
	<div class="xznj mt15" id="class_add_grade">
		<span style="display: inline;vertical-align: middle;float: left;padding-left: 16px;">年　　级：</span>
		<div style="width:70px; float:left;"><label style=" "><input style="width:26px;" type="radio" value="0" name="grade_add" checked=""/>不选</label></div>
		<?php if($roominfo['grade']==1){
				$gradearr = array('一年级','二年级','三年级','四年级','五年级','六年级');
				for($i=1;$i<7;$i++){
					if($i!=4)
						echo '<div style="width:70px; float:left;"><label style=" "><input style="width:26px;" type="radio" value="'.$i.'" name="grade_add" />'.$gradearr[$i-1].'</label></div>';
					else
						echo '<div style="width:70px; float:left;" class="pads"><label style=" "><input style="width:26px;" type="radio" value="'.$i.'" name="grade_add" />'.$gradearr[$i-1].'</label></div>';
				}
			}elseif($roominfo['grade']==7){
				$gradearr = array('初一','初二','初三');
				for($i=7;$i<10;$i++){
					echo '<div style="width:70px; float:left;"><label style=""><input style="width:26px;" type="radio" value="'.$i.'" name="grade_add" />'.$gradearr[$i-7].'</label></div>';
				}
			}elseif($roominfo['grade']==10){
				$gradearr = array('高一','高二','高三');
				for($i=10;$i<13;$i++){
					echo '<div style="width:70px; float:left;"><label style=" "><input style="width:26px;" type="radio" value="'.$i.'" name="grade_add" />'.$gradearr[$i-10].'</label></div>';
				}
			}
		?>
		
	</div>
	<?php }?>
</div>
</div>

<!--选择班级课程-->
<div id="selectcourses" class="terwai" style="display:none">
	<div class="ternei"></div>
	<input id="currentclassid" type="hidden" value="0">
	<span style="color:#0068b7;" id="choosettitle"></span>
	<div class="terlie" id="">
			<div id="nochoosecourses" style="display: none;">还未设置任何班级课程</div>
			<ul style="display: block;" id="choosetsimp"></ul>  
		</div>
		<div class="xiansuoyout" style="">
		<span style="float:left;margin-right:60px;line-height:22px;display: inherit;height:22px;"> 课程列表</span>
		<div style="height:26px;float:left;">
		<input type="text" style="width:180px;" value="输入课程名称" class="soutxt"/>
		<input type="button" value="搜 索" class="souhuang"/>
		</div>
		</div>
		<?php if ($roominfo['template'] == 'plate') { ?>
		<div class="xianquans">
			<ul id="choosetall">
				<!-- 本校课程 -->
				<?php if(!empty($folderlist)){ ?>
					<?php foreach ($folderlist as $key=>$fitem){
                        $img  = show_plate_course_cover($fitem['img']); ?>
						<li id="folderitem_<?=$fitem['folderid']?>" title="<?=$fitem['foldername']?>" >		                    
							<div class="fl" style="cursor:pointer;border:solid 1px #e3e3e3;"><img src="<?=empty($img) ? 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_129_77.jpg' : show_thumb($img, '129_77')?>" style="width:129px;height:77px;"></div>
							<p class="lsiret" >
								<label class="psrer" title="<?=$fitem['foldername']?>">
								<input type="checkbox" class="deraer" value="<?=$fitem['folderid']?>" style="cursor:pointer;"/>
								<?=shortstr($fitem['foldername'],12)?></label>
							</p>
		                </li>
		                <?php } ?>
                <?php }else{ ?>
                	<li class="first">暂无课程</li>
                <?php } ?>
			</ul>
		</div>
		<?php } else { ?>
		<div class="xianquan">
			<ul id="choosetall">
				<!-- 本校课程 -->
				<?php if(!empty($folderlist)){ ?>
					<?php foreach ($folderlist as $key=>$fitem){ ?>					
						 <li id="folderitem_<?=$fitem['folderid']?>" title="<?=$fitem['foldername']?>" >
							<input type="checkbox" class="fl mt40" value="<?=$fitem['folderid']?>" style="cursor:pointer;"/>
							<label style="margin-left:4px;_margin-left:2px;">
									<div class="fl ml10" style="cursor:pointer;"><img src="<?=empty($fitem['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' : $fitem['img']?>" style="width:57px;height:80px; padding-right:5px;"></div>                                
								<div class="clear"></div>
								<p class="p1s" style="cursor:pointer;"><?=shortstr($fitem['foldername'],12)?></p>
							</label>
						</li>
					<?php } ?>		                
				<?php }else{ ?>
						<li class="first">暂无课程</li>
				<?php } ?>
			</ul>
		</div>
<?php } ?>
</div>
<script language="javascript">
function closedialog(id){
	H.get('dialog'+id).exec('close');
}
function addclass(){
	var _xform = new xForm({
			domid:'dialogadd',
			errorcss:'cuotic',
			okcss:'zhengtic',
			showokmsg:false
		});
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			saveadd();
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			closedialog('add');
			return false;
		}
	});
	if(!H.get('dialogadd')){
		H.create(new P({
			id : 'dialogadd',
			title: '添加班级',
			easy:true,
			width:400,
			padding:5,
			content:$('#dialogadd')[0],
			button:button
		}),'common');
	}
	$('#class_add_classname').next('em').remove();
	H.get('dialogadd').exec('show');
}
function checkclassname(type){
	classerr = 0;
	var tclassname = $.trim($('#class_'+type+'_classname').val());
	$('#class_'+type+'_classname').next('em').remove();
	if(tclassname==''){
		$('#'+type+'classmsg').attr('class','emacuo p3');
		$('#'+type+'classmsg').html('<font color="red">班级名称不能为空</font>');
		// $('#class_'+type+'_classname').after('<em class="emacuo"><font color="red">班级名称不能为空</font></em>');
		classerr = 1;
		return false;
	}else{
		if (tclassname.length>15) {
			$('#'+type+'classmsg').attr('class','emacuo p3');
			$('#'+type+'classmsg').html('<font color="red">班级名称太长，应该为15个字符以内!</font>');
			// $('#class_'+type+'_classname').after('<em class="emacuo"><font color="red">班级名称太长，应该为15个字符以内!</font></em>');
			classerr = 1;
			return false;
		}
		else{
			$('#'+type+'classmsg').html(' ');
		}
	}
	if(!(type=='edit' && _tclassname==tclassname)){
	$.ajax({
		type:"POST",
		dataType:"JSON",
		url: "<?=geturl('aroomv2/classes/classnameexists')?>",
		data:{'classname':tclassname},
		async:false,
		success: function(data){
			if(data == 1) {
				$('#'+type+'classmsg').attr('class','emacuo p3');
				$('#'+type+'classmsg').html('<font color="red">班级已存在!</font>');
				classerr = 1;
			} else {
				classerr = 0;
				$('#'+type+'classmsg').html(' ');
			}
		}
	});
	}
	if(classerr)
		return false;
	return true;
}
function saveadd(){
	var classname = $('#class_add_classname').val();
	if(classname == '请输入班级名称'){
		$('#class_add_classname').focus();
		return;
	}
	var grade= $('#class_add_grade input[type=radio]:checked').val();
	if(!checkclassname('add')){
		return;
	}
	$.ajax({
		type:'post',
		url:'<?=geturl('aroomv2/classes/add')?>',
		dataType:'text',
		data:{'classname':classname,'grade':grade},
		success:function(data){
			dialogtip();
			if(data==1){
				H.get('xtips').exec('setContent','添加成功').exec('show').exec('close',500);
			}else{
				H.get('xtips').exec('setContent','添加失败').exec('show').exec('close',500);
			}
				
		}
	});
}
function dialogtip(){
	if(!H.get('xtips')){
		H.create(new P({
			id:'xtips',
			easy:true,
			padding:10
		},{
			onclose:function(){
				location.reload(true);
			}
		}),'common');
	}
}
//保存班级课程
function savecourses(){
	var classid = parseInt($('#currentclassid').val()),
		folderids = [];
	$('#choosetsimp li').each(function(index){
		folderids.push($(this).attr('folderid'));
	})
	if(classid <=0){
		alert('参数错误！');
		return false;
	}
	$.post('/aroomv2/classcourses/savefolder.html',{classid:classid,folderids:folderids},function(data){
		dialogtip();
		if(data.code==0){
			H.get('xtips').exec('setContent','保存成功').exec('show').exec('close',500);
		}else{
			H.get('xtips').exec('setContent','保存失败').exec('show').exec('close',500);
		}
	},'json');
}

//选课课程弹框
function selectcourses(classid,sfid){
	$('.soutxt').val('输入课程名称');
	$('#choosetall li').show();
	$('#currentclassid').val(classid);
	$('#choosetall li input').prop('checked',false);
	$('#nochoosecourses').hide();
	
	var sarr = [];
	var shtm = '';
	if(sfid != ''){
		sarr = sfid.split(',');
	}
	if(sarr.length >0){
		for(var i=0;i<sarr.length;i++){
			var folderid = sarr[i],
				foldername = $('#folderitem_'+folderid).attr('title');
			
			shtm += '<li class="mylabel" folderid="'+folderid+'">';
			shtm += '<a href="javascript:;" class="labelnode">'+foldername+'</a>';
			shtm += '<a href="javascript:void(0)" class="labeldel" folderid="'+folderid+'">';
			shtm += '<img src="http://static.ebanhui.com/ebh/tpl/2012/images/transparent.gif"></a></li>';
			$('#folderitem_'+folderid).find('input').prop('checked',true);
		}
	}
	if(shtm == ''){
		$('#nochoosecourses').show();
	}
	$('#choosetsimp').html(shtm);
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			savecourses();
			return false;
		},
		autofocus:true
	});
	button.add({
		value:"取消",
		callback:function(){
			closedialog('courses');
			return false;
		}
	});
	if(!H.get('dialogcourses')){
		H.create(new P({
			id : 'dialogcourses',
			title: '选择课程',
			easy:true,
			content:$('#selectcourses')[0],
			button:button
		}),'common');
	}
	H.get('dialogcourses').exec('show');
}
//选择课程列表下的课程至选择课程下
function selectcoursesitem(folderid,foldername,checked){
	$('#nochoosecourses').hide();
	if(!checked){
		$('#choosetsimp li[folderid='+folderid+']').remove();
		return false;
	}
	var html = '<li class="mylabel" folderid="'+folderid+'">';
		html += '<a href="javascript:;" class="labelnode">'+foldername+'</a>';
		html += '<a href="javascript:void(0)" class="labeldel" folderid="'+folderid+'"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/transparent.gif"></a>'
    	html += '</li>';
    var ibool = false;	//是否已存在标识	
	if($('#choosetsimp li').length == 0){
		$('#choosetsimp').html(html);
	}else{
		$('#choosetsimp li').each(function(index){
			if($(this).attr('folderid') == folderid){
				ibool = true;
				return false;	
			}
		})
		if(!ibool){
			$('#choosetsimp').append(html);
		}
	}
}

function clearcoursesw(classid){
	var button = new xButton();
	button.add({
		value:"确定",
		callback:function(){
			clearcourses(classid);
			return false;
		},
		autofocus:true
	});

	button.add({
		value:"取消",
		callback:function(){
			H.get('dialogdel').exec('close');
			return false;
		}
	});
	if(!H.get('dialogdel')){
		H.create(new P({
			id : 'dialogdel',
			title: '清空班级课程',
			easy:true,
			width:400,
			padding:5,
			content:'<div class="deletestudents"><div class="tishi"><span>是否确认清空班级课程？</span></div></div>',
			button:button
		}),'common');
	}
	H.get('dialogdel').exec('show');
}

//清空所选课程
function clearcourses(classid){
	$.post('/aroomv2/classcourses/clearall.html',{classid:classid},function(data){
		dialogtip();
		if(data.code==0){
			H.get('xtips').exec('setContent','清空成功').exec('show').exec('close',500);
		}else{
			H.get('xtips').exec('setContent','清空失败').exec('show').exec('close',500);
		}
	},'json');
}
//转义特殊字符
function escapestr(string) {  
    return string.replace(/(\\|\"|\n|\r|\t|\$|\*|\+)/g, "\\$1");  
}
//绑定课程列表相关事件
$(function(){
	$('.soutxt').on('focus',function(){
		if($.trim($(this).val()) == '输入课程名称'){
			$(this).val('');
		}
	})
	$('.soutxt').on('blur',function(){
		if($.trim($(this).val()) == ''){
			$(this).val('输入课程名称');
		}
	})
	$('.souhuang').on('click',function(){
		var q = escapestr($.trim($('.soutxt').val()));
		if(q == '输入课程名称'){
			$('#choosetall li').show();
			return false;
		}
		$('#choosetall li').each(function(index){
			var str = $(this).attr('title');
			try{
				var regexp = new RegExp(q,"g");
				var result = regexp.test(str);
			}catch(e){
				var result = false;
			}
			if(!result){
				$(this).hide();
			}else{
				$(this).show();
			}
		})
	});
	$('#choosetall label .fl,#choosetall label .p1s').on('click',function(e){
		var checked = $(this).parent().siblings('input').is(':checked');
		$(this).parent().siblings('input').prop('checked',!checked);
		var idstr = $(this).parent().parent().attr('id'),
			itemarr = idstr.split('_'),
			foldername = $(this).parent().parent().attr('title');
		selectcoursesitem(itemarr[1],foldername,!checked);
	})
	$('#choosetall li input').on('change',function(){
		var checked = $(this).is(':checked'),
			foldername = $(this).parent().attr('title'),
			folderid = $(this).val();
		selectcoursesitem(folderid,foldername,checked);
	})
	$(document).on('click','#choosetsimp .mylabel .labeldel',function(e){
		var folderid = $(this).attr('folderid');
		$(this).parent().remove();
		$('#folderitem_'+folderid).find('input').prop('checked',false);
	})
})
</script>