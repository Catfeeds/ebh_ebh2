<?php $this->display('home/page_header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/jfxt.css" rel="stylesheet" type="text/css" />
<style>
    .datatabs td {
        border-bottom: none;
        border-top: 1px solid #efefef;
        color: #666666;
        padding: 10px 6px;
    }
</style>

<div class="topbaad">
    <div class="rule">
        <div class="lefrig" style="background:#fff;margin-top:15px;float:left;">
            <div style="float:left;width:1000px;">
                <?php if(!empty($scorelist)){?>
                    <table class="datatabs" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody class="tabhead">
                        <tr>
                            <th width="5%"></th>
                            <th align="center" width="25%">日期</th>
                            <th align="left" width="15%" >学分</th>
                            <th align="center" width="55%">学分说明</th>
                        </tr>
                        </tbody>
                        <?php foreach($scorelist as $scl){?>
                            <?php if(!empty($scl['title']) && !empty($scl['score'])){?>
                                <tbody class="tabcont">
                                <tr >
									<td></td>
                                    <td style="height: 35px;"><?=Date('Y-m-d H:i:s',$scl['dateline'])?></td>
                                    <td style="height: 35px;color: red;padding-left: 10px;">
                                        +<?=$scl['score']?>
                                    </td>
                                    <?php if($scl['type']==0 || $scl['type']==4){?>
                                        <td style="height: 35px;">学习<span style="color: #4db3ff">《<?=$scl['title']?>》</span>课件获得</td>
                                    <?php }elseif($scl['type']==3){?>
                                        <td style="height: 35px;">评论<span style="color: #4db3ff">《<?=$scl['title']?>》</span>课件获得</td>
                                    <?php } ?>
                                </tr>
                                </tbody>
                            <?php }elseif(!empty($scl['subject']) && !empty($scl['score'])){ ?>
                                <tbody class="tabcont">
                                <tr>
									<td></td>
                                    <td style="height: 35px;"><?=Date('Y-m-d H:i:s',$scl['dateline'])?></td>
                                    <td style="height: 35px;color: red;padding-left: 10px;">
                                        +<?=$scl['score']?>
                                    </td>
                                    <?php if($scl['type']==2){?>
                                        <td style="height: 35px;">发表<span style="color: #4db3ff">《<?=$scl['subject']?>》</span>原创文章获得</td>
                                    <?php }elseif($scl['type']==5){?>
                                        <td style="height: 35px;">阅读<span style="color: #4db3ff">《<?=$scl['subject']?>》</span>原创文章获得</td>
                                    <?php } ?>
                                </tr>
                                </tbody>
                            <?php } ?>
                        <?php } ?>
                    </table>
                <?php }else{ ?>
                    <div class="nodata"></div>
                <?php } ?>
                <?php echo $pagestr; ?>
            </div>
        </div>
    </div>
</div>
<div style="clear:both;"></div>
<script type="text/javascript">
    $(function(){
        top.$('#mainFrame').width(1000);
        top.$('.rigksts').hide();
    });
</script>