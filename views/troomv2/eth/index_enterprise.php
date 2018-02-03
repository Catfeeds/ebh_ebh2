<?php $this->display('troomv2/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css"/>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style>
  .waitite2{
    margin-left: 16px;
  }
  .enterprise{

  }
  .enterprise ul li{
    margin: 0;
    font-size: 14px;
  }
  .enterprise .workcurrent a{
    background: none;
  }
  .enterprise a.title-a .jnisrso{ 
    font-size: 14px;
    color: #777;
    background: none;
  }
  .enterprise .showtap a.title-a{
    background:url(http://static.ebanhui.com/ebh/tpl/default/images/workcurrent.jpg) no-repeat right 0px;
  }
  .enterprise .showtap a.title-a .jnisrso{
    background:url(http://static.ebanhui.com/ebh/tpl/default/images/workcurrent.jpg) left 0px no-repeat;
    color: #4c88ff;
  }
  
</style>
<div class="lefrig">
    <div class="waitite waitite2">
		<div class="work_menu enterprise" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent showtap"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">发消息</span></a></li>
        <li class="workcurrent "><a href="/troomv2/eth/history.html" class="title-a"><span class="jnisrso">详情</span></a></li>
        <li class="workcurrent "><a href="/troomv2/eth/inbox.html" class="title-a"><span class="jnisrso">收件箱</span></a></li>
        <li class="workcurrent "><a href="/troomv2/eth/bind.html" class="title-a"><span class="jnisrso">绑定情况</span></a></li>
			</ul>
		</div>
    </div>
    <div class="jisrshuer">
        <div class="tsireh">
            收件人：
            <a href="javascript:showWeixinDialog()"  class="huerse"></a>
        </div>
        <div class="chouadse">
        	<div class="ewater">
                <ul id="wrap2">
                </ul>
            </div>
        </div>
      <div class="tsireh">
            主题：
      </div>
        <textarea class="huetse" name="subject" id="subject" cols="45" rows="5" onkeyup="strLenCalc();">请输入消息主题</textarea>
        <p class="husrets">可输入<span id="checklen" class="luuusize">200</span>字</p>
        <div class="tsireh">
            内容：
        </div>
        <div style="clear:both"></div>
        <div class="txtxdaru">
        <?php
        EBH::app()->lib('UEditor')->xEditor('message','970px','553px');
		?>
        </div>
        <!-- <img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/shilt012.jpg" /> -->
        <a href="javascript:sendWeixin()" style="color:#fff" class="uhksere">发送</a>
    </div>
</div>


<!-- ================ -->
<!--发送成功提示-->
<div id="dialogsuccess" style="display:none;height:100px;">
	<div style="height:70px;">
		<div class="tishi mt40"><p style="font-size: 16px; line-height: 35px; text-align: center;">消息通知已经发送成功！</p></div>
	</div>
	<div style="text-align: center;">
		<a class="uhksere" style="margin:20px 0 20px 144px;color:#fff" href="javascript:;" onclick="parent.window.H.get('dialogsuccess').exec('close');">确定</a>
	</div>
</div>


<div id="wxDialog" class="taneret" style="display:none">
  <link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/xtree/iconfont.css">
  <link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/dialog.css?v=00000002"> 
  <style>
  .organize{
    float: left;
    display: block;
  }
   .organize li .tr{
        height: 30px;
       /* min-width: 100%;*/
        width: 100%;
        overflow: visible;
        white-space: nowrap;
        padding: 0 15px 0 10px;
    }
    .organize li .ban{ 
      cursor:not-allowed!important;
    }
    .organize li .ban .cname{ 
      color: #ccc;       
      cursor:not-allowed!important;
    }
    .organize li .on{
      background:#92caf8;
    }

  .organize ul{
    overflow: visible;
  }
  .organize li .tr .cname{
    width: auto;
    padding:0 15px 0 10px;
  }
  .organize li{
    float: none;
  }
  </style>  
  <div class="pantre">
    <ul id="wrap">
    </ul>
  </div>
  <div class="rtyres">    
    <div id="banter" class="banter" >
      <ul id="classchoose" class="organize">      
      </ul>
    </div>
    <div class="etshout">
        <input class="txtshout" name="textarea" type="text" id="title" value="请输入关键字" />
        <a href="javascript:parent.window.wxsearch()" class="shoutbtn">搜 索</a>
    </div>
 
    <div id="chooseStudent" class="xueter" > </div> 
    <div id="chooseClass" class="xueter" style="display: none;">
      <ul>
        <?php foreach ($classlist as $class) {?>
            <li><label class="namester"  title="<?=$class['classname']?>">
            <input xxid="class_choose_<?=$class['classid']?>" onclick="parent.window.classChoseEvent(this)" class="teatle" type="checkbox" isclass="1" classid="<?=$class['classid']?>" tag="<?=$class['classname']?>">
            <?=shortstr($class['classname'],20)?>
            </label>
            </li>
        <?php }?>
      </ul>
    </div>   
    <div class="xuanque">   
      <input id="chooseAllClass" class="teatle" type="checkbox" isclass="2" style="display: inline-block;">
      <label id="ifChooseAll" for="chooseAllClass" class="namester">全选</label>         
    </div>
    <div class="allselect">
      <a href="javascript:void(0)" onclick="parent.window.H.get('wxDialog').exec('close');" class="wrkeey">确 定</a>
    </div>    
  </div>
</div>
<script>
	function showWeixinDialog(){
    parent.window.H.get('wxDialog').exec('show');
    // $("#classchoose li:first",parent.document).trigger('click');
     $("#chooseAllClass",parent.document).hide();
	}

	$(function(){   
		//主题判断
		$("#subject").on("click",function(){
			var subject = $.trim($(this).val());
			if((subject == '' )||(subject == '请输入消息主题')){
				$(this).val('');
				$(this).focus();
				}
			$(this).on("blur",function(){
				var sb = $(this).val();
				if( sb == "" ){
					$(this).val('请输入消息主题');
					}
				});

			});
		$("#classchoose li").click(function(){
			$("#classchoose li",parent.document).removeClass('xuanz');
			$(this).addClass('xuanz');
		});
    $(".xuanque").hide();
    $.ajax({
      type: "GET",
      url: "/troomv2/enterprise/department.html?staff=1",
      dataType: "json",
      success:function(data){
        var arr = data.data,
           arrz = [],
           obj  = {'0':'true'},
           firstid = 0; 

          diedai(arr,obj);
          readerData(arrz);
          firstid = parent.window.$("#classchoose>li").attr('class');       
          var $tr = parent.window.$("#classchoose .tr")
          $tr.click(function(event) {

              var self = $(this),
                    id = self.attr('classid'),
                  name = self.attr('classname');

              $tr.removeClass('on');   
              self.addClass('on');
              
              if(firstid!=id){
                setTimeout(function(){           
                  self.parents('.rtyres').find('.xuanque').find("#class_choose_"+id).attr('tag',name);
                  self.parents('.rtyres').find('.xuanque').show();
                },1000);
              } 
          });
          function readerData(arr){ 
              for(var i = 0,len = arr.length; i < len; i++){
                var superior = arr[i].superior,
                     classid = arr[i].classid,
                   classname = arr[i].classname,
                   usercount = arr[i].usercount,
                   haspower = arr[i].haspower,
                          li = '',
                          tr = '<div '+(haspower?'class="tr" onclick="parent.window.getClassAndStudentsInfo('+classid+')"':'class="tr ban"')+' classid="'+classid+'" classname="'+classname+'" >';
                          //todo:
                  if( superior == 0 ){
                      li='<li class='+classid+' >'
                        +  tr
                        +    '<i></i><i class=" img-section"></i><a class="cname">'+classname+'</a>'
                        +  '</div>'
                        +'</li>';
                      parent.window.$("#classchoose").append(li);                      
                  }else{
                      if(parent.window.$("."+superior+'>ul').length < 1){
                          parent.window.$("."+superior).find('i').eq(0).addClass('iconfont icon-sanjiao-open');
                          li ='<ul>'
                             +  '<li class='+classid+' >'
                             +   tr
                             +    '<i></i><i class=" img-organize"></i><a class="cname">'+classname+' (<span style="color:red;margin:0;">'+usercount+'</span>)</a>'
                             +   '</div>'
                             +  '</li>'
                             +'</ul>';
                          parent.window.$("."+superior).append(li); 
                      }else{
                          li ='<li class='+classid+' >'
                             + tr
                             +  '<i></i><i class=" img-organize"></i><a class="cname">'+classname+' (<span style="color:red;margin:0;">'+usercount+'</span>)</a>'
                             + '</div>'
                             +'</li>';
                          parent.window.$("."+superior+">ul").append(li );  
                      }
                  }
              }

              parent.window.$("#classchoose").find('.iconfont').click(function(e){ 
                  var self = $(this),
                  classname = self[0].classList[1];
                  self.removeClass(classname);
                  if( classname == 'icon-sanjiao-close' ){
                      self.addClass('icon-sanjiao-open');
                      self.parent().nextAll('ul').css('display','block');       
                  }else{
                      self.addClass('icon-sanjiao-close'); 
                      self.parent().nextAll('ul').css('display','none'); 
                  }
              })
          }

          function diedai(arr,supobj){
            var objfor = [];       
            if(arr.length == arrz.length) return false;
            for(var i = 0,len = arr.length; i < len; i++ ){        
              var superior = arr[i].superior,
                  classid = arr[i].classid;
              if(supobj[superior]){
                  arrz.push(arr[i]);             
                  objfor[classid] = true;
              }          
            }       
            diedai(arr,objfor);
          }     

      }
    });

    // $("#chooseClassTag").click(function(){
    //   $("#chooseStudent",parent.document).hide();
    //   $("#chooseClass",parent.document).show();
    //   $("#banter",parent.document).hide();
    //   $("#chooseAllClass",parent.document).show();
    //   $("input[id^=class_choose_]",parent.document).hide();
    //   $("#chooseStudentTag",parent.document).removeClass('workrent');
    //   $(this).addClass('workrent');
    // });

    // $("#chooseStudentTag").click(function(){
        // $("#chooseClass",parent.document).hide();
        // $("#banter",parent.document).show();
        // $("#chooseStudent",parent.document).show();
        // $("#chooseClassTag",parent.document).removeClass('workrent');        
        // $(this).addClass('workrent');
    // });

  
  


    $("#chooseAllClass").click(function(){    
   parent.window.console.log($(this));
      // if($(this).prop('checked') == true){
      //     $.each($("#chooseClass ul input:checkbox",parent.document),function(key,obj){
      //       if($(obj).prop('checked') == false){
      //         $(obj).trigger('click');
      //       }
      //         parent.window.console.log(1);
      //     });
      // }else{
      //     $.each($("#chooseClass ul input:checkbox",parent.document),function(key,obj){
      //       if($(obj).prop('checked') == true){
      //         $(obj).trigger('click');
      //       }
      //     });
      // }
    });

    parent.window.H.remove('wxDialog');
    $('#wxDialog',parent.window.document.body).remove();
    parent.window.H.create(new P({
        id:'wxDialog',
        title:'选择收件人',
        easy:true,
        content:$("#wxDialog")[0]
      }),'common');
   	parent.window.initsearch("title",parent.window.wx.searchtext);

	})

  function triggerEvent(trueid,type){
    	parent.window.triggerEvent(trueid,type);    
  }
  function getWeixinContent(){
    	return UE.getEditor('message').getContent();
  }
  function getWeixinSubject(){
  	return $.trim($("#subject").val());
  }
  	
  function sendWeixin(){
    var msg = UE.getEditor('message').getContent();
    var subject = $.trim($("#subject").val());

    //验证主题
    if((subject=='') ||( subject.length>600) || subject=='请输入消息主题'){
  	  top.dialog({
  		title: '提示信息',
  		content: '请输入消息主题,且不超过200个字！',
  		cancel: false,
  		okValue: '确定',
  		ok: function () {
        setTimeout(function() {$("#subject").trigger("click");}, 1);
      }
  		}).showModal();
  	  return ;
  	  }
    //验证消息
    if(msg == '' || msg.length>60000){
      top.dialog({
      title: '提示信息',
      content: '消息内容不能为空,且不超过2万个字',
      cancel: false,
      okValue: '确定',
      ok: function () {
        setTimeout(function() {$("#subject").trigger("click");}, 1);
      }
      }).showModal();
      UE.getEditor('message').focus();
      return ;
    }
    var data = parent.window.getWeixinData();
    data = JSON.stringify(data);   
    if(data == '{}'){
  	  top.dialog({
  		title: '提示信息',
  		content: '请选择发送对象!',
  		cancel: false,
  		okValue: '确定',
  		ok: function () {
        setTimeout(function() {$("#subject").trigger("click");}, 1);
  		}}).showModal();
  	  return ;
  	  }
    $.ajax({
        type: "POST",
        url: "<?=geturl('troomv2/eth/save')?>",
        data:{datas:data,'message':msg,'subject':subject},
        success:function(res){
         if(res=="1"){
         		showSuccess();
          }else{
            var d = top.dialog({
  		title: '提示信息',
  		content: '发送失败，请稍后再试或联系管理员！',
  		cancel: false,
  		okValue: '确定',
  		ok: function () {}
  		});
  		d.showModal();
  	  return ;
          } 
        }
    });
  }

  function showSuccess(){
  	parent.window.H.remove('dialogsuccess');
  	$('#dialogsuccess',parent.window.document.body).remove();

  	parent.window.H.create(new P({
  		id : 'dialogsuccess',
  		title: '消息提示',
  		easy:true,
  		width:400,
  		padding:5,
  		content:$('#dialogsuccess')[0]
  	},{
  		onclose:function(){
  			location.href = '/troomv2/eth/history.html';
  		}
  	}),'common');

  	parent.window.H.get('dialogsuccess').exec('show');

  }

  function clearMessage(){
  	UE.getEditor('message').setContent('');
  }

  function trueCloseWeixinDialog(){
    parent.window.H.remove('wxDialog');
  };

  function msgFocus(){
  	 UE.getEditor('message').focus();
  }

  function strLenCalc() {
  	var subject = $("#subject").val(),
  	maxlen = 200,
  	curlen = maxlen,
  	len = subject.length;

  	if (curlen >= len) {
  		$("#checklen").html(curlen - len);
  	} else {
  		$("#subject").val(subject.substr(0, maxlen));
  	}
  }
</script>
<!-- ================= -->

<?php $this->display('troomv2/page_footer'); ?>