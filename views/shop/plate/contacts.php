<div class="subpage group" style="margin:10px auto 0 auto">
    <div class="nseeate" style="width:1140px;">
        <div class="neipadd">
            <ul>
                <li class="stes"> 地址：<?= $varpool['roomdetail']['craddress']?></li>
                <li class="paees">电话：<?= $varpool['roomdetail']['crphone']?></li>
                <li class="elain">
                    <?php
                    if(empty($varpool['roomdetail']['cremail'])){
                        $prename = '主页';
                        $pre = '';
                        $varpool['roomdetail']['cremail'] = !empty($varpool['roomdetail']['fulldomain']) ? $varpool['roomdetail']['fulldomain'] : $varpool['roomdetail']['domain'].'.ebh.net';
                        if (strpos($varpool['roomdetail']['cremail'], 'http://') !== 0) {
                            $varpool['roomdetail']['cremail'] = 'http://'.$varpool['roomdetail']['cremail'];
                        }
                    } else {
                        if(preg_match('/^[a-zA-Z0-9_\-]{1,}@[a-zA-Z0-9_\-]{1,}\.[a-zA-Z0-9_\-.]{1,}$/',$varpool['roomdetail']['cremail'])){
                            $prename = "邮箱";
                            $pre = 'mailto:';
                        } else{
                            $prename = '主页';
                            $pre = '';
                            if (strpos($varpool['roomdetail']['cremail'], 'http://') !== 0) {
                                $varpool['roomdetail']['cremail'] = 'http://'.$varpool['roomdetail']['cremail'];
                            }
                        }
                    }
                    ?>
                    <?= $prename ?>：<a href="<?= $pre.$varpool['roomdetail']['cremail']?>" style="color:#666;"><?= $varpool['roomdetail']['cremail']?></a>
                </li>
                <?php
                    if (!empty($varpool['roomdetail']['kefuqq']) && !empty($varpool['roomdetail']['kefu'])) { ?>
                        <li class="tsqq1s">
                            <span style="float:left;">客服：</span>
                            <span class="qqwaik">
                         <?php if(!empty($varpool['roomdetail']['kefuqq'])){foreach($varpool['roomdetail']['kefuqq'] as $k=>$v){?>
                             <a class="qqlx" target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $v?>&amp;site=qq&amp;menu=yes">
                         <?php echo !empty($varpool['roomdetail']['kefu'][$k])?ssubstrch($varpool['roomdetail']['kefu'][$k],0,8):'在线客服'?></a>
                         <?php }} ?>
                    </span>
                        </li>
                    <?php }
                ?>

            </ul>
            <?php if(!empty($varpool['roomdetail']['lng']) && !empty($varpool['roomdetail']['lat'])){?>
            <div class="baidutu">
                <div id="container" style="height:100%" >
            </div>
            <?php }?>
        </div>
    </div>
</div>

<style type="text/css">
    .iw_poi_title {color:#CC5522;font-size:14px;font-weight:bold;overflow:hidden;padding-right:13px;white-space:nowrap}
    .iw_poi_content {font:12px arial,sans-serif;overflow:visible;padding-top:4px;white-space:-moz-pre-wrap;word-wrap:break-word}
    <?php if(!empty($varpool['roomdetail']['isdesign'])) { ?>.denser{margin:0 !important;}<?php } ?>
</style>
<script type="text/javascript">
    var defaultZoom = 16;	//默认缩放比例
    var mp;//地图
    var lng = '<?=!empty($varpool['roomdetail']['lng']) ? $varpool['roomdetail']['lng'] : ""?>';
    var lat = '<?=!empty($varpool['roomdetail']['lat']) ? $varpool['roomdetail']['lat'] : ""?>';
    var crname = '<?=!empty($varpool['roomdetail']['crname']) ? $varpool['roomdetail']['crname'] : ""?>';
    var address = '<?= !empty($varpool['roomdetail']['craddress']) ? $varpool['roomdetail']['craddress']: "" ?>';
    lng = lng ? lng : 120.137383;
    lat = lat ? lat : 30.279108;
    crname = crname ? crname : 'e板会网校';
    address = address ? address : '浙江省杭州市西湖区德力西大厦1号楼802F';

    //标注json
    var json = {title:crname,content:address,point:{lng:lng,lat:lat},isOpen:1,icon:{w:35,h:25,l:0,t:0,x:6,lb:10}};
    //异步加载
    function loadScript() {
        var script = document.createElement("script");
        script.src = "http://api.map.baidu.com/api?v=2.0&ak=H8Y9OO2Gt8C584uRpzC4LED4&callback=initialize";
        document.body.appendChild(script);
    }
    $(function(){
        loadScript();
    });
    //异步加载后回调 初始化
    function initialize() {
        mp = new BMap.Map('container');
        addMarker(json);//向地图中添加marker
        mp.enableScrollWheelZoom();
        //右上角，仅包含平移和缩放按钮
        mp.addControl(new BMap.NavigationControl({anchor: BMAP_ANCHOR_TOP_LEFT, type: BMAP_NAVIGATION_CONTROL_SMALL}));

    }

    ////////////////////////////////

    //创建marker
    function addMarker(json){
        var point = new BMap.Point(json.point.lng,json.point.lat);
        var iconImg = createIcon(json);
        //var marker = new BMap.Marker(point,{icon:iconImg});
        var marker = new BMap.Marker(point);
        var info = createInfoWindow(json);
        var label = new BMap.Label(json.content,{"offset":new BMap.Size(json.icon.lb-json.icon.x+10,-20)});
        mp.centerAndZoom(point, defaultZoom);
        mp.addOverlay(marker);
        marker.setLabel(label);
        label.setStyle({
            borderColor:"#808080",
            color:"#333",
            cursor:"pointer"
        });

        marker.addEventListener("click",function(){
            this.openInfoWindow(info);
        });
        info.addEventListener("open",function(){
            marker.getLabel().hide();
        })
        info.addEventListener("close",function(){
            marker.getLabel().show();
        })
        label.addEventListener("click",function(){
            marker.openInfoWindow(info);
        })
        if(json.isOpen){
            label.hide();
            marker.openInfoWindow(info);
        }
    }
    //创建InfoWindow
    function createInfoWindow(json){
        var iw = new BMap.InfoWindow("<b class='iw_poi_title' title='" + json.title + "'>" + json.title + "</b><div class='iw_poi_content'>"+json.content+"</div>");
        return iw;
    }
    //创建一个Icon
    function createIcon(json){
        var icon = json.icon;
        //http://api0.map.bdimg.com/images/marker_red_sprite.png
        //http://map.baidu.com/image/us_cursor.gif
        var icons = new BMap.Icon("http://api0.map.bdimg.com/images/marker_red_sprite.png", new BMap.Size(icon.w,icon.h),{imageOffset: new BMap.Size(-icon.l,-icon.t),infoWindowOffset:new BMap.Size(icon.lb+5,10),offset:new BMap.Size(icon.x,icon.h)})
        return icons;
    }
</script>
    <script src="http://static.ebanhui.com/design/js/getroominfo.js"></script>
    <script src="http://static.ebanhui.com/design/js/player.js"></script>
