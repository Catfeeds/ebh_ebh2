<?php $this->display('college/page_header'); ?>
    <style>
        .work_mes a.workbtns {
            background: #6489ac ;
            border-radius: 3px;
            color: #fff;
            display: inline-block;
            overflow: hidden;
            padding: 6px 20px;
            vertical-align: -2px;
            float:left;
            margin-left: 10px;
            *margin-left: 75px;
            margin-top:4px;
        }

        .datatab a {
            color: #81a2e2;
        }
    </style>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/collegestyle.css"/>
<script src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
    <div class="lefrig" style="background:#fff;float:left;">
        <?php
        if(!empty($folder)){
            $this->assign('selidx',3);
            $this->display('college/course_nav');
        }?>
<div class="asktop">
    <a class="<?php echo ($this->input->get('type')==2?'dapais':'tipais')?>" href="<?php echo geturl('college/myask/sortname') ?>?type=1">提问排名</a>
    <a class="<?php echo ($this->input->get('type')==2?'tipais':'dapais')?>" href="<?php echo geturl('college/myask/sortname') ?>?type=2">解答排名</a>
</div>
<div class="oetute">
    <ul id="ranklist">
        <?php foreach ($list as $value) {
            echo '<li class="dtuwrs">';
            echo '<a href="http://sns.ebh.net/12165/main.html" target="_blank" class="destgy">';
            echo '<img class="imgrdu" src="' . (empty($value['face']) ? 'http://static.ebanhui.com/ebh/tpl/default/images/m_man_50_50.jpg"' : $value['face']) . '" title="' . $value['username'] . '">';
            echo '</a>';
            echo '<span class="srusdyt">' . $value['username'] . '</span>';
            echo '<span class="srusdyt">' . ($this->input->get('type') == 2 ? '回答' : '提问') . ':' . $value['number'] . '次</span>';

        }
        ?>

    </ul>
</div>
</div>
<script type="text/javascript">
    var searchtext = "请输入关键字";
    $(function() {
        initsearch("title",searchtext);
        $("#ser").click(function(){
            var title = $("#title").val();
            if(title == searchtext)
                title = "";
            var url = '<?= geturl('college/myask/myanswer') ?>' + '?q='+title;
            <?php if(!empty($folder)){
            $itemid = $this->input->get('itemid');?>
            url += '&folderid=<?=$folder['folderid']?>';
            url += '&itemid=<?=!empty($itemid)?$itemid:''?>';
            <?php }?>
            document.location.href = url;
        });
        <?php if(!empty($folder)){?>
        $.each($('.work_mes li a,.workbtns'),function(k,v){
            $(this).attr('href',$(this).attr('href')+'?folderid=<?=$folder['folderid']?>&itemid=<?=$itemid?>');
        });
        $.each($('.huirenw a, .ketek a, .cwsp a'),function(k,v){
            $(this).attr('href',$(this).attr('href')+'&folderid=<?=$folder['folderid']?>&itemid=<?=$itemid?>');
        });
        <?php }?>
    });
</script>

