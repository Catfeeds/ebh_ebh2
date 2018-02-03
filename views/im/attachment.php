<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="http://static.ebanhui.com/checkin/css/common.css" />
		
		<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css">
		<style>
			a:hover{
				text-decoration: none;
			}
			.datatab th {
			    color: #333;
			    font-family: 微软雅黑;
			    font-size: 17px;
			    font-weight: normal;
			    padding: 6px 0;
			    text-align: center;
			}
			.datatab td {
			    border: none;
			    text-align: center;
			    padding: 5px;
			    font-size: 13px;
			}
			.first{
				text-align: left!important;
			}
			.icont{
				float: left;
    			width: 32px;
    			height: 32px;
			}
			.ico-ppt {
				background:url(http://static.ebanhui.com/pan/images/anste21.png) no-repeat;
			}
			.ico-mp3 {
				background:url(http://static.ebanhui.com/pan/images/anste22.png) no-repeat;
			}
			.ico-doc {
				background:url(http://static.ebanhui.com/pan/images/anste23.png) no-repeat;
			}
			.ico-zip {
				background:url(http://static.ebanhui.com/pan/images/anste24.png) no-repeat;
			}
			.ico-swf {
				background:url(http://static.ebanhui.com/pan/images/anste25.png) no-repeat;
			}
			.ico-xls {
				background:url(http://static.ebanhui.com/pan/images/anste26.png) no-repeat;
			}
			.ico-html {
				background:url(http://static.ebanhui.com/pan/images/anste27.png) no-repeat;
			}
			.ico-txt {
				background:url(http://static.ebanhui.com/pan/images/anste28.png) no-repeat;
			}
			.ico-avi {
				background:url(http://static.ebanhui.com/pan/images/listico1.png) no-repeat;
			}
			.ico-jpg {
				background:url(http://static.ebanhui.com/pan/images/listico2.png) no-repeat;
			}
			.ico-jpeg {
				background:url(http://static.ebanhui.com/pan/images/listico3.png) no-repeat;
			}
			.ico-gif {
				background:url(http://static.ebanhui.com/pan/images/listico4.png) no-repeat;
			}
			.ico-bmp {
				background:url(http://static.ebanhui.com/pan/images/listico5.png) no-repeat;
			}
			.ico-png {
				background:url(http://static.ebanhui.com/pan/images/listico6.png) no-repeat;
			}
			.ico-flv {
				background:url(http://static.ebanhui.com/pan/images/listico7.png) no-repeat;
			}
			.ico-mp4 {
				background:url(http://static.ebanhui.com/pan/images/listico8.png) no-repeat;
			}
			.ico-mpg {
				background:url(http://static.ebanhui.com/pan/images/listico9.png) no-repeat;
			}
			.ico-rmvb {
				background:url(http://static.ebanhui.com/pan/images/listico10.png) no-repeat;
			}
			.ico-wmv {
				background:url(http://static.ebanhui.com/pan/images/listico11.png) no-repeat;
			}
			.ico-rar {
				background:url(http://static.ebanhui.com/pan/images/listico12.png) no-repeat;
			}
			.ico-bt {
				background:url(http://static.ebanhui.com/pan/images/listico13.png) no-repeat;
			}
			.ico-pdf {
				background:url(http://static.ebanhui.com/pan/images/listico14.png) no-repeat;
			}
			.ico-mov {
				background:url(http://static.ebanhui.com/pan/images/listico15.png) no-repeat;
			}
			.ico-file {
				background:url(http://static.ebanhui.com/pan/images/anste1.png) no-repeat;
			}
			._right{
				float:left;
				width:85%;
			}
			.name{
				width:100%;
				color:#338bff;
				word-wrap: break-word;
				padding-left:5px;
				line-height: 20px;
			}
			._time{
				width:100%;
				word-wrap: break-word;
				padding-left:5px;
				line-height: 20px;
				color:#999;
			}
			.datatab a {
			    color: #3366CC;
			}
			.previewBtn{
				background: #338bff;
				color: #fff!important;
				display: inline-block;
				font-family: 微软雅黑;
				font-size: 14px;
				height: 25px;
				line-height: 25px;
				margin:8px 0;
				text-align: center;
				width: 85px;
				font-weight: normal;
				margin-right: 0px;
				border-radius: 3px;
   	 			border: none;
				float: right;
				margin-right: 15px;
			}
			.disable{
				background: #ccc!important;
			}
		</style>
	</head>
	<body>
		<table width="100%" class="datatab" style="border:none;width: 100%;">
			<?php EBH::app()->helper('fileico');
							foreach ($attachments as $atta) {
								$ico = format_ico($atta['suffix']);?>
                                <tr>
                                    <td class="first" width="85%"><i class=" icont <?=$ico?>" style="margin: 3px 4px 0 15px"></i><div class="_right"><p class="name"><?= $atta['title'] ?></p><p class="_time"><?= date('Y-m-d H:i', $atta['dateline']) ?>&nbsp;&nbsp;&nbsp;<?= getsize($atta['size'])?></p></div></td>
                                    <td width="15%">
										<?php
										    
											$docSuffix = array('doc','xls','ppt','pdf','docx','xlsx','pptx');
											$picSuffix = array('jpg','jpeg','png','gif');
											if(in_array($atta['suffix'],$docSuffix) && $atta['ispreview'] == 1){
										?>
										<a class="previewBtn" href="<?= (stripos($atta['source'],'http://') !== false ?$atta['source']:'http://'.$atta['source']) . '/attach.html?attid=' . $atta['attid'] ?>&type=preview&k=<?=urlencode($key)?>&.<?=$atta['suffix']?>" target="_blank">打开</a>
										<?php }elseif(in_array($atta['suffix'],$picSuffix)){ ?>
										<a class="previewBtn" href="<?= (stripos($atta['source'],'http://') !== false ?$atta['source']:'http://'.$atta['source']) . '/attach.html?attid=' . $atta['attid'] ?>&k=<?=urlencode($key)?>&.<?=$atta['suffix']?>" target="_blank">打开</a>
										<?php }else{ ?>
										<a class="previewBtn disable" href="javascript:void(0);" target="_blank">打开</a>
										<?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
		</table>	
	</body>
</html>
