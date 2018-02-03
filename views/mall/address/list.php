<?php $this->display('mall/header') ?>
<body>                  
<div class="buygoods">
    <div class="buygoodson">
		<div class="work_menu delivery-title" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">地址管理</span></a></li>
			</ul>
			<a href="javascript:void(0)" class="isell readdress addaddress" >新增收货地址</a>
		</div>
        <div class="clear"></div>
        <div class="buygoodsearch-1 w930" style="float:left;">
        <?php if(!empty($address)){ ?>
            <div class="buygoodslist buygoodslistgray">
                <table cellpadding="0" cellspacing="0" class="goodstable fontsize14 mt15">
                    <tr>
                        <th width="30%">收货地址</th>
                        <th width="17%">收货人</th>
                        <th width="17%">手机号码</th>
                        <th width="17%">常用标签</th>
                        <th width="17%">操作</th>
                    </tr>
                    <?php foreach ($address as $add) { ?>
                        <tr>
                            <input id="areacode<?= $add['addr_id'] ?>" value="<?= $add['addr_id'] ?>" type="hidden">
                            <input id="detail_address<?= $add['addr_id'] ?>" value="<?= $add['fulladdress'] ?>" type="hidden">
                            <input id="username<?= $add['addr_id'] ?>" value="<?= $add['username'] ?>" type="hidden">
                            <input id="phone<?= $add['addr_id'] ?>" value="<?= $add['mobile'] ?>" type="hidden">
                            <input id="tag<?= $add['addr_id'] ?>" value="<?= $add['tagname'] ?>" type="hidden">
                            <input id="is_default<?= $add['addr_id'] ?>" value="<?= $add['default'] ?>" type="hidden">
                            <td ><?= $add['fulladdress'] ?></td>
                            <td ><?= $add['consignee'] ?></td> 
                            <td ><?= $add['mobile'] ?></td>
                            <td ><?= $add['tagname'] ?></td>
                            <td><a href="javascript:void(0)" data-aid="<?= $add['addr_id'] ?>" class="contactseller updateaddress">修改</a> <a href="javascript:void(0)" data-aid="<?= $add['addr_id'] ?>" class="contactseller red deladdress">删除</a></td>
                        </tr>
                    <?php }?>
                    
                </table>
                <div class="clear"></div>
                
            </div>
			
            <?php }else{?>
                <div class="buygoodslist nobuygoods3">很抱歉，暂无地址</div>
            <?php }?>
        </div>
		<?php if(!empty($total)){?>
		<div class="recordpage" style="margin-top:5px;">
            <div class="record-1">共<span class="red">&nbsp;<?= $total ?>&nbsp;</span>条记录</div>
            <div style="position:relative;right:-96px;top:-42px;"><?= $pagination?></div>
        </div>
		<?php }?>
    </div>
</div>
    <script type="text/javascript" src="http://static.ebanhui.com/mall/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/mall/js/sea.js"></script>
