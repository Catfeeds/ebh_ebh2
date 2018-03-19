<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
        <link rel="stylesheet" href="http://static.ebanhui.com/checkin/css/common.css" />
        <link rel="stylesheet" href="http://static.ebanhui.com/checkin/css/checkinview.css" />
        <link rel="stylesheet" href="http://static.ebanhui.com/checkin/css/checkinviewGai.css" />
        <link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?version=20160224001" rel="stylesheet" type="text/css">
		<script src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
        <style type="text/css">
            table.datatab th,table.datatab td{text-align:left;padding:0 3px;}
            table.datatab th,table.datatab .singlerow{white-space:nowrap;}
            table.datatab .coursename{width:8em;}
            table.datatab td.today{color:#f00;}
            table.datatab .attend_num{width:20%;}
            table.datatab .attend_box .num_box{width:75%;}
            table.datatab .datatime{width:150px;}
            table.datatab .count{width:40px;}
            table.datatab .oper{width:100px;}
        </style>
	</head>
	<body>
		<div class="checkinview">
			<div class="waitite">
				<div class="work_menu" style="position:relative;margin-top:0">
					<ul>
                        <li><a href="/troomv2/attendance.html">课件列表</a></li>
						<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">出勤列表</span></a></li>
					</ul>
				</div>	
				<div class="clear"></div>
			</div>
            <form action="/troomv2/attendance/classcount/<?=$classid?>.html" class="checkin_form">
                <input type="hidden" value="0" name="export">
                <select name="folderid" id="forum" style="width:130px;" class="selectinput">
                    <option value='' disabled selected style='display:none;'>请选择课程</option>
                    <option value='0' <?php if(0 == $this->input->get('folderid')){?>selected<?php } ?> >选择课程</option>
                    <?php foreach($folders as $id => $folder){ ?>
                        <option value="<?=$id?>"  <?php if($id == $this->input->get('folderid')){?>selected<?php } ?> ><?=$folder?></option>
                    <?php } ?>
                </select>
                <div style="float:left;width:140px;height:36px;margin:0 20px 0 0;">
                    <div style="float:left; display:inline;height: 36px;">
                        <input type="text" id="startTime" name="startTime" class="readonly" readonly="readonly" style="" placeholder="选择开始时间" onclick="WdatePicker({});" value="<?=$this->input->get('startTime')?>" />&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                </div>
                <div style="float:left;width:140px;height:36px;margin:0 20px 0 0;">
                    <div style="float:left; display:inline;height: 36px;">
                        <input type="text" id="endTime" name="endTime" class="readonly" readonly="readonly" style="" placeholder="选择结束时间" onclick="WdatePicker({});" value="<?=$this->input->get('endTime')?>" />&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                </div>
                <input type="text" placeholder="搜索课件名称" name="name" id="name" value="<?=$this->input->get('name')?>" />
                <button type="button" class="search_btn" value="搜索">搜索</button>
                <button type="button" class="export" value="导出">导出</button>
                <button class="load" value="刷新" >刷新</button>
            </form>
            <table class="datatab" width="100%" cellspacing="0" cellpadding="0">
                <tr style="background: #eef1f6;">
                    <th class="count">序号</th>
                    <th>课件名称</th>
                    <th class="coursename">课程</th>
                    <th class="count">应到</th>
                    <th class="count">已到</th>
                    <th class="datatime">课件开始时间</th>
                    <th class="attend_num">出勤率</th>
                    <th class="oper">操作</th>
                </tr>
                <?php if (!empty($list)) {
                    $index = ($pageparam['page'] - 1) * $pageparam['pagesize'];
                    foreach ($list as $data) { ?>
                        <tr>
                            <td><?=++$index?></td>
                            <td<?php if ($data['t'] == 1) { ?> class="today"<?php } ?>><?=$data['title']?></td>
                            <td><?=$data['foldername']?></td>
                            <td class="singlerow"><?=$data['studentCount']?></td>
                            <td class="singlerow"><?=$data['signCount']?></td>
                            <td class="singlerow"><?=date('Y-m-d H:i:s', $data['truedateline'])?></td>
                            <td>
                                <div class="attend_box">
                                    <div class="num_box">
                                        <div class="num" style="width:<?php if($data['studentCount'] > 0){?><?=min(100, intval($data['signCount']/$data['studentCount'] * 100))?><?php }else{ ?>0<?php } ?>%;"></div>
                                    </div>
                                    <div class="num_txt"><?php if($data['studentCount'] > 0){ ?><?=min(100, intval($data['signCount']/$data['studentCount'] * 100)) ?><?php }else{  ?>0<?php } ?>%</div>
                                </div>
                            </td>
                            <td><a href="/troomv2/attendance/detail/<?=$data['cwid']?>.html?classid=<?=$classid?>&from=c">详情</a></td>
                        </tr>
                    <?php }
                } ?>
            </table>
            <?=isset($pagestr) ? $pagestr : ''?>
		</div>
	</body>
<script>
	$(function(){
		var mainFrame = parent.document.getElementById('mainFrame');
		if (mainFrame) {
            var allH = document.body.offsetHeight + 50;
            mainFrame.style.height = allH + "px";
        }
		$('.search_btn').on('click',function(){
            $('input[name="export"]').val(0);
			$('.checkin_form').submit();
		});
		$('.load').on('click',function(){
            $('input[name="export"]').val(0);
			$('.checkin_form').submit();
		});
		$('.export').on('click',function(){
			$('input[name="export"]').val(1);
			$('.checkin_form').submit();
		});
		$('.selectinput').change(function(){
			$('input[name="export"]').val(0);
			$('.checkin_form').submit();
		});
	})

</script>
</html>
