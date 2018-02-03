<?php
$this->display('admin/header');
?>
<style type="text/css">
.mr10 {
	margin-right: 10px;
	width: 100px;
    line-height: 30px;
    background: #fff;
    text-align: center;
    font-weight: 400;
    font-family: 'Lato', sans-serif;
    cursor: pointer;
    display: inline-block;
    border: 1px solid #FFAC30;
    border-radius: 4px;
    box-shadow: 0 -1px 0 #e0e0e0 inset, 0 1px 2px rgba(0, 0, 0, 0.23) inset;
}
.del {
	cursor: pointer;
	margin-right: 10px;
}
#b,#m,#s{
	line-height: 47px;
}
</style>
<body id="main">
<form method="post" action="/admin/spitem/add.html" onsubmit="return $(this).form('validate')" id="itemform">
<table cellspacing="0" cellpadding="0" width="100%"  class="maintable">
<tr>
	<th>一级分类</th>
	<td><?php if(!empty($bsid)){?>
		<select id="bsid" onchange="getNextSort(this.value,'msid');showSort(this.value, this, '#b');">
		<option selected = "selected" value="0">请选择</option>
		<?php foreach($bsid as $key=>$value){?>
			<option value="<?php echo $value['sid']?>"><?php echo $value['sname']?></option>
		<?php }?>
		</select>
		<?php } else {?>
			<select id="bsid" onchange="getNextSort(this.value,'msid');showSort(this.value, this, '#b');">
			<option selected = "selected" value="0">请选择</option>
		<?php }?>	
	</td>
	
</tr>
<tr>
	<th>二级分类</th>
	<td>
		<select id="msid" onchange="getNextSort(this.value,'ssid');showSort(this.value, this, '#m');">
		</select>
	</td>	
	
</tr>
<tr>
	<th>三级分类</th>
	<td>
		<select id="ssid" onchange="getLabel();showSort(this.value, this, '#s');">
		</select>
	</td>	
</tr>
<tr>
	<th>分类列表</th>
	<td>
		<div id="b">
		一级分类：
			<span></span>
		</div>
		<div id="m">
		二级分类：
			<span></span>
		</div>
		<div id="s">
		三级分类：
			<span></span>
		</div>
	</td>
	
</tr>
<tr>
	<th>标签列表</th>
	<td>
		<label id="label">
			<span></span>
		</label>
	</td>
	
</tr>
<tr>
	<th>添加标签</th>
	<td>
		<input type="text" name="label" id="labell" /><input type="button" value="添加" onclick="addlabel()"/>
	</td>
	
</tr>
</table>
<div class="buttons">
<input type="reset" id='valuereset' name="valuereset" value="重置" onclick="hide()" />

