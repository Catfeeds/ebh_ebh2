<?php
$this->display('admin/header');
?>
<body>
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>会员管理 - 开通统计</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tr>
			<td  class="active" >开通统计</td>
			</tr>
			</table>
		</td>
	</tr>
</table>

<form id="ck"  onsubmit="return _search();">
<label >会员:</label>
<input type="text" name="q" value="" >
<label>所属同步学堂：</label>
    <span id="">
   	<?php $this->widget('classroom_widget');?>
   	</span>
<label>开通时长:</label>
<span id="">
<select  name="addtime" id="select" >
<option value="">选择时长</option>
<option value="6" >6个月</option>
<option value="12" >12个月</option>
</select>
</span>
<label style="width:10">订单号/卡号:</label>
<input type="text" name="ordernumber" value="">
<label>开通方式:</label>
<span id="">
<select  name="payfrom" id="payfrom" >
<option value="">开通方式</option>
<option value="1" >年卡开通</option>
<option value="2" >快钱开通</option>
<option value="3" >支付宝开通</option>
<option value="4" >人工开通</option>
<option value="5" >内部测试</option>
<option value="6" >农行支付</option>
<option value="7" >银联支付</option>
</select>
</span>
<label>开通时间：</label>
<input id="stardateline" class="ipt w100" type="text" value="" onfocus="" name="begintime" /> ~
<input id="enddateline" class="ipt w100" type="text" value="" onfocus="" name="endtime" />
<input type="submit" name="listsubmit" value="查询" />

</form>
<script type="text/javascript">
	var payfrom = ['','年卡开通','快钱开通','支付宝','人工开通','内部测试','农行支付','银联支付'];
    function _render(_data){
        $(".moduletbody").html('');
        $.each($(_data),function(k,v){
            $(_renderRow(k,v)).appendTo(".moduletbody");
        });
    }

    function _renderRow(k,v){
        var row = ['<tr class="tr_module_2350">'];
     	row.push('<td class="username" align="center">'+v.username+'</td>');
     	row.push('<td class="school" align="center">'+v.crname+'</td>');
     	row.push('<td class="paytime" align="center">'+v.addtime+'</td>');
		row.push('<td class="money" align="center">'+v.money+'</td>');
     	row.push('<td class="card" align="center">'+v.ordernumber+'</td>');
     	row.push('<td class="payfrom" align="center">'+payfrom[v.payfrom]+'</td>');
     	row.push('<td align="center">'+getformatdate(v.dateline)+'</td>');
        row.push('</tr>');
        return row.join('');
    }
</script>
<table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
	<tr>
	<th fieldname="i.username" width="15%">会员</th>
	<th fieldname="i.school" >网校</th>
	<th filedname="i.paytime">开通时长(月)</th>
	<th filedname="i.money">金额(元)</th>
	<th fieldname="i.card" >订单号/卡号</th>
	<th fieldname="i.payfrom" >开通方式</th>
	<th fieldname="i.dateline" >开通时间</th>
	</tr>
	<tbody class="moduletbody">
	</tbody>
</table>

<table cellspacing="0" cellpadding="0" width="100%"  class="btmtable">
<tr><th width="12%">批量操作</th><th>
<input type="checkbox" name="chkall" id="chkall" onclick=""><label for="chkall">全选</label>
<input type="radio" name="operation" value="noop" checked id="noop"><label for="noop">不操作</label>
</th></tr>

<tr id="divnoop" style="display:none"><td></td><td></td></tr>
</table>
<div id="pp"></div>
<div class="buttons">
<input type="submit" name="listsubmit" value="提交保存" class="submit">
<input type="reset" name="listreset" value="重置">
</div>
<script>
$(function(){
    $("#stardateline,#enddateline").focus(function(){
    	$(this).datebox({showSeconds:false});
    });
    $("#stardateline,#enddateline").trigger('focus');
    $(".pagination-page-list").trigger('change');
});
$(function(){
    $(".pagination-page-list").trigger('change');
});
function _search(){
	$('#pp').pagination({pageNumber:1});
    $(".pagination-page-list").trigger('change');
    return false;
}

$('#pp').pagination({
pageSize:10,
onSelectPage:function(pageNumber, pageSize){
    var query = $('#ck').serialize();
    $.post("/admin/opencount/getListAjax.html",
        {query:query,pageNumber:pageNumber,pageSize:pageSize},
        function(message){
            message = JSON.parse(message);
            $('#pp').pagination('refresh',message.shift());
             _render(message);
            

        }
        );
    return false;
}
});
</script>
</body>
<?php
$this->display('admin/footer');
?>