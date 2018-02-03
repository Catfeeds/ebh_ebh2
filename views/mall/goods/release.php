<?php $this->display('mall/header') ?>
<script src="http://static.ebanhui.com/mall/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/mall/css/jquery.Jcrop.css"/>
<style>
.tips{
	font-size:12px;
}
.ui-dialog2-content{
	overflow: hidden;
}
.zxx_out_box{margin:0 auto;}
.zxx_main_con{
	width: 330px;
	height: 330px;
	float: left;
}
.zxx_test_list{
	width: 330px;
	height: 330px;
	border: 1px solid #e6e6e6;
	border-radius: 5px;	
	position: relative;
	background: url(http://static.ebanhui.com/mall/img/photo_bg.jpg);
}
.rel{
	width: 330px;
	height: 330px;
	position:relative;
	margin: 0 auto;
}
.abs{position:absolute;}
.fixed{position:fixed;}
.love_img_btn{ text-align:center; margin-top:30px;}
.btn2{ font-size:12px; color:#FFF; text-align:center; width:79px; height:30px; line-height:30px; border:none; background:url(../style/images/btn_bg1.png) no-repeat;}
.jcrop-holder { 
	float:left;
	background-color: #fff !important;
}

.jcrop-keymgr{
	display: none !important;
}
/*控制预览图大小*/
.crop_preview{float:left;margin-left:20px;width:66px;height:66px;overflow:hidden;}
.clear{clear:both}
.btn{cursor:pointer}
.tl{text-align:left}
.tc{text-align:center}
.ml10 {margin-left:10px;}
.mt10 {margin-top:10px;}
.ml-180{margin-left:-180px;}

.jcrop-holder{
	width: 330px!important;
}
.jcrop-holder #preview-pane {
  display: block;
  position: absolute;
  z-index: 2000;
  top: 65px;
  right: -260px;
  border: 1px #e6e6e6 solid;
  background-color: white;
  -webkit-border-radius: 6px;
  -moz-border-radius: 6px;
  border-radius: 6px;
}

/* The Javascript code will set the aspect ratio of the crop
   area based on the size of the thumbnail preview,
   specified here */
#preview-pane .preview-container {
  width: 220px;
  height: 220px;
  overflow: hidden;
}
.img_container{
    width: 330px;
    height: 330px;
    display: inline-block;
    border: 1px solid #e6e6e6;
    position: relative;
    border-radius: 5px;
}
.forOther{
	background: url(http://static.ebanhui.com/mall/img/clickIcon.jpg) center center no-repeat;
}
.forIe{
	background: url(http://static.ebanhui.com/mall/img/clickIconforIE.jpg) center center no-repeat;
}
#head_photo{
	display: inline-block;
	position: absolute;
	z-index: 999;
    left: 0px;
    top: 0px;
    width: 330px;
    height: 330px;
    opacity: 0;
    filter: alpha(opacity=0);
    cursor: pointer;
}
#photo_pic{
	display: none;
}
.images_tips {
	position: absolute;
	top: -80px;
	right: 15px;
	width: 200px;
	text-align: justify;
	color: #fe2725;
}
.tips {
	position: absolute;
	left: 0;
	bottom: -20px;
	font-size: 12px;
	color: #999999;
}
/*这里是鼠标预览小图的样式*/
.imgviews{
	position: relative;
}
.photobubbles_box{
	width: 100px;
	height: 56.25px;
	position: absolute;
	top: -56px;
	right: -100px;
	z-index: 999;
	overflow: hidden;
	opacity: 0;
	filter: alpha(opacity=0);
	display: none;
}
.photobubbles{
	width: 100px;
	height: 56.25px;
	border: 0 none;
}
</style>
<body>
<div class="buygoods">
    <div class="buygoodson buygoodsonfb-1">
        <div class="work_menu delivery-title" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">商品发布</span></a></li>
			</ul>
			<p class="red">提示：为了让买家顺利的与您联系。请务必设置好您的QQ授权代码，<a href="/homev2/profile/profile.html#QQsqm" class="goset1s" target="_blank">去设置</a></p>
		</div>
        <div class="mallrelease">
            <div class="mallproperty malltitle-1">
                <span class="mallspan">属性：</span>
                <input type="radio"  name="gtype" id="new" value="1" checked/>
                <label for="new">全新商品</label>
                <input type="radio"  name="gtype" id="old" value="2" <?= isset($goods['new']) && $goods['new'] == 2 ? 'checked':''; ?>/>
                <label for="old" class="secondhandgoods">二手商品</label>
                <span class="import">*</span>
            </div>
            <div class="malltitle-1">
                <span class="mallspan">标题：</span>
                <input type="text" class="titleinput-1" name="gname" id="gname" value="<?= isset($goods['gname']) ? $goods['gname'] :'' ?>" />
                <span class="wordlimit"><span id="num"><?= isset($goods['gname']) ?  mb_strlen($goods['gname'],'UTF-8'):0 ?></span>/30</span>
                <span class="import">*</span>
                <span class="explain-1 gtitle" style="display:none">请填写商品标题</span>
            </div>
            <div class="malltitle-1">
                <input type="hidden" name="tags" id="tags" value="<?= empty($goods['tags']) ? '' : implode(',', $goods['tags'])?>" />
                <input type="hidden" name="checksum" id="checksum" value="" />
                <span class="mallspan fl">标签：</span>
                <ul class="labelul-1"  id="tagItem">
                    <?php if(!empty($goods['tags'])){ ?>
                        <?php foreach ($goods['tags'] as $key => $tag) { ?>
                            <li class="mylabel-1" id="tag<?= $key ?>">
                                <span class="labeleft-1"></span>
                                <div class="bqnr-2">
                                    <a class="labelnode-1" href="javascript:void(0)"><?= $tag ?></a>
                                    <a class="labeldel-1 pageDel_label" title="删除标签" href="javascript:void(0)" onclick="removeTag(<?= $key ?>)">
                                    <img src="http://static.ebanhui.com/ebh/tpl/default/images/transparent.gif"></a>
                                </div>
                                <span class="labelright-1"></span>
                            </li>
                        <?php } ?>    
                    <?php } ?>
                    <li class="addBtn">
                        <div class="addlabel-1" style="<?php if(!empty($goods['tags']) && count($goods['tags']) ==3 ){ echo "display:none";}?>">
                            <span class="addlabelspan1">+</span>
                            <span class="addlabelspan2">添加标签</span>
                        </div>
                    </li>
                </ul>
                <span class="import fl">*</span>
                <span class="explain-1 gtags" style="display:none">请选择标签</span>
            </div>
            <div >
                <div class="malltitle-1">
                    <span class="mallspan">价格/积分：</span>
                    <input type="radio"  name="price" id="pradio" value="1" <?= isset($goods['is_real']) && $goods['is_real']== 1 ? 'checked':'' ?> <?= !isset($goods['is_real']) ? 'checked' : '' ?> />
                    <!--不可点击添加class="notclick"-->
                    <div class="integralprice price1 <?= isset($goods['is_real']) && $goods['is_real']==2 ? 'notclick':'' ?>">
                        <label class="btntri" for="pradio">一口价</label>
                        <input type="text" class="priceinput" id="gprice" value="<?= isset($goods['is_real']) && $goods['is_real'] == 2   ? '' :(isset($goods['price']) && floatval($goods['price']) ? $goods['price'] : ''); ?>" />
                        <span>元</span>
                    </div>
                    <span class="import">*</span>
                    <span class="explain-1 gprice" style="display:none">请填写商品价格</span>
                </div>
                <div class="malltitle-1">
                    <span class="mallspan"></span>
                    <input type="radio"  name="price" id="sradio" value="2" <?= isset($goods['is_real']) && $goods['is_real']==2 ? 'checked':'' ?> />
                    <!--不可点击添加class="notclick"-->
                    <div class="integralprice <?= isset($goods['is_real']) && $goods['is_real']==2 ? '':'notclick' ?> price2">
                        <label class="btntri" for="sradio">积分价</label>
                        <input type="text" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" class="priceinput" id="sprice" disabled="disabled" value="<?= empty($goods['score']) ? '' :$goods['score']; ?>"  />
                        <span>积分</span>
                    </div>
                    <span class="import">*</span>
                    <span class="explain-1 sprice" style="display:none">请填写商品积分</span>
                </div>
           </div>
              
            <div class="malltitle-1">
                <span class="mallspan">库存：</span>
                <input type="text" class="stockinput" id="inventory" value="<?= isset($goods['stock'])? $goods['stock'] : ''?>"/>
                <span class="fontsize15">件</span>
                <span class="import">*</span>
                <span class="explain-1 gstore" style="display:none">请填写商品库存</span>
            </div>
            <div class="malltitle-1 takedollor" style="<?php if( isset($goods['is_real']) && $goods['is_real']==2 ){ echo 'display:none';} ?>">
                <span class="mallspan">运送费：</span>
                <input type="text" class="stockinput" id="freight" value="<?= isset($goods['freight'])? $goods['freight'] : ''?>"/>
                <span class="fontsize15">元</span>
                <span class="import">*</span>
                <span class="explain-1 gticket" style="display:none">请填写商品运费</span>
            </div>
            <div class="malltitle-1">
                <span class="mallspan fl">发货地址：</span>
                <span class="fontsize15 sendaddress fl" id="sendaddress"><?= isset($goods['fulladdress'])? $goods['fulladdress'] : ''?></span>
                <span class="import fl">*</span>
                <a href="javascript:void(0)" class="replaceaddress fl" id="replaceAds"><?= isset($goods['fulladdress'])? '修改地址' : '填写地址'?></a>
                <span class="explain-1 addrinfo" style="display:none">请填发货地址</span>
            </div>
			<div class="clear"></div>
			<!--上传封面-->
			<div class="malltitle-1">
                <span class="mallspan fl">商品封面：</span>

				<div class="productcoverfa notup " style="<?= isset($goods) ? 'display:none':'' ?>">
					<a href="javascript:void(0)" class="productcover upload_images_cover">上传封面</a>
					<span class="import">*</span>
                    <span class="explain-1 cover" style="display:none">请上传商品封面</span>
				</div>
				<div class="productcoverfa hasup" style="<?= isset($goods) ? 'display:block':'display:none' ?>">
					<a href="javascript:void(0)" class="productcover upload_images_cover">重新上传</a>
					<!--点击图片预览弹出弹框-->
					<a href="javascript:void(0)" class="imgviews" onclick="showimg()">图片预览
						<div class="photobubbles_box">
							<img class="photobubbles" src="<?= !empty($goods['images']) ? $showpath.$goods['images'][0]['path']: '' ?>" alt="" />
						</div>
					</a>
					<span class="upcolor">上传成功！</span>
					<span class="upcolor" style="display:none;">上传失败！</span>
					<span class="import">*</span>
                    <input type="hidden" id="cover_sid" value="<?= isset($goods) ? $goods['images'][0]['sid'] : ''?>">
				</div>
            </div>
            <div class="malltitle-1">
                <?php 
                    $pics_sid = '';
                    if(isset($goods)){
                        $ids = array_column($goods['images'],'sid');
                        unset($ids[0]);
                        $pics_sid = implode(',', $ids);
                    }
                ?>
                <input type="hidden" id="pics_sid" value="<?= $pics_sid.',' ?>">
                <span class="mallspan upimagesfl">商品轮播图：</span>
                <div class="upimages-1">
                    <?php if(!empty($goods['images'])){ ?>
                        <?php for($i = 1; $i< count($goods['images']);$i++) { ?>
                            <div class='upimgs'>
                                <img src='<?= $showpath.$goods['images'][$i]['path'] ?>' width='90' height='90' class='upload_images1' />
                                <a href='javascript:void(0)' sid='<?= $goods['images'][$i]['sid'] ?>' onclick='closeImg(this)' style='display:block'>
                                    <img src='http://static.ebanhui.com/mall/img/delico.png' width='20' height='20'/>
                                </a>
                            </div>
                        <?php }?>    
                    <?php } ?>
                    <?php if(!empty($goods['images']) && count($goods['images']) < 6){ ?>   
                        <div class="upimgs" id="emptyupimgs">
                            <img src="http://static.ebanhui.com/mall/img/upic.png" width="90" height="90" class="upload_images" />
                            <a href="javascript:void(0)" class="close_img"><img src="http://static.ebanhui.com/mall/img/delico.png" width="20" height="20" /></a>
                        </div>
                    <?php }elseif(!empty($goods['images']) && count($goods['images']) == 6){ ?>
            
                    <?php }else{?>
                        <div class="upimgs" id="emptyupimgs">
                            <img src="http://static.ebanhui.com/mall/img/upic.png" width="90" height="90" class="upload_images" />
                            <a href="javascript:void(0)" class="close_img"><img src="http://static.ebanhui.com/mall/img/delico.png" width="20" height="20" /></a>
                        </div>
                    <?php }?>
                    <?php
                        $mids = '';
                        if(!empty($goods['images'])){
                            $mids = implode(',', array_column($goods['images'],'mid'));
                        }
                    ?>
                    <input type="hidden" id="mids" value="<?= $mids ?>">
                </div>
                <div class="fl">
                    <p class="uploadprompt ml10" >请至少上传一张图片<br />图片尺寸保持1:1即可</p>
                    <p class="wordlimit ml10"><br /><span id="counter"><?=empty($goods['images']) ? 0 : count($goods['images'])-1?></span>/5</p>
                </div>
            </div>
            <div class="malltitle-1">
                <span class="mallspan fl">商品详情：</span>
                <div class="txtxdaru" style="margin-left: 95px;">
                    <?php
                    $editor = Ebh::app()->lib('UMEditor');
                    $editor->xEditor('message','840px','600px',empty($goods['descr']) ? '': $goods['descr']); ?>
                </div>

            </div>
        </div>
        <input type="hidden" name="action" value="<?= isset($goods) ? 'upd': 'add' ?>">
        <input type="hidden" name="gid" value="<?= isset($goods) ? $goods['gid']: '' ?>">
        <?php 
            // var address = province_code+'-'+city_code+'-'+area_code+'--'+province+'-'+city+'-'+area+'--'+detailedAds_box;
            $addrinfo = '';
            if(!empty($goods)){
                $preAddr = $goods['province_name'].$goods['city_name'].$goods['district_name'];
                $sufAddr = str_replace($preAddr, '', $goods['fulladdress']);
                $addrinfo = $goods['province'].'-'.$goods['city'].'-'.$goods['district'].'--'.$goods['province_name'].'-'.$goods['city_name'].'-'.$goods['district_name'].'--'.$sufAddr;
            }
        ?>
        <input type="hidden" id="addrinfo" value="<?= $addrinfo ?>">
       
        <a href="javascript:void(0)" class="issued" onclick="sendform()">发布</a>
    </div>
