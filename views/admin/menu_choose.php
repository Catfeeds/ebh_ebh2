<form id="ck">
    <table cellspacing="0" cellpadding="0" class="toptable"><tr><td>
    <label>关键字: </label><input type="text" name="q" id="searchkey" value="" size="20" />
    <span>
    <input type="button" onclick="return _search()" value="搜索"/>
		选择网校类型:
			<select name="roomtypesel" id="roomtypesel" onChange="selectlevel(this.value)" style="width:60px">
				<option value="0">教育版</option>
				<option value="1">企业版</option>
			</select>
		</select>
		<label>选择一级菜单:</label><select id="toplevel" name="aid" style="width: 100px;" onchange="_search();">
		 	<option  value="0" >请选择</option>
		</select>
    </td></tr>
    </table>
</form>
<style type="text/css">
    .bgone{
        background: gray;
    }
</style>
<script type="text/javascript">
	 $.post("/admin/menu/choose.html",
	    {q:'',page:1,pagesize:10,roomtype:0},
	    function(message){
	            message = JSON.parse(message);
	            $('#pp').pagination('refresh',{total: message.count});
	             _render(message.menulist);
	            $(".pagination-num").parent().next().html('<span style="padding-right:6px;">页</span>');
				$(".pagination-last").hide();
	            $(".pagination-info").hide();
	    	}
	   );
   	$.post("/admin/menu/getListAjax.html",
	    {roomtype:0},
	    function(data){
	    	data = JSON.parse(data);
	    	var palname = $("#toplevel");
			var topmenulist = data.menulist;
				$.each(topmenulist,function(i,item){
					palname.append('<option value="'+item.mid+'">'+item.mtitle+'</option>');
					
				})
	    	}
	   );
    function _render(_data){
        $(".moduletbody").html('');
        $.each($(_data),function(k,v){
        		$(_renderRow(k,v)).appendTo(".moduletbody");
        });
    }
    function _renderRow(k,v){
        var row = ['<tr style="cursor:pointer" mid='+v.mid+' onclick="_getTInfo(this,\''+v.mtitle+'\',\''+v.url+'\')">'];
        row.push('<td>'+(v.pmtitle||'')+'</td>');
        row.push('<td>'+(v.mtitle||'')+'</td>');
        row.push('<td>'+(v.url||'')+'</td>');
        row.push('</tr>');
        return row.join('');
    }
</script>


<div style="margin-left:auto;margin-right:auto;width:100%">
<table align="center" border="1" cellspacing="0" cellpadding="0" class="listtable">
<tr>
<td>一级菜单</td>
<td>二级菜单</td>
<td>跳转地址</td>
</tr>
<tbody class='moduletbody'>
</tbody>
</table>
<div id="pp"></div>
<script type="text/javascript">
	function _search(){
		var Tmid = $('#toplevel').val();
	   $('#pp').pagination({pageNumber:1});
	   $(".pagination-page-list").trigger('change');
	   return false;
	}
	$('#pp').pagination({
	    pageSize:10,
	    onSelectPage:function(pageNumber, pageSize){
	        var query = $("#searchkey").val();
	        var roomType = $('#roomtypesel').val();
	        var Tmid = $('#toplevel').val();
	        $.post("/admin/menu/choose.html",
	            {q:query,page:pageNumber,pagesize:pageSize,tmid:Tmid,roomtype:roomType},
	            function(message){
		                message = JSON.parse(message);
		                $('#pp').pagination('refresh',{total: message.count});
		                 _render(message.menulist);
		                $(".pagination-num").parent().next().html('<span style="padding-right:6px;">页</span>');
						$(".pagination-last").hide();
		                $(".pagination-info").hide();
	            	}
	            );
	        return false;
	    }
	});
	function selectlevel(roomType){
		var palname = $("#toplevel");
		$('option',palname).remove('');
		palname.append('<option value="0">请选择</option>');
		$.ajax({
			type:"post",
			url:"/admin/menu/getListAjax.html",
			async:true,
			data:{roomtype:roomType},
			dataType:'json',
			success:function(data){
				var topmenulist = data.menulist;
					$.each(topmenulist,function(i,item){
						palname.append('<option value="'+item.mid+'">'+item.mtitle+'</option>');
						
					})
				_search()
			}
		});
	}
	function _getTInfo(e,mtitle,url){
	    $("input[name='mtitle']").val(mtitle);
	    $("input[name='url']").val(url);
		$("input[name='mtitle']").focus();
	    $('.panel-tool-close').trigger('click');
	}
</script>