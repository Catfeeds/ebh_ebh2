<!DOCTYPE html>
<html lang="zh-CN" manifest="index.manifest">
<head>
    <meta charset="utf-8" />

    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
    Remove this if you use the .htaccess -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>绘图</title>
    <meta name="description" content="绘图" />
    <meta name="author" content="yan" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
    <link rel="shortcut icon" href="http://static.ebanhui.com/draw/images/Painter.gif" />

    <!-- bootstrap css -->
    <link rel="stylesheet" href="http://static.ebanhui.com/draw/plugins/bootstrap/css/bootstrap.min.css" />
    <link href="http://static.ebanhui.com/draw/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">

    <!-- 主页css  -->
    <link rel="stylesheet" href="http://static.ebanhui.com/draw/css/layout.css" />
    <link rel="stylesheet" href="http://static.ebanhui.com/draw/css/index.css" />
    <link rel="stylesheet" href="http://static.ebanhui.com/draw/css/index-responsive.css" />

    <!-- jquery ui css -->
    <link rel="stylesheet" href="http://static.ebanhui.com/draw/plugins/jqueryui+/themes/base/minified/jquery-ui.min.css" />
    <link rel="stylesheet" href="http://static.ebanhui.com/draw/plugins/jqueryui+/themes/base/minified/jquery.ui.core.min.css" />
    <link rel="stylesheet" href="http://static.ebanhui.com/draw/plugins/jqueryui+/themes/base/minified/jquery.ui.dialog.min.css" />
    <link rel="stylesheet" href="http://static.ebanhui.com/draw/plugins/jqueryui+/themes/base/minified/jquery.ui.theme.min.css" />

    <!-- color css -->
    <link rel='stylesheet' href="http://static.ebanhui.com/draw/plugins/spectrum/spectrum.css" />

    <!-- 添加百度统计 -->
    <!-- <script src="http://static.ebanhui.com/draw/js/baidu.js"></script> -->
</head>

<body>
<div id="loading" class="loading">
    <div class="progress progress-striped active">
        <div class="bar" style="width: 100%;"></div>
    </div>
    <p class="load">
        Loading core module please wait a while...
    </p>
    <p class="check">
        Checking environment
    </p>
    <div class="check-result">
        <ul>
            <li class="check-canvas">
                <strong>Canvas</strong>
                <span class="unsupport">支持</span>
                <small>注:支持意味着你能绘制，不支持不能绘制，你可能需要更换浏览器</small>
            </li>
            <li class="check-canvas-text">
                <strong>绘制文字</strong>
                <span class="unsupport">支持</span>
                <small>注:支持意味着你能绘制文字，不支持不能绘制，若要绘制文字你可能需要更换浏览器</small>
            </li>
            <li class="check-range">
                <strong>滑块</strong>
                <span class="unsupport">支持</span>
                <small>注:支持意味着你能运用滑块元素，不支持不能实用滑块，降级为输入框，如果你需要更好的体验可能要升级浏览器</small>
            </li>
        </ul>
        <p class="select">
            您的浏览器并不支持所有功能，但可以使用大部分功能，可能造成体验不完整，若想完整体验您可升级浏览器，推荐chrome，firefox，opera，safari，ie9+<br>
            <button class="btn btn-success btn-large">马上使用</button>
        </p>
        <p class="sorry">
            sorry，您的浏览器不支持html5，请升级浏览器吧
        </p>
    </div>