</div>
<div id="dialog"></div>
</form>  
</body>
<script type="text/javascript">
	function getNextSort(sid,sorttype){
		if(sid == 0){
			return false;
		}else{
			var sort = '#'+sorttype;
			$.ajax({
			type:'post',
			url:'/admin/jingpin/getsortAjax.html',
			data:{sid:sid,sorttype:sorttype},
			success:function(data){	
				var data = eval('('+data+')');
				$(sort+' option').remove('');
				$(sort).append('<option selected = "selected" value="0">请选择</option>');
				$.each(data,function(i,item){
					$(sort).append('<option value="'+item.sid+'">'+item.sname+'</option>');
				})
			}
		});
		}		
	}

	function getLabel(){
		var sid = $('#ssid').val();
		if(sid ==0){
			return false;
		}else{
			$.ajax({
				type:'post',
				url:'/admin/jingpin/getLabelAjax.html',
				data:{sid:sid},
				success:function(data){
					var data = eval('('+data+')');
					$('#label span').remove('');
					$.each(data,function(i,label){
						$('#label').append('<span onclick="editMess(' + label.id + ',\'editlabel\'' + ',this' + ')" class="mr10">' + label.label + '</span>');
						$('#label').append('<span onclick="checkHasItem(' + label.id  + ',\'editlabel\'' + ',this' + ')" class="del">' + '删除' + '</span>');
					})
				}
			});
		}
	}

	arr = [];
	if (!Array.indexOf) {
   		Array.prototype.indexOf = function(obj){
        for(var i=0; i<this.length; i++){
            if(this[i]==obj){
                return i;
            }
        }
        return -1;
   		}
	}

	function showSort(id, obj, tag) {
		var sort = $(obj).find("option:selected").text();
		if (sort !== '请选择' && arr.indexOf(sort) < 0) {
			$(tag).append('<span onclick="editMess(' + id + ',\'editsort\'' + ',this' + ')" class="mr10">' + sort + '</span>');
			$(tag).append('<span onclick="checkHasItem(' + id  + ',\'editsort\'' +  ',this' +')" class="del">' + '删除' + '</span>');
		}
		arr.push(sort);
	}

	function addlabel() {
		var sid = $('#ssid').val();
		var label = document.getElementById("labell").value;
		if(sid == null) {
			alert('请填写三级分类');return false;
		}
		if(!label) {
			alert('请填写标签名');return false;
		}
		$.ajax({
				type:'post',
				url:'/admin/jingpin/addlabelAjax.html',
				data:{sid:sid,label:label},
				success:function(data){
					if(data){
						var data = eval('('+data+')');
						if(data == 0) {
							alert("该分类下标签名已存在");
							return false;
						} 
						$('#label').append('<span onclick="editMess(' + data + ',\'editlabel\'' + ',this' +')" class="mr10">'+label+'</span>');
						$('#label').append('<span onclick="checkHasItem(' + data  + ',\'editlabel\'' + ',this' + ')" class="del">' + '删除' + '</span>');
						alert('添加成功');
						$('#labell').focus();
					}else{
						alert('添加失败，请重试..');
					}
				}
			});

	}

	function checkHasItem(id, act, obj) {
		if (act !== 'editlabel') {
			var sortlevel = obj.parentNode.id;
			$.ajax({
	            type: "POST",
	            url: "/admin/jingpin/checkHasItem.html",
	            data: {
	                sid:id,
	                level:sortlevel
	            },
	            dataType: "json",
	            success: function(data) {
	                if(data.hasbuy == 1){
	                 	 var mess = '该分类下还有课程，而且已经有人报名，不能被删除！！！';
	                 	 alert(mess);
	                 	 return false;
	                    }
	                else if(data.nobuy == 1){
	                   	 var mess = '该分类下还有课程，没人报名，确定要删除！！！？';
	                } else {
	                	var mess = '该分类下没有课程，确定要删除？';
	                }
	                if(confirm(mess)) {
	                 	del(id, act, obj);
	                 }
	                 return data;
	            },
	            error: function(jqXHR){     
	               alert("发生错误：" + jqXHR.status); 
	               return false; 
	            }    
			                    
			});
		} else {
			var ssid = $('#ssid').val();
			var label = $(obj).prev().html();
			$.ajax({
	            type: "POST",
	            url: "/admin/jingpin/checkHasItem.html",
	            data: {
	                label:label,
	                id:id,
	                sid:ssid
	            },
	            dataType: "json",
	            success: function(data) {
	                if(data == 1){
	                 	var mess = '该标签下还有课程，情请慎重！！！，确定要删除？';
		                 	if(confirm(mess)) {
		                 	del(id, act, obj);
		                	 }
	                    }
	                else{
	                   	var mess = '该标签下无课程，确定要删除？';
	                   		if(confirm(mess)) {
	                 			del(id, 'delNoitemsLabel', obj);
	                 		}
	                    }
	                 
	            },
	            error: function(jqXHR){     
	               alert("发生错误：" + jqXHR.status); 
	               return false; 
	            }    
			                    
			});
		}
	}

	function del(id, act, obj) {
		var labelname = $(obj).prev().html();
		var sortlevel = obj.parentNode.id;
		var ssid = $('#ssid').val();
        $.ajax({
            type: "POST",
            url: "/admin/jingpin/" + act + ".html",
            data: {
                label:'',
                labelname:labelname,
                level:sortlevel,
                id:id,
                sid:ssid
            },
            dataType: "json",
            success: function(data) {
                if(data.success){
                    var b = $(obj).prev();
                    b.remove();
                    $(obj).remove();
                    if (act == 'editsort')
       					window.location.reload();
                    alert("已删除");
                    }
                else{
                    alert(data.msg);
                    }
            },
            error: function(jqXHR){     
               alert("发生错误：" + jqXHR.status);  
            }    
            
        });
	}

	function editMess(id,act,obj){ 
        var tag = obj.firstChild.tagName;
        //console.log(tag);
        if (typeof(tag) != "undefined" && tag.toLowerCase() == "input") { 
         return;
        }
        var sid = $('#ssid').val();//sid 检验label是否重复
        var input = document.createElement("input");//
        input.value = obj.innerText||obj.textContent;
        input.setAttribute("id","creatinput");
        var org = obj.innerHTML;
        var c = input.value;
        obj.innerHTML = "";
        $(obj).append(input);
        input.focus();
        input.onblur = function(){             
            if(input.value == c||input.value == "") {
              obj.innerHTML = org;           
            } else{
                $.ajax({
                    type: "POST",
                    url: "/admin/jingpin/" + act + ".html",
                    data: {
                        label:input.value, 
                        id:id,
                        sid:sid
                    },
                    dataType: "json",
                    success: function(data) {
                    	if(data == 0) {
                    		alert("修改值已存在。。。");
                    		return false;
                    	}
                    	if (obj.parentNode.id !== 'label') {
                    		var tagName = '#' + obj.parentNode.id + 'sid';
                    		$(tagName).find("option:selected").text(data.msg);
                    		arr.push(data.msg);
                    	}
                        if(data.success){
                            $(obj).html(data.msg);
                            	alert("已修改成功");
                            }
                        else{
                            alert(data.msg);
                            }
                    },
                    error: function(jqXHR){     
                       alert("发生错误：" + jqXHR.status);  
                    }    
                    
                });   
           }
        }

    }

	
	function showAdd(obj){
		$(obj).show();
	}
	
	function hide() {
		$('#showbsid').hide();
		$('#showmsid').hide();
		$('#showssid').hide();
		var b = "一级分类：<span></span>";
		var m = "二级分类：<span></span>";
		var s = "三级分类：<span></span>";
		$('#b').html(b);
		$('#m').html(m);
		$('#s').html(s);
		arr = [];
		$('#label').html('');

	}
</script>
<?php
$this->display('admin/footer');
?>