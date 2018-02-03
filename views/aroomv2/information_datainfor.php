<?php $this->display('aroomv2/page_header'); ?>
<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />
<style type="text/css">
    .zixuns .zx_bj2 {
        background: rgba(0, 0, 0, 0) url("http://static.ebanhui.com/ebh/tpl/aroomv2/images/zximg_bj_2.jpg") no-repeat scroll left center;
        height: 101px;
        padding: 0;
        width: 135px;
    }
</style>
<body>
<div class="ter_tit">
    当前位置 > <a href="<?=geturl('aroomv2/module')?>">门户配置</a> > <a href="/aroomv2/moduledit.html">模块内容编辑</a> > 资讯管理
    <a style="color:#388DE4;margin-left:425px;font-size:14px;font-family:微软雅黑" href="javascript:void(0)" onclick="location.reload(1)">[刷新]</a>
</div>
<div class="zixuns mt10">
    <div class="zixuns_top"  >

        <div class="zixuns_top_l fl" style="margin-bottom:10px;*margin-bottom:0;width:650px">
            <div class="fl">
                <span style="font-size:14px; color:#333;">时间段：</span>
                <input id="startdate" class="inp" type="text" readonly="readonly" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});" value="<?=$startdate?>"  />
                <span style="font-size:14px; color:#333;">到</span>
                <input id="enddate" class="inp" readonly="readonly" type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});" value="<?=$enddate?>" />
            </div>
            <div class="fl ml10" ><a href="javascript:;" onclick="searchbydate()" class="workBtns workBtns-1">确 定</a></div>
            <?php if($roominfo['template'] =='drag' || $roominfo['template'] == 'plate'){?>
                <div class="fl ml10">
                    <span style="line-height:30px;font-size:14px;">分类：</span>
                    <select id="navcode" style="font-size:13px;padding:4px 1px;">
                        <option value="0" <?=$navcode==0?'selected="true"':''?>>全部</option>
                        <?php if(empty($navigatorlist)){
                            $navigatorlist[] = array('code'=>'news','mame'=>'新闻资讯');
                        }
                        $navigatorlist[] = array('code'=>'deleted','name'=>'已删除分类');
                        foreach($navigatorlist as $nav){
                            ?>
                            <option value="<?=$nav['code']?>" <?=$navcode==$nav['code']?'selected="true"':''?>><?=empty($nav['nickname'])?$nav['name']:$nav['nickname']?></option>
                            <?php if(!empty($nav['subnav'])){
                                foreach($nav['subnav'] as $subnav){	?>
                                    <option value="<?=$subnav['subcode']?>" <?=$navcode==$subnav['subcode']?'selected="true"':''?>><?=$subnav['subnickname']?></option>
                                    <?php
                                }
                            }
                        }?>
                    </select>
                </div>
            <?php }?>
        </div>
        <div class="zixuns_top_r fr" style="margin-top:6px;">
            <ul>
                <li ><a target="_blank" href="/aroomv2/information/datainfor/add.html<?=empty($navcode)?'':'?navcode='.$navcode?>" class="releaseinformation" >发布资讯</a></li>
            </ul>
        </div>
    </div>
    <div class="clear"></div>
    <div class="zixun_b">
        <table cellpadding="0" cellspacing="0" class="tables"style="*margin-top:10px;">
            <tr class="first">
                <td width="134">资讯</td>
                <td width="230"></td>
                <td width="76">发布时间</td>
                <td width="44">人气</td>
                <td width="107">操作</td>
            </tr>
            <?php foreach($news as $index => $oneNews){?>
                <tr>
                    <td width="135" style="padding-left:0 !important;">
                        <?php if ($roominfo['template'] == 'plate') { ?>
                            <a href="javascript:;" class="fl zx_bj2" style="cursor:default;margin-left:5px;"><img src="<?=!empty($oneNews['thumb'])?$this->_show_plate_news_img($oneNews['thumb']):'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/news_viewholder.jpg?v=1'?>" style="margin-top:14px; margin-left:5px;width:123px;height:70px;"/></a>
                        <?php } else { ?>
                            <a href="javascript:;" class="fl zx_bj" style="cursor:default;margin-left:5px;"><img src="<?=!empty($oneNews['thumb'])?$this->_show_plate_news_img($oneNews['thumb']):'http://static.ebanhui.com/ebh/tpl/aroomv2/images/zixun.jpg'?>" style="margin-top:4px; margin-left:5px;width:134px;height:101px;"/></a>
                        <?php } ?>
                    </td>
                    <td colspan=4 width="634">
                        <table cellpadding="0" cellspacing="0" style=" height:100px;">
                            <tr>
                                <td colspan=4 style="border-top:none;padding:0!important;">
                                    <a style="<?=empty($oneNews['status'])?'color:#999!important':''?>" title="<?=empty($oneNews['status'])?'已禁用。':''?><?=$oneNews['subject']?>" href="/aroomv2/information/datainfor/view.html?itemid=<?=$oneNews['itemid']?>.html"><b ><?=$oneNews['subject']?></b></a>
                                </td>
                            </tr>
                            <tr>
                                <td style="border-top:none;padding:0 !important;">
                                    <p style="width:290px;word-wrap: break-word;float:left; padding-left:3px;"><?=shortstr($oneNews['note'],40)?></p>
                                </td>
                                <td width="123" style="border-top:none;padding:0!important;"><?=date('Y-m-d',$oneNews['dateline'])?></td>
                                <td width="44" style="border-top:none;padding:0!important;"><?=$oneNews['viewnum']?></td>
                                <td width="107" style="border-top:none;padding:0 !important;"><a href="/aroomv2/information/datainfor/view.html?itemid=<?=$oneNews['itemid']?>.html" class="select">查看</a><a target="_blank" href="/aroomv2/information/datainfor/edit.html?itemid=<?=$oneNews['itemid']?><?=empty($navcode)?'':'&navcode='.$navcode?>">修改</a><a href="javascript:;" onclick="showdeldata(<?= $oneNews['itemid']?>)">删除</a></td>
                            </tr>
                        </table>

                    </td>

                </tr>
            <?php }?>
        </table>
    </div>