</div><!-- end .loading -->
<div class="container-fluid">
    <nav class="navbar" style="display:none">
        <div class="navbar-inner">
            <h1><a class="brand" href="javascript:void(0)"  id="saveImg"><b>上传</b></a></h1>
            <ul id="menu" class="nav">
                <li class="dropdown file">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">文件 <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><b class="icon-plus-sign"></b> 新建<i>Ctrl+N</i></a>
                        </li>
                        <li>
                            <a href="#"><b class="icon-folder-open"></b> 打开<i>Ctrl+O</i></a>
                        </li>
                        <li>
                            <a id="nav-file-negative"  data-toggle="modal" href="#negative-modal"><b class="icon-share-alt"></b> 导入底片<i></i></a>
                        </li>
                        <li>
                            <a id="nav-file-image"  data-toggle="modal" href="#image-modal"><b class="icon-share-alt"></b> 插入图片<i></i></a>
                        </li>
                        <li>
                            <a id="nav-file-save" href="#"><b class="icon-ok"></b> 保存 <i>Ctrl+S</i></a>
                        </li>
                        <li>
                            <a href="#myModal" data-toggle="modal" id="nav-file-export" href="#"><b class="icon-share-alt"></b> 导出<i>Ctrl+E</i></a>
                        </li>
                    </ul>
                </li><!-- end .file -->
                <li class="dropdown edit">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">编辑 <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a id="nav-edit-undo" href="#"><b class="icon-step-backward"></b> 撤销<i>Ctrl+Z</i></a>
                        </li>
                        <li>
                            <a id="nav-edit-clear" href="#"><b class="icon-trash"></b> 清空<i>Ctrl+D</i></a>
                        </li>
                        <li>
                            <a id="nav-edit-clear-negative" href="#"><b class="icon-trash"></b> 清空底片<i></i></a>
                        </li>
                        <li>
                            <a id="nav-edit-convert" href="#"><b class="icon-random"></b> 倒置<i>Ctrl+R</i></a>
                        </li>
                        <li>
                            <a id="nav-edit-flipx" href="#"><b class="icon-resize-horizontal"></b> 水平翻转<i>Ctrl+H</i></a>
                        </li>
                        <li>
                            <a id="nav-edit-flipy" href="#"><b class="icon-resize-vertical"></b> 垂直翻转<i>Ctrl+V</i></a>
                        </li>
                    </ul>
                </li><!-- end .edit -->
                <li class="dropdown social">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" rel="nofollow">分享<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li id="nav-share-qq">
                            <a class="qq qcShareQQDiv" href="#" target="_blank" rel="nofollow"><b class="icon-qq"></b> QQ好友</a>
                        </li>
                        <li id="nav-share-qzone">
                            <a version="1.0" class="qzone qzOpenerDiv" href="#" target="_blank" rel="nofollow"><b class="icon-qzone"></b> QQ空间</a>
                        </li>
                        <li id="nav-share-qweibo">
                            <a class="qweibo" href="#" target="_blank" rel="nofollow"><b class="icon-qweibo"></b> 腾讯微博</a>
                        </li>
                        <li id="nav-share-weibo">
                            <a class="weibo" href="#" target="_blank" rel="nofollow"><b class="icon-weibo"></b> 新浪微博</a>
                        </li>
                    </ul>
                </li><!-- end .share -->
            </ul><!-- end .nav -->
        </div><!-- end .navbar-inner -->
    </nav>
    <div class="row-fluid main-wrap">
        <div class="span12 canvas-wrap">
            <img src="<?= $imgsrc ?>" id="backgroundimg"/>
            <canvas width="1000" height="400" id="canvas-background" class="canvas-paint canvas-background"></canvas>
            <canvas width="1000" height="400" class="canvas-paint canvas-negative" id="canvas01"></canvas>
            <canvas width="1000" height="400" class="canvas-paint canvas-layer" id="canvas02"></canvas>
            <canvas width="1000" height="400" class="canvas-paint canvas-buffer" id="canvas03"></canvas>
            <canvas width="1000" height="400" id="canvas-mouse" class="canvas-paint canvas-mouse"></canvas>
            <div id="text-input" class="text-input hide" contenteditable></div>
        </div><!-- end .canvas-wrap -->
        <!-- <div class="span3 info">

        </div><!-- end .info -->
    </div><!-- end .main-wrap -->

    <div id="tool-wrap" class="tool-wrap">
        <div class="tool">
            <button class="stroke active" title="轮廓工具" data-current-tool="Pen" data-tool-panel="stroke"></button>
            <button class="shape" title="形状工具" data-current-tool="Line" data-tool-panel="shape"></button>
            <button class="eraser" title="橡皮擦工具" data-current-tool="Eraser" data-tool-panel="eraser"></button>
            <button class="flood-fill" title="填充工具" data-current-tool="FloodFill" data-tool-panel="flood-fill"></button>
            <button class="eye-dropper" title="吸管工具" data-current-tool="EyeDropper" data-tool-panel="eye-dropper"></button>
            <button class="text" title="文字工具" data-tool-panel="text" data-current-tool="Text"></button>
            <input class="color" type="text" title="颜色" value="rgba(0,0,0,1)"/>
        </div><!-- end .tool -->
        <div class="tool-panel">
            <div class="stroke wrap">
                <button class="pen" title="铅笔" data-tool="stroke" data-tool-class="Pen"> </button>
                <button class="curve-closed-stroke" title="闭合曲线" data-tool="stroke" data-tool-class="CurveClosedStroke"></button>
                <button class="rect-stroke" title="矩形" data-tool="stroke" data-tool-class="RectStroke"> </button>
                <button class="circle-stroke" title="圆形" data-tool="stroke" data-tool-class="CircleStroke"></button>
                <button class="ellipes-stroke" title="椭圆" data-tool="stroke" data-tool-class="EllipesStroke"></button>
                <div id="tool-stroke-attribute-panel" class="tool-attribute-panel" title="轮廓属性面板">
                    <form>
                        <fieldset>
                            <legend>property</legend>
                            <label>size：<input class="width" type="range" min="1" max="100" value="1" data-attr="lineWidth" /><span>1</span></label>
                            <label>opacity：<input class="opacity" type="range" max="100" value="100" data-attr="opacity" /><span>100</span></label>
                        </fieldset>
                        <fieldset >
                            <legend>shadow</legend>
                            <label>shadowOffsetX：<input class="shadow-offsetx" type="range" min="-10" max="10" value="0" data-attr="shadowOffsetX" /><span>0</span></label>
                            <label>shadowOffsetY：<input class="shadow-offsety" type="range" min="-10" max="10" value="0" data-attr="shadowOffsetY" /><span>0</span></label>
                            <label>shadowBlur：<input class="shadow-blur" type="range" min="0" max="10" value="0" data-attr="shadowBlur" /><span>0</span></label>
                            <label>shadowColor：<input class="shadow-color" type="color" data-attr="shadowColor" /></label>
                        </fieldset>
                        <fieldset class="radios">
                            <legend>lineJoin</legend>
                            <label>
                                <input data-attr="lineJoin" name="line-join" type="radio" value="miter" checked="true" /><span>miter</span>
                            </label>
                            <label>
                                <input data-attr="lineJoin" name="line-join" type="radio" value="bevel" /><span>bevel</span>
                            </label>
                            <label>
                                <input data-attr="lineJoin" name="line-join" type="radio" value="round" /><span>round</span>
                            </label>
                        </fieldset>
                        <fieldset class="radios">
                            <legend>lineCap</legend>
                            <label>
                                <input name="line-cap" type="radio" data-attr="lineCap" value="butt" checked="true" /><span>butt</span>
                            </label>
                            <label>
                                <input name="line-cap" type="radio" data-attr="lineCap" value="round" /><span>round</span>
                            </label>
                            <label>
                                <input name="line-cap" type="radio" data-attr="lineCap" value="square" /><span>square</span>
                            </label>
                        </fieldset>
                    </form>
                </div>
            </div><!-- end .stroke -->

            <div class="shape wrap">
                <button class="line" title="直线" data-tool="shape" data-tool-class="Line"></button>
                <button class="curve-closed" title="闭合曲线" data-tool="shape" data-tool-class="CurveClosed"></button>
                <button class="rect" title="矩形" data-tool="shape" data-tool-class="Rect"></button>
                <button class="circle" title="圆" data-tool="shape" data-tool-class="Circle"></button>
                <button class="ellipes" title="椭圆" data-tool="shape" data-tool-class="Ellipes"></button>
                <div id="tool-shape-attribute-panel" class="tool-attribute-panel" title="形状属性面板">
                    <form>
                        <fieldset>
                            <legend>property</legend>
                            <label>size：<input class="width" type="range" min="1" max="100" value="1" data-attr="lineWidth" /><span>1</span></label>
                            <label>opacity：<input class="opacity" type="range" max="100" value="100" data-attr="opacity" /><span>100</span></label>
                        </fieldset>
                        <fieldset>
                            <legend>shadow</legend>
                            <label>shadowOffsetX：<input class="shadow-offsetx" type="range" min="-10" max="10" value="0" data-attr="shadowOffsetX" /><span>0</span></label>
                            <label>shadowOffsetY：<input class="shadow-offsety" type="range" min="-10" max="10" value="0" data-attr="shadowOffsetY" /><span>0</span></label>
                            <label>shadowBlur：<input class="shadow-blur" type="range" min="0" max="10" value="0" data-attr="shadowBlur" /><span>0</span></label>
                            <label>shadowColor：<input class="shadow-color" type="color" data-attr="shadowColor" /></label>
                        </fieldset>
                        <fieldset class="radios">
                            <legend>lineJoin</legend>
                            <label>
                                <input data-attr="lineJoin" name="line-join" type="radio" value="miter" checked="true" /><span>miter</span>
                            </label>
                            <label>
                                <input data-attr="lineJoin" name="line-join" type="radio" value="bevel" /><span>bevel</span>
                            </label>
                            <label>
                                <input data-attr="lineJoin" name="line-join" type="radio" value="round" /><span>round</span>
                            </label>
                        </fieldset>
                        <fieldset class="radios">
                            <legend>lineCap</legend>
                            <label>
                                <input name="line-cap" type="radio" data-attr="lineCap" value="butt" checked="true" /><span>butt</span>
                            </label>
                            <label>
                                <input name="line-cap" type="radio" data-attr="lineCap" value="round" /><span>round</span>
                            </label>
                            <label>
                                <input name="line-cap" type="radio" data-attr="lineCap" value="square" /><span>square</span>
                            </label>
                        </fieldset>
                    </form>
                </div>
            </div><!-- end .shape -->

            <div class="eraser wrap">
                <div id="tool-eraser-attribute-panel" class="tool-attribute-panel" title="橡皮属性面板">
                    <form>
                        <fieldset>
                            <legend>property</legend>
                            <label>size：<input class="size" type="range" min="1" max="100" data-attr="lineWidth" value="1" /><span>1</span></label>
                            <label>opacity：<input class="opacity" type="range" max="100" value="100" data-attr="opacity" /><span>100</span></label>
                        </fieldset>
                        <fieldset class="radios">
                            <legend>lineJoin</legend>
                            <label>
                                <input data-attr="lineJoin" name="line-join" type="radio" value="miter" checked="true" /><span>miter</span>
                            </label>
                            <label>
                                <input data-attr="lineJoin" name="line-join" type="radio" value="bevel" /><span>bevel</span>
                            </label>
                            <label>
                                <input data-attr="lineJoin" name="line-join" type="radio" value="round" /><span>round</span>
                            </label>
                        </fieldset>
                        <fieldset class="radios">
                            <legend>lineCap</legend>
                            <label>
                                <input name="line-cap" type="radio" data-attr="lineCap" value="butt" checked="true" /><span>butt</span>
                            </label>
                            <label>
                                <input name="line-cap" type="radio" data-attr="lineCap" value="round" /><span>round</span>
                            </label>
                            <label>
                                <input name="line-cap" type="radio" data-attr="lineCap" value="square" /><span>square</span>
                            </label>
                        </fieldset>
                    </form>
                </div>
            </div><!-- end .eraser -->

            <div class="flood-fill wrap">
                <div id="tool-flood-fill-attribute-panel" class="tool-attribute-panel" title="油漆桶属性面板">
                    <form>
                        <fieldset>
                            <legend>property</legend>
                            <label>allowance：<input class="allowance" type="range" min="1" max="256" data-attr="allowance" value="1" /><span>1</span></label>
                        </fieldset>
                    </form>
                </div>
            </div><!-- end .floodfill -->

            <div class="text wrap">
                <button class="text" title="文本" data-tool="text" data-tool-class="Text"> </button>
                <button class="text-stroke" title="文本轮廓" data-tool="text" data-tool-class="TextStroke"> </button>
                <div id="tool-text-attribute-panel" class="tool-attribute-panel" title="文字属性面板">
                    <form>
                        <fieldset>
                            <legend>property</legend>
                            <label>font:
                                <select class="font" data-attr="family">
                                    <option selected="true" class="serif" value="serif">serif</option>
                                    <option class="sans-serif" value="sans-serif">sans-serif</option>
                                    <option class="arail" value="Arial">Arial</option>
                                    <option class="arial-black" value="Arial Black">Arial Black</option>
                                    <option class="terminal" value="Terminal">Terminal</option>
                                    <option class="verdana" value="Verdana">Verdana</option>
                                    <option class="fangzhengshuti" value="方正舒体">方正舒体</option>
                                    <option class="fangzhengyaoti" value="方正姚体">方正姚体</option>
                                    <option class="heiti" value="黑体">黑体</option>
                                    <option class="huawencaiyun" value="华文彩云">华文彩云</option>
                                    <option class="huawenhupo" value="华文琥珀">华文琥珀</option>
                                    <option class="huawenxinwei" value="华文新魏">华文新魏</option>
                                    <option class="huawenzhongsong" value="华文中宋">华文中宋</option>
                                    <option class="kaiti" value="楷体_GB2312">楷体_GB2312</option>
                                    <option class="lishu" value="隶书">隶书</option>
                                    <option class="songti" value="宋体">宋体</option>
                                    <option class="weiruanyahei" value="微软黑体">微软黑体</option>
                                    <option class="youyuan" value="幼圆">幼圆</option>
                                </select>
                            </label>
                            <label class="checkbox"><b>bold:</b>
                                <input class="bold" type="checkbox" value="bold" data-attr="bold">
                            </label>
                            <label class="checkbox"><i>italic:</i>
                                <input class="italic" type="checkbox" value="italic" data-attr="italic">
                            </label>
                            <label>size：<input class="size" type="range" min="8" max="100" data-attr="size" value="12" /><span>12</span><span>px</span></label>
                            <label>border：<input class="border" type="range" min="0" max="100" data-attr="border" value="0" /><span>0</span><span></span></label>
                            <label>opacity：<input class="opacity" type="range" max="100" data-attr="opacity" value="100" /><span>100</span></label>
                        </fieldset>
                        <fieldset>
                            <legend>shadow</legend>
                            <label>shadowOffsetX：<input class="shadow-offsetx" type="range" min="-10" max="10" value="0" data-attr="shadowOffsetX" /><span>0</span></label>
                            <label>shadowOffsetY：<input class="shadow-offsety" type="range" min="-10" max="10" value="0" data-attr="shadowOffsetY" /><span>0</span></label>
                            <label>shadowBlur：<input class="shadow-blur" type="range" min="0" max="10" value="0" data-attr="shadowBlur" /><span>0</span></label>
                            <label>shadowColor：<input class="shadow-color" type="color" data-attr="shadowColor" /></label>
                        </fieldset>
                    </form>
                </div>
            </div><!-- end .text -->
        </div><!-- end .tool-panel -->
    </div><!-- end .tool-wrap -->

    <footer></footer>

    <!-- 导入底片 -->
    <div id="negative-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">导入底片</h3>
        </div>
        <div class="modal-body">
            <form>
                <fieldset>
                    <legend>导入图片</legend>
                    <label><input id="negative-modal-file" type="file" accept="image/*" value="save/7777777.png" /></label>
                </fieldset>
                <fieldset>
                    <legend>属性</legend>
                    <label>x坐标 <input id="negative-modal-x" type="number" min="0" max="2000" value="10" /></label>
                    <label>y坐标 <input id="negative-modal-y" type="number" min="0" max="1000" value="10" /></label>
                    <label>宽度 <input id="negative-modal-width" type="number" min="0" max="2000" value="800" /></label>
                    <label>高度 <input id="negative-modal-height" type="number" min="0" max="1000" value="600" /></label>
                </fieldset>
                <fieldset>
                    <legend>预览</legend>
                    <figure>
                        <figcaption>预览</figcaption>
                        <img id="negative-modal-view" />
                    </figure>
                </fieldset>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
            <button id="negative-modal-ok" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">确定</button>
        </div>
    </div>
