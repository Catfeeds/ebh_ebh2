<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/draw/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/draw/css/canvastyle.css"/>
<!--     <link rel="stylesheet" href="http://static.ebanhui.com/js/dialog/css/dialog.css"/> -->
</head>
<body>
<input type="hidden" name="imgAdrr" id="imgAdrr" value="<?php echo $baseUrl;?>" />
<input type="hidden" name="qid" id="qid" value="<?php echo $qid;?>" />
<input type="hidden" name="uid" id="uid" value="<?php echo $uid;?>" />
<input type="hidden" name="cwid" id="cwid" value="<?php echo $cwid;?>" />
<input type="hidden" name="aid" id="aid" value="<?php echo $aid;?>" />
<div id="canvers_all">
    <div class="canvers_all_top">
        <ul>
            <li title="画笔"><span id="canvers_pen"></span></li>
            <li title="橡皮"><span id="canvers_eraser"></span></li>
            <li title="清除"><span id="canvers_clear"></span></li>
        </ul>
        <div class="canvers_fontsize_div" title="画笔粗细">
            <div class="canvers_fontsize">
                <div class="size" size="1"><span></span></div>
                <div class="size" size="2"><span></span></div>
                <div class="size" size="3"><span></span></div>
                <div class="size" size="4"><span></span></div>
                <div class="size" size="5"><span></span></div>
            </div>
        </div>
        <div class="canvers_color_div" title="画笔颜色">
            <div class="canvers_color">
                <div class="color" color="#000"></div>
                <div class="color" color="#0008ff"></div>
                <div class="color" color="#00d0ff"></div>
                <div class="color" color="#ff00e0"></div>
                <div class="color" color="#b400ff"></div>
                <div class="color" color="#00c4ff"></div>
                <div class="color" color="#00ffa1"></div>
                <div class="color" color="#c0ff00"></div>
                <div class="color" color="#efff00"></div>
                <div class="color" color="#ffd400"></div>
                <div class="color" color="#ff8100"></div>
                <div class="color" color="#ff0c00"></div>
            </div>
        </div>
        <?php if (empty($isSee)) {?>
            <input id="canvers_save" type="button" value="保存" />
        <?php }?>

    </div>
    <div class="canvers_bottom">
        <div class="zero"></div>
        <canvas id="canvas"></canvas>
    </div>
