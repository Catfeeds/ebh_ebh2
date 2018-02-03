<?php
/**
 * 课程介绍
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/11/9
 * Time: 10:56
 */
?>
<div class="coursecatson">
    <div class="lvjies">
        <h1><?=$folder['foldername']?></h1>
        <?=$folder['detail']?>
    </div>
    <div class="courselists">
        <?php if(!empty($folder['introduce'])){?>
            <?php foreach($folder['introduce'] as $k=>$introduce){?>
                <div class="kecjs mt25">
                    <h2><?=$introduce['title']?></h2>
                    <p><?=$introduce['content']?></p>
                </div>
            <?php }
        }?>
    </div>
</div>