</div><!-- end .container -->

<!-- 导入底片 -->
<div id="image-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">导入图片</h3>
    </div>
    <div class="modal-body">
        <form>
            <fieldset>
                <legend>导入图片</legend>
                <label><input id="image-modal-file" type="file" accept="image/*" /></label>
            </fieldset>
            <fieldset>
                <legend>属性</legend>
                <label>x坐标 <input id="image-modal-x" type="number" min="0" max="2000" value="10" /></label>
                <label>y坐标 <input id="image-modal-y" type="number" min="0" max="1000" value="10" /></label>
                <label>宽度 <input id="image-modal-width" type="number" min="0" max="2000" value="800" /></label>
                <label>高度 <input id="image-modal-height" type="number" min="0" max="1000" value="600" /></label>
            </fieldset>
            <fieldset>
                <legend>预览</legend>
                <figure>
                    <figcaption>预览</figcaption>
                    <img id="image-modal-view" />
                </figure>
            </fieldset>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
        <button id="image-modal-ok" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">插入</button>
    </div>
</div>
</div><!-- end .container -->

<!-- 保存图片预览 -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">保存图片-右键-图片另存为</h3>
    </div>
    <div class="modal-body">
        <p><img id="save-image" src="http://static.ebanhui.com/draw/images/Painter.gif" style="outline: 1px solid #ff0"></p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
    </div>