</div>
<div class="clear"></div>
<?=$pagestr?>
<!--删除资讯-->
<div id="delnews" class="tanchukuang" style="display:none;height:160px;">
    <div class="tishi" style="padding-top:20px;"><span style=" line-height:127px;">你确定要删除该资讯吗？</span></div>
</div>
<script type="text/javascript">
    <!--
    function searchbydate(){
        var sdate = $('#startdate').val();
        var edate = $('#enddate').val();
        var href='/aroomv2/information/datainfor.html?sdate='+sdate+'&edate='+edate;
        location.href = href;
    }
    //删除
    function showdeldata(itemid){
        var button = new xButton();
        button.add({
            value:"确定",
            callback:function(){
                delsend(itemid);
                H.get('delnews').exec('close');
                return false;
            },
            autofocus:true
        });

        button.add({
            value:"取消",
            callback:function(){
                // location.reload();
                H.get('delnews').exec('close');
                return false;
            }
        });

        if(!H.get('delnews')){
            H.create(new P({
                id : 'delnews',
                title: '删除资讯',
                easy:true,
                width:420,
                padding:5,
                button:button,
                content:$('#delnews')[0]
            }),'common').exec('show');

        }else{
            H.get('delnews').exec('show');
        }

    }

    function delsend(itemid) {
        $.ajax({
            url:"<?= geturl('aroomv2/information/deldata')?>",
            type:'post',
            data:{'itemid':itemid},
            dataType:'text',
            success:function(data){
                if(data=='success'){
                    $.showmessage({
                        img : 'success',
                        message:'资讯删除成功',
                        title:'删除资讯',
                        callback :function(){
                            document.location.reload();
                        }
                    });
                }else{
                    $.showmessage({
                        img : 'error',
                        message:'删除失败，请稍后再试或联系管理员。',
                        title:'删除资讯'
                    });
                }
            }
        });
    }
    $('#navcode').live('change',function(){
        location.href = '/aroomv2/information/datainfor.html?navcode='+$(this).val();
    });
    if (top.location == self.location) {
        setCookie('ebh_refer',encodeURIComponent(self.location),10,'/','.<?=$this->uri->curdomain?>');
        top.location='/aroomv2.html';
    }
    //-->
</script>
</body>
</html>
