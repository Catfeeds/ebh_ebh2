<?php $this->display('troomv2/page_header'); ?>
<style>
#icategory {
    padding: 10px 20px;
	float:left;
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
.category_cont1 div a.curr, .category_cont1 div a:hover{
    background: #4c8eff ;
    border-radius: 2px;
    color: #ffffff;
    font-size: 14px;
	padding:3px;
}
.category_cont1 div a {
    color: #2c71ae;
	font-size:14px;
}
.category_cont1 div {
    float: left;
    height: 25px;
    line-height: 22px;
    overflow: hidden;
    padding: 0 10px;
}
.ghjut {
    margin: 0 0 0 10px;
    width: 165px;
}
.datatab td{
	border-top:1px solid #f5f5f5;
	border-bottom:none;
}
</style>

<body>
<div class="lefrig">
	<div class="waitite">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">绑定情况</span></a></li>
			</ul>
		</div>
        <div style="width:205px;" class="hsidts">
        	<a href="/troomv2/eth.html" class="lasrnwe">发消息</a>
            <a href="/troomv2/eth/history.html" class="lasrnwe">发信历史</a>
            <a href="/troomv2/eth/inbox.html" class="lasrnwe">收件箱</a>
        </div>
    </div>
    <div class="workol">
    	<div class="work_mes work_mes1s">
            <ul class="extendul extendul1s">
                <li class="<?=empty($request['type'])?"workcurrent":""?>"><a href="/troomv2/eth/bind.html"><span>全部<?php if(!empty($totalcount)){?>（<?=$totalcount?>）<?php }?></span></a></li>
                <li class="<?=!empty($request['type'])&&($request['type']=='binded')?"workcurrent":""?>"><a href="/troomv2/eth/bind.html?type=binded<?=!empty($request['classid'])?"&classid=".$request['classid']:""?>"><span>已绑定<?php if(!empty($bindcount)){?>（<?=$bindcount?>）<?php }?></span></a></li>
                <li class="<?=!empty($request['type'])&&($request['type']=='nobind')?"workcurrent":""?>"><a href="/troomv2/eth/bind.html?type=nobind<?=!empty($request['classid'])?"&classid=".$request['classid']:""?>"><span>未绑定<?php if(!empty($nobindcount)){?>（<?=$nobindcount?>）<?php }?></span></a></li>
            </ul>
        </div>
        <div id="icategory">
            <dl>
                <dd>
                    <div class="category_cont1">
                        <div><a href="/troomv2/eth/bind.html<?=!empty($request['type'])?"?type=".$request['type']:""?>" class="<?=empty($request['classid'])?"curr":""?>">全部</a></div>
                        <?php if(!empty($classlist)){foreach($classlist as $class){?>
                        <div><a href="/troomv2/eth/bind.html?classid=<?=$class['classid']?><?=!empty($request['type'])?"&type=".$request['type']:""?>" class="<?=!empty($request['classid'])&&($request['classid']==$class['classid']) ?"curr":""?>"><?=$class['classname']?></a></div>
                        <?php }} ?>
                    </div>
                </dd>
            </dl>
        </div>
        <div class="clear"></div>
        <table width="100%" style="border:none;" class="datatab">
            <thead class="tabhead">
                <tr class="">
                    <th class="gryxdhzt">个人信息</th>
                    <th>邮箱</th>
                    <th>电话</th>
                    <th>状态</th>
                </tr>
            </thead>
            <tbody>
            <?php if(!empty($studentlist)){foreach($studentlist as $student){?>
            	<tr class="<?=(end($studentlist)==$student)?"last":""?>">
                	<td width="30%">
                    	<a title="" data-uid="<?=$student['uid']?>" href="javascript:;" style="float:left;"><img src="<?=getavater($student,'50_50')?>" class="imgyuan" style="width:40px; height:40px;"></a>
						<p class="ghjut"><?=getusername($student)?><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/<?=($student['sex']==1)?"women":"man"?>.png" class="ml5"></p>
						<p class="ghjut"><?=$student['username']?></p>
					</td>
					<td width="25%" style="text-align:center"><?=empty($student['email'])?"-":$student['email']?></td>
					<td width="20%" style="text-align:center"><?=empty($student['mobile'])?"-":$student['mobile']?></td>
					<?php if(!empty($student['bind'])){?>
					<td width="25%" style="text-align:center; color:#5e98fb;">已绑定</td>
					<?php }else{?>
					<td width="25%" style="text-align:center; color:#ff3333;">未绑定</td>
					<?php }?>
					
				</tr>
            <?php }}else{?>
                <tr class="last">
                	<td colspan="4"><div class="nodata"></div></td>
				</tr>
            <?php }?>
			</tbody>
		</table>
		<?=$pagestr?>
	</div>
</div>
</body>
</html>
