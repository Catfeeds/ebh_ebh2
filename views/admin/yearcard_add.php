<?php
$this->display('admin/header');
?>
<body>
<h1>添加年卡</h1>
        <form id="form_yearcard" method="post" novalidate action="<?php echo geturl('admin/yearcard/add');?>">
            <div class="fitem">
                <label>所属同步学堂</label>
				<select name="crid" id="crid" style="width:150px" >
                
				</select>
            </div>
            <div class="fitem">
				<label>时长</label>
                <select name="time">
                	<!-- <option value="36">三年</option>
                	<option value="24">二年</option> -->
					<option value="12">一年</option>
					<option value="6">半年</option>
				</select>
            </div>
            
			<div class="fitem">
                <label>生产数量</label>
                <input name="num" class="easyui-validatebox" value="10">
            </div>

            <div class="fitem">
                <label>年卡前缀</label>
                <input name="cardpre" class="easyui-validatebox" value="5A">
            </div>

            <div class="fitem">
                <label>卡号长度</label>
                <input name="cardlength" class="easyui-validatebox" value="8">
            </div>

            <div class="fitem">
                <label>是否针对china500 5A课程包</label>
                <input name="type" type="checkbox" value="1" />
            </div>
			
        </form>
    </div>
	
	<div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveyearcard()">保存</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" onclick="$('#form_yearcard')[0].reset()">重置</a>
    </div>

	<script>
		$(function(){
			$.ajax({
				url:'<?php echo geturl('admin/classroom/getsimplelist');?>',
				type:'GET',
				success:function(data){
					var datas = eval('('+data+')'); 
					for(var i=0;i<datas.length;i++){
						$("#crid").append("<option value='"+datas[i]['crid']+"'>"+ datas[i]['crname']+ "</option>");  
					}
					
				},
				error:function(){
					alert();
				}
			});
		})
		function saveyearcard(){
			if($('#form_yearcard').form('validate'))
				$('#form_yearcard').submit();
		}
		
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