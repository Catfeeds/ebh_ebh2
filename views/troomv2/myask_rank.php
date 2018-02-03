<?php $this->display('troomv2/page_header'); ?>
    <style>
        #icategory {
            background: none repeat scroll 0 0 #F7FAFF;
            border-top: 1px solid #E1E7F5;
            padding: 6px 20px;
            _margin-bottom:-5px;
        }
        #icategory dt {
            float: left;
            line-height: 22px;
            padding-right: 5px;
            text-align: left;
        }
        #icategory dd {
            float: left;
            width: 950px;
        }
        .category_cont1 div a.curr, .category_cont1 div a:hover, .price_cont div a:hover, .price_cont div a.curr {
            background: none repeat scroll 0 0 #5e96f5;
            color: #FFFFFF;
            text-decoration: none;
            border-radius:2px;
            padding:2px !important;
            font-size:13px;
        }
        .category_cont1 div a {
            color: #2C71AE;
            text-decoration: none;
            padding: 2px;
            cursor: pointer;
        }
        .category_cont1 div {
            float: left;
            height: 25px;
            line-height: 22px;
            overflow: hidden;
            padding:0 10px;
        }
        .key_word {
            padding: 6px 20px;
            border-bottom-width: 1px;
            border-bottom-style: solid;
            height:28px;
            border-bottom-color: #cdcdcd;
        }
        .key_word dt {
            float: left;
            line-height: 22px;
            padding-right: 5px;
            text-align: left;
        }
        .pbtns {
            background: url(http://static.ebanhui.com/ebh/tpl/2012/images/sunt0518.png) repeat scroll 0 0 transparent;
            border: medium none;
            color: #333333;
            height: 20px;
            vertical-align: middle;
            width: 40px;
            cursor:pointer;
        }
        .workdata{
            width:1000px;
        }
		.workcurrent a {
			border-bottom: 2px solid #ff9500;
		}
    </style>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
    <div class="lefrig">
        <div class="waitite">
			<div class="work_menu" style="position:relative;margin-top:0">
				<ul>
					<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso"><?=$pagemodulename?></span></a></li>
				</ul>
			</div>
            <a href="<?= geturl('troomv2/myask/addquestion') ?>" class="jaddre">提个问题</a>
            <div class="diles">
                <?php
                $q= empty($q)?'':$q;
                if(!empty($q)){
                    $stylestr = 'style="color:#000"';
                }else{
                    $stylestr = "";
                }
                ?>
                <input name="title" class="newsou" <?=$stylestr?> id="title" name="uname" value="<?= $q?>"  type="text" />
                <input id="ser" type="button" class="soulico" value="">
            </div>
        </div>
        <div class="workol">
            <div class="work_mes work_mesalone">
                <ul class="extendul">
                    <li><a href="<?= geturl('troomv2/myask/askme') ?>"><span>提给我的</span></a></li>
                    <li><a href="<?= geturl('troomv2/myask') ?>"><span>课程问题</span></a></li>
                    <li><a href="<?= geturl('troomv2/myask/classquestion') ?>"><span>班级问题</span></a></li>
                    <li><a href="<?= geturl('troomv2/myask/allquestion') ?>"><span>全部问题</span></a></li>
                    <li><a href="<?= geturl('troomv2/myask/myquestion') ?>"><span>我的问题</span></a></li>
                    <li><a href="<?= geturl('troomv2/myask/myanswer') ?>"><span>我的回答</span></a></li>
                    <li><a href="<?= geturl('troomv2/myask/myfavorit') ?>"><span>我的关注</span></a></li>
                    <!-- 新增 -->
                    <li><a href="<?= geturl('troomv2/myask/settled') ?>"><span>已解决</span></a></li>
                    <li><a href="<?= geturl('troomv2/myask/hot') ?>"><span>热门</span></a></li>
                    <li><a href="<?= geturl('troomv2/myask/recommend') ?>"><span>推荐</span></a></li>
                    <li><a href="<?= geturl('troomv2/myask/wait') ?>"><span>等待回复</span></a></li>
                    <li class="workcurrent"><a href="/troomv2/myask/tjfx.html"><span style="color:#ff9500;">统计分析</span></a></li>
                </ul>
            </div>
            <div class="lishnrt">
                <a class="hietse" href="/troomv2/myask/tjfx.html">统计分析</a>
                <a class="hietse xhusre" href="/troomv2/myask/rank.html">排行榜</a>
            </div>
            <div class="clear"></div>
            <table width="100%" style="margin-bottom:10px;" class="datatab">
                <?php $i=1; foreach($item as $v){?>
                <tr class="">
                    <td>
                        <div class="paimingfa"><span class="paiming <?php if($i==2){echo 'paiming2';}elseif($i==3){echo 'paiming3';}elseif($i>3){echo 'paiming1';}?>"><?php echo $i?></span></div>
                        <div style="float:left;margin-right:15px;">
                            <?php
                            if($v['sex'] == 1)
                                $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
                            else
                                $defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
                            $face = empty($v['face']) ? $defaulturl:$v['face'];
                            $face = str_replace('.jpg','_50_50.jpg',$face);
                            ?>
                            <a href="javascript:;"><img style="width:40px;height:40px; border-radius:20px;" title="<?php echo $v['realname']?>" src="<?php echo $face?>"></a>
                        </div>
                        <div style="width:140px;float:left;">
                            <span class="renming"><?php echo $v['realname']?></span>
                            <span class="xingbie" style="<?php if($v['sex']==0) echo 'background:url(http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png) no-repeat left center;'?>"></span>
                            <div style="clear:both;"></div>
                            <span class="renming1"><?php echo $v['username']?></span>
                        </div>
                        <?php $img='';
                        if($i==1){$img='<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/pmj.jpg">';}
                        elseif($i==2){$img='<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/pmy.jpg">';}
                        elseif($i==3){$img='<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/pmt.jpg">';}?>
                        <div style="float:left;width:520px; margin-top:5px;"><?php echo $img?></div>
                        <div class="wjd">问+答</div>
                        <div class="wjdzs"><?php echo $v['count']?></div>
                    </td>
                </tr>
                <?php $i++; }?>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        var searchtext = "请输入关键字";
        $(function() {
            initsearch("title",searchtext);
            $("#ser").click(function(){
                var title = $("#title").val();
                var folderid = $("a.curr").attr('tag');
                if(title == searchtext)
                    title = "";
                var url = '<?= geturl('troomv2/myask') ?>' + '?folderid='+folderid+'&q='+title;
                document.location.href = url;
            });
        });

        function _search(folderid){
            var title = $("#title").val();
            if(title == searchtext)
                title = "";
            var url = '<?= geturl('troomv2/myask') ?>' + '?folderid='+folderid+'&q='+title;
            document.location.href = url;
        }
        function delask(qid,title) {
            var url = '<?= geturl('troomv2/myask/delask') ?>';
            var successurl = '<?= geturl('troomv2/myask/myquestion') ?>';
            $.confirm("您确定要删除问题 【" + title + "】 吗？",function(){
                $.ajax({
                    url:url,
                    type:'post',
                    data:{'qid':qid},
                    dataType:'text',
                    success:function(data){
                        if(data=='success'){
                            $.showmessage({message:'问题删除成功！'});
                            document.location.href = successurl;
                        }else{
                            $.showmessage({message:'对不起，问题删除失败，请稍后再试！'});
                        }
                    }
                });
            });
        }
        $(function(){
            $('.datatab tr:last td').css('border-bottom','none');
        });
    </script>
<?php
$this->display('troomv2/page_footer');
?>