<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>批量导入部门</title>
    <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
    <style type="text/css">
        form.upfile{vertical-align:top;}
        .download{text-align:right;margin-bottom:90px;margin-right:50px;}
        .download a:link{color:#3095c6;text-decoration:none;font-weight:700;font-size:14px;}
        .download a:visited{color:#3095c6;text-decoration:none;font-weight:700;font-size:14px;}
        .download a:hover{color:#3095c6;text-decoration:underline;font-weight:700;font-size:14px;}
        .download a:active{color:#3095c6;text-decoration:none;font-weight:700;font-size:14px;}
        button.btn{
            background: #5e96f5;
            height: 34px;
            display: inline;
            line-height: 34px;
            font-size: 14px;
            border: none;
            text-align: center;
            cursor: pointer;
            color: #fff;
            vertical-align:top;
            letter-spacing:5px;
            width:74px;
        }
        button.btn.wait{width:260px;}
        div.main{display:inline-block;}
        dl{margin:30px 0 0 0;padding:0;line-height:1.8;color:#6d6d6d;}
        dt,dd{margin:0;padding:0;}
        dt em{font-style:normal;color:#f00;}
        div.msg{font-size:16px;font-weight:700;color:#f00;margin-top:10px;}
    </style>
</head>
<body>
<div style="width:705px;margin:40px 0 0 105px;font-size:13px;">
<div class="download"><a href="http://static.ebh.net/ebh/file/deptments_tmp.xls">导入模板下载</a></div>
<form method="post" class="upfile" enctype="multipart/form-data"><div class="main"><input type="hidden" name="superior" value="<?=htmlspecialchars($superior, ENT_COMPAT)?>" /><input type="file" id="excel" name="excel" required="required" style="width:350px;margin-right:50px;" /></div><button id="btn-post" type="submit" class="btn<?php if (!empty($wait)) { echo ' wait'; } ?>"<?php if (!empty($wait)) { ?> disabled="disabled"<?php } ?>><?=!empty($wait) ? '正在处理，请等待...' : '提交' ?></button></form>
<dl>
    <dt>注意<em>(非常重要)</em></dt>
    <dd>1.导入系统目前只支持xls格式文件，暂不支持xlsx格式文件。</dd>
    <dd>2.导入的Excel文件必须严格按照导入模板格式。</dd>
    <dd>3.Excel文件中必须包含部门名称这个字段。</dd>
</dl>
    <div id="msg" class="msg"><?php if (!empty($msg)) { ?>
<?php if (is_array($msg)) {
    foreach ($msg as $m) {
        echo htmlspecialchars($m, ENT_NOQUOTES).'<br />';
    }
} else {
        echo htmlspecialchars($msg, ENT_NOQUOTES);
    } ?>
<?php } ?></div>
<?php if (!empty($wait)) { ?>
<script type="text/javascript">
    (function($) {
        var wait = true;
        function checkProgress() {
            $.ajax({
                'url': '/aroomv3/enterprise/getImportResult.html',
                'type': 'get',
                'dataType': 'json',
                'success': function(d) {
                    if (typeof(d.errno) === undefined) {
                        return;
                    }
                    if (d.errno == 1) {
                        setTimeout(checkProgress, 2000);
                        return;
                    }
                    if (d.errno == 0) {
                        $("#msg").html(d.msg);
                        $("#btn-post").html('提交').removeClass('wait').removeAttr('disabled');
                    }
                }
            });
        }
        checkProgress();
    })(jQuery);
</script>
<?php } ?>
</div>
</body>
</html>