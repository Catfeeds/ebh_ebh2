<?php $this->display('troom/page_header'); ?>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<div class="ter_tit">
    当前位置 > 课程列表
</div>
<div class="lefrig">
    <div class="annotate"> 在此页面中,您可以维护教室的课程信息,包括添加、修改、删除课程.
        <div class="tiezitoolss">
            <a class="hongbtn jiabgbtn marrig" href="<?= geturl('troom/subject/add') ?>" >开设课程</a>
            <a class="hongbtn mianbgbtn" href="<?= geturl('troom/subject/freecourseware') ?>">免费课件</a>
        </div>
    </div>
    <style type="text/css">
        .kejian {
            height: 740px;
            width: 748px;
            float:left;
            border: 1px solid #dcdcdc;
        }
        .kejian .showimg {
            margin-top: 6px;
            margin-left: 8px;
        }
        .kejian liss {
            width: 748px;
        }
        .kejian .liss .danke {
            width: 145px;
            float: left;
            margin-top: 8px;
            height: 235px;
        }
        .kejian .liss .danke .spne {
            text-align: center;
            width: 140px;
            height: 20px;
            display: block;
            line-height: 20px;
            color: #0033ff;
            float:left;
        }
        .kejian .liss .danke .sds {
            height: 184px;
            width: 145px;
            border: 1px solid #cdcdcd;
            background-image: url(http://static.ebanhui.com/ebh/tpl/2012/images/dise.jpg);
            background-repeat: no-repeat;
            background-position: center center;
            margin-bottom: 8px;
        }

        .showimg { background-color:#CBCBCB; float:left;}
        .showimg img { background-color:#FFFFFF; border:1px solid #CDCDCD; padding:4px; position:relative; left:-4px; top:-5px;}
        .hover .showimg { background-color:#0087B2;}
        .hover .showimg img { border:1px solid #0087B2;}
        .showimg .hover{border: 1px solid #0099cc;}


        .noke {
            height: 480px;
            width: 744px;
            float: left;
            border: 1px solid #cdcdcd;
        }
        .noke p {
            background: url(http://static.ebanhui.com/ebh/tpl/2012/images/nokejianico.jpg) no-repeat;
            height: 120px;
            margin-top: 90px;
            margin-left: 170px;
            padding-left: 140px;
            font-size: 16px;
            padding-top: 30px;
            width: 307px;
        }
        .noke span {
            color: #e94f29;
        }

    </style>
    <script type="text/javascript">
        $(function() {
            $(".showimg").parent().hover(function() {
                $(this).siblings().find("img").stop().animate({opacity: '1'}, 1000);
                $(this).addClass("hover");
            }, function() {
                $(this).siblings().find("img").stop().animate({opacity: '1'}, 1000);
                $(this).removeClass("hover");
            });
        });
        function delfolder(folderid, fname) {
            $.confirm("确认要删除课程 [" + fname + "] 吗？", function() {
                var url = '<?= geturl('troom/subject/delfolder') ?>';
                $.ajax({
                    url: url,
                    type: "post",
                    dataType: "text",
                    data: {"folderid": folderid},
                    success: function(data) {
                        if (data == 'success') {
                            $.showmessage({
                                img: 'success',
                                message: '删除课程成功',
                                title: '删除课程',
                                callback: function() {
                                    document.location.reload();
                                }
                            });
                        } else {
                            $.showmessage({
                                img: 'error',
                                message: '删除课程失败，请稍后再试或联系管理员。',
                                title: '删除课程'
                            });
                        }
                    }
                });
            });
        }
        /*
         * 上移
         */
        function moveup(folderid) {
            move(folderid,1);
        }
        /*
         * 下移
         */
        function movedown(folderid) {
            move(folderid,0);
        }
        function move(folderid, flag) {
            var url = "<?= geturl('troom/subject/move') ?>";
            $.ajax({
                url: url,
                type: "post",
                dataType: "text",
                data: {"folderid": folderid,"flag":flag},
                success: function(data) {
                    if (data == 'success') {
                        $.showmessage({
                            img: 'success',
                            message: '课程位置移动成功',
                            title: '课程位置',
                            callback: function() {
                                document.location.reload();
                            }
                        });
                    } else {
                        $.showmessage({
                            img: 'error',
                            message: '课程位置移动失败，请稍后再试或联系管理员。',
                            title: '课程位置'
                        });
                    }
                }
            });
        }
    </script>

    <?php if (!empty($folders)) { ?>
        <div class="kejian">
            <ul class="liss">
             
                <?php foreach ($folders as $folder) { ?>
                    <li class="danke" style="margin-left:4px; _margin-left:2px;list-style: none;">
                        <div class="showimg"><a href="<?= geturl('troom/subject/' . $folder['folderid']) ?>" title="<?= $folder['foldername'] ?>"><img src="<?= empty($folder['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' : $folder['img'] ?>" width="114" height="159" border="0" /></a></div>
                        <span class="spne">
                            <a href="javascript:moveup(<?= $folder['folderid'] ?>)" title="左移" style="float:left;margin-left:15px;_margin-left:25px! important;padding-top:3px;padding-top:1px! important;"><img src="http://static.ebanhui.com/ebh/tpl/default/images/forright.gif"></a>
                            <a href="<?= geturl('troom/subject/edit/' . $folder['folderid']) ?>" style="float:left;text-decoration:none;">[编辑]</a>
           
                            <?php if ($folder['coursewarenum'] > 0) { ?>
                                <a href="javascript:;" class="del" onclick="alert('该课程下面包含课件不能删除');
                                            return false;" style="float:left;color: #535353;cursor:default;text-decoration:none;" title="课程下面包含课件不能删除">[删除]</a>
               
                            <?php } else { ?>
                                <a href="javascript:;" onclick="delfolder(<?= $folder['folderid'] ?>, '<?= str_replace('\'', '', $folder['foldername']) ?>')" class="del" style="float:left;text-decoration:none;">[删除]</a>
         
                            <?php } ?>
                            <a href="javascript:movedown(<?= $folder['folderid'] ?>)" title="右移" style="float:left;padding-top:3px;padding-top:1px! important;"><img src="http://static.ebanhui.com/ebh/tpl/default/images/forleft.gif"></a>
                        </span>
                        <span class="spne"><a href="<?= geturl('troom/subject/' . $folder['folderid']) ?>" style="text-decoration: none;" title="<?= $folder['foldername'] ?>"><?= ssubstrch($folder['foldername'], 0, 20) ?>(<?= $folder['coursewarenum'] ?>)</a></span>
                    </li>
 
                <?php } ?>
            </ul>
        </div>
    <?php } else { ?>

        <div class="noke"><p>您还没有<span>开设任何课程</span>，只有开设课程后，才可以将您的课件等内容上传。</p></div>

    <?php } ?>
    <?= $pagestr ?>
</div>
<?php $this->display('troom/page_footer'); ?>