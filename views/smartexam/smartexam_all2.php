<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/college/style.css<?=getv()?>" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<title>微题-历史记录</title>
<style>
  a.lans{
    color: #20bafa;
  }
  a.lans:hover{
    color: #1177fa;
    text-decoration: none;
  }
  .retyi{
    background: none;
    height: 20px;
    line-height: 20px;
  }
  .tansty{
    height: auto;
  }
</style>
</head>

<body>
<div class="lefrig smallsubject" style=" background:#fff; float: left; width: 1000px; margin-top: 0px;">
	<div class="work_menu">
        <ul>
            <li><a target="_blank" href="http://exam.ebanhui.com/ssmartenew/<?=$crid?>.html"><span>微题</span></a></li>
            <li class="workcurrent"><a href="<?=geturl('smartexam/smartexam/qlist')?>"><span>历史记录</span></a></li>
            <li><a href="<?=geturl('smartexam/myerrorbook')?>"><span>错题本</span></a></li>
        </ul>
	</div>
  <?php if(!empty($elist)) { ?>
  <?php 
    $num_hanzi_map = array(
      '1'=>'一','2'=>'二','3'=>'三','4'=>'四','5'=>'五','6'=>'六','7'=>'七','8'=>'八','9'=>'九','10'=>'十','11'=>'十一','12'=>'十二',
    );
  ?>
  <?php foreach($elist as $ek=>$e) { ?>
      <?php
        $status_map = array(
          '0'=>'草稿',
          '1'=>'进行中...',
          '3'=>'已完成'
        );
        if(count($e['alist']) == 0){
          $startname = "开始巩固";
        }else{
          $startname = "继续巩固";
        }
        $detailstyle = ($ek>1)?'style=\'display:none;\'':'';
        $detailhit =  ($ek>1)?'查看答题记录':'收起答题记录';
        $limitedtimestr = (empty($e['limitedtime']))?'不限时':'限时'.$e['limitedtime'].'分钟';
      ?>
  	<div class="waiste">
     		<h2 class="retyi"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/litits.jpg" style="vertical-align: middle;">  <?=$e['title']?></h2>
          <a title="删除微题" href="javascript:delexam(<?=$e['eid']?>)" class="reybt"></a>
          <p class="sreytu">
            <?=date('Y-m-d H:i',$e['dateline'])?> 出题 共<span class="huangs"><?=$e['score']?></span>分　<?php if(empty($e['limitedtime'])){echo '不计时';}else{echo '计时：<span class="huangs">',$e['limitedtime'],' </span>分钟';}?>　答题<?=count($e['alist'])?>次　<span class="lans"><?=$status_map[$e['status']]?></span> 
            <?php if(empty($e['status'])){?>
              <a class="lans" target="_blank" href="http://exam.ebanhui.com/ssmarteedit/<?=$crid?>/<?=$e['eid']?>.html">（编辑草稿）</a>
            <?php }?>
            <?php if(!empty($e['cannew']) && !empty($e['status'])){?>
              <a class="lans" target="_blank" href="http://exam.ebanhui.com/smartedo/<?=$e['eid']?>.html">（<?=$startname?>）</a>
            <?php }?>
          </p>
        	<a href="javascript:void(0)" onclick="$('#table_<?=$e["eid"]?>').slideToggle('normal',function(){resetheight()})" class="rtykyu"><?=$detailhit?></a>
        <div id="table_<?=$e['eid']?>" <?=$detailstyle?> >
      	<table width="100%" class="databer" >
            <tr>
              <th>答题记录</th>
              <th>答题时间</th>
              <th>用时</th>
              <th>得分/总分</th>
              <th>错题数/总题数</th>
              <th>错题详情</th>
              <th>查看试卷</th>
            </tr>
            <?php foreach ($e['alist'] as $ak=>$a) {?>
            <?php 
                $datici = key_exists($ak+1,$num_hanzi_map)?$num_hanzi_map[$ak+1]:($ak+1);
                $dateline = date('Y-m-d H:i',$a['dateline']);
                $completetime = secondToStr($a['completetime']);
                $totalscore = $a['totalscore'];
                $score = $a['score'];
                $quecount = $a['quecount'];
                $eid = $a['eid'];
                $aid = $a['aid'];
            ?>
            <tr>
              <td>第<?=$datici?>次答题</td>
              <td><?=$dateline?></td>
              <td><?=$completetime?></td>
              <td><span class="huangs"><?=$totalscore?></span>/<?=$score?></td>
              <td><span class="huangs"><?=$a['falsenum']?></span>/<?=$quecount?></td>
              <?php if(empty($a['status'])){?>
                <td><a class="pusiz" target="_blank" href="http://exam.ebanhui.com/smartedo/<?=$a['eid']?>/<?=$a['aid']?>.html" >继续巩固</a></td>
              <?php }else{?>
                 <td><a class="pusiz"  href="javascript:void(0)" onclick="fenxi('<?=$datici?>','<?=$dateline?>','<?=$limitedtimestr?>','<?=$completetime?>','<?=$totalscore?>','<?=$score?>','<?=$quecount?>','<?=$eid?>','<?=$aid?>','<?=$a["falsenum"]?>')" >查看详情</a></td>
              <?php }?>
              <?php if(!empty($a['status'])){?>
                <td><a target="_blank" href="http://exam.ebanhui.com/smartemark/<?=$a['eid']?>/<?=$a['aid']?>.html" class="pusiz">查看试卷</a></td>
              <?php }else{?>
                <td>&nbsp;</td>
              <?php }?>
            </tr>
            <?php }?>
          </table>
           </div>
    </div>
  <?php }?>
  <?php }else{?>
    <div style="text-align: center" class="nodata"></div>
  <?php }?>
  <?=$pagestr?>
