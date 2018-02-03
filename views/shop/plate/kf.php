<?php
if (!empty($roomdetail['kefuqq']) && is_array($roomdetail['kefuqq'])) {
    $kefu['kefuqq'] = $roomdetail['kefuqq'];
} elseif (!empty($roomdetail['kefuqq'])) {
    $kefu['kefuqq'] = explode(',', $roomdetail['kefuqq']);
}
if (!empty($roomdetail['kefu']) && is_array($roomdetail['kefu'])) {
    $kefu['kefu'] = $roomdetail['kefu'];
} elseif (!empty($roomdetail['kefu'])) {
    $kefu['kefu'] = explode(',', $roomdetail['kefu']);
}
if (!empty($roomdetail['crphone'])) {
    $phone = explode(',', $roomdetail['crphone']);
}
//print_r(ebh::app()->model('user'));exit;
?>


<div class="kflist">
	
	<div id="mycollect" class="mycollect" style="display: none;">
		<i class="mycollectnum" id="mycollectnum">0</i>
		
		<div class="mycollect_inner" id="mycollect_inner">
			<div class="discountheader">
				<span class="formheaderlabel" style="width: 50px;">序号</span>
				<span class="formheaderlabel" style="width: 150px;text-align: left;text-indent: 10px;">课程名称</span>
				<span class="formheaderlabel" style="width: 90px;">有效期</span>
				<span class="formheaderlabel" style="width: 90px;">价格</span>
			</div>
			
			<ul class="discountcontent" id="discountcontent">
	
			</ul>
			
			<div class="discountfooter">
				<span class="discountfootertext" style="width:210px;">原价: <span id="nocountprice" style="color: red;">0</span></span>
				<span class="discountfootertext" style="width:110px;">折后: <span id="discountprice" style="color: red;">0</span></span>
				<a href="/ibuy.html?from=discount" class="nowsignup" id="nowsignup">立即报名</a>
				<span class="nowsignup" id="nonowsignup" style="display: none;background: #CCCCCC;cursor: auto;">立即报名</span>
			</div>
		</div>
	
	</div>
	
	
    <div class="qqkf onhover">
		<div class="kfliston">
			<div class="qqkfson" style="overflow:auto;max-height:200px;">
				<div class="djqqlx" style="font-size: 13px;">点击QQ立即联系</div>
				<?php if(!empty($kefu['kefuqq'])){foreach($kefu['kefuqq'] as $k=>$v){?>
					<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $v?>&site=qq&menu=yes" style="color: #fff"><div class="qqkfsonlist"><?php echo !empty($kefu['kefu'][$k])?ssubstrch($kefu['kefu'][$k],0,8):'在线客服'?></div></a>
					<!--        <div class="qqkfsonlist"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=892357903&site=qq&menu=yes">在线客服2</a></div>-->
				<?php }}?>
			</div>
			<div class="lxdhson">
				<div class="djqqlx">联系电话</div>
				<?php if(!empty($phone)){ foreach($phone as $value){?>
					<p class="lxdhs1s"><?php echo $value?></p>
				<?php } }?>
			</div>
		</div>
	</div>
    <div class="dfkf"></div>
</div>

