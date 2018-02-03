<?php

/**
 * 门户通用方法
 */
/**
 *过滤掉html标签
 */
function _strip_tags(&$value){
    $value = strip_tags($value);
}

/**
 *门户样式模板
 *$type = 1,普通5条无修饰//样板:教育动态
 *$type = 2,第一条图文,2,3两条无修饰//样板:教师风采
 *$type = 3
 *$type = 4,心灵驿站模板
 *$type = 5,创业故事模板
 *$type = 6,千奇百怪
 *$type = 7 ,糗事百科
 *$type = 8,大家都再看，百科杂谈
 *$type = 9 ,新闻home页面 左5右2 模板
 */
function aHelper($cateTree,$m,$c,$total=5,$type=1,$offset = 0){
    $res = '';
    $code = '/'.$cateTree[$m]['code'];
    $i=1;
    if($type==1){
        foreach ($cateTree[$m]['children'][$c]['articles'] as $article) {
            $res.='<li class="content"><a target=_blank title="'.$article['subject'].'" href="'.$code.'/'.$article['itemid'].'.html'.'">'.shortstr($article['subject'],42).'</a></li>';
            $i+=1;
            if($i>$total)break;
        }
    }else if($type==2){
        $j=1;
        foreach ($cateTree[$m]['children'][$c]['articles'] as $article) {
            if($j==1){
                $article['thumb'] = empty($article['thumb'])?'http://static.ebanhui.com/portal/images/defaultpic.jpg':$article['thumb'];
                $res.='<div class="gkkdiv">';
                $res.='<a target=_blank style="float:left" title="'.$article['subject'].'" href="'.$code.'/'.$article['itemid'].'.html'.'"><img width="143px" height="98px;" src="'.$article['thumb'].'" /></a>';
                $res.='<p style="float:left;width:113px;height:68px;padding:15px;background-color:#F2F2F2"><a target=_blank style="" title="'.$article['subject'].'" target="_blank" href="'.$code.'/'.$article['itemid'].'.html'.'" class="size14">'.shortstr(strip_tags($article['note']),38,'...[详细]').'</a></p>';
                $res.='</div>';
                $j++;
            }else{
                $res.='<p  class="xiaocon"  style="line-height:1.6;height:20px"><a target=_blank title="'.$article['subject'].'" href="'.$code.'/'.$article['itemid'].'.html'.'">'.shortstr($article['subject'],46,'').'</a></p>';
            }
            if(++$i>$total)break;
        }
    }else if($type==3){
        if(!empty($cateTree[$m]['children'][$c]['articles'][0]))
            $article = $cateTree[$m]['children'][$c]['articles'][0];
        $article['thumb'] = empty($article['thumb'])?'http://static.ebanhui.com/portal/images/defaultpic.jpg':$article['thumb'];
            return '<a target=_blank title="'.$article['subject'].'" href="'.$code.'/'.$article['itemid'].'.html'.'"><img alt="'.$article['subject'].'" width="310px" height="151px" src="'.$article['thumb'].'"></a>';
        return '';
    }else if($type==4){
        $res = '';
        $j=1;
        foreach ($cateTree[$m]['children'][$c]['articles'] as $article) {
            if($j==1){
                $res.='<a target=_blank title="'.$article['subject'].'" style="float:left;margin:10px 0;" href="'.$code.'/'.$article['itemid'].'.html'.'"><img  width="173px" height="126px" src="'.$article['thumb'].'" /></a>';
                $res.='<p style="float:left;margin:10px 0 10px 12px;"><a target=_blank title="'.$article['subject'].'" href="'.$code.'/'.$article['itemid'].'.html'.'">'.wordwrap(shortstr($article['subject'],30,""),30,"<br />",true).'</a></p>';
                $res.='<p style="float:left;margin-left:12px;"><a target=_blank title="'.$article['note'].'" href="'.$code.'/'.$article['itemid'].'.html'.'">'.wordwrap(shortstr($article['note'],66,'...[详情]'),30,"<br />",true).'</a></p>';
            }else{
                $res.='<p class="xiaocon"><a target=_blank title="'.$article['subject'].'" href="'.$code.'/'.$article['itemid'].'.html'.'">'.shortstr($article['subject'],48,'').'</a></p>';
            }
            $j+=1;
            if(++$i>$total)break;
        };
        return $res;
    }else if($type==5){
        $res = '';
        foreach ($cateTree[$m]['children'][$c]['articles'] as $article) {
            $article['thumb'] = empty($article['thumb'])?'http://static.ebanhui.com/portal/images/defaultpic.jpg':$article['thumb'];
            $res.='<a target=_blank title="'.$article['subject'].'" class="article" target="_blank" href="'.$code.'/'.$article['itemid'].'.html'.'">';
            $res.='<img width="143px" height="98px" src="'.$article['thumb'].'" />';
            $res.='<span>'.shortstr($article['subject'],34,'...[详情]').'</span>';
            $res.='</a>';
            if(++$i>$total)break;
        }
       return $res;
    }else if($type==6){
        $j=0;
        $res = '';
        $articles = array_slice($cateTree[$m]['children'][$c]['articles'],$offset,$total);
        foreach ($articles as $article) {
            if($j!=2){
                $article['thumb'] = empty($article['thumb'])?'http://static.ebanhui.com/portal/images/defaultpic.jpg':$article['thumb'];
                $res.='<div class="gkkdiv">';
                $res.='<a target=_blank title="'.$article['subject'].'" class="gkkimg" target="_blank" href="'.$code.'/'.$article['itemid'].'.html'.'"><img  src="'.$article['thumb'].'" /></a>';
                $res.='<p class="gkktitle"> <a target=_blank title="'.$article['subject'].'" target="_blank" href="'.$code.'/'.$article['itemid'].'.html'.'" class="size14">'.shortstr($article['subject'],38).'</a></p>';
                $res.='<p class="gkktitle"><a target=_blank title="'.$article['subject'].'" href="'.$code.'/'.$article['itemid'].'.html'.'">'.shortstr($article['note'],46).'</a></p>';
                $res.='</div>';
                $j++;
            }else{
                $res.='<p class="xiaocon"><a target=_blank title="'.$article['subject'].'" href="'.$code.'/'.$article['itemid'].'.html'.'">'.shortstr($article['subject'],40).'</a></p>';
            }
            if(++$i>$total)break;
        }
        return $res;
    }else if($type==7){
        $j=0;
        $res = '';
        foreach ($cateTree[$m]['children'][$c]['articles'] as $article) {
            if($j!=1){
                $article['thumb'] = empty($article['thumb'])?'http://static.ebanhui.com/portal/images/defaultpic.jpg':$article['thumb'];
                $res.='<div class="gkkdiv">';
                $res.='<a target=_blank title="'.$article['subject'].'" class="gkkimg" target="_blank" href="'.$code.'/'.$article['itemid'].'.html'.'"><img  src="'.$article['thumb'].'" /></a>';
                $res.='<p class="gkktitle"> <a target=_blank title="'.$article['subject'].'" target="_blank" href="'.$code.'/'.$article['itemid'].'.html'.'" class="size14">'.wordwrap(shortstr($article['subject'],20,''),60,"<br />",true).'</a></p>';
                $res.='<p class="gkktitle"><a target=_blank title="'.$article['subject'].'" href="'.$code.'/'.$article['itemid'].'.html'.'">'.shortstr($article['note'],70,'...[详情]').'</a></p>';
                $res.='</div>';
                $j++;
            }else{
                $res.='<p class="xiaocon"><a target=_blank title="'.$article['subject'].'" href="'.$code.'/'.$article['itemid'].'.html'.'">'.strip_tags(shortstr($article['subject'],50)).'</a></p>';
            }
            if(++$i>$total)break;
        }
        return $res;
    }else if($type==8){
        foreach ($cateTree[$m]['children'][$c]['articles'] as $article) {
            $res.='<li class="doulock"><a target=_blank title="'.$article['subject'].'" href="'.$code.'/'.$article['itemid'].'.html'.'">'.$article['subject'].'</a></li>';
            $i+=1;
            if($i>$total)break;
        }
    }else if($type==9){
        $articles = $cateTree[$m]['children'][$c]['articles'];
        $article = array_slice($articles,$offset,1);
        if(empty($article))return '';
        $article = $article[0];
        $article['thumb'] = empty($article['thumb'])?'http://static.ebanhui.com/portal/images/defaultpic.jpg':$article['thumb'];
        $res.='<a target=_blank title="'.$article['subject'].'" class="listu" href="'.$code.'/'.$article['itemid'].'.html'.'" target="_blank"><img width="100px" height="62px" src="'.$article['thumb'].'"></a>';
        $res.='<p class="krryle"><a target=_blank title="'.$article['subject'].'" class="size14" href="'.$code.'/'.$article['itemid'].'.html'.'" target="_blank">'.shortstr($article['subject'],26,'').'</a></p>';
        $res.='<p class="krryle"><a target=_blank title="'.$article['subject'].'" href="'.$code.'/'.$article['itemid'].'.html'.'">'.shortstr($article['note'],56,'...[详情]').'</a></p>';
    }
   
    return $res;
}
//门户网站home页面获取栏目标题
function aTitle($cateTree,$m,$c){
    return $cateTree[$m]['children'][$c]['name'];
}
//门户网站home页面获取栏目地址
function aMore($cateTree,$m=0,$c=0){
    if($m!=-1){
        return '/'.$cateTree[$m]['code'].'.html';
    }else{
        return '/'.$cateTree[0]['code'].'-1-0-0-'.$cateTree[0]['children'][$c]['catid'].'.html';
    }
}


/**
 *数组仿数据库连接查询函数
 *@author zkq
 *@date 2014-08-08
 *@param $arrays 待查询的数组集合 array($array1,$array2,$array3...);$array1,$array2,$array3...为关联数组
 *@param $tagArr 连接查询的字段 array('a','b.c','d.e','f')表示$array1的a字段连接$array2的b字段,$array2的c字段连接$array3的d字段...
 *@return $array 连接查询之后的数组
 */
function visualLink($arrays,$tagArr){
    $newArr = array();
    $tag1 = explode('.',$tagArr[0]);
    if(count($tag1)==1)$tag1[1] = $tag1[0];
    $tag2 = explode('.',$tagArr[1]);
    foreach ($arrays[0] as $v1) {
        foreach ($arrays[1] as $v2) {
            if($v1[$tag1[1]]==$v2[$tag2[0]]){
                $newArr[] = array_merge($v1,$v2);
            }
        }
    }
    array_shift($arrays);
    array_shift($arrays);
    array_shift($tagArr);
    array_unshift($arrays,$newArr);
    if(count($arrays)>=2){
        $newArr = visualLink($arrays,$tagArr);
    }
    return $newArr;
}