</div>



<!-- 选择标签弹框 start -->
<div class="addLabel1" style="display: none;">
    <p class='clues'>现有标签</p>
    <ul class='labelList1'>

    </ul>
    <div class='labels'>
        <p class='clues'>新增标签<span style="font-size:12px;color:#999;">（最多添加3个标签）</span></p>
        <ul class='labelList2'>

        </ul>
        <p class="labelTips" style="opacity:0;filter:alpha(opacity=0);position: absolute;right: 0;top:50px;font-size: 14px;color: #ffaf29;">该标签已经添加！</p>
    </div>
</div>
<!-- 选择标签弹框 end -->

<!-- 更换地址弹窗 start -->

<div class="replaceAds" style="display:none;">

            <div id='city_china' class="city_china_Box">      
                <span class='txtMsg'>发货地址：</span>
                <?php if(isset($goods)){ ?>
                    <select id="s_province" name="s_province" class='province' style="margin-right: 14px;">
                        <option areacode="<?=$goods['province']?>"><?=$goods['province_name']?></option>
                    </select>
                    <select id="s_city" name="s_city" class='city' style="margin-right: 14px;">
                        <option areacode="<?=$goods['city']?>"><?=$goods['city_name']?></option>
                    </select>
                    <select id="s_county" name="s_county" class='area' style="margin-right: 0;">
                        <option areacode="<?=$goods['district']?>"><?=$goods['district_name']?></option>
                    </select>
                <?php }else{?>
                    <select id="s_province" name="s_province" class='province' style="margin-right: 14px;">
                        <option value="">选择省</option>
                    </select>
                    <select id="s_city" name="s_city" class='city' style="margin-right: 14px;">
                        <option value="">选择市</option>
                    </select>
                    <select id="s_county" name="s_county" class='area' style="margin-right: 0;">
                        <option value="">选择区</option>
                    </select>
                <?php } ?>        
                <p class="profileTips sameTips" style=""></p>
            </div>

            <div class="ads_Box">
                <span class="txtMsg">详细地址：</span>
                <textarea class="detailedAds_box" maxlength="40" style="font-weight:normal;color:#000;"><?= empty($goods['address']) ? '' : $goods['address']  ?></textarea>
                
                <span style="position: absolute;bottom: 0px;right:12px"><b class="haveLen">0</b>/<b class="remLen">40</b></span>
                <p class="AdsTips sameTips" style=""></p>
            </div>
            <?php 
                $addrinfo = '';
                if(isset($goods)){
                    $addrinfo  = $goods['province'].'-'.$goods['city'].'-'.$goods['district'];
                    $addrinfo .= '--';
                    $addrinfo .= $goods['province_name'].'-'.$goods['city_name'].'-'.$goods['district_name'];
                    $addrinfo .= '--';
                    $addrinfo .= $goods['address'];
                }
            ?>
            
