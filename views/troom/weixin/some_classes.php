<?php $this->display('troom/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<script src="http://static.ebanhui.com/ebh/js/JSON.js"></script>
<div class="ter_tit"> 当前位置 > <a onclick="trueCloseWeixinDialog()" href="<?= geturl('troom/weixin') ?>">微家校通</a> > 班级群发</div>
<div class="lefrig"  style="background:#fff;float:left;margin-top:15px;width:788px;">
<div class="waiyry">
<div class="chouad" style="height:auto">
<span class="shyten">收件人：</span>
<div class="ewater">
<ul id="wrap2">

</ul>
</div>
<a href="javascript:showWeixinDialog()" class="weticen" style="float:right"></a>
</div>
<div style="width:697px; margin:0 auto;"><textarea class="txttiantl" name="summary"></textarea></div>
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
  if(msg.length==0 || msg.length>1500){
    alert('内容不超过500字');
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
      url: "<?=geturl('troom/weixin/do_all_send')?>",
      data:{datas:data},
      success:function(res){
       if(res=="1"){
          $.showmessage({
            message:'发送成功！',
            callback :function(){
                 location.href = location.href;
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
 <?php $this->display('troom/page_footer');?>