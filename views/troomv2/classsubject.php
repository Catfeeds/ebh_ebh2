<?php
$this->display('troomv2/page_header');
$roominfo = Ebh::app()->room->getcurroom();
?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2016/css/covers.css<?=getv()?>" />
	<style type="text/css">
		.kejian {
			width: 1000px;
			background:#fff;
			float:left;
			border:none;
		}
		.kejian .showimg {
			margin-top: 10px;
			margin-left: 14px;
		}
		.kejian liss {
			width: 748px;
		}
		.kejian .liss .danke {
			width: 145px;
			float: left;
			margin-left:20px;
			display:inline;
			margin-top: 8px;
			height: 218px;
		}
		.kejian .liss .danke .spne {
			text-align: center;
			width: 135px;
			height: 36px;
			line-height:15px;
			overflow: hidden;
			word-wrap: break-word;
			display: block;
			color: #0033ff;
			float:left;
		}
		.kejian .liss .danke .sds {
			height: 184px;
			width: 145px;
			border: 1px solid #cdcdcd;
			background-image: url(http://static.ebanhui.com/ebh/tpl/2012/images/dise.jpg);
			background-repeat: no-repeat;
			background-position: center center;
			margin-bottom: 8px;
		}
		
		.showimg { float:left;}
		.showimg img {border:1px solid #CDCDCD; padding:4px; position:relative; left:-4px; top:-5px;}
		.hover .showimg img { border:1px solid ;}
		.showimg .hover{border: 1px solid;}
		
		
		.noke {
			height: 480px;
			width: 786px;
			float: left;
			border: 1px solid #cdcdcd;
			background: #fff;
		}
		.noke p {
			background: url(http://static.ebanhui.com/ebh/tpl/2012/images/nokejianico.jpg) no-repeat;
			height: 120px;
			margin-top: 90px;
			margin-left: 170px;
			padding-left: 140px;
			font-size: 16px;
			padding-top: 30px;
		    width: 307px;
		}
		.noke span {
			color: #e94f29;
		}
		.work_mes {
			height:auto;
			border-bottom:solid 1px #ffffff;
		}
		.danke:hover{ box-shadow:0 0 5px #ccc;}
		.bordershadow{
			top:135px;
			height:24px;
		}
		.filter_box{
			clear: both;
			color: #919191;
			font-size: 16px;
			height: auto;
			padding: 20px 0 20px 15px;
		}
		.filter_box .filter_ul li{
			float: left;
			margin-right: 15px;
			cursor: pointer;
			padding-right: 14px;
		}
		.coursebox{
			width: 950px;
			height: 128px;
			margin: 0 0 22px 20px;
		}
		.coursecover{
			width: 216px;
			height: 128px;
			float: left;
		}
		.coursecover img{
			width: 216px;
			height: 128px;
			border: 0 none;
		}
		
		.coursecontent{
			float: left;
			width: 724px;
			height: 128px;
			margin-left: 10px;
		}
		.coursecontent .titlecour{
			color: #666;
			font-size: 16px;
			font-weight: bold;
		}
		.coursecontent p{
			width: 734px;
			height: 30px;
			color: #666;
			font-size: 16px;
			font-weight: bold;
			position: relative;
		}
		.coursecontent p img{
			display: inline-block;
			width: 34px;
			height: 34px;
			border-radius: 50%;
		}
		.lookcourse{
			color: #20A0FF;
			cursor: pointer;
			font-size: 14px;
		}

		.marr5{
			margin-right: 5px;
		}
		.sortup{
			background: url(http://static.ebanhui.com/ebh/images/sortup.png) no-repeat center right;
		}
		.sortdown{
			background: url(http://static.ebanhui.com/ebh/images/sortdown.png) no-repeat center right;
		}
		.color49B1FF{
			color: #49B1FF;
		}
	</style>
	
	
	<div class="lefrig">
<div class="waitite">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso"><?=$pagemodulename?></span></a></li>
			</ul>
		</div>
	<?php $this->assign('currentindex',0);
	$this->display('troomv2/courselinkbar');?>
</div>

<?php if($roominfo['isschool'] != 7 || (!empty($school_type) && ($school_type == 2))){
		if(!empty($subjectlist)){?>
		<div class="<?=$roominfo['template'] == 'plate' ? 'studycourse studycourse-1' : 'kejian' ?>">
			<ul class="<?=$roominfo['template'] == 'plate' ? '' : 'liss' ?>">

		        <?php 
				if ($roominfo['template'] == 'plate') {
					foreach($subjectlist as $subject) {
						$img = show_plate_course_cover($subject['img']); ?>
					<li>
						<a href="<?= geturl('troomv2/classsubject/'.$subject['folderid']) ?>" title="<?= $subject['foldername'] ?>"><img class="courseimg-2" src="<?= empty($img) ? 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_212_125.jpg' : show_thumb($img, '212_125') ?>" width="212" height="125" /></a>
						<a href="<?= geturl('troomv2/classsubject/'.$subject['folderid']) ?>" title="<?= $subject['foldername'] ?>" class="coursrtitle-2"><?=$subject['foldername'] ?>(<?= $subject['coursewarenum'] ?>)
						<div class="bordershadow" title="<?= $subject['foldername'] ?>"></div></a>
						
					</li>
		        <?php }
				} else {
					foreach($subjectlist as $subject) { ?>
						<li class="danke">
							<div class="showimg"><a href="<?= geturl('troomv2/classsubject/'.$subject['folderid']) ?>" title="<?= $subject['foldername'] ?>"><img src="<?= empty($subject['img']) ? 'http://static.ebanhui.com/ebh/images/nopic.jpg' : $subject['img'] ?>" width="114" height="159" border="0" /></a></div>
							<span class="spne"><a href="<?= geturl('troomv2/classsubject/'.$subject['folderid']) ?>" style="text-decoration: none;" title="<?= $subject['foldername'] ?>"><?= ssubstrch($subject['foldername'],0,20) ?>(<?= $subject['coursewarenum'] ?>)</a></span>
						</li>
		        <?php }
				}
				 ?>
		
			</ul>
		</div>
		<?php }else{ ?>
			<div class="noke" style="border:none; margin:0 auto; width:1000px;"><p>您还没有<span>开设任何课程</span>，只有开设课程后，才可以将您的课件等内容上传。</p></div>
		<?php } ?>			
	<?php }else{?>
		<div class="work_mes">
			<ul>
				<?php $i=0;$currPid = $this->input->request('pid');$currPid = $currPid ?$currPid:0;foreach($folderbypid as $k=>$package){?>

					<li class="<?=(($currPid==0 && $i==0) || $currPid==$package['pid']?'workcurrent':'')?> ptab"  id="tab<?=$package['pid']?>"><a href="javascript:void(0)" title="<?=$package['pname']?>" onclick="changetab(<?=$package['pid']?>,this)"><span><?=$package['pname']?></span></a></li>
				<?php $i++;}?>
			</ul>
		</div>
		
		<?php if(!empty($subjectlist)) { ?>
		<div class="filter_box">
			<ul class="filter_ul">
				<li class="sortli" data-orderBy="[0]" cur="0" >全部</li>
				<li class="sortli" data-orderBy="[5,6]">人气</li>
				<li class="sortli" data-orderBy="[7,8]">点赞</li>
				<li class="sortli" data-orderBy="[9,10]">评论</li>
				<li class="sortli" data-orderBy="[11,12]">课单价</li>
				<li class="sortli" data-orderBy="[13,14]">课件数</li>
				<li class="sortli" data-orderBy="[1,2]">学分</li>
				<li class="sortli" data-orderBy="[3,4]">时长</li>
			</ul>
		</div>
		<?php if(!empty($subjectlist)){ foreach ($subjectlist as $item) {
		    
		?>
		<div class="coursebox" data-id="<?=$item['pid']?>">
			<div class="coursecover">
				<a href="<?= geturl('troomv2/classsubject/'.$item['folderid']) ?>">
					<img src="<?=($item['img']?show_thumb($item['img'],'212_125'):'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_212_125.jpg')?>"/>
				</a>
			</div>
			<div class="coursecontent">
				<p>
					<a class="titlecour" href="<?= geturl('troomv2/classsubject/'.$item['folderid']) ?>" title="<?=$item['foldername']?>"><?=(mb_strlen($item['foldername'],'UTF8')<=30?$item['foldername']:mb_substr($item['foldername'],0,30,'UTF8').'...')?></a>
					<span style="color: #FF6663;position: absolute;top: 0;right: 50px;font-weight: 100;"><?=($item['price']==0?'':'单价')?>
						<span class="size20"><?=($item['price']==0?'免费':$item['price'].'元')?></span>
						<span><?=($item['iday']>0?'/'.$item['iday'].'天':'')?></span>
						<span><?=($item['imonth']>0?'/'.$item['imonth'].'个月':'')?></span>
					</span>
				</p>
				<p style="color: #999;font-size: 14px;font-weight: 100;">
					<span><?=$item['number']?></span>节课&nbsp;&nbsp;&nbsp;
					<span><?=$item['fabulous']?></span>个赞&nbsp;&nbsp;&nbsp;
					<span><?=$item['popularity']?></span>次学习&nbsp;&nbsp;&nbsp;
					<span><?=$item['comment']?></span>条评论&nbsp;&nbsp;&nbsp;
					<span><?=$item['credit']?></span>个学分&nbsp;&nbsp;&nbsp;
					<?=(empty($item['timeLength'])?'':'<span>时长&nbsp;<span class="size20">'.$item['timeLength'].'</span></span>')?>
				</p>
				<p style="height: 34px;">
                    <?php foreach ($item['teachers'] as $key =>$ite) {?>
                    <?php

                        if($key > 11){
                            echo '<span class="marr5">...<span>';
                            break;
                        }else{
                            echo '<span class="marr5"><img src="'.$ite['face'].'" alt="" title="'.(empty($ite['realname'])?$ite['username']:$ite['realname']).'"  /></span>';
                        }


                  } ?>
				</p>
				<p style="margin-top: 10px;">
					<span class="lookcourse marr5" onclick="courseStat('<?=$item['folderid']?>','<?=$item['foldername']?>')">文件统计</span>
					<span class="lookcourse marr5" onclick="courseRank('<?=$item['folderid']?>')">学习排名</span>
				</p>
			</div>
		</div>
		
		<?php } } ?>
		<?php }else{ ?>
			<div class="noke" style="border:none; margin:0 auto; width:1000px;"><p>您还没有<span>开设该课程</span>，只有开设课程后，才可以将您的课件等内容上传。</p></div>
		<?php } ?>
	<?php
	} ?>
<div id="courserank" style="display:none;">
    <style>
		.ui-dialog2{
        	border-radius: 4px;
      	}
   	</style>
    <iframe id="courserankiframe" src="/troomv2/classsubject/classsubjectRank.html" frameborder="0" width="1000" height="640"></iframe>
</div>

<div id="coursestat" style="display:none;">
    <style>
		.ui-dialog2{
        	border-radius: 4px;
      	}
   	</style>
    <iframe id="coursestatiframe" src="/troomv2/classsubject/classsubjectStat.html" frameborder="0" width="1000" height="640"></iframe>
</div>
	
<script>


    window.onload=function () {
        parent.window.layer.closeAll();

    }

    $.extend ({
        //处理排序显示
        orderBy:function (orderBy) {
            if(orderBy == 0){
                $('.filter_ul li').eq(0).addClass('color49B1FF');
            }else{
                $('.filter_ul li').eq(0).removeClass('color49B1FF');

            }
          $('.filter_ul li').each(function (k,v) {
              var data = v.getAttribute('data-orderBy');
                  data = eval(data);
              var self = this;

              if($.inArray(orderBy,data) >= 0){
                  $(self).addClass('workcurrent');
                  if(orderBy%2 == 0 ){
                      //下箭头
                      if(orderBy==0)
                          return;
                      $(self).addClass('sortdown');
                      $(self).addClass('color49B1FF');
                      $(self).removeClass('sortup');
                  }else{
                      //上箭头
                      $(self).addClass('sortup');
                      $(self).addClass('color49B1FF');
                      $(self).removeClass('sortdown');
                  }
              }else{
                  $(self).removeClass('workcurrent');
                  $(self).removeClass('sortdown');
                  $(self).removeClass('sortup');
                  $(self).removeClass('color49B1FF');

              }

          })
        }


    });

//排序选择
$('.filter_ul li').on('click',function () {
    parent.window.layer.load();
    var self = this;
    var data = self.getAttribute('data-orderBy');
    data = eval(data);
    var cur  = self.getAttribute('cur');
    var orderBy = 0;
    if(cur){
        for( var k in data){
            if(data[k] != cur){
                orderBy = data[k];
                self.setAttribute('cur',orderBy);
            }
        }
    }else{
        orderBy = data[0];
        self.setAttribute('cur',orderBy);
    }
    var pid = $('.work_mes li[class*="workcurrent"]').attr('id').substr(3);
    $.orderBy(orderBy);

    getFolderList(pid,orderBy);
//    url += '?pid=' + pid + '&orderBy=' + orderBy;
//    location = url;

})
//选择服务包
function changetab(pid,e){
      $.orderBy(0);
      if(e){
          var li = $(e).parent();
          getFolderList(pid);
      }else{
         return;
      }
      var _class = $(li).attr('class');
      if(_class.indexOf('workcurrent') >=0)
          return;
      $(li).addClass('workcurrent');
      $(li).siblings().removeClass('workcurrent');
//      parent.window.layer.load();
//      var url = location.href ;
//      url = url.match('.*?\.html');
//      url += '?pid='+pid;
//      //选择服务包
//      location.href = url;

}
//关闭加载模态框
var closeModel = function () {
    window.parent.layer.closeAll();
}
//打开加载模态框
var openModel  = function () {
    window.parent.layer.load();
}
//获取每个服务包的课程
    function getFolderList(pid,orderBy) {
       openModel();
      //清空原来数据
        $('.coursebox').each(function () {
            $(this).remove();
        })
        var data = {pid:pid,orderBy:orderBy||0};
        $.ajax({
            url:'getFolderList.html',
            type:'post',
            dataType:'json',
            asyn:true,
            data:data,
            success:function (res) {
                if(typeof (res.code) == 'number' && res.code==0 ){
                    var list = res.data;
                    var html = '';
                    for(var key in list){
                        var item = list[key];
                        item.titleFoldername = item.foldername;//title输出原来标题
                        item.foldername = item.foldername.length <= 30?item.foldername:item.foldername.substr(0,30)+'...';
                        var teachers = item.teachers;//课程关联的教师
                        var teachersHtml = '';
                        for(var _key in teachers){
                            var teacher = teachers[_key];
                            if(_key > 11){
                                teachersHtml += '...';
                                break;
                            }else{
                            teachersHtml += '<span class="marr5"><img src="'+teacher.face+'" alt="" title="'+teacher.realname+'"></span>';
                            }
                        }
                        if(item.price > 0){
                            var price ='\t\t\t\t\t<span style="color: #FF6663;position: absolute;top: 0;right: 50px;font-weight: 100;">单价\t\t\t\t\t\t<span class="size20">'+(item.price)+'元</span>' +
                                '\t\t\t\t\t\t<span>'+(item.iday>0?'/'+item.iday+'天':'')+'</span>\n' +
                                '\t\t\t\t\t\t<span>'+(item.imonth>0?'/'+item.imonth+'个月':'')+'</span>\n' +
                                '\t\t\t\t\t</span>\n';
                        }else{
                            var price = '<span style="color: #FF6663;position: absolute;top: 0;right: 50px;font-weight: 100;">免费' +
                                '<span>'+(item.iday>0?'/'+item.iday+'天':'')+'</span>' +
                                '<span>'+(item.imonth>0?'/'+item.imonth+'个月':'')+'</span>' +
                                '</span>';

                        }
                         if(item.timeLength){
                             timeLength = '<span>时长&nbsp;<span class="size20">'+item.timeLength+'</span></span>';
                         }else{
                             timeLength = '';
                         }
                         html += '<div class="coursebox" data-id="'+item.pid+'">\n' +
                        '\t\t\t<div class="coursecover">\n' +
                        '\t\t\t\t<a href="/troomv2/classsubject/'+item.folderid+'.html">\n' +
                        '\t\t\t\t\t<img src="'+item.img+'">\n' +
                        '\t\t\t\t</a>\n' +
                        '\t\t\t</div>\n' +
                        '\t\t\t<div class="coursecontent">\n' +
                        '\t\t\t\t<p>\n' +
                        '\t\t\t\t\t<a class="titlecour" href="/troomv2/classsubject/'+item.folderid+'.html" title="'+item.titleFoldername+'">'+item.foldername+'</a>\n' +price
                         +
                        '\t\t\t\t</p>\n' +
                        '\t\t\t\t<p style="color: #999;font-size: 14px;font-weight: 100;">\n' +
                        '\t\t\t\t\t<span>'+item.number+'</span>节课&nbsp;&nbsp;&nbsp;\n' +
                        '\t\t\t\t\t<span>'+item.fabulous+'</span>个赞&nbsp;&nbsp;&nbsp;\n' +
                        '\t\t\t\t\t<span>'+item.popularity+'</span>次学习&nbsp;&nbsp;&nbsp;\n' +
                        '\t\t\t\t\t<span>'+item.comment+'</span>条评论&nbsp;&nbsp;&nbsp;\n' +
                        '\t\t\t\t\t<span>'+item.credit+'</span>个学分&nbsp;&nbsp;&nbsp;\n' +timeLength+
                        '\t\t\t\t\t\t\t\t\t</p>\n' +
                        '\t\t\t\t<p style="height: 34px;">\n' +teachersHtml+
                        '\t\t\t\t</p>\n' +
                        '\t\t\t\t<p style="margin-top: 10px;">\n' +
                        '\t\t\t\t\t<span class="lookcourse marr5" onclick="courseStat(\''+item.folderid+'\',\''+item.foldername+'\')">文件统计</span>\n' +
                        '\t\t\t\t\t<span class="lookcourse marr5" onclick="courseRank('+item.folderid+')">学习排名</span>\n' +
                        '\t\t\t\t</p>\n' +
                        '\t\t\t</div>\n' +
                        '\t\t</div>'
                    }
                    $('.lefrig').append(html);
                    var height = document.body.offsetHeight;
                    var ifameObject = parent.document.getElementById('mainFrame');
                    $(ifameObject).css({height:height});
                    closeModel();
                }

            },
            error:function () {
                parent.window.layer.alert('请求错误');
                closeModel();
            }
        })

    }
changetab($('.work_mes li[class^="workcurrent"]').attr('id').substr(3));//获取当前pid,首次进入



parent.window.H.remove('coursestat');
$('#coursestat',parent.window.document.body).remove();
parent.window.H.create(new P({
    id:'coursestat',
    title:'',
    easy:true,
    content:$("#coursestat")[0]
}),'common');
function courseStat(folderid,foldername){
	parent.window.$("#coursestatiframe").attr("folderid",folderid);
	parent.window.$("#coursestatiframe").attr("foldername",foldername);
	parent.window.H.get('coursestat').exec('show');

}

parent.window.H.remove('courserank');
$('#courserank',parent.window.document.body).remove();
parent.window.H.create(new P({
    id:'courserank',
    title:'',
    easy:true,
    content:$("#courserank")[0]
}),'common');
function courseRank(folderid){
	parent.window.$("#courserankiframe").attr("folderid",folderid);
	parent.window.H.get('courserank').exec('show');
}
//进入课件列表
    $(document).on('click','a[href^="/troomv2"]',function () {
       parent.window.layer.load();
    })
</script>
<?php //$this->display('troomv2/page_footer'); ?>