</div>

<!-- 更换地址弹窗 end -->
<!-- 展示封面图弹框 -->
<div class="coverimg" style="display:none;">
    <img src="<?= !empty($goods['images']) ? $showpath.$goods['images'][0]['path']: '' ?>" id="coverimg" width="100%">           
</div>
<input type="hidden" id="coverorCarousel" value="0" />
<script type="text/javascript">
	//标题
	var $titleinput_1 = $(".titleinput-1");//标题输入框
	var gtitle = $(".gtitle");  //标题输入框提示
	$titleinput_1.on("blur keyup",function(){
		if($(this).val() == ""){
			gtitle.show();
		}else{
			gtitle.hide();
		}
	});
	$titleinput_1.focus(function(){
		$(this).addClass("on");
	});
	$titleinput_1.blur(function(){
		$(this).removeClass("on");
	});
	//这里还缺一块添加标签的提示信息
	
	
	
	//价格/积分
	var $btntri = $(".btntri");
	$btntri.click(function(){
		$(this).parent().parent().siblings().find(".explain-1").hide();
	});
	var $gprice = $("#gprice"); //价格输入框
	var $$gprice = $(".gprice"); //价格提示信息
	$gprice.on("blur keyup",function(){
		var theval = $(this).val();
		clearNoNum($(this)[0]);
		// $(this).val(theval);
		if($(this).val() == ""){
			$$gprice.show();
		}else{
			$$gprice.hide();
		}
		if($(this).val()>9999.99){
			$(this).val(9999.99);
		}
	});
	
	function clearNoNum(obj){ 
		obj.value = obj.value.replace(/[^\d.]/g,"");  //清除“数字”和“.”以外的字符  
		obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的  
		obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$","."); 
		obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3');//只能输入两个小数  
		if(obj.value.indexOf(".")< 0 && obj.value !=""){//以上已经过滤，此处控制的是如果没有小数点，首位不能为类似于 01、02的金额 
			obj.value= parseFloat(obj.value); 
		} 
	} 
	// var reg = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;
	// $gprice.on("blur",function(){
		// if(!reg.test($(this).val())){
			// $(this).val("");
		// }
	// });
	// $gprice.on("keyup",function(){
		
	// });
	$gprice.focus(function(){
		$(this).addClass("on");
	});
	$gprice.blur(function(){
		$(this).removeClass("on");
	});
	var $sprice = $("#sprice");//积分输入框
	var $$sprice = $(".sprice");//积分提示信息
	$sprice.on("blur keyup",function(){
		if($(this).val() == ""){
			$$sprice.show();
		}else{
			$$sprice.hide();
		}
	});
	$sprice.on("keyup",function(){
		if($(this).val() < 1){
			$(this).val("");
		}
	});
	$sprice.focus(function(){
		$(this).addClass("on");
	});
	$sprice.blur(function(){
		$(this).removeClass("on");
	});
	//库存
	var $inventory = $("#inventory");//库存输入框
	var $gstore = $(".gstore");//库存提示信息
	$inventory.on("blur keyup",function(){
		var theval = $(this).val();
		$(this).val(theval.replace(/[^\d]/g,''));
	
		if($(this).val() == ""){
			$gstore.show();
		}else{
			$gstore.hide();
		}
		if($(this).val()>9999){
			$(this).val(9999);
		}
	});
	$inventory.focus(function(){
		$(this).addClass("on");
	});
	$inventory.blur(function(){
		$(this).removeClass("on");
	});
	//运送费
	var $freight = $("#freight");//运送费输入框
	var $gticket = $(".gticket");//运送费提示信息
	$freight.on("blur keyup",function(){
		var theval = $(this).val();
		clearNoNum($(this)[0]);
		if($(this).val() == ""){
			$gticket.show();
		}else{
			$gticket.hide();
		}
		
		if($(this).val()>999.99){
			$(this).val(999.99);
		}
	});
	
	
	// var postageReg = /^(0|[1-9]|[1-9][0-9]|[1-9][0-9][0-9]|[1-9][0-9][0-9][0-9]?)(\.[0-9]{2})?$/;
	// $freight.on("blur",function(){
		// if(!postageReg.test($(this).val())){
			// $(this).val("");
		// }
	// });
	$freight.focus(function(){
		$(this).addClass("on");
	});
	$freight.blur(function(){
		$(this).removeClass("on");
	});
	
    // 添加标签
    	var $addLabel = $(".addLabel1")[0];
    	<?php 
            if(!empty($goods['tags'])){
                $str = ''; 
                foreach ($goods['tags'] as $tag) {
                  $str .= "'".$tag."',";
                }
                $str = trim($str,',');
            } 
        ?>
        <?php if(isset($str) && $str!=''){ ?>
            var $topArr = [<?= $str ?>];
        <?php }else{ ?>
            var $topArr=[];
        <?php } ?>    
        var $bottomArr=[];
        var $addlabel_1 = $(".addlabel-1");
        var $labelList1=$(".labelList1");
        var $labelList2=$(".labelList2");
        var $labelTips=$(".labelTips");
        var $tagItem = $("#tagItem");
       	$addlabel_1.on("click",function(){
        	 //初始化弹框标签
	        function initTags(){
	            $.post('/mall/goods/tags.html',{},function(data){
	                for(var i in data){
	                    $bottomArr.push(data[i]);
	                }
	                $bottomArr = arrRepeat($bottomArr);
	                ergodicB();
	            },'json');
	        }
	        initTags();
			ergodicA();
            top.dialog({   

                title : "添加标签",
                content : $addLabel,
                okValue : "保存",
                ok : function(){
                	$('.addBtn').siblings().remove();//点击添加标签将页面中的删除
                	if($topArr.length == 0){
                		return false;
                	}else{
                		// 页面展示所选择标签
                        $(".gtags").hide();
                		for(var i=0;i<$topArr.length;i++){
	                  		var tagsItem =  '<li class="mylabel-1" id="tag'+i+'"><span class="labeleft-1"></span><div class="bqnr-2"><a class="labelnode-1" href="javascript:void(0)">'+$topArr[i]+'</a><a class="labeldel-1 pageDel_label" title="删除标签"  href="javascript:void(0)"><img src="http://static.ebanhui.com/ebh/tpl/default/images/transparent.gif"></a></div><span class="labelright-1"></span></li>';
				            $('#tagItem').prepend(tagsItem);
	                  	}
	                    if($(".labelul-1 .mylabel-1").length >= 3){
	                        $(".labelul-1 li").last().hide();
	                    }
                	}
                },
                width : "400",
                height : "180"
            }).showModal();

        });
        
        $tagItem.on("click","li .pageDel_label",function(){
        	$(this).parent().parent().remove();
        	var $labelVal = $(this).prev().html();
        	for(var i=0;i<$topArr.length;i++){
        		if($labelVal == $topArr[i]){
        			$topArr.splice(i,1);
        		}
        	}
        	ergodicA();
        	removeTag('+i+');
        });
        
        $labelList1.on("click","li .closeBtn",function(){
            var nowIndex=$(this).parent().index();
            $topArr.splice(nowIndex,1);
            ergodicA();
        });
        $labelList2.on("click","li", function() {
            var labelText_bottom = $(this).html();
            if($topArr.length == 0){
                $topArr.push(labelText_bottom);
            }else if($topArr.length == 1){
            	if($topArr[0] != labelText_bottom){
            		$topArr.push(labelText_bottom);
            	}else{
            		$labelTips.animate({opacity:1},300,function(){
            			setTimeout(function(){
            				$labelTips.animate({opacity:0},300);
            			},2000);
            		});
            		return false;
            	}
            }else if($topArr.length == 2){
            	if($topArr[0] == labelText_bottom || $topArr[1] == labelText_bottom){
            		$labelTips.animate({opacity:1},300,function(){
            			setTimeout(function(){
            				$labelTips.animate({opacity:0},300);
            			},2000);
            		});
            		return false;
            	}else{
            		$topArr.push(labelText_bottom);
            	}
            }else if($topArr.length == 3){
            	return false;
            }
            ergodicA();
       });
        
        function ergodicA(){
            $labelList1.empty();
            for(var i=0;i<$topArr.length;i++){
                var $newP="<li><span class='label_text'>"+$topArr[i]+"</span> <span class='closeBtn'><img src='http://static.ebanhui.com/mall/img/closeBtn.jpg' /></span></li>";
                $labelList1.append($newP);
            }
        }
        function ergodicB(){
            $labelList2.empty();
            for(var i=0;i<$bottomArr.length;i++){
                var $newP="<li>"+$bottomArr[i]+"</li>";
                $labelList2.append($newP);
            }
        }
        //数组去重
        function arrRepeat(arr){ 
			var res = [];
			var json = {};
			for(var i = 0; i < arr.length; i++){
			 	if(!json[arr[i]]){
				  	res.push(arr[i]);
				   	json[arr[i]] = 1;
				}
			}
			return res;
		}