<script>
	
    $('.dfkf').on('click',function(){
        $("html,body").animate({scrollTop:0}, 500);
    })
    $('.kfliston').hide();
    $('.qqkf').on('mouseenter',function(){
        $('.kfliston').show();
    });
    $('.qqkf').on('mouseleave', function() {
        $('.kfliston').hide();
    });
    
	var $mycollect = $("#mycollect");
    var $discountcontent = $("#discountcontent");	//存放列表的ul
    var $mycollectnum = $("#mycollectnum"); 		//存放总条数dom
    var $nocountprice = $("#nocountprice");			//原价dom
    var $discountprice = $("#discountprice");		//折后价dom
	$.ajax({		//页面加载请求接口判断我的收藏是否显示
		type:"get",
		url:"/room/collect/checkstar.html",
		async:true,
		dataType:'json',
		success:function(json){
			if(json.code == 1){
				var data = json.data; 
				if(data.switch == 1){
					$('#mycollect').show();
					getcollect();
				}else{
					$('#mycollect').hide();
				}
			}else{
				console.log("接口错误");
			}
		},
		error:function(json){
			console.log(json);
		}
	});

   
	$mycollect.hover(function(){		//收藏列表，鼠标移上显示，移出隐藏
	 	$('#mycollect_inner').show();
    },function(){
    	$('#mycollect_inner').hide();
    });

    function getcollect(){		//请求接口获取收藏的列表，动态生成数据
    	$.ajax({
	        url: '/room/collect/ajax_list.html',
	        type: 'get',
	        async: true,
	        dataType: 'json',
	        success: function(json) {
	        	if(json.code == 1){
		        	var data = json.data;
    				$discountcontent.empty();
	        		$nocountprice.html(data.totalprice);
	        		$discountprice.html(data.afterdiscount);
	        		$mycollectnum.html(data.num);
	        		if (typeof data.list == undefined) {
	        			data.list = [];
	        		}
	        		if( data.list.length > 0){
	        			$("#nowsignup").show();
	        			$("#nonowsignup").hide();
	        		}else{
	        			$("#nowsignup").hide();
	        			$("#nonowsignup").show();
	        		}
	        		for(var i=0;i<data.list.length;i++){
	        			var oLi = "<li id='delfold"+data.list[i].folderid+"' class='discountcontentli'>";
	        			oLi += "<span class='serialnumber' style='float:left; width: 50px;text-align: center;line-height: 30px;'>"+(i+1)+"</span>";
	        			oLi += "<span style='float: left;width: 150px;line-height: 30px;text-indent: 10px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;'>"+data.list[i].iname+"</span>";
	        			if(data.list[i].iday == 0){
	        				oLi += "<span style='float: left;width: 90px;line-height: 30px;text-align: center;'>"+data.list[i].imonth+"个月</span>";
	        			}else{
	        				oLi += "<span style='float: left;width: 90px;line-height: 30px;text-align: center;'>"+data.list[i].iday+"天</span>";
	        			}
	        			oLi += "<span style='float: left;width: 90px;line-height: 30px;text-align: center;'>￥<span>"+data.list[i].iprice+"</span></span>";
	        			oLi += "<span class='delcollectbtn' onclick='delcollect("+data.list[i].folderid+")'></span>";
	        			oLi += "</li>";
	        			$discountcontent.append(oLi);
	        		};
	        	}else{
	        		$mycollect.css("display","none");
	        	}
	        },
	        error: function(json){
	        	console.log(json);
	        }
	    });
    };
    
    
    function delcollect(folderid){  //收藏删除操作
    	$.ajax({
    		type:"post",
    		url:"/room/collect/ajax_del.html",
    		dataType: 'json',
    		data: {'folderid': folderid},
    		success: function(data){
    			if(data.code == 1){
    				getcollect();
					$.ajax({
			    		type:"post",
			    		url:"/room/collect/checkcollectbutton.html",
			    		async:true,
			    		data: {'folderid': window.parent.$("#nowregister").attr("folderid")},
			    		dataType:'json',
			    		success:function(json){
			    			if(json.code == 1){
				    			var kkdata = json.data;
			    				if(kkdata.collect == 0){
			    					window.parent.$("#addcollect").hide();
			    					window.parent.$("#cancelcollect").hide();
			    				}else if(kkdata.collect == 1){
			    					window.parent.$("#addcollect").hide();
			    					window.parent.$("#cancelcollect").show()
			    				}else{
			    					window.parent.$("#addcollect").show();
			    					window.parent.$("#cancelcollect").hide()
			    				}
			    			}else{
			    				console.log("接口错误")
			    			}
			    		},
			    		error:function(data){
			    			
			    		}
			    	});
			    	console.log(1);
    			}
    		},
    		error: function(data){
    			console.log(data);
    		}
    	});
  };
</script>