
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
</head>

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/collegestyle.css"/>

<body>
<div class="lefrig">
    <div class="lefrig-1">
        <!--问题导航-->
        <div class="navigation">
            <ul>
                <li><a href="<?= geturl('troomv2/myask/allquestion') ?>" class="curr">全部问题</a></li>
                <li><a href="<?= geturl('troomv2/myask/hot') ?>">热门</a></li>
                <li><a href="<?= geturl('troomv2/myask/recommend') ?>">推荐</a></li>
                <li><a href="<?= geturl('troomv2/myask/wait') ?>">等待答复</a></li>
                <li><a href="<?= geturl('troomv2/myask/settled') ?>">已解决</a></li>
                <li><a href="<?= geturl('troomv2/myask/myquestion') ?>">我的问题</a></li>
                <li><a href="<?= geturl('troomv2/myask/myanswer') ?>">我的提问</a></li>
                <li><a href="<?= geturl('troomv2/myask/myfavorit') ?>">我的关注</a></li>

            </ul>
            <div class="diles">
                <input name="txtname" class="newsou" id="title" placeholder="请输入学生姓名" type="text">
                <input class="soulico" value="" type="button">
            </div>
            <a href="javascript:void(0)" class="iwantask">我要提问</a>
        </div>
        <div class="clear"></div>
        <!--问题列表-->
        <div class="problemslist">
            <ul>
                <?php
                foreach ($asks as $v) {
                    $str = '<img class="lateximg" src="http://img.ebanhui.com/formula/2016/11/11/14788363831817.png">';
                    ?>
                    <li>
                        <h2 class="problemstitle"><a href="javascript:void(0)"><?=$v['title']?></a></h2>
                        <div class="problemdetail"><a href="javascript:void(0)"><?= shortstr($v['message'],200)?></a>
                        </div>
                        <div class="answernumber">
                            <span class="answernumberspan">回答数</span>
                            <span><b class="b1"><?=$v['answercount']?></b><b class="b2">/</b><b class="b3"><?=$v['viewnum']?></b></span>
                        </div>
                        <div class="clear"></div>
                        <ul class="questionerpic-1">
                            <?php
                            $v['imagesrc'] = explode(",",$v['imagesrc']);
                            $picNum = count($v['imagesrc']);
                            for ($i=0;$i<4;$i++){
                                ?>
                                <li><a href="javascript:void(0)"><img src=""/></a></li>
                                <?php
                            }
                            ?>
                            <?php
                            if($picNum >4){
                                ?>
                                <li class="questpicmore-1"><a href="javascript:void(0)">更<br/>多</a></li>
                                <?php
                            }
                            ?>
                        </ul>
                        <div class="questinformation-1">
                            <span class="questiontime-1"><?=timetostr($v['dateline'])?></span>
                            <img class="questionerhead"
                                 src="http://static.ebanhui.com/ebh/tpl/default/images/m_man_50_50.jpg"/>
                            <span class="questioner"><?= empty($v['realname'])?$v['username']:$v['realname'] ?></span>
                            <p class="coursewarelink"><?= $v['foldername'] ?></p>
                        </div>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