</script>
<script type="text/javascript">
    <?php if(isset($goods)){ ?>
        var last_province_code = <?= $goods['province'] ?>;
        var last_city_code = <?= $goods['city'] ?>;
        var last_area_code = <?= $goods['district'] ?>;
        var last_province = <?= "'".$goods['province_name']."'" ?>;
        var last_city = <?= "'".$goods['city_name']."'" ?>;
        var last_area = <?= "'".$goods['district_name']."'" ?>;
    <?php }else{ ?>
        var last_province_code = undefined;
        var last_city_code = undefined;
        var last_area_code = undefined;
        var last_province = undefined;
        var last_city = undefined;
        var last_area = undefined;
    <?php } ?>
    // 替换地址
	    var $remLen = $(".remLen");
	    var $haveLen = $(".haveLen");
	    var len = 0;
    	$(".detailedAds_box").bind("input propertychange", function() {
			len = $(this).val().length;
			$remLen.html(40 - len);
			$haveLen.html(len);
		});
    	var $repalceAds = $(".replaceAds")[0];
    	var $detailedAds_box = $('.detailedAds_box');
    	var $sendaddress = $('#sendaddress');
    	var $addrinfo = $('#addrinfo');
    	
    	var $s_province = $("#s_province");
		var $s_city = $("#s_city");
		var $s_county = $("#s_county");
		var province_data,
			city_data,
			pro_sec,
			city_sec,
			county_sec,
			city_index,
			county_index;			//////////////////////////////////////////
        $("#replaceAds").on("click",function(){
        	
            top.dialog({			
                title : "编辑地址",
                content : $repalceAds,
                okValue : "保存",
                ok : function(){
                    var province_code = $s_province.find("option:selected").attr('areacode');
                    var province = $s_province.find("option:selected").text();
                   
                    var city_code = $s_city.find("option:selected").attr('areacode');
                    var city = $s_city.find("option:selected").text();
                    
                    var area_code = $s_county.find("option:selected").attr('areacode');
                    var area = $s_county.find("option:selected").text();
                    if(province_code == undefined){
                        province_code = last_province_code;
                        city_code = last_city_code;
                        area_code = last_area_code;
                        province = last_province;
                        city = last_city;
                        area = last_area;
                    }
                    if(province_code == undefined || province == undefined || city_code == undefined || city == undefined || area_code == undefined || area == undefined){
                        top.dialog({
                            title : "添加错误",
                            content : "请填写发货地址",
                            okValue : "确定",
                            ok : function(){
								
                            },
                            width : "200px",
                            height : "60px"
                        }).showModal();
                        return;
                    }
                    var detailedAds_box = $detailedAds_box.val();
                    if(detailedAds_box == undefined || detailedAds_box == ''){
                       top.dialog({
                            title : "添加错误",
                            content : "请填写发货详细地址",
                            okValue : "确定",
                            ok : function(){
								
                            },
                            width : "200px",
                            height : "60px"
                        }).showModal();
                        return; 
                    }
                    var address = province_code+'-'+city_code+'-'+area_code+'--'+province+'-'+city+'-'+area+'--'+detailedAds_box;
                    var showaddress = province+' '+city+' '+area+' '+detailedAds_box;
                    $sendaddress.html(showaddress);
                    $addrinfo.val(address);
                    $('#replaceAds').text('编辑地址');
                    $(".addrinfo").hide();
                    top.resetmain();
                },
                onshow : function(){
                	pro_sec = $s_province.find("option:selected").text();
                	city_sec = $s_city.find("option:selected").text();
                	county_sec = $s_county.find("option:selected").text();
                	if(pro_sec == "选择省"){
						$.ajax({
							type:"get",
							url:"/mall/shop/ajaxGetArea.html?",
							dataType : "json",
							async : false,
							success : function(data){
								province_data = data;
								for(var i=0;i<data.length;i++){
									var provinceList = "<option areacode=" + data[i].areacode + ">"+data[i].cityname+"</option>";
									$s_province.append(provinceList);
								}
							}
						});
					}else{
						$.ajax({
							type:"get",
							url:"/mall/shop/ajaxGetArea.html?",
							dataType : "json",
							async : false,
							success : function(data){
								province_data = data;
								$s_province.empty();
								$s_province.append("<option>选择省</option>");
								for(var i=0;i<data.length;i++){
									var provinceList = "<option areacode=" + data[i].areacode + ">"+data[i].cityname+"</option>";
									$s_province.append(provinceList);
									if(pro_sec === data[i].cityname){
										$s_province.children().eq(i+1).prop("selected","selected");
										city_index = i;
									}
								}
								$.ajax({
									type:"get",
									url:"/mall/shop/ajaxGetArea.html?parent_areacode="+data[city_index].areacode+"",
									dataType : "json",
									async : false,
									success : function(data){
										$s_city.empty();
										city_data = data;
										for(var i=0;i<data.length;i++){
											var cityList = "<option areacode="+data[i].areacode+">"+data[i].cityname+"</option>";
											$s_city.append(cityList);
											if(city_sec === data[i].cityname){
												$s_city.children().eq(i).prop("selected","selected");
												county_index = i;
											}
										}
										$.ajax({
											type:"get",
											url:"/mall/shop/ajaxGetArea.html?parent_areacode="+city_data[county_index].areacode+"",
											dataType : "json",
											async : false,
											success : function(data){
												$s_county.empty();
												for(var i=0;i<data.length;i++){
													var countyList = "<option areacode="+data[i].areacode+">"+data[i].cityname+"</option>";
													$s_county.append(countyList);
													if(county_sec === data[i].cityname){
														$s_county.children().eq(i).prop("selected","selected");
													}
												}
											}
										});
									}
								});
								
							}
						});
					}
					$s_province.on("change",function(){
						var pro_sec = $s_province.find("option:selected").text();
						var index_pro = $s_province.find("option:selected").index();
						if(pro_sec == "选择省"){
							$s_city.empty();
							$s_county.empty();
							var option_city = "<option>选择市</option>";
							$s_city.append(option_city);
							var option_county = "<option>选择区</option>";
							$s_county.append(option_county);
						}else{
							var province_areacode = province_data[index_pro-1].areacode;
							$s_city.empty();
							$.ajax({
								type:"get",
								url:" /mall/shop/ajaxGetArea.html?parent_areacode="+province_areacode+"",
								dataType : "json",
								async : false,
								success : function(data){
									for(var i=0;i<data.length;i++){
										var cityList = "<option areacode="+data[i].areacode+">"+data[i].cityname+"</option>";
										$s_city.append(cityList);
									}
									$.ajax({
										type:"get",
										url:"/mall/shop/ajaxGetArea.html?parent_areacode="+data[0].areacode+"",
										dataType : "json",
										async : false,
										success : function(data){
											$s_county.empty();
											for(var i=0;i<data.length;i++){
												var countyList = "<option areacode="+data[i].areacode+">"+data[i].cityname+"</option>";
												$s_county.append(countyList);
											}
										}
									});
								}
							});
						}
					});
					$s_city.on("change",function(){
						var index_pro = $s_province.find("option:selected").index();
						var index_city = $(this).find("option:selected").index();
						$.ajax({
							type : "get",
							url : "/mall/shop/ajaxGetArea.html?parent_areacode="+province_data[index_pro-1].areacode+"",
							dataType : "json",
							async : false,
							success : function(data){
								$.ajax({
									type:"get",
									url:"/mall/shop/ajaxGetArea.html?parent_areacode="+data[index_city].areacode+"",
									dataType : "json",
									async : false,
									success : function(data){
										$s_county.empty();
										for(var i=0;i<data.length;i++){
											var countyList = "<option areacode="+data[i].areacode+">"+data[i].cityname+"</option>";
											$s_county.append(countyList);
										}
									}
								});
							}
						});
					});
                }
            }).showModal();
        });
