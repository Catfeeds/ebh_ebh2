<?php
$this->display('admin/header');
?>
    <body>
    <h1>生成账号</h1>
    <div style="margin-left: 20px;margin-top:10px;">
        <form id="form_yearcard" method="post" novalidate action="<?php echo geturl('admin/license/add');?>">
            <div class="fitem">
                <label>所属网校</label>
                <span>软件介绍</span>
            </div>
            <div class="fitem">
                <label>所属班级</label>
                <span>微课大师认证</span>
            </div>
            <div class="fitem">
                <label>生产数量</label>
                <input name="num" class="easyui-validatebox" value="10">
            </div>

        </form>
        </div>

        <div id="dlg-buttons" style="margin-left: 20px;">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveyearcard()">提交</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" onclick="$('#form_yearcard')[0].reset()">重置</a>
        </div>
    </div>
    <script>

        function saveyearcard(){
            if($('#form_yearcard').form('validate')){
                $('#form_yearcard').submit();
            }else{
                alert('数量不能为空！');
            }

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