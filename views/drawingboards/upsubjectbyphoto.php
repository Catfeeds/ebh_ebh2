<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>WebUploader演示</title>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/webuploader.css" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/style_upload.css" />
</head>
<body>
    <div id="wrapper">
        <input type="hidden" name="qid" id="qid" value="<?php echo $qid;?>" />
        <input type="hidden" name="cwid" id="cwid" value="<?php echo $cwid;?>" />
        <input type="hidden" name="uid" id="uid" value="<?php echo $uid;?>" />
        <div id="container">
            <!--头部，相册选择和格式选择-->

            <div id="uploader">
                <div class="queueList">
                    <div id="dndArea" class="placeholder">
                        <div id="filePicker"></div>
                        <!-- <p>或将照片拖到这里，单次最多可选300张</p> -->
                    </div>
                </div>
                <div class="statusBar" style="display:none;">
                    <div class="progress">
                        <span class="text">0%</span>
                        <span class="percentage"></span>
                    </div><div class="info"></div>
                    <div class="btns">
                        <div id="filePicker2"></div><div class="uploadBtn">开始上传</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/examv2/js/webuploader.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/examv2/js/upload.js"></script>
</body>
</html>
