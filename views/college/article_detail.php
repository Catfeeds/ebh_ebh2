<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $systemsetting = Ebh::app()->room->getSystemSetting();?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title><?=$roominfo['crname']?></title>
</head>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/collegestyle.css?v=20170710150583">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css">
<body style="position:relative;left:0px;background:url(http://static.ebanhui.com/ebh/tpl/2016/images/bg_gt.jpg?v=20161201) no-repeat #f5fafd center top;">
<div class="lefrig">
    <div class="lefrig-2">
        <h2 class="probe">
        	<?=$info['detail']['subject']?>
        </h2>
        <div class="questinformation-1 questinformationline">
        	<span class="questiontime-2" style="margin-left:320px;"><?=timetostr($info['detail']['dateline'])?></span>
            <img class="questionerhead" src="<?=empty($info['detail']['face'])?getavater($info['detail']):$info['detail']['face']?>">
            <span class="questioner" title="<?=$info['detail']['realname']?>"><?=$info['detail']['realname']?></span>
            <p class="quester"><?=$info['detail']['class']?></p>
            <span class="flriget gkico"><?=$info['detail']['viewnum']?></span>
            <span class="flriget plico" id="review"><?=empty($info['detail']['review'])?0:$info['detail']['review']?></span>
        </div>
        <div style="padding:20px 0;font-size:16px;">
        	<?=$info['detail']['message']?>
        </div>
    </div>
  <div class="lefrig-3" id="lefrig-3">	
        <div class="alltitle">全部评论</div>
        <div class="allcommentslist">
            <ul class="ule" id="box">
            </ul>
        </div>
  </div>
  <div id="mpage" style="height:60px;clear:both;"></div>
    <div style="width:100%;position:fixed;top:55%;height:1px;display: block" id="testpl" >
        <ul class="toolbarx">
            <li class="tool tFeedback"><a href="javascript:;">评论</a></li>
        </ul>
  </div>
</div>

