<?php $this->display('troomv2/page_header'); ?>
    <style>
        .tosre {
            height:35px;
            margin: 25px 30px;
            width: 850px;
            float: left;
        }
        .tospan {
            float:left;
            font-size: 14px;
            color: #666;
            height:24px;
            line-height: 24=1wpx;
        }
        .selops {
            width: 150px;
            float:left;
            height: 24px;
            line-height: 24px;
            font-size: 14px;
        }
        .tosre a{
            float:left;
            margin: 0 0 0 20px;
            padding: 2px 8px;
            font-size: 14px;
        }
        .tosre a.disrs{
            background: #20A0FF;
            color:#fff;
        }
        .myclasstable {
            font-family: 微软雅黑;
            font-size: 14px;
            text-align: center;
            width: 400px;
            margin: 0 0 0 18px;
            border: 1px solid #e6e6e6;
            border-bottom: none;
        }
        .nodata{background-color:#fff;}
        .man{background-image: url('http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png')}
    </style>
    <body>
<?php if (!empty($classes)) { ?>
    <div class="lefrig xglefrig" style="margin-top: 0px;">
        <div class="work_menu" style="width:1000px; position:relative;margin-top:0px;">
            <ul>
                <li class="workcurrent"><a href="javascript:void(0)" style="font-size:16px;line-height: 33px;border:none;"><span>单位学分</span></a></li>
            </ul>
        </div>
        <form method="get" action="/troomv2/credit.html" id="rank-filter">
            <div class="tosre">
                <span class="tospan">选择单位：</span>
                <select name="classid" class="selops"><?php foreach ($classes as $classid => $class) { ?>
                        <option value="<?=$classid?>"<?php if ($cid == $classid) { ?> selected="selected"<?php } ?>><?=$class['classname']?></option>
                    <?php } ?></select>
                <?php if ($orderType == 0) { ?>
                    <a href="javascript:;" class="disrs">按最高</a>
                    <a href="/troomv2/credit.html?order=1&classid=<?=$cid?>">按最低</a>
                <?php } else { ?>
                    <a href="/troomv2/credit.html?classid=<?=$cid?>">按最高</a>
                    <a href="javascript:;" class="disrs">按最低</a>
                <?php } ?>
                <input type="hidden" name="order" value="<?=$orderType?>" />
            </div>
        </form>
        <table class="myclasstable" id="list-table" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <th style="text-align:left;padding-left:60px;" width="70%">个人信息</th>
                <th width="30%">学分</th>
            </tr>
            <?php if (!empty($students)) {
                foreach ($students as $student) { ?>
                    <tr>
                        <td>
                            <div style="float:left;padding:0 10px;">
                                <a href="javascript:;"><img gender="1" class="touxyuan" src="<?=getavater($student, '50_50')?>"></a>
                            </div>
                            <div style="width:200px;float:left;">
                                <span class="renming" title="<?=htmlspecialchars($student['realname'], ENT_COMPAT)?>"><?=htmlspecialchars($student['realname'], ENT_NOQUOTES)?></span>
                                <span class="xingbie<?php if (empty($student['sex'])) { echo ' man';} ?>"></span>
                                <div style="clear:both;"></div>
                                <span class="renming1" title="<?=htmlspecialchars($student['username'], ENT_COMPAT)?>"><?=htmlspecialchars($student['username'], ENT_NOQUOTES)?></span>
                            </div>
                        </td>
                        <td data-id="409667">
                            <span><?=$student['score']?></span>
                        </td>
                    </tr>
                <?php }
            } ?>
            </tbody>
        </table>
        <?=$pagestr?>
    </div>
    <script type="text/javascript">
        (function($) {
            $("select[name='classid']").bind('change', function() {
                $("#rank-filter").trigger('submit');
            });
        })(jQuery);
    </script>
<?php } else { ?>
    <div class="nodata"></div>
<?php } ?>

<?php $this->display('troomv2/page_footer'); ?>