</div>

<div id="showfenxiwrap" style="display:none;">
  <div class="tansty">
    <h2 class="rytwqw">第<span id="datici">一</span>次答题</h2>
    <p class="kerye">完成时间：<span id="dateline">0</span>&nbsp;&nbsp;&nbsp;&nbsp;共<span id="quecount">0</span>题&nbsp;&nbsp;&nbsp;&nbsp;<span id="limitedtimestr">不限时</span>&nbsp;&nbsp;&nbsp;&nbsp;总分 <span class="huangs" id="score">0</span> 分，您得了 <span id="totalscore" class="huangs">0</span> 分.</p>
      <div class="waisttg">
          <table id="databer" width="100%" class="databer">
               
          </table>
      </div>
      <a id="falsequeurl" target="_blank" href="#" class="retbtn">查看错题</a>
  </div>
</div>



<script type="text/javascript">
  function delexam(eid){
    $.ajax({
          url:"<?=geturl('smartexam/smartexam/delexam')?>",
          type:"post",
          dataType:"json",
          data: {eid:eid},
          success:function(res){
            if(res.status == 0){
				 top.dialog({
					title: '提示信息',
					content: '删除成功！',
					width:370,
					cancel: false,
					okValue: '确定',
					ok: function () {
					location.reload(1);
					}
				}).showModal();
            }else{
				top.dialog({
					title: '提示信息',
					content: '对不起，删除失败，请稍后再试！',
					width:370,
					cancel: false,
					okValue: '确定',
					ok: function () {
					location.reload(1);
					}
				}).showModal();
            }
          }
      });
  }


function fenxi(datici,dateline,limitedtimestr,completetime,totalscore,score,quecount,eid,aid,falsenum){
  $("#datici").text(datici);
  $("#dateline").text(dateline);
  $("#limitedtimestr").text(limitedtimestr);
  $("#totalscore").text(totalscore);
  $("#quecount").text(quecount);
  $("#score").text(score);
  $("#dateline").text(dateline);
  if(falsenum == "0"){
    $("#falsequeurl").hide();
  }else{
    $("#falsequeurl").show();
    $("#falsequeurl").attr('href','http://exam.ebanhui.com/smartemark/'+eid+'/'+aid+'.html?showfalse=1');
  }
  $.ajax({
      url:"<?=geturl('smartexam/smartexam/fenxi')?>",
      type:"post",
      dataType:"json",
      data: {aid:aid},
      success:function(res){
        $("#databer").html(res.htmlstr);
        showFenxiDialog();
      }
  });
}

function showFenxiDialog(){
  parent.window.Func('fenxi',$("#showfenxiwrap").html());
  with(parent.window){
    H.create(new P({
      title:" ",
      id:"showfenxiwrap",
      content:Func('fenxi'),
      modal:true
    })).exec('show');
  }
}
</script>
<script>
function resetheight(){
	var totalheight = 0;
	var height_smallsubject = $(".smallsubject") ? parseInt($('.smallsubject').get(0).offsetHeight):0;
	totalheight = height_smallsubject;
	top.resetmain(totalheight);
}
//定时器作为修正使用,防止重复刷新页面没有加载完成
var timer = setTimeout(function(){
	resetheight();
	},500)
	
$(function(){
	if (window.top != window.self){
		top.$('#mainFrame').width(1000);
		top.$('.rigksts').hide();
	}
});
</script>
</body>
</html>