</script>

<script type="text/javascript">
    function removeTag(tag) {
        $(".addlabel-1").show();
        $(".labelul-1 li").last().show();
        var tag_name = $('#tag'+tag+' div.bqnr-2 a:first-child').html();
        var tagItem = $('#tags').val();
        var tagArr = tagItem.split(",");
        if(!Array.indexOf)
        {
            Array.prototype.indexOf = function(obj)
            {              
                for(var i=0; i<this.length; i++)
                {
                    if(this[i]==obj)
                    {
                        return i;
                    }
                }
                return -1;
            }
        }
        var index = tagArr.indexOf(tag_name);
        if (index >= 0) {
            tagArr.splice(index,1);
        }
        var tagStr = tagArr.join(',');
        $('#tags').val(tagStr);
        $('#tag'+tag).remove();
        //删除弹框中对应的标签
        for(var i=0;i<$topArr.length;i++){
            if($topArr[i] == tag_name){
                $topArr.splice(i,1);
            }
        }
    }
    //字段校验
    function checkdata(){
        var flag = true;

        // 商品标题
        var gname = $('#gname').val();
        if(gname == ''){
            $(".gtitle").show();
            
            flag = false;
        }else{
            $(".gtitle").hide();
        }
        // 商品属性标签
        var tags = $('#tagItem').children().length;
        if(tags <=1 ){
            $(".gtags").show();
            
            flag = false;
        }else{
            $(".gtags").hide();
        }
        // 商品价格、积分
        var price_type = $("input[name='price']:checked").val();

        var price;
        $(".sprice").hide();
        $(".gprice").hide();
        if(price_type == 1){//普通商品
            price = $('#gprice').val();
            if(price == '' || isNaN(price) || price <= 0 ){
                $(".gprice").show();
                flag = false;
                
            }
        }else{//积分商品
            price = $('#sprice').val();
            if(price == '' || isNaN(price) || price <= 0 ){
                $(".sprice").show();
                flag =false;
                
            }
        }
        // 库存
        var inventory = $('#inventory').val();
        if(inventory == '' || isNaN(inventory) || inventory <= 0){
            $(".gstore").show();
            
            flag = false;
        }else{
            $(".gstore").hide();
        }
        // 运费
        var freight = $('#freight').val();
        if($('#sprice').val() == ""){
        	if(freight == '' || isNaN(freight) || freight <= 0 ){
	            $(".gticket").show();
	            
	            flag = false;
	        }else{
	            $(".gticket").hide();
	        }
        }
        
        // 发货地址
        var sendaddress = $('#sendaddress').html();
        $(".addrinfo").hide();
        if(sendaddress == ''){
            $(".addrinfo").show();
            
            flag = false;
        }else{
            $(".addrinfo").hide();
        }
        var cover_sid = $('#cover_sid').val();
        $(".cover").hide();
        if(cover_sid == ''){
            $(".cover").show();
            
            flag = false;
        }else{
            $(".cover").hide();
        }
        var descr = UM.getEditor('message').getContent();
        if(!descr){
            
            warnDesc();
            flag = false;
        }
        return flag;
    }
    // 发布商品
    function sendform() {
        if(!checkdata()){
            return false;
        }
        // 全新、二手 1全新 2二手
        var gtype = $("input[name='gtype']:checked").val();
        // 商品名称
        var gname = $('#gname').val();
        // 商品属性标签
        var labelfield = $topArr.join(",");
       	$('#tags').attr("value",labelfield);
        var tags = $('#tags').val();
        // 商品价格、积分
        var price_type = $("input[name='price']:checked").val();
        var price;
        if(price_type == 1){
            price = $("#gprice").val();
        }else{
            price = $("#sprice").val() ;
        }
        // 库存
        var inventory = $('#inventory').val();
        // 运费
        var freight = $('#freight').val();
        // 发货地址
        var addrinfo = $('#addrinfo').val();
        // 商品封面图片
        var cover_sid = $('#cover_sid').val();
        //轮播图
        var pics_sid = $('#pics_sid').val();

        // 商品详情
        var descr = UM.getEditor('message').getContent();
        // 图片信息
        var mids = $("#mids").val();
        // 表单行为
        var action = $("input[name='action']").val();
        var gid = $("input[name='gid']").val();
        var url = '/mall/goods/addoredit.html';
        if(pics_sid == ','){
            $(".uploadprompt").css('color','red');
            return ;
        }
        $.post(url,{
            gtype:gtype,
            gname:gname,
            tags:tags,
            price_type:price_type,
            price:price,
            inventory:inventory,
            freight:freight,
            addrinfo:addrinfo,
            cover_sid:cover_sid,
            pics_sid:pics_sid,
            descr:descr,
            mids:mids,
            gid:gid,
            action:action
        },function(data){
            location.href = '/mall/goods.html';
        },'json')
    }
