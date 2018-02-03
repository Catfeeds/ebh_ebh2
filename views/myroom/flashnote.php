<div id="notecontent"></div>
<script>
var cwid = "<?=$cwid?>";
var btnvalue = '插入笔记';
function getcwid(){
	return cwid;
}
function geturl(){
	var url = new Array();
	url[0] = 'http://<?=$domain?>.<?=$this->uri->curdomain?>/flashnote/getNoteDetail.html';
	url[1] = 'http://<?=$domain?>.<?=$this->uri->curdomain?>/flashnote.html';
	return url;
}
function mynote(){

	if($('#notecontent').is('div')){
		swfobject.embedSWF("http://<?=$domain?>.<?=$this->uri->curdomain?>/static/flash/flashnote.swf", "notecontent", "978", "578" ,"9.0.0");
		$('#notebtn').val('隐藏笔记');
		$('#reloadnotebtn').css('display','block');
	}else if($('#notecontent').css('visibility')=='hidden'){
		$('#notecontent').css('height','');
		$('#notecontent').css('visibility','visible');
		// $('.notecontent').css('display','block');
		$('#reloadnotebtn').css('display','block');
		$('#notebtn').val('隐藏笔记');
	}
	else{
	// alert(2);
		$('#notecontent').css('height','0');
		$('#notecontent').css('visibility','hidden');
		$('#reloadnotebtn').css('display','none');
		$('#notebtn').val(btnvalue);
	}
}
function reloadnote(){
	swfobject.embedSWF("http://<?=$domain?>.<?=$this->uri->curdomain?>/static/flash/flashnote.swf?idd="+Math.random(), "notecontent", "978", "578" ,"9.0.0");
}

$(function(){
	$.ajax({
		type:'get',
		data:{'cwid':cwid},
		url:'/flashnote/getNoteDetail.html',
		success:function(data){
			if(data!="0"){
				btnvalue = '查看笔记';
				$('#notebtn').val(btnvalue);
			}
		}
	})
})

</script>