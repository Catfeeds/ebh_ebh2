<?php $this->display('college/page_header'); ?>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/selcur/css/lnclass.css">
<div class="maines">
    <div class="waitite" style="background: #fff;">
        <span class="jnisrso">我的同学</span>
        <div class="diles" style="margin-top:0px;">
            <input id="title" class="newsou" style="color:#a5a5a5" value="请输入关键字" name="title" type="text" />
            <input id="ser" class="soulico" value="" style="position:absolute" type="button" />
        </div>
    </div>
    <div class="myrom">
        <ul>
            <?php if (!empty($students)){ ?>
                <?php foreach($students as $student) {
                    if($student['sex'] == 1) {
                        $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
                    } else {
                        $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
                    }
                    $face = empty($student['face']) ? $defaulturl : $student['face'];
                    $face = getthumb($face,'50_50');
                ?>
                    <li class="jisrte">
                        <img class="lefimg" src="<?= $face ?>" />
                        <div class="jrtgzze">
                            <?php $name = !empty($student['realname'])?$student['realname']:$student['username']; ?>
                            <p class="tisresr" title="<?= $name ?>"><?= mb_substr($name, 0, 6, 'utf-8') ?></p>
                            <p class="nisresr" title="<?= empty($myclass['classname'])?'':$myclass['classname'] ?>"><?= mb_substr(empty($myclass['classname'])?'':$myclass['classname'], 0, 9, 'utf-8') ?></p>
                            <a class="fasir" href="javascript:void();" data-tid="<?= $student['uid'] ?>" data-name="<?= $name ?>">发私信</a>
                        </div>
                    </li>
            <?php }} ?>
        </ul>

        <!-- 在线同学不存在 -->
        <?php if (empty($students)){ ?>
            <div class="lefstr" style="padding-bottom:20px;background:white; width:998px;">
                <div class="listmode" style="display:block">
                    <div class="nodata">
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
    <div><?php echo $pagestr; ?></div>
</div>

<!--发送私信dialog start-->
<div class="waiyry clearfix" id="wxDialog" style="display:none;width:698px;margin:0;padding:30px 44px;">
    <div class="chouad" style="height:auto">
        <span class="shyten">收件人：</span>
        <div class="ewater" style="height:36px;">
            <ul id="wrap2"></ul>
        </div>
    </div>
    <textarea class="txttiantl" name="summary" style="font-size:14px;"></textarea>
    <div class="wtkkr" style="height:45px;">
        内容不超过500字
        <a id="sendmessage" class="msgsendbtn">发 送</a>
    </div>
</div>
<!--发送私信dialog end-->
<input type="hidden" id="setclick" name="setclick" value="0" />
<script>
    $(function(){
        $("#sendmessage").on('click',function(){
            //$(this).off('click');
            var d = new Date();
            var nowTime = d.getTime();
            var getTime = $('#setclick').val();
            if ((nowTime - getTime) < 2000) {
                return false;
            }

            var msg =  $.trim($("textarea.txttiantl",parent.document).val());
            var tid = $("#wrap2 li:first",parent.document).attr("tid");
            console.log(msg.length);
            if($("#wrap2",parent.document).html() == ''){
                top.dialog({
                    title:"提示信息",
                    content:"收件人错误",
                    cancel:false,
                    okValue:"确定",
                    ok:function(){
                        this.close().remove();
                    }
                }).showModal();
                return;
            }
            if(msg.length==0){
                top.dialog({
                    title:"提示信息",
                    content:"请输入内容",
                    cancel:false,
                    okValue:"确定",
                    ok:function(){
                        this.close().remove();
                    }
                }).showModal();
                return;
            } else if(msg.length>500){
                top.dialog({
                    title:"提示信息",
                    content:"内容不超过500字",
                    cancel:false,
                    okValue:"确定",
                    ok:function(){
                        this.close().remove();
                    }
                }).showModal();
                return;
            }

            $.ajax({
                type: "POST",
                url: "/myroom/msg/do_send.html",
                data:{tid:tid, msg:msg},
                success:function(res){
                    $('#setclick').val(nowTime);
                    if(res=="1"){
                        parent.window.showSendSuccess();
                    }else{
                        parent.window.showSendFail();
                    }
                }
            });
        });

        $(".fasir").on('click',function(){
            parent.window.H.get('wxDialog').exec('show');
            //每次打开重置收件人和信息内容
            $("#wrap2",parent.document).html("");
            $("textarea.txttiantl",parent.document).val("");
            //添加收件人
            var tid = $(this).data("tid");
            var tname = $(this).data("name");
            $("#wrap2",parent.document).append('<li tid="'+tid+'" class="lvtewu">'+tname+'</li>');
            //焦点对话框
            $("textarea.txttiantl",parent.document).focus();
        });

        //创建dialog
        parent.window.H.remove('wxDialog');
        $('#wxDialog',parent.window.document.body).remove();
        parent.window.H.create(new P({
            id:'wxDialog',
            title:'发私信',
            easy:true,
            content:$("#wxDialog")[0]
        }),'common');

        $('#title').on('click', function(){
            var name = $(this).val();
            if (name = '请输入关键字') {
                $(this).val('');
            }
        });
        $('#title').on('blur', function(){
            var name = $(this).val();
            if (!name) {
                $(this).val('请输入关键字');
            }
        });
        // 搜索在线同学
        $('#ser').on('click', function(){
            var sname = $('#title').val();
            if (sname && sname != '请输入关键字') {
                location.href = '/college/classmate/online.html?name='+sname;
            } else {
                location.href = '/college/classmate/online.html';
            }
        });
    });
</script>

<?php $this->display('myroom/page_footer'); ?>