<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/jQuery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
<script type="text/javascript">
$(function() {

    var readtimeview;
    var viewtime = 0; //用来计时
    var typenovedio = 5;//阅读原创文章
    var articleid = <?=$info['detail']['itemid']?>;

    $.ajax({
        type:"post",
        url:"/studyscorelogs/getOtherSetting.html",
        dataType:"json",
        success:function(data){
            if(data.code == 0){
                readtimeview = parseInt(data.data.news.readtime);
                var readtimeInt = setInterval(function(){
                    viewtime++;
                    if(viewtime >= readtimeview){
                        $.ajax({
                            type:"post",
                            url:"/studyscorelogs/addScore.html",
                            data:{
                                "type":typenovedio,
                                "articleid":itemid,
                                "readtime":viewtime
                            },
                            success:function(json){
                                console.log("成功");
                            },
                            error:function(json){

                            }
                        });
                        clearInterval(readtimeInt);
                    }
                },1000);
            }else{
                console.log("返回错误")
            }
        },
        error:function(data){

        }
    });





    $("#testpl").on("click", function() {
		top.dialog({
			id: "testpl", //可选
			title: "发表评论",
			content: "<textarea class='textts' placeholder='请输入你的评论。。。' id='textts'></textarea>",
			okValue: "发表",
			ok: function() {
                var message = $("#textts").val();
                if (message) {
                    addReview(message);
                } else {
                    alert('评论不能为空');
                }
			},
			width: 600,
			height: 180,
			padding: 20
		}).showModal(); //show:无遮罩层,showModal:有遮罩层，需要全屏显示请在dialog前加上top,例：top.dialog({....}).showModal()
	});
       itemid = <?=$info['detail']['itemid']?>;
       uid = <?=$uid?>;
       getlist();
        
})
    
     //新增评论
     function addReview(message) {
        if (typeof message== undefined) {
            return false;
        }
        var url = '/college/myarticle/addReview.html';
        $.ajax({
            url:url,
            type:'post',
            dataType:'json',
            data : {'message' : message,'articleid':itemid},
            success:function(res){
                
                if (res.code ==1) {
                var d=  top.dialog({
                        title: '提示信息',
                        content: '评论成功',
                        width:370,
                        cancel: false,
                            okValue: '确定',
                            ok: function () {
                            }
                        }).showModal();
                        setTimeout(function(){
                            d.close().remove();
                        },2000);
                        getlist();
                        var reviewNum = $("#review").html();
                        reviewNum = parseInt(reviewNum)+1;
                        $("#review").html(reviewNum);
                } else {
                      var d=  top.dialog({
                        title: '提示信息',
                        content: '评论失败，字数超过1000',
                        width:370,
                        cancel: false,
                            okValue: '确定',
                            ok: function () {
                            }
                        }).showModal();
                        setTimeout(function(){
                            d.close().remove();
                        },2000);
                }
            },
            error : function(){
                console.log('req err');
            }
        });
     }
    //渲染
    function renderList(list){
        $("#box").empty();
        if (list.length == 0) {
            var str = '<div class="nodata"></div>';
            var $dom = $(str);
            $("#box").append($dom);
            $(window).scrollTop(0);
            return ;
        }
        var str = '';
        for(var i = 0,len = list.length; i<len; i++) {
            var data = list[i];
            var delStr = '';
            if (list[i].uid == uid) {
                delStr = '<a href="javascript:;" class="shield delatereviews" onclick="del_comment('+data.rwid+',this);">删除</a>';
            }
            str += '<li><div class="avatar-1"><img src="'+data.face+'" class="circular"></div><div class="commentsright"><div class="commentsright-top"><a href="javascript:void(0)"  class="studentname" >'+data.realname+'</a><span class="totalscore time">'+data.dateline+'</span></div></div><div class="commentsright-center">'+data.comment+'</div><div class="commentsright-bottom">'+delStr+'</div></li>'
        }
        var $dom = $(str);
        $("#box").append($dom);
        $(window).scrollTop(0);

    }
        function getlist(url){   //获取评论分页
            if(typeof url == "undefined") {
                url = '/college/myarticle/getReviewsAjax.html<?=empty($seg)?"":"?seg=1"?>';
            }
            $.ajax({
                url:url,
                type:'post',
                dataType:'json',
                data : {'itemid' : itemid},
                success:function(res){
                    if(res.errCode == 133){
                        var cmain_bottom = '<div class="cmain_bottom " style="width: 100%;  min-height: 400px;">' +
                            '<div class="study" style="margin: 0 auto;border-bottom:none;">' +
                                '<div class="nodata"></div>'+
                                '<p class="zwktrykc" style="text-align: center;"></p>'+
                            '</div>'+
                        '</div>';
                        $('#mpage').empty();
                        $("#exams").empty().append(cmain_bottom);
                    }else{
                        var $pagedom = $(res.data.pagestr);
                        $pagedom.find('.listPage a').bind('click',function(){
                            var url = $(this).attr('data');
                            var estype = $('.curr').attr('data');
                            if(!!url) {
                                getlist(url);
                            }
                        });
                        $("#mpage").empty().append($pagedom);
                        renderList(res.data.list);
                    }
                },
                error : function(){
                    console.log('req err');
                }
        });
       }

    //删除评论
    function del_comment(itemid){
        var d = dialog({
            title: '删除评论',
            content: '您确定要删除该评论吗？删除后不可查看该评论!',
            okValue: '确定',
            ok: function () {
                var url = "<?= geturl('college/myarticle/updateReview')?>";
                $.ajax({
                    url:url,
                    type:'post',
                    data:{'itemid':itemid,'del':1},
                    dataType:'json',
                    success:function(result){
                        if(result.code == '1'){
                            var d=  top.dialog({
                            title: '提示信息',
                            content: result.msg,
                            width:370,
                            cancel: false,
                                okValue: '确定',
                                ok: function () {
                                }
                            }).showModal();
                            setTimeout(function(){
                                d.close().remove();
                            },2000);
                            var reviewNum = $("#review").html();
                            reviewNum = parseInt(reviewNum)-1;
                            $("#review").html(reviewNum);
                            getlist();
                        }else{
                            alert(result.msg);
                        }
                    }
                });
                
            },
            cancelValue: '取消',
            cancel: function () {}
        });
        d.showModal();
    }
</script>

</body>
</html>
