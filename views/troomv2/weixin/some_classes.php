<?php $this->display('troomv2/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script src="http://static.ebanhui.com/ebh/js/JSON.js"></script>
<div class="lefrig">
<div class="work_mes">
	<ul>
		<li>
		<a href="/troomv2/weixin/list_msg.html">发信历史</a>
		</li>
		<li class="">
		<a href="/troomv2/weixin/parent_send.html">家长回复</a>
		</li>
		<li class="workcurrent">
		<a href="/troomv2/weixin/class_send_msg.html">班级群发</a>
		</li>
	</ul>
</div>
<div class="waiyry" style="float:left;">
<div class="chouad" style="height:auto;width:879px;">
<span class="shyten">收件人：</span>
<div class="ewater" style="width:800px;">
<ul id="wrap2">

</ul>
</div>
<a href="javascript:showWeixinDialog()" class="weticen" style="float:right"></a>
</div>
<div style="width:900px;float:left; margin:0 auto;"><textarea style="width:879px;" class="txttiantl" name="summary"></textarea></div>
<div class="wtkkr">
内容不超过500字
<a href="javascript:clearMessage()" class="reler">清 空</a>
<a href="javascript:sendWeixin()" class="tjewkc">发 送</a>
</div>

</div>

</div>

<!-- ================ -->
<div id="wxDialog" class="taneret" style="display:none">
<div class="pantre">
<ul id="wrap">

</ul>
</div>
<div class="rtyres">
<div class="workmet">
<ul>
<li id="chooseClassTag" class="workrent">
<a href="#">
选择班级
</a>
</li>
<li id="chooseStudentTag">
<a href="#">
选择学生
</a>
</li>
</ul>
<div class="etshout">
  <input class="txtshout" name="textarea" type="text" id="title" value="请输入关键字" />
  <a href="javascript:parent.window.wxsearch()" class="shoutbtn">搜 索</a>
</div>
</div>
<div id="banter" class="banter" style="display:none;">
<ul id="classchoose">
<?php foreach($classlist as $class){?>
<li onclick="parent.window.getClassAndStudentsInfo(<?=$class['classid']?>)">
<a href="#">
<?=$class['classname']?>
</a>
</li>
<?php }?>
</ul>
</div>
<div id="chooseStudent" class="xueter" style="display:none;"> </div>
<div id="chooseClass" class="xueter">
  <ul>
    <?php foreach ($classlist as $class) {?>
        <li><input xxid="class_choose_<?=$class['classid']?>" onclick="parent.window.classChoseEvent(this)" class="teatle" type="checkbox" isclass="1" classid="<?=$class['classid']?>" tag="<?=$class['classname']?>"><label class="namester" for="checkbox"><?=$class['classname']?></label></li>
    <?php }?>
  </ul>
</div>
<div class="xuanque">
  <input id="chooseAllClass" class="teatle" type="checkbox" isclass="2" style="display: inline-block;">
  <label id="ifChooseAll" class="namester">全选</label>
  <a href="javascript:void(0)" onclick="parent.window.H.get('wxDialog').exec('close');" class="wrkeey">确 定</a>
</div>
</div>

</div>
<script>
	function showWeixinDialog(){
    parent.window.H.get('wxDialog').exec('show');
	}

	$(function(){

		$("#classchoose li").click(function(){
			$("#classchoose li",parent.document).removeClass('xuanz');
			$(this).addClass('xuanz');
		});

    $("#chooseClassTag").click(function(){
      $("#chooseStudent",parent.document).hide();
      $("#chooseClass",parent.document).show();
      $("#banter",parent.document).hide();
      $("#chooseAllClass",parent.document).show();
      $("input[id^=class_choose_]",parent.document).hide();
      $("#chooseStudentTag",parent.document).removeClass('workrent');
      $(this).addClass('workrent');
    });

    $("#chooseStudentTag").click(function(){
        $("#chooseClass",parent.document).hide();
        $("#banter",parent.document).show();
        $("#chooseStudent",parent.document).show();
        $("#chooseClassTag",parent.document).removeClass('workrent');
        $("#classchoose li:first",parent.document).trigger('click');
        $("#chooseAllClass",parent.document).hide();
        $(this).addClass('workrent');
    });

    $("#chooseAllClass").click(function(){
      if($(this).prop('checked') == true){
         $.each($("#chooseClass ul input:checkbox",parent.document),function(key,obj){
            if($(obj).prop('checked') == false){
              $(obj).trigger('click');
            }
          });
      }else{
          $.each($("#chooseClass ul input:checkbox",parent.document),function(key,obj){
            if($(obj).prop('checked') == true){
              $(obj).trigger('click');
            }
          });
      }
    });

    parent.window.H.remove('wxDialog');
    $('#wxDialog',parent.window.document.body).remove();
    parent.window.H.create(new P({
        id:'wxDialog',
        title:'选择学生',
        easy:true,
        content:$("#wxDialog")[0]
      }),'common');
    parent.window.initsearch("title",parent.window.wx.searchtext);

	})

function triggerEvent(trueid,type){
  parent.window.triggerEvent(trueid,type);    
}
function getWeixinContent(){
  return $.trim($("textarea.txttiantl").val());
}
function sendWeixin(){
  var msg =  $.trim($("textarea.txttiantl").val());
  if(msg.length>1500){
    alert('内容不超过500字');
    return;
  }
  if(msg == ''){
      alert('内容不能为空');
      return;
  }
  var data = parent.window.getWeixinData();
  data = JSON.encode(data);
  if(data == "fail_to_load_msg"){
    alert("微信内容获取失败");
    return;
  }
  if(data == '{}'){
    alert("请选择发送对象");
    return;
  }
  $.ajax({
      type: "POST",
      url: "<?=geturl('troomv2/weixin/do_all_send')?>",
      data:{datas:data},
      success:function(res){
       if(res=="1"){
          $.showmessage({
            message:'发送成功！',
            callback :function(){
                 location.href = '/troomv2/weixin/list_msg.html';
            }});
        }else{
          $.showmessage({message:'发送失败'});
        } 
      }
  });
}

function clearMessage(){
  $("textarea.txttiantl").val("");
}

function trueCloseWeixinDialog(){
  parent.window.H.remove('wxDialog');
};

function msgFocus(){
  $("textarea.txttiantl").focus();
}

</script>


<!-- ================= -->
 <?php $this->display('troomv2/page_footer');?>