</div>
<script src="http://static.ebanhui.com/draw/js/jquery-1.11.3.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/draw/js/rem.js"></script>
<!-- <script type="text/javascript" src="http://static.ebanhui.com/draw/js/canvasjs.js"></script> -->
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js"></script>
<script type="text/javascript">
    var canvas = document.getElementById('canvas');
    var canvers_pen = document.getElementById('canvers_pen');
    var canvers_eraser = document.getElementById('canvers_eraser');
    var clear = document.getElementById('canvers_clear');
    var canvers_save = document.getElementById('canvers_save');

    canvas.addEventListener('mousemove', onMouseMove, false);
    canvas.addEventListener('mousedown', onMouseDown, false);
    canvas.addEventListener('mouseup', onMouseUp, false);

    canvas.addEventListener('touchstart',onMouseDown,false);
    canvas.addEventListener('touchmove',onMouseMove,false);
    canvas.addEventListener('touchend',onMouseUp,false)
    //初始配置
    var old = '';
    canvas.height = $(".canvers_bottom").height() - $(".zero").height();
    canvas.width = $(".canvers_bottom").width();
    var ctx = canvas.getContext('2d');
    var iserase = false;
    ctx.lineWidth = 3.0; // 设置线宽
    ctx.strokeStyle = "#000"; // 设置线的颜色
    var radius = 20;      //画圆的半径
    var flag = false;
    function onMouseMove(evt){
        evt.preventDefault();
        if (flag)
        {
            var p = pos(evt);
            if (iserase)
            {
                eraseCanvas(p.x,p.y);
            } else {

                ctx.lineTo(p.x, p.y);
                //ctx.lineWidth = 3.0; // 设置线宽
                //ctx.shadowColor = "#fc1741";
                //ctx.shadowBlur = 1;
                //ctx.shadowOffsetX = 3;
                ctx.stroke();
            }
        }
    }
    function onMouseDown(evt)
    {
        evt.preventDefault();
        ctx.beginPath();
        var p = pos(evt);
        ctx.moveTo(p.x, p.y);
        flag = true;
    }

    function eraseCanvas(x,y){
        ctx.shadowColor = "#fff";
        ctx.shadowBlur = 0;
        ctx.save();
        ctx.beginPath();
        ctx.arc(x,y,radius,0,Math.PI*2,false)
        ctx.clip();
        ctx.clearRect(0,0,canvas.width,canvas.height)
        ctx.restore()
    }
    function onMouseUp(evt)
    {
        evt.preventDefault();
        flag = false;
    }
    //画笔
    var pen = function(){
        if(iserase) {
            iserase = false;
            if(old != "") {
                ctx.strokeStyle = old;
                ctx.shadowColor = old;
            }
            old = "";
        }
    }
    //清除
    var allclear = function(){
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        var url = $('#imgAdrr').val();
        preImage(url,function(){
            ctx.drawImage(this,0,0);
        });
    }
    //橡皮
    var eraser = function(){
        iserase = true;
        old = ctx.strokeStyle;
        ctx.strokeStyle = "#fff";
        ctx.shadowColor = "#fff";
    }
    //保存
    var save = function(){
        var img = convertCanvasToImage(canvas);
        var imgdata = img.src;
        var qid = $("#qid").val();
        var uid = $("#uid").val();
        var cwid = $("#cwid").val();
        var aid = $("#aid").val();
        $.ajax({
            url:'http://up.ebh.net/uploadsubjectdraws.html',
            type:'post',
            dataType:'json',
            data:{'data':imgdata,'cwid':cwid,'aid':aid,'qid':qid,'uid':uid},
            //crossDomain: true,
            success:function(data){
                var imgsrc = data;
                top.H.get('artdialogss').exec('destroy');
               /* var icqid = $("#icqid").val()
                top.$("#img_"+icqid).attr('src',imgsrc);
                top.$("#answer_"+icqid).attr('value',imgsrc);
                top.$("#div_"+icqid).css('display','block');
                top.$("#btn_"+icqid).css('display','none');
                top.H.get('artdialogss').exec('destroy');*/
            }
        })
    }

    //监听画笔
    canvers_pen.addEventListener('click',pen,false);
    //监听橡皮
    canvers_eraser.addEventListener('click',eraser,false);
    //监听清除
    clear.addEventListener('click',allclear,false);
    //监听保存
    <?php if (empty($isSee)) {?>
            canvers_save.addEventListener('click',save,false);
    <?php }?>
    

    // Converts canvas to an image
    function convertCanvasToImage(canvas) {
        var image = new Image();
        image.src = canvas.toDataURL("image/png");
        return image;
    }

    function preImage(url,callback){
        var img = new Image(); //创建一个Image对象，实现图片的预下载
        img.crossOrigin = "Anonymous";
        img.src = url;

        if (img.complete) { // 如果图片已经存在于浏览器缓存，直接调用回调函数
            callback.call(img);
            return; // 直接返回，不用再处理onload事件
        }

        img.onload = function () { //图片下载完毕时异步调用callback函数。
            callback.call(img);//将回调函数的this替换为Image对象
        };
    }

    function pos(event)
    {
        var x,y;
        if(isTouch(event)){
            x = event.touches[0].pageX;
            y = event.touches[0].pageY - $(".zero").height();
            console.log(event.touches[0].pageY)
            console.log(y)
        }else{
            x = event.layerX;
            y = event.layerY;
        }
        return {x:x,y:y};
    }

    function isTouch(event)
    {
        var type = event.type;
        if(type.indexOf('touch')>=0){
            return true;
        }else{
            return false;
        }
    }

    function getWidth()
    {
        var xWidth = null;

        if (window.innerWidth !== null) {
            xWidth = window.innerWidth;
        } else {
            xWidth = document.body.clientWidth;
        }

        return xWidth;
    }

    //设置画笔

    //下拉列表开关
    var listOpen = function(obj1,obj2){
        $(obj1).on("click",function(){
            var style = $(obj2).css("display");
            if(style == "none"){
                $(obj2).css("display","block")
            }else if(style == "block"){
                $(obj2).css("display","none")
            }
            //阻止事件冒泡
            (event || window.event).cancelBubble = true
        })
        $(document).on("click",function(){
            $(obj2).css("display","none")
        })
        $(document).on("touchstart",function(){
            $(obj2).css("display","none")
        })
    }
    //画笔粗细点选
    listOpen(".canvers_fontsize_div",".canvers_fontsize")
    //画笔颜色点选
    listOpen(".canvers_color_div",".canvers_color")

    //改变画笔粗细
    $(".size").on("click",function(){
        ctx.lineWidth = $(this).attr("size")
    })
    $(".size").on("touchstart",function(){
        ctx.lineWidth = $(this).attr("size")
    })
    //改变画笔颜色
    $(".color").on("click",function(){
        ctx.strokeStyle = $(this).attr("color")
    })
    $(".color").on("touchstart",function(){
        ctx.strokeStyle = $(this).attr("color")
    })

    var url = $('#imgAdrr').val();
    preImage(url,function(){
        ctx.drawImage(this,0,0);
    });
    <?php if (!empty($dialog)) {?>
        var dialog = '<?php echo $dialog;?>';
        var width = parent.window.width/2;
        var html = '<iframe marginheight="0" id="child" marginwidth="0" width="'+width+'" frameborder="0" src="'+dialog+'"></iframe>';
        parent.parent.window.H.create(new P({
                id : 'child_artdialog',
                title : '试题详情',
                content : html,
                resizable:true
            },{onclose:function(){
                parent.parent.window.H.get('child_artdialog').exec('destroy');
            }}),'common').exec('show');
            //var mainFrame = document.getElementById("child");
    <?php } ?>
</script>
</body>
</html>
