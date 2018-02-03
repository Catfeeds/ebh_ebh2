<?php
$this->display('admin/header');
?>
<style>
.checkbox{
	width:20px;
	height:20px;
}
</style>
<body id="main">
	<form id="form_module" method="post" onsubmit="return $(this).form('validate')" action="<?php geturl('admin/appmodule/classroomedit');?>" >
	<label >所属平台</label>
        <input type="text" class="w300" readonly="readonly" value="<?=empty($roominfo)?'':$roominfo['crname']?>" id="crname" name="crname" required="true" >
        <input type="button" id="drop" value="选择" />
        <input type="button" id="clear" value="清除" />
		
		<input type="hidden" value="<?=empty($crid)?0:$crid?>" id="mediaid" name="crid"/>
		<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
			<?php foreach($modulelist as $module){
				$moduleid = $module['moduleid'];
				
				if(!empty($rmarr[$moduleid]) && !empty($rmarr[$moduleid]['available']) || !empty($module['system'])){
					$checkstr = 'checked="checked"';
				}
				else{
					$checkstr = '';
				}
				?>
			<tr>
			<th><?=$module['modulename']?><p><?=$module['url']?></p></th>
			<td>
                <input class="checkbox" type="checkbox" <?=$checkstr?> <?=empty($module['system'])?'':'disabled="true"'?>/>
				<input type="hidden" class="available" name="available[]" value="<?=empty($checkstr)?0:$module['moduleid']?>"/>
				<input type="hidden" class="moduleid" value="<?=$module['moduleid']?>"/>
				
			</td>
			</tr>
			<?php }?>
	</table>
	<div class="buttons">
		<input type="submit" value="提交保存" class="submit">
    </div>
</form>
	<div id="crwrap" style="display:none">
		<iframe id="cr" ></iframe>
	</div>
<script>
	$(function(){
		
	})
	
	$('.checkbox').click(function(){
			
		var moduleid = $(this)[0].checked ? $(this).nextAll('.moduleid').val() : 0;
		$(this).next('.available').val(moduleid);
	});
	
	$('#drop').click(function(){
       showcr();  
    });
	
	function showcr(){
        var url = '/admin/classroom/roomselect.html';
        var width = $(window).width();
        var height = $(window).height();
        $('#cr')
        .attr('width',width/5*3)
        .attr('height',height/5*3)
        .attr('src',url);
        $('#crwrap').show();
        $('#crwrap').dialog({    
            title: '请选择教室', 
            closed: false,    
            cache: false,   
            modal: true   
        });
        return false;
    }
	$('#clear').click(function(){
        $('#mediaid').val("");
        $('#crname').val("");
		
    }); 
    var closedialog = function (){
        $("#crwrap").dialog('close');
    }
	function _search(){
		location.href = '/admin/appmodule/classroomedit.html?crid='+$('#mediaid').val();
	}
	$('#crname').validatebox({
		required:true,
		validType: 'text',
		missingMessage:'请选择网校'
	});
	</script>
	<style>
		.fitem{
            margin-bottom:5px;
        }
        .fitem label{
            display:inline-block;
            width:80px;
        }
	</style>
</body>
<?php
$this->display('admin/footer');
?>