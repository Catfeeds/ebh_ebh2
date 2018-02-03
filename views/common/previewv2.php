<?php   
$ext = strstr($course['cwurl'],'.');	//.docx 等
$stime = isset($stime) ? $stime : 0;
if($course['ispreview']) {
?>
    

<script type="text/javascript" src="http://static.ebanhui.com/pan/js/swfobject.js"></script>
<script type="text/javascript">
    function playdoc(url, height, width, type,stime ) {
        url = encodeURIComponent(url);
        var params = {
            menu: "false",
            scale: "noScale",
            allowFullscreen: "true",
            allowScriptAccess: "always",
            bgcolor: "#000000",
            quality: "high",
            wmode:"Opaque"
        };
        var attributes = {
            id: "documentViewer"
        };
        var flashvars = {
            swfurl: url,
            _type: type,
            stime: stime
        };
        swfobject.embedSWF("http://static.ebanhui.com/ebh/flash/word_view.swf?v=20161031001", "documentViewer", width, height, "10.0.0", "", flashvars, params, attributes, swfloadcall)
    }

    function playppt(url, height, width, type) {
        var ppturl = encodeURIComponent(url);
        var swfVersionStr = "11.1.0";
        var flashvars = {
            ppturl: ppturl
        };
        var params = {"wmode":"Opaque"};
        var xiSwfUrlStr = "";
        params.quality = "high";
        params.bgcolor = "#ffffff";
        params.allowscriptaccess = "always";
        params.allowfullscreen = "true";
        var attributes = {};
        attributes.id = "documentViewer";
        attributes.name = "documentViewer";
        attributes.align = "middle";
        if (typeof(height) == "undefined") {
            height = 960
        }
        if (typeof(width) == "undefined") {
            width = 540
        }
        swfobject.embedSWF("http://static.ebanhui.com/ebh/flash/ppt_view.swf?v=20161031001", "documentViewer", height, width, swfVersionStr, xiSwfUrlStr, flashvars, params, attributes, swfloadcall);
        swfobject.createCSS("#documentViewer", "display:block;text-align:left; padding-top:0px")
    }

    /*
        function playmu(url, height, width, hasbtn, pic, size, pageControl, mode, seek) {
            url = encodeURIComponent(url);
            if (hasbtn == undefined) {
                hasbtn = 0
            }
            if (seek == undefined) {
                seek = -1
            }
            if (mode == undefined) {
                mode = 0
            }
            if (pageControl == undefined) {
                pageControl = 0
            }
            var flashvarsVideoNewControls = {
                source: url,
                type: "video",
                streamtype: "file",
                autostart: "false",
                controltype: 1,
                picurl: pic,
                size: size,
                classover: hasbtn,
                pageControl: pageControl,
                seek: seek,
                mode: mode
            };
            var params = {
                menu: "false",
                scale: "noScale",
                allowFullscreen: "true",
                allowScriptAccess: "always",
                bgcolor: "#000000",
                quality: "high",
                wmode: "Opaque"
            };
            var attributes = {
                id: "documentViewer"
            };
            if (width == undefined) {
                width = "900px"
            }
            if (height == undefined) {
                width = "562px"
            }
            swfobject.embedSWF("http://static.ebanhui.com/pan/flash/playerv3.swf", "documentViewer", width, height, "10.0.0", "http://static.ebanhui.com/pan/flash/expressInstall.swf", flashvarsVideoNewControls, params, attributes, swfloadcall)
        }*/

    function swfloadcall(attr) {
        if (typeof(attr) != "undefined" && typeof(attr.success) != "undefined" && attr.success == false) {
            $("#documentViewer").html('<span style="margin-left:200px;font-size:18px;line-height:300px;color:#000">您还没有安装flash播放器,请点击<a href="http://www.adobe.com/go/getflash" target="_blank" style="color:red;font-weight:bold;">这里</a>安装</span>')
        }
    }
    /*
        function playaudio(url, height, width) {
            url = encodeURIComponent(url);
            if (typeof(hasbtn) == "undefined") {
                hasbtn = 0
            }
            if (typeof(seek) == "undefined") {
                seek = -1
            }
            if (typeof(mode) == "undefined") {
                mode = 0
            }
            var flashvarsVideoNewControls = {
                source: url,
                type: "video",
                streamtype: "file",
                server: "",
                duration: "52",
                poster: "",
                autostart: "false",
                logo: "",
                logoposition: "top left",
                logoalpha: "30",
                logowidth: "130",
                logolink: "http://www.ebh.net",
                hardwarescaling: "false",
                darkcolor: "000000",
                brightcolor: "4c4c4c",
                controlcolor: "FFFFFF",
                hovercolor: "67A8C1",
                controltype: 1,
                classover: hasbtn,
                mode: mode,
                seek: seek
            };
            var params = {
                menu: "false",
                scale: "noScale",
                allowFullscreen: "true",
                allowScriptAccess: "always",
                bgcolor: "#000000",
                quality: "high"
            };
            var attributes = {
                id: "documentViewer"
            };
            if (width == undefined) {
                width = "900px"
            }
            if (height == undefined) {
                width = "400px"
            }
            swfobject.embedSWF("http://static.ebanhui.com/pan/flash/aplayer.swf", "documentViewer", width, height, "10.0.0", "/static/flash/expressInstall.swf", flashvarsVideoNewControls, params, attributes, swfloadcall)
        }*/
    function playswf(url, height, width) {
        var flashvarsVideoNewControls = {};
        var params = {
            menu: "false",
            scale: "noScale",
            allowFullscreen: "true",
            allowScriptAccess: "always",
            bgcolor: "#000000",
            quality: "high"
        };
        var attributes = {
            id: "documentViewer"
        };
        if (width == undefined) {
            width = "900px"
        }
        if (height == undefined) {
            width = "400px"
        }
        swfobject.embedSWF(url, "documentViewer", width, height, "10.0.0", "/static/flash/expressInstall.swf", flashvarsVideoNewControls, params, attributes, swfloadcall)
    };
</script>
<script type="text/javascript">
$(function(){
	var url = "<?= $course['cwsource'].'attach.html?cwid='.$course['cwid'].'&type=preview' ?>";
	<?php if($ext == '.ppt' || $ext == '.pptx' ) {?>
		playppt(url,"978","760",1);
	<?php } else if(in_array($ext,array('.doc','.docx','.pdf'))) {?>
		playdoc(url,1000,978,2,<?=$stime?>);
	<?php } ?>
});
</script>



<?php if($ext == '.ppt' || $ext == '.pptx') { ?>
 <div style="width:978px;height:760px;padding-top: 0px;float:left;" class="introduce" >
<div id="documentViewer" style="width:978px;height:760px;"></div>
<br />
</div> 
<?php } else if(in_array($ext,array('.doc','.docx','.pdf'))) {?>
<div style="width:978px;height:1000px;padding-top: 0px;float:left;" class="introduce" >
		<div id="documentViewer" style="width:978px;height:1000px;"></div>
<br />
</div>
<?php  }?>

<?php }?>

        
        
        