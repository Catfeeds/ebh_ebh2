<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    
    <title></title>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/draw/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/draw/css/canvastyle.css?v=20170118003"/>
    <script type="text/javascript" src="http://static.ebanhui.com/draw/js/jquery-1.11.3.js"></script>
</head>
<body>
<input type="hidden" name="imgAdrr" id="imgAdrr" value="/drawingboards/getimg.html?url=<?php echo $baseUrl;?>"/>
<input type="hidden" name="icqid" id="icqid" value="<?php echo $icqid;?>" />
<div id="canvers_all">
    <div class="canvers_all_top">
        <ul>
            <li class="pen" data="pen" title="画笔"><span id="canvers_pen"></span></li>
            <li class="eraser" data="eraser" title="橡皮"><span id="canvers_eraser"></span></li>
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
        <div class="back" title="上一步"></div>
        <div class="advance" title="下一步"></div>
        <div id="canvers_clear" class="clear" title="清空"></div>
        <input id="canvers_save" type="button" value="保存" />
    </div>
    <div class="set">
    	<ul class="type">
    		<li class="line" data="line" title="直线"><span></span></li>
    		<li class="dotted" data="dotted" title="虚线"><span></span></li>
    		<li class="arrows" data="arrows" title="箭头"><span></span></li>
    		<li class="rect" data="rect" title="矩形"><span></span></li>
    		<li class="poly" data="poly" title="三角形"><span></span></li>
    		<li class="circle" data="circle" title="圆形"><span></span></li>
    	</ul>
    </div>
    <div class="canvers_bottom">
     	<div class="zero"></div>
     	<canvas id="canvas_bg" style="position:absolute;left:1.42rem;top:1.42rem;z-index:0;"></canvas>
        <canvas id="canvas" style="position:absolute;left:1.42rem;top:1.42rem;z-index:1;"></canvas>
    </div>
</div>

<script type="text/javascript" src="http://static.ebanhui.com/draw/js/rem.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/draw/js/canvasinit.js?v=20170118002"></script>
<script type="text/javascript" src="http://static.ebanhui.com/draw/js/canvas.js?v=20170119004"></script>

</body>
</html>