</div>
</div><!-- end .container -->
<!-- import jquery js -->
<script src="http://static.ebanhui.com/draw/plugins/jquery/jquery-1.9.1.min.js"></script>

<script src="http://static.ebanhui.com/draw/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- import spectrum -->
<script src='http://static.ebanhui.com/draw/plugins/spectrum/spectrum.js'></script>

<!-- import jquery ui js -->
<script src="http://static.ebanhui.com/draw/plugins/jqueryui+/ui/minified/jquery-ui.min.js"></script>

<!-- import my js -->

<!-- 添加存储类js -->
<script src="http://static.ebanhui.com/draw/js/model/storageModel.js"></script>
<!-- 添加鼠标模型类 -->
<script src="http://static.ebanhui.com/draw/js/model/mouseModel.js"></script>

<!-- 添加点列表对象 -->
<script src="http://static.ebanhui.com/draw/js/model/pointListModel.js"></script>
<!-- import shape js -->
<script src="http://static.ebanhui.com/draw/js/model/shapeModel.js"></script>

<!-- import nav js -->
<script src="http://static.ebanhui.com/draw/js/controler/nav.js"></script>

<!-- import tool js -->
<script src="http://static.ebanhui.com/draw/js/model/toolModel.js"></script>
<script src="http://static.ebanhui.com/draw/js/model/toolContainerModel.js"></script>
<script src="http://static.ebanhui.com/draw/js/controler/tool.js"></script>

<!-- import canvas -->
<script src="http://static.ebanhui.com/draw/js/model/canvasModel.js"></script>
<script src="http://static.ebanhui.com/draw/js/model/canvasContainerModel.js"></script>
<script src="http://static.ebanhui.com/draw/js/controler/canvas.js"></script>

<!-- 导入主页js -->
<script src="http://static.ebanhui.com/draw/js/controler/index.js"></script>

<!-- 提示消息js -->
<script src="http://static.ebanhui.com/draw/plugins/torangetek/torangetek.messager.js"></script>

<!-- 检测环境 -->
<script src="http://static.ebanhui.com/draw/plugins/modernizr/modernizr.custom.35897.js"></script>
<!-- 导入load js -->
<script src="http://static.ebanhui.com/draw/js/controler/loading.js"></script>

<!-- 分享组件js -->
<script src="http://static.ebanhui.com/draw/js/controler/share.js"></script>
<script>
    $(function(){
        $('.stroke').click();
        $('#saveImg').click(function(){
            $('#nav-file-export').click();
            var imgSrc = $('#save-image').attr('src');
            // var uid  = <?php echo $uid; ?>;
            // var qid  = <?php echo $qid; ?>;
            // var icid = <?php echo $icid; ?>;
            // var crid = <?php echo $crid; ?>;
            // var start = <?php echo time();?>;
            // var longUrl = "<?php echo 'http://static.ebh.net/ebh/images/cszx04.png';?>";
            var longUrl = $('#backgroundimg').attr('src');
            var arr1 = longUrl.split('/');
            arr1.splice(0,3);
            var baseUrl = arr1.join('/');

            // var obj  = {imgSrc:imgSrc, uid:uid, qid:qid, icid:icid, crid:crid, start:start, baseUrl:baseUrl};
            var obj  = {imgSrc:imgSrc, baseUrl:baseUrl};
            $.post('http://up.ebh.net/uploaddraw.html', obj, function(msg){
                console.log(msg);
            });
        });
    })
</script>
</body>
</html>
