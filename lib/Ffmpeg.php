<?php
/**
*ffmpeg类库，用于实现视频格式转换和截图等功能
*/
class Ffmpeg {
	/**
	*amr音频转换成mp3格式
	*@param $sourcepath amr文件路径
	*@param $destpath 转换后mp3的保存路径
	*/
	public function amr2mp3($sourcepath,$destpath) {
		$cmd = "ffmpeg -i $sourcepath $destpath";
		exec($cmd);
		if(file_exists($destpath)) {
			return true;
		}
		return FALSE;
	}
	/**
	*跟flv文件加上关键帧
	*@param $sourcepath amr文件路径
	*@param $destpath 转换后新的保存路径
	*/
	public function setFlvKeyFrame($sourcepath,$destpath) {
		$cmd = "yamdi -i $sourcepath -o $destpath";
		exec($cmd);
		if(file_exists($destpath)) {
			return true;
		}
		return FALSE;
	}
	/**
	*获取flv的截图
	*ffmpeg -ss 00:23:00 -s 400*300 -i Mononoke.Hime.mkv -frames:v 1 out1.jpg
	*@param $sourcepath string flv文件路径
	*@param $destpath string 截图后的保存路径
	*@param $size string 图片尺寸 400*300 格式
	*@param $sstime string 需要截图的flv播放时间点可以秒或者 hh:mm:ss[.xxx]的形式
	*/
	public function getVideoImage($sourcepath,$destpath,$size,$sstime = '10') {
		$cmd = "ffmpeg -i $sourcepath -f image2 -ss $sstime -s $size -vframes 1 $destpath";
		exec($cmd);
		if(file_exists($destpath)) {
			return true;
		}
		return FALSE;
	}
	/**
	*将flv视频生成m3u8格式
	*@param $sourcepath string flv文件路径 
	*@param $sourcepre string m3u8文件内的ts文件路径前缀，一般是实际路径，需要被替换， /data0/uploads/mu/
	*@param $destpath string	保存的m3u8路径
	*@param $destdir string	m3u8内的ts文件的实际保存文件夹 /data0/uploads/mu/2014/10/22/143423423/143423423
	*@param $persecond int 多少秒截一个ts文件，默认30秒
	*示例：$ffmpeg->flv2m3u8('/data0/uploads/2014/10/22/143423423.flv','/data0/uploads/mu/','/data0/uploads/mu/2014/10/22/143423423.m3u8','/data0/uploads/mu/2014/10/22/143423423/143423423','/',30);
	*/
	public function flv2m3u8($sourcepath,$sourcepre,$destpath,$destdir,$destpre,$persecond = 30) {
		$tspath = substr($sourcepath,0,strlen($sourcepath)-5).'.ts';
		$is264 = $this->ish264($sourcepath);
		$ext = strtolower( strrchr( $sourcepath , '.' ) );	//.flv
		if($is264 && $ext != '.mp4') {
			$fcmd = "ffmpeg -y -i $sourcepath -vcodec copy -acodec libfaac -vbsf h264_mp4toannexb $tspath";
		} else {
			$fcmd = "ffmpeg -y -i $sourcepath -vcodec h264 -acodec libfaac -vbsf h264_mp4toannexb $tspath";
		}
		log_message('fcmd:'.$fcmd);
		exec($fcmd);
		if(!file_exists($tspath) || filesize($tspath) <= 0) {
			return FALSE;
		}
		$scmd = "segmenter -i $tspath -d $persecond -o $destdir -x $destpath";
		log_message('scmd:'.$scmd);
		exec($scmd);
		if(!file_exists($destpath) || filesize($destpath) <= 0 ) {
			return FALSE;
		}
		$sedcmd = "sed -i 's#$sourcepre#$destpre#g' $destpath";
		log_message('sedcmd:'.$sedcmd);
		exec($sedcmd);
		return TRUE;
	}
	public function flv2m3u8v2($sourcepath,$sourcepre,$destpath,$destdir,$destpre,$persecond = 30) {
		$tspath = substr($sourcepath,0,strlen($sourcepath)-5).'.ts';
		$is264 = $this->ish264($sourcepath);
		$ext = strtolower( strrchr( $sourcepath , '.' ) );	//.flv
		$fcmd = "ffmpeg -y -i $sourcepath -vf \"scale=trunc(iw/2)*2:trunc(ih/2)*2\" -vcodec h264 -acodec libfaac -vbsf h264_mp4toannexb $tspath";
		log_message('fcmd:'.$fcmd);
		exec($fcmd);
		if(!file_exists($tspath) || filesize($tspath) <= 0) {
			return FALSE;
		}
		$scmd = "segmenter -i $tspath -d $persecond -o $destdir -x $destpath";
		log_message('scmd:'.$scmd);
		exec($scmd);
		if(!file_exists($destpath) || filesize($destpath) <= 0 ) {
			return FALSE;
		}
		$sedcmd = "sed -i 's#$sourcepre#$destpre#g' $destpath";
		log_message('sedcmd:'.$sedcmd);
		exec($sedcmd);
		return TRUE;
	}
	/**
	*判断视频文件是否为h264编码
	*@param $sourcepath string flv文件路径
	*@return bool 是h264编码返回true
	*/
	public function ish264($sourcepath) {
		$cmd = "ffprobe -v quiet -print_format json -show_format -show_streams $sourcepath";
		$execarr = array();
		exec($cmd,$execarr);
		$result = implode($execarr,',');
		if(stripos($result,'h264') !== FALSE || stripos($result,'H.264') !== FALSE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>