<script type="text/javascript">
    var box = $(".newAddress")[0];
    $(function(){
        $(".addaddress").click(function(){
            addaddress();
        });
        $(".updateaddress").click(function(){
            var aid = $(this).attr('data-aid');
            updateaddress(aid);
        });
		
    });
    var $personBox,$PersonTips; //收货人$personBox是输入框，$PersonTips是提示信息

    var $province,$profileTips,$s_province,$s_city,$s_county;   //选择地址框

    var $detailedAds_box,$AdsTips,$remLen,$haveLen;     //详细地址$detailedAds_box是输入框，$AdsTips是提示信息

    var $phoneBox,$PhoneTips;                                   //手机验证$phoneBox是手机输入框,$PhoneTips是提示
    var regPhone = /^1(3|4|5|7|8|9)[0-9]{9}$/; //手机号码正则，1开头，第二位可以填写3、4、5、7、8、9，总共11位手机号码

    var $offenBox,$OffenTips;                                       //常用标签$offenBox是输入框

    var $tick;              //是否设为默认地址$tick是选择框

    var $sameTips       //公共的提示
    var temp1 = false;
    var temp2 = false;
    var temp3 = false;
    var temp4 = false;
    var temp5 = false;
    function submitaddress(aid){
        var consignee = $(".personBox",window.parent.document).val();
        var province = $("#s_provincec option:selected",window.parent.document).val();
        var city = $("#s_cityc option:selected",window.parent.document).val();
        var district = $("#s_countyc option:selected",window.parent.document).val();
        var address = $(".detailedAds_boxc",window.parent.document).val();
        var mobile = $(".phoneBox",window.parent.document).val();
        var tagname = $(".offenBox",window.parent.document).val();
        var value = $("#tick",window.parent.document).next().attr('checked');
        if(value == undefined){
            var defaultval = 0;
        }else{
            var defaultval = 1;
        }
        if($("#s_provincec option:selected",window.parent.document).html() == $("#s_cityc option:selected",window.parent.document).html()){
        	if($("#s_countyc option:selected",window.parent.document).html() == undefined){
        		var fulladdress = $("#s_provincec option:selected",window.parent.document).html() + address;
        	}else{
        		var fulladdress = $("#s_provincec option:selected",window.parent.document).html() + $("#s_countyc option:selected",window.parent.document).html() + address;
        	}
        }else{
        	if($("#s_countyc option:selected",window.parent.document).html() == undefined){
        		var fulladdress = $("#s_provincec option:selected",window.parent.document).html() + $("#s_cityc option:selected",window.parent.document).html() + address;
        	}else{
        		var fulladdress = $("#s_provincec option:selected",window.parent.document).html() + $("#s_cityc option:selected",window.parent.document).html() + $("#s_countyc option:selected",window.parent.document).html() + address;
        	}
        }
        if(province != undefined && city != undefined && district == undefined){
            district = 0;
        }
        if(province == undefined && city == undefined &&  district == undefined){
            return false;
        }
        if(temp1 && temp3 && temp4 && temp5){
            $.ajax({
                url:'/mall/address/add.html',
                dataType:'json',
                type:'post',
                data:{consignee:consignee,province:province,city:city,district:district,address:address,mobile:mobile,tagname:tagname,'default':defaultval,fulladdress:fulladdress,aid:aid},
                success:function(res){
                    if(res.status){
                        location.href = location.href;
                    }else{
                        top.dialog({
                            skin:"ui-dialog2-tip",
							title : "信息提示",
                            width:350,
                            content: "<div class='FPic'></div><p>"+res.msg+"</p>",               
                            onshow:function(){
                                var that=this;
                                setTimeout(function () {
                                that.close().remove();
                                }, 2000);
                            }
                        }).showModal();
                    }
                }
            })
        }
    }
    function updateaddress(aid) {
        top.$("#s_provincec").unbind('change');
        top.$("#s_cityc").unbind('change');
        top.$("#s_countyc").unbind('change');
        top.dialog({
            title: "修改收货地址",
            content: '<div class="newAddress" style="position: relative;"><div class="person_Box"><span class="txtMsg">收货人：</span><input class="consignee_box personBox" type="text" maxlength="20" placeholder="请填写收货人" /><p class="PersonTips sameTips">收货人未填写！</p></div><div class="city_china_Box" id="city_china"><span class="txtMsg">收货地址：</span><select id="s_provincec" name="s_province" class="province consignee_box"><option value="">选择省</option></select><select id="s_cityc" name="s_city" class="city"><option value="">选择市</option></select><select id="s_countyc" name="s_county" class="area"><option value="">选择区</option></select><p class="profileTips sameTips" style="">收货地址未选择！</p></div><div class="ads_Box" style="position: relative;"><span class="txtMsg">详细地址：</span><textarea class="detailedAds_box detailedAds_boxc consignee_box" maxlength="40" placeholder="请填写详细的地址,最多不超过40字。" style="font-weight:normal;color:#000;"></textarea><span style="position: absolute;bottom: 0;right:10px;color: #BBBBBB;"><b class="haveLen">0</b> / <b class="remLen">40</b></span><p class="AdsTips sameTips" style="">详细地址未填写！</p></div><div class="phone_Box"><span class="txtMsg">手机号码：</span><input class="consignee_box phoneBox" type="text" placeholder="请填写手机号码" /><p class="PhoneTips sameTips" style="">联系方式未填写！</p></div><div class="offen_Box"><span class="txtMsg">常用标签：</span><input class="consignee_box offenBox" type="text" maxlength="30" placeholder="请填写常用标签（如：家，公司等）" /><p class="OffenTips sameTips" style="">常用标签未填写！</p></div><div class="check_box"><input type="checkbox" checked="checked" id="tick" /><label for="tick" class="tick">设为默认地址</label></div>',  //
            okValue: "保存",
            ok : function() {
                top.$(".personBox").trigger('blur');
                top.$(".detailedAds_boxc").trigger('blur');
                top.$(".phoneBox").trigger('blur');
                top.$(".offenBox").trigger('blur');
                submitaddress(aid);
            },
            onshow : function(){
            //在弹框弹出事件中获取dom节点进行之后的操作
                $personBox = top.$(".personBox");
                $PersonTips = top.$(".PersonTips");
                
                $province = top.$(".province");
                $profileTips = top.$(".profileTips");
                $s_province = top.$("#s_province");
                $s_city = top.$("#s_city");
                $s_county = top.$("#s_county");
                
                
                $detailedAds_box = top.$(".detailedAds_boxc");
                $AdsTips = top.$(".AdsTips");
                $remLen = top.$(".remLen");
                $haveLen = top.$(".haveLen");
                
                $phoneBox = top.$(".phoneBox");
                $PhoneTips = top.$(".PhoneTips");
                
                $offenBox = top.$(".offenBox");
                $OffenTips = top.$(".OffenTips");
                
                $tick = top.$(".tick");
                
                $sameTips = top.$(".sameTips");
                $consignee_box = top.$(".consignee_box");
            }
        }).showModal();
        //收货人验证 
        $personBox.on("blur",function() {
            $PersonTips.show();
            if($(this).val() == "") {
                $PersonTips.addClass("error_icon");
                $PersonTips.removeClass("correct_icon");
                $PersonTips.html("收货人未填写！");
                temp1 = false;
            } else {
                $PersonTips.addClass("correct_icon");
                $PersonTips.removeClass("error_icon");
                $PersonTips.html("");
                consignee = $(this).val();
                temp1 = true;
            }
        });
        $personBox.keyup(function(){
            if($(this).val() == ""){
                $PersonTips.addClass("error_icon");
                $PersonTips.removeClass("correct_icon");
                $PersonTips.html("收货人未填写！");
                $PersonTips.show();
                temp1 = false;
            }
        });

        //选择城市部分js 城市联动在area.js文件中
        $province.change(function() {
            $profileTips.show();
            if($(this).val() == "") {
                $profileTips.addClass("error_icon");
                $profileTips.removeClass("correct_icon");
                $profileTips.html("未选择收货地址！");
                temp2 = false;
            }else{
                $profileTips.addClass("correct_icon");
                $profileTips.removeClass("error_icon");
                $profileTips.html("");
                address = $(this).val();
                temp2 = true;
            }
        });
        $province.blur(function(){
            if($(this).val() == "") {
                $profileTips.addClass("error_icon");
                $profileTips.removeClass("correct_icon");
                $profileTips.html("未选择收货地址！");
                $profileTips.show();
                temp2 = false;
            }
        });

        //详细地址验证
        $detailedAds_box.bind("input propertychange", function() {
            var len = $(this).val().length;
            $remLen.html(40 - len);
            $haveLen.html(len);
        });
        $detailedAds_box.blur(function() {
            $AdsTips.show();
            if($(this).val() == "") {
                $AdsTips.addClass("error_icon");
                $AdsTips.removeClass("correct_icon_adsBox");
                $AdsTips.html("详细地址未填写！");
                temp3 = false;
            } else {
                $AdsTips.addClass("correct_icon_adsBox");
                $AdsTips.removeClass("error_icon");
                $AdsTips.html("");
                detailed_address = $(this).val();
                temp3 = true;
            }
        });
        $detailedAds_box.keyup(function(){
            if($(this).val() == "") {
                $AdsTips.show();
                $AdsTips.html("详细地址未填写！");
                $AdsTips.addClass("error_icon");
                $AdsTips.removeClass("correct_icon_adsBox");
                temp3 = false;
            }
        });

        //手机输入框验证
        $phoneBox.on("blur", function() {
            $PhoneTips.show();
            if($(this).val() == "") { //失去焦点判断，若输入框为空，则默认提示显示
                $PhoneTips.addClass("error_icon");
                $PhoneTips.removeClass("correct_icon");
                $PhoneTips.html("联系方式未填写！");
                temp4 = false;
            } else {
                if(!regPhone.test($(this).val())) { //输入框不为空判断手机号码正则是否匹配，不匹配则显示警告提示
                    $PhoneTips.addClass("error_icon");
                    $PhoneTips.removeClass("correct_icon");
                    $PhoneTips.html("手机号码格式错误！");
                    temp4 = false;
                } else { //正则匹配正确，则正常显示
                    $PhoneTips.addClass("correct_icon");
                    $PhoneTips.removeClass("error_icon");
                    $PhoneTips.html("");
                    phone = $(this).val();
                    temp4 = true;
                }
            }
        });
        $phoneBox.keyup(function(){
            if($(this).val() == "") { 
                $PhoneTips.show();
                $PhoneTips.html("联系方式未填写！");
                $PhoneTips.addClass("error_icon");
                $PhoneTips.removeClass("correct_icon");
                temp4 = false;
            }
        });

        //常用标签验证
        $offenBox.on("blur", function() {
            $OffenTips.show();
            if($(this).val() == "") {
                $OffenTips.addClass("error_icon");
                $OffenTips.removeClass("correct_icon");
                $OffenTips.html("常用标签未填写！");
                temp5 = false;
            } else {
                $OffenTips.addClass("correct_icon");
                $OffenTips.removeClass("error_icon");
                $OffenTips.html("");
                tag = $(this).val();
                temp5 = true;
            }
        });
        $offenBox.keyup(function(){
            if($(this).val() == "") {
                $OffenTips.show();
                $OffenTips.html("常用标签未填写！");
                $OffenTips.addClass("error_icon");
                $OffenTips.removeClass("correct_icon");
                temp5 = false;
            } 
        });

        //  单选框功能
        var radio_lock = true;  //控制是否设为默认地址的一个控制锁
        $tick.click(function(){
            if(radio_lock == true){
                $tick.removeAttr("checked");
                $(this).css("background","url(http://static.ebanhui.com/mall/img/radio_buttons1.png) no-repeat left center");
                radio_lock = false;
            }else{
                $tick.attr("checked","checked");
                $(this).css("background","url(http://static.ebanhui.com/mall/img/radio_buttons3.png) no-repeat left center");
                radio_lock = true;
            }
        });
        setTimeout('ajaxupload('+aid+')',300);
    }
    var getData = function(parent_areacode,ele){
        $s_province = top.$("#s_province");
        $s_city = top.$("#s_city");
        $s_county = top.$("#s_county");
        $.ajax({
            url:'/mall/shop/ajaxGetArea.html?parent_areacode='+parent_areacode,
            type:'GET',
            dataType:'json',
            success:function(data){
                if(data.length > 0){
                    var html='';
                    for(var i=0;i<data.length;i++){
                        html+='<option value="'+data[i].areacode+'">'+data[i].cityname+'</option>'
                    }
                    $(ele,window.parent.document).html(html);
                }
            }
        });
    };
    function ajaxupload(aid){
    	$.ajax({
            url:'/mall/address/getAddress.html',
            dataType:'json',
            type:'post',
            data:{aid:aid},
            success:function(res){
                $s_province = top.$("#s_province");
                $s_city = top.$("#s_city");
                $s_county = top.$("#s_county");
                $(".personBox",window.parent.document).val(res.consignee);
                getData(0,'#s_provincec');
                getData(res.province,'#s_cityc');
                getData(res.city,'#s_countyc');
                setTimeout('chooseaddress('+res.province+','+res.city+','+res.district+')',200);
                $profileTips.hide();
                $(".detailedAds_boxc",window.parent.document).val(res.address);
                $(".phoneBox",window.parent.document).val(res.mobile);
                $(".offenBox",window.parent.document).val(res.tagname);
                if(res.daddress == 1){
                    top.$(".tick").attr('checked',true);
                }else{
                    top.$(".tick").trigger('click');
                }
            }
        })
    }
    function chooseaddress(province,city,country){
        $("#s_provincec option",window.parent.document).each(function(){
            if($(this).val() == province){
                $(this).prop('selected',true);
            }
        });
        $("#s_cityc option",window.parent.document).each(function(){
            if($(this).val() == city){
                $(this).prop('selected',true); 
            }
        });
        if(country != 0){
             $("#s_countyc option",window.parent.document).each(function(){
                if($(this).val() == country){
                        $(this).prop('selected',true);
                    }
                });
        }else{
            $("#s_countyc",window.parent.document).empty();
        }
        var getadressData = function(parent_areacode,ele){
            $.ajax({
                url:'/mall/shop/ajaxGetArea.html?parent_areacode='+parent_areacode,
                type:'GET',
                dataType:'json',
                success:function(data){
                    if(data.length > 0){
                        var html='';
                        for(var i=0;i<data.length;i++){
                            html+='<option value="'+data[i].areacode+'">'+data[i].cityname+'</option>'
                        }
                        $(ele,window.parent.document).html(html);
                        if(ele == '#s_countyc'){
                            return;
                        }
                        if(data.length == 1){
                            getadressData(top.$('#s_cityc').val(),'#s_countyc');
                        }
                        if(parent_areacode == 0){
                            getadressData($s_province.val(),'#s_cityc');
                            getadressData(top.$('#s_cityc').val(),'#s_countyc');
                        }else{
                            getadressData(top.$('#s_cityc').val(),'#s_countyc');
                        }
                    }
                }
            });
        };
        top.$("#s_provincec").on('change',function(){
            getadressData($(this).val(),'#s_cityc');
        });
        top.$("#s_cityc").on('change',function(){
            getadressData($(this).val(),'#s_countyc');
        });
    }
    function addaddress() {
        top.$("#s_provincec").unbind('change');
        top.$("#s_cityc").unbind('change');
        top.$("#s_countyc").unbind('change');
        top.dialog({
            title: "新增收货地址",
            content: '<div class="newAddress" style="position: relative;"><div class="person_Box"><span class="txtMsg">收货人：</span><input class="consignee_box personBox" type="text" maxlength="20" placeholder="请填写收货人" /><p class="PersonTips sameTips">收货人未填写！</p></div><div class="city_china_Box" id="city_china"><span class="txtMsg">收货地址：</span><select id="s_provincec" name="s_province" class="province consignee_box" style="margin-right:13px"><option value="">选择省</option></select><select id="s_cityc" name="s_city" class="city" style="margin-right:13px"><option value="">选择市</option></select><select id="s_countyc" name="s_county" class="area" style="margin-right:0"><option value="">选择区</option></select><p class="profileTips sameTips" style="">收货地址未选择！</p></div><div class="ads_Box" style="position: relative;"><span class="txtMsg">详细地址：</span><textarea class="detailedAds_box detailedAds_boxc consignee_box" maxlength="40" placeholder="请填写详细的地址,最多不超过40字。" style="font-weight:normal; color:#000;"></textarea><span style="position: absolute;bottom: 0;right:10px;color: #BBBBBB;"><b class="haveLen">0</b> / <b class="remLen">40</b></span><p class="AdsTips sameTips" style="">详细地址未填写！</p></div><div class="phone_Box"><span class="txtMsg">手机号码：</span><input class="consignee_box phoneBox" type="text" placeholder="请填写手机号码" /><p class="PhoneTips sameTips" style="">联系方式未填写！</p></div><div class="offen_Box"><span class="txtMsg">常用标签：</span><input class="consignee_box offenBox" type="text" maxlength="30" placeholder="请填写常用标签（如：家，公司等）" /><p class="OffenTips sameTips" style="">常用标签未填写！</p></div><div class="check_box"><input type="checkbox" checked="checked" id="tick" /><label for="tick" class="tick" checked="checked">设为默认地址</label></div>',  //
            okValue: "保存",
            onshow : function(){
                //在弹框弹出事件中获取dom节点进行之后的操作
                $personBox = top.$(".personBox");
                $PersonTips = top.$(".PersonTips");
                
                $province = top.$(".province");
                $profileTips = top.$(".profileTips");
                $s_province = top.$("#s_provincec");
                $s_city = top.$("#s_cityc");
                $s_county = top.$("#s_countyc");
                
                
                $detailedAds_box = top.$(".detailedAds_boxc");
                $AdsTips = top.$(".AdsTips");
                $remLen = top.$(".remLen");
                $haveLen = top.$(".haveLen");
                
                $phoneBox = top.$(".phoneBox");
                $PhoneTips = top.$(".PhoneTips");
                
                $offenBox = top.$(".offenBox");
                $OffenTips = top.$(".OffenTips");
                
                $tick = top.$(".tick");
                
                $sameTips = top.$(".sameTips");
                $consignee_box = top.$(".consignee_box");
            },
            ok: function() {
                temp2 = true;
            	if(temp1 == true && temp2 == true && temp3 == true && temp4 == true && temp5 == true){
            		submitaddress(0);
            	}else{
            		for(var i=0;i<$consignee_box.length;i++){
						if($consignee_box.eq(i).val() == ""){
							$sameTips.eq(i).addClass("error_icon");
							$sameTips.eq(i).show();
						}
					}
            		return false;
            	} 
            }
        }).showModal();
        //收货人验证 
        $personBox.on("blur",function() {
            $PersonTips.show();
            if($(this).val() == "") {
                $PersonTips.addClass("error_icon");
                $PersonTips.removeClass("correct_icon");
                $PersonTips.html("收货人未填写！");
                temp1 = false;
            } else {
                $PersonTips.addClass("correct_icon");
                $PersonTips.removeClass("error_icon");
                $PersonTips.html("");
                consignee = $(this).val();
                temp1 = true;
            }
        });
        $personBox.keyup(function(){
            if($(this).val() == ""){
                $PersonTips.addClass("error_icon");
                $PersonTips.removeClass("correct_icon");
                $PersonTips.html("收货人未填写！");
                $PersonTips.show();
                temp1 = false;
            }
        });
        
        //选择城市部分js 城市联动在area.js文件中
        $province.change(function() {
            $profileTips.show();
            if($(this).val() == "") {
                $profileTips.addClass("error_icon");
                $profileTips.removeClass("correct_icon");
                $profileTips.html("未选择收货地址！");
                temp2 = false;
            }else{
                $profileTips.addClass("correct_icon");
                $profileTips.removeClass("error_icon");
                $profileTips.html("");
                address = $(this).val();
                temp2 = true;
            }
        });
        $province.blur(function(){
            if($(this).val() == "") {
                $profileTips.addClass("error_icon");
                $profileTips.removeClass("correct_icon");
                $profileTips.html("未选择收货地址！");
                $profileTips.show();
                temp2 = false;
            }
        });

        //详细地址验证
        $detailedAds_box.bind("input propertychange", function() {
            var len = $(this).val().length;
            $remLen.html(40 - len);
            $haveLen.html(len);
        });
        $detailedAds_box.blur(function() {
            $AdsTips.show();
            if($(this).val() == "") {
                $AdsTips.addClass("error_icon");
                $AdsTips.removeClass("correct_icon_adsBox");
                $AdsTips.html("详细地址未填写！");
                temp3 = false;
            } else {
                $AdsTips.addClass("correct_icon_adsBox");
                $AdsTips.removeClass("error_icon");
                $AdsTips.html("");
                detailed_address = $(this).val();
                temp3 = true;
            }
        });
        $detailedAds_box.keyup(function(){
            if($(this).val() == "") {
                $AdsTips.show();
                $AdsTips.html("详细地址未填写！");
                $AdsTips.addClass("error_icon");
                $AdsTips.removeClass("correct_icon_adsBox");
                temp3 = false;
            }
        });
        
        //手机输入框验证
        $phoneBox.on("blur", function() {
            $PhoneTips.show();
            if($(this).val() == "") { //失去焦点判断，若输入框为空，则默认提示显示
                $PhoneTips.addClass("error_icon");
                $PhoneTips.removeClass("correct_icon");
                $PhoneTips.html("联系方式未填写！");
                temp4 = false;
            } else {
                if(!regPhone.test($(this).val())) { //输入框不为空判断手机号码正则是否匹配，不匹配则显示警告提示
                    $PhoneTips.addClass("error_icon");
                    $PhoneTips.removeClass("correct_icon");
                    $PhoneTips.html("手机号码格式错误！");
                    temp4 = false;
                } else { //正则匹配正确，则正常显示
                    $PhoneTips.addClass("correct_icon");
                    $PhoneTips.removeClass("error_icon");
                    $PhoneTips.html("");
                    phone = $(this).val();
                    temp4 = true;
                }
            }
        });
        $phoneBox.keyup(function(){
            if($(this).val() == "") { 
                $PhoneTips.show();
                $PhoneTips.html("联系方式未填写！");
                $PhoneTips.addClass("error_icon");
                $PhoneTips.removeClass("correct_icon");
                temp4 = false;
            }
        });
        
        //常用标签验证
        $offenBox.on("blur", function() {
            $OffenTips.show();
            if($(this).val() == "") {
                $OffenTips.addClass("error_icon");
                $OffenTips.removeClass("correct_icon");
                $OffenTips.html("常用标签未填写！");
                temp5 = false;
            } else {
                $OffenTips.addClass("correct_icon");
                $OffenTips.removeClass("error_icon");
                $OffenTips.html("");
                tag = $(this).val();
                temp5 = true;
            }
        });
        $offenBox.keyup(function(){
            if($(this).val() == "") {
                $OffenTips.show();
                $OffenTips.html("常用标签未填写！");
                $OffenTips.addClass("error_icon");
                $OffenTips.removeClass("correct_icon");
                temp5 = false;
            } 
        });
        
        //  单选框功能
        var radio_lock = true;  //控制是否设为默认地址的一个控制锁
        $tick.click(function(){
            if(radio_lock == true){
                $tick.removeAttr("checked");
                $(this).css("background","url(http://static.ebanhui.com/mall/img/radio_buttons1.png) no-repeat left center");
                radio_lock = false;
            }else{
                $tick.attr("checked","checked");
                $(this).css("background","url(http://static.ebanhui.com/mall/img/radio_buttons3.png) no-repeat left center");
                radio_lock = true;
            }
        });
        var getadressaData = function(parent_areacode,ele){
            $.ajax({
                url:'/mall/shop/ajaxGetArea.html?parent_areacode='+parent_areacode,
                type:'GET',
                dataType:'json',
                success:function(data){
                    if(data.length > 0){
                        var html='';
                        for(var i=0;i<data.length;i++){
                            html+='<option value="'+data[i].areacode+'">'+data[i].cityname+'</option>'
                        }
                        $(ele,window.parent.document).html(html);
                        if(ele == '#s_countyc'){
                            return;
                        }
                        if(data.length == 1){
                            getadressaData($s_city.val(),'#s_countyc');
                        }
                        if(parent_areacode == 0){
                            getadressaData($s_province.val(),'#s_cityc');
                            getadressaData($s_city.val(),'#s_countyc');
                        }else{
                            getadressaData($s_city.val(),'#s_countyc');
                        }
                    }
                }
            });
        };
        getadressaData(0,'#s_provincec');
        $s_province.on('change',function(){
            getadressaData($(this).val(),'#s_cityc');
        });
        $s_city.on('change',function(){
            getadressaData($(this).val(),'#s_conuntyc');
        });
    }
</script>
<script type="text/javascript">
    $(".deladdress").on("click", function() {
        var aid = $(this).data('aid');
        top.dialog({
            title: "信息提示",
            content: "<p style='font-weight:bold;font-size:16px'>是否要删除该地址?</p>",
            okValue: "是",
            ok: function() {
                $.post('/mall/address/del.html',{
                        aid:aid
                    },function(data){
                        if(data.status){
                            location.href = '/mall/address/all.html';
                        }else{
                            top.dialog({
                                title:"信息提示",
                                width:350,
                                content: "<div class='FPic'></div><p>"+data.msg+"</p>",               
                                onshow:function(){
                                    var that=this;
                                    setTimeout(function () {
                                    that.close().remove();
                                    }, 2000);
                                }
                            }).showmodal();
                            return false;
                        }
                    },'json');
            },
            cancelValue: "否",
            cancel: function() {

            },
            width: "280px"
        }).showModal();
    });
</script>
<?php $this->display('mall/footer') ?>