</script>
<script type="text/javascript">
    $('#gname').bind('keyup', function() {
        if(30-$('#gname').val().length <= 0){
            $('#gname').val($('#gname').val().substring(0,30));
        }
        $('#num').html($('#gname').val().length);
                
    })
    
//  $('#freight').bind('keyup', function() {
//      if($('#freight').val() > 9999){
//          $('#freight').val(9999);
//      }
//              
//  })
    // $(".integralprice").click(function(){
    //     $(this).addClass('notclick');
    // })
    $("input[name='price']").click(function(){
        var val = $(this).val();
        if(val == 1){
            $('.price2').addClass('notclick');
            $('#sprice').attr('disabled',true);
            $('#gprice').attr('disabled',false);
            $('#sprice').val('');
            $('#gprice').val('');
            $('.price1').removeClass('notclick');
        }else{
            $('.price1').addClass('notclick');
            $('#sprice').attr('disabled',false);
            $('#gprice').attr('disabled',true);
            $('#sprice').val('');
            $('#gprice').val('');
            $('.price2').removeClass('notclick');
        }
    })
    var $coverimg = $(".coverimg");
    function showimg(){
        	dialog({

                title : "商品封面图",
                content : $coverimg,
                okValue : "确定",
                ok : function(){

                },
                width : "400px"
            }).showModal();
    }
    function warnDesc(){
         top.dialog({

                title : "请填写商品信息",
                content : "请填写商品信息",
                okValue : "确定",
                ok : function(){

                },
                width : "200px",
                height : "60px"
            }).showModal();
    }
    $("#sradio").click(function(){ //积分选框
    	$(".gprice").hide();
        if($(this).is(':checked')){
            $("#freight").attr('disabled','disabled');
            $("#freight").css('background','#e6e6e6');
            $(".takedollor").hide();
        }else{
        	$(".takedollor").show();
        }
		$(window.parent.parent.document.getElementById('mainFrame')).css('height',$('.buygoodson').outerHeight()+'px');
    });
    $("#pradio").click(function(){
		
    	$(".sprice").hide();
        if($(this).is(':checked')){
            $("#freight").removeAttr('disabled');
            $("#freight").css('background','white');
            $(".takedollor").show();
        }else{
        	$(".takedollor").hide();
        }
		$(window.parent.parent.document.getElementById('mainFrame')).css('height',$('.buygoodson').outerHeight()+'px');
    });
    var photoLock = true;
    $(".imgviews").hover(function(){
    	if(photoLock){
    		$('.photobubbles_box').css("display","block");
    		$('.photobubbles_box').animate({
	    		opacity : 1
	    	},function(){
	    		photoLock = false;
	    	});
    	}
    },function(){
    	if(photoLock == false){
    		$('.photobubbles_box').css("display","none");
    		$('.photobubbles_box').animate({
	    		opacity : 0
	    	},function(){
	    		photoLock = true;
	    	});
    	}
    });
    
    
    
    
</script>
<script type="text/javascript" src="http://static.ebanhui.com/mall/js/ajaxfileupload.js<?=getv()?>" ></script>
<script type="text/javascript" src="http://static.ebanhui.com/mall/js/jquery.Jcrop.js" ></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/jquery.base64.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/mall/js/release-img.js" ></script>
<script type="text/javascript" src="http://static.ebanhui.com/mall/js/sea.js" ></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js" ></script>
<?php $this->display('mall/footer') ?>
