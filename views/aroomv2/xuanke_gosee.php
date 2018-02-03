<?php $this->display('troomv2/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/selcur/css/selcur.css<?=getv()?>" type="text/css" rel="stylesheet">

<body>
<div class="cright">
    <div class="ter_tit">
        当前位置 >
        <a href="/aroomv2/more.html">更多应用</a>
        >
        <a href="/aroomv2/xuanke.html">选课系统</a>
        >
        <span>查看</span>
    </div>
    <div class=" clear"></div>
    <div class="lefrigs">
        <h2 class="sizrer"><?php echo $xuanke['name']?></h2>
        <div class="kostrds" style="margin-bottom:20px;">
            <ul>
                <li class="fklisr"><a href="gosee.html?xkid=<?php echo $xkid?>" class="wursk botsder">活动动态</a></li>
                <li class="fklisr"><a href="/aroomv2/xuanke/view.html?xkid=<?php echo $xkid?>" class="wursk ">活动详情</a></li>
                <li class="fklisr"><a class="wursk " href="/aroomv2/xuanke/courselist.html?xkid=<?php echo $xkid?>">课程列表</a></li>
                <li class="fklisr"><a class="wursk " href="/aroomv2/xuanke/baoming.html?xkid=<?php echo $xkid?>">报名结果</a></li>
            </ul>
        </div>
        <div class="tsejier">
            <p class="dsirerd">
                <span class="huersde">活动已发布</span>
                <span class="jiertse"><span class="jliserw">0</span>位老师申报</span>
            </p>
            <p class="huetwre">2016-07-02 06:20</p>
            <p class="hjuiers">等待教师们申报选修课<span class="huerses">申报日期：2016-07-07 至 2016-07-27</span></p>
            <p class="hjuiers"><a href="reportcourse.html?xkid=<?php echo $xkid?>" class="hjisres">查看申报课程</a><a href="xuanke_edit.html?xkid=<?php echo $xkid?>" class="hjisres">修改活动</a></p>
        </div>
        <div class="tsejier">
            <p class="dsirerd">
                <span class="huersde">课程申报结束</span>
                <span class="jiertse"><span class="jliserw">3</span>位老师申报</span>
            </p>
            <p class="huetwre">2016-07-02 06:20</p>
            <p class="hjuiers">请设置完课程规则及选课规则后，发布第一轮选课</p>
            <p class="hjuiers"><a href="reportcoursefinish_set.html?xkid=<?php echo $xkid?>" class="hjisres">设置课程</a></p>
        </div>
        <div class="tsejier">
            <p class="dsirerd">
                <span class="huersde">第一轮选课进行中</span>
                <span class="jiertse"><span class="jliserw">5</span>位老师申报</span>
            </p>
            <p class="huetwre">2016-07-02 06:20</p>
            <p class="hjuiers">等待教师们申报选修课<span class="huerses">申报日期：2016-07-07 至 2016-07-27</span></p>
            <p class="hjuiers"><a href="/aroomv2/xuanke/firstcondition.html?xkid=<?php echo $xkid?>" class="hjisres" target="">查看选课情况</a></p>
        </div>
        <div class="tsejier">
            <p class="dsirerd">
                <span class="huersde">第一轮选课结束</span>
                <span class="jiertse"><span class="jliserw">5</span>位老师申报</span>
            </p>
            <p class="huetwre">2016-07-02 06:20</p>
            <p class="hjuiers">等待教师们申报选修课<span class="huerses">申报日期：2016-07-07 至 2016-07-27</span></p>
            <p class="hjuiers"><a href="/aroomv2/xuanke/firstcondition.html?xkid=<?php echo $xkid?>&step=1" class="hjisres" target="">调整选课结果</a></p>
        </div>
        <div class="tsejier">
            <p class="dsirerd">
                <span class="huersde">第二轮选课进行中</span>
                <span class="jiertse"><span class="jliserw">5</span>位老师申报</span>
            </p>
            <p class="huetwre">2016-07-02 06:20</p>
            <p class="hjuiers">等待教师们申报选修课<span class="huerses">申报日期：2016-07-07 至 2016-07-27</span></p>
            <p class="hjuiers"><a href="/aroomv2/xuanke/secondcondition.html?xkid=<?php echo $xkid?>" class="hjisres" target="">查看选课情况</a></p>
        </div>
        <div class="tsejier">
            <p class="dsirerd">
                <span class="huersde">第二轮选课结束</span>
                <span class="jiertse"><span class="jliserw">5</span>位老师申报</span>
            </p>
            <p class="huetwre">2016-07-02 06:20</p>
            <p class="hjuiers">等待教师们申报选修课<span class="huerses">申报日期：2016-07-07 至 2016-07-27</span></p>
            <p class="hjuiers"><a href="/aroomv2/xuanke/secondcondition.html?xkid=<?php echo $xkid?>&step=1" class="hjisres" target="">调整选课结果</a></p>
        </div>
        <div class="tsejier">
            <p class="dsirerd">
                <span class="huersde">选课活动结束</span>
                <span class="jiertse"><span class="jliserw">5</span>位老师申报</span>
            </p>
            <p class="huetwre">2016-07-02 06:20</p>
            <p class="hjuiers">等待教师们申报选修课<span class="huerses">申报日期：2016-07-07 至 2016-07-27</span></p>
            <p class="hjuiers"><a href="/aroomv2/xuanke/baoming.html?xkid=<?php echo $xkid?>" class="hjisres" target="">查看结果</a><a href="/troomv2/survey/add.html?xkid=<?php echo $xkid?>" target="_blank" class="hjisres">发布问卷</a></p>
        </div>
        <div class="tsejier">
            <p class="dsirerd">
                <span class="huersde">课程问卷评价已发布</span>
                <span class="jiertse"><span class="jliserw">5</span>位老师申报</span>
            </p>
            <p class="huetwre">2016-07-02 06:20</p>
            <p class="hjuiers">等待教师们申报选修课<span class="huerses">申报日期：2016-07-07 至 2016-07-27</span></p>
            <p class="hjuiers"><a href="/aroomv2/xuanke/assess.html?xkid=<?php echo $xkid?>"  class="hjisres">查看评价</a><a href="javascript:;" class="hjisres" onclick="editsurvey(<?php echo $xuanke['sid']?>)">修改</a></p>
        </div>
    </div>
</div>
<div class="tanchukuangs" id="dialogedit2" style="display: none">
    <div class="ui-dialog-header">
        <button class="ui-dialog-close qkks"title="关闭">×</button>
        <div class="ui-dialog-title">信息提示</div>
    </div>
    <div class="sckj1s">
        <div class="xzkctsxx" style="">确定要编辑该问卷吗？</div>
        <div class="xuanbtn2s">
            <a href="javascript:;" class="jxxk">确定</a>
            <a href="javascript:;" class="qkks">取消</a>
        </div>
    </div>
</div>
</body>
<script>
    $("#login").bind("click",function(){
        var d = dialog({
            title: false,
            content: document.getElementById("dialogedit2"),
            cancel: false,
            padding:1
//            fixed:true
        });
        d.show();
        $('.qkks').on('click',function(){
            d.close();
        })

    });
    function editsurvey(sid) {
        var sid = sid;
        $.ajax({
            type:'post',
            url:'<?=geturl('troomv2/survey/getanswernum')?>',
            dataType:'json',
            data:{'sid':sid},
            success:function(data){
                if(data!=undefined && data!=null){
                    var msg = '';
                    if(data>0)
                        msg = '你的问卷已收集 '+data+' 份投票，编辑问卷会影响已收集的投票。<br />';
                    msg += '确定要编辑该问卷吗?';
                    $(".xzkctsxx").html(msg);
                }
            },
            error:function(){
                alert("服务器连接错误，请重试");
            }
        });

        var d = dialog({
            title: false,
            content: document.getElementById("dialogedit2"),
            cancel: false,
            padding:1
//            fixed:true
        });
        d.show();
        $('.qkks').on('click',function(){
            d.close();
        });
        $('.jxxk').on('click',function(){
            d.close();
            var current_sid = $("#current_sid").val();
            window.open("/troomv2/survey/edit/"+sid+".html?xkid=<?php echo $xkid?>");
            return false;
        });

//        var button = new xButton();
//        button.add({
//            value:"确定",
//            callback:function(){
//                H.get('dialogedit').exec('close');
//                var current_sid = $("#current_sid").val();
//                window.open("/troomv2/survey/edit/"+current_sid+".html");
//                return false;
//            },
//            autofocus:true
//        });
//
//        button.add({
//            value:"取消",
//            callback:function(){
//                H.get('dialogedit').exec('close');
//                return false;
//            }
//        });
//        if(!H.get('dialogedit')){
//            H.create(new P({
//                id : 'dialogedit',
//                title: '编辑问卷',
//                easy:true,
//                width:400,
//                padding:5,
//                content:$('#dialogedit')[0],
//                button:button
//            }),'common');
//        }
//
//        H.get('dialogedit').exec('show');
    }
</script>
</html>
