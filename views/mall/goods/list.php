<?php $this->display('mall/header') ?>

<script type="text/javascript">
/*全选*/
$(function(){
	$("#allchose").click(function(){    
		if(this.checked){    
			$("table td :checkbox").prop("checked", true);   
		}else{    
			$("table td :checkbox").prop("checked", false); 
		}    
	});
});
/*商品状态选择*/
$(function(){
	var selects=$("#select");
  	var options=$("#option");
  	var state=true;
  	selects.click(function(){
   		if(state){
   			if(!($(this).is(":animated"))){
    			options.slideDown();
   			}else{
    			options.css("display","none");
  			}  
   			state=false;
   		}else{
   			if(!($(this).is(":animated"))){
   				options.slideUp();
   			}else{
    			$(this).stop(true,true);
   				options.css("display","");
   			}
   			state=true;
   		}
  	});
	$("li").click(function(){
		options.css("display","none");
		selects.children("i").text($(this).attr("tip"));
        var status = $(this).data('status');
        selects.attr('data-status',status);
		state=false;
	});
  	options.click(function(){
   		selects.click(function(){return false;});
		$(".goodsordeseach").trigger("click");
  	});
});

</script>
<style>
.goodstable.width950 td{
	border-top:1px solid #ececec;
	border-bottom:none;
}
</style>
<body>
<?php

    function showActionButton($tagid){
        $buttons = '';
        switch ($tagid) {
            case 0:case 5:
                return false;
                break;
            case 1:case 3:
                $buttons .= '<a href="javascript:void(0)" class="confirmreceipt ml10" data-action="delSelected">批量删除</a>';
                break;
            case 2:
                $buttons .= '<a href="javascript:void(0)" class="confirmreceipt ml10" data-action="downSelected">批量下架</a>';
                break;
            case 3:
                $buttons .= '<a href="javascript:void(0)" class="confirmreceipt ml10" data-action="delSelected">批量删除</a>';
                break;
            case 4:
                $buttons .= '<a href="javascript:void(0)" class="confirmreceipt ml10" data-action="upSelected">批量上架</a>';
                $buttons .= '<a href="javascript:void(0)" class="confirmreceipt ml10" data-action="delSelected">批量删除</a>';
                break;            
            default:
                # code...
                break;
        }

        return $buttons;
    }
    function getSelectOption($code){
        switch ($code) {
            case 0:
                return '全部';
                break;
            case 1:
                return '待审核';
                break;
            case 2:
                return '出售中';
                break;
            case 3:
                return '审核退回';
                break;
            case 4:
                return '已下架';
                break;
            case 5:
                return '已删除';
                break;
            default:
                # code...
                break;
        }
    }
    function getGoodsStatus($audit,$sale,$del ,$gid){
        if($del == 1){
            return '已删除';
        }
        if($audit == 0){
            return '待审核';
        }
        if($audit == 1 && $sale == 0){
            return '<span class="gray">已下架</span>';
        }
        if($audit == 1 && $sale == 1){
            return '出售中';
        }
        if($audit == 2){
            return '<span class="red">审核退回</span><br/><a href="javascript:;" style="color:#4e8cf0" onclick="showRemark('.$gid.')">查看</a>';
        }
    }
    function getGoodsAction($audit,$sale,$del,$gid){
        if($del == 1){//已删除
            $action = '<a href="javascript:void(0)" class="editdel" data-action="restore" data-gid="'.$gid.'">还原</a>';
            return $action;
        }
        if($audit == 0){//待审核
            $action = '<a href="javascript:void(0)" class="editdel" data-action="edit" data-gid="'.$gid.'">修改</a>';
            $action.= '<br>';
            $action.= '<a href="javascript:void(0)" class="editdel" data-action="del" data-gid="'.$gid.'">删除</a>';
            return $action;
        }
        if($audit == 1 && $sale == 0){//已下架
            $action = '<a href="javascript:void(0)" class="editdel" data-action="up" data-gid="'.$gid.'">上架</a>';
            $action.= '<br>';
            $action.= '<a href="javascript:void(0)" class="editdel" data-action="edit" data-gid="'.$gid.'">修改</a>';
            $action.= '<br>';
            $action.= '<a href="javascript:void(0)" class="editdel" data-action="del" data-gid="'.$gid.'">删除</a>';
            return $action;         
        }
        if($audit == 1 && $sale == 1){//销售中
            $action = '<a href="javascript:void(0)" class="editdel" data-action="down" data-gid="'.$gid.'">下架</a>';
            return $action;
        }
        if($audit == 2){//审核退回
            $action = '<a href="javascript:void(0)" class="editdel" data-action="edit" data-gid="'.$gid.'">修改</a>';
            $action.= '<br>';
            $action.= '<a href="javascript:void(0)" class="editdel" data-action="del" data-gid="'.$gid.'">删除</a>';
            return $action;
        }
        
    }
?>
<div class="buygoods">
	<div class="buygoodson">
		<div class="work_menu" style="position:relative;margin-top:0">
			<ul>
				<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso">商品管理</span></a></li>
			</ul>
			<a href="javascript:void(0)" class="isell">我要卖</a>
		</div>
        <div class="goodsnav goodsnavml25 goodsnavmt10">
            <ul>
                <li class="first <?php if($goods['params']['tagid'] == 0) echo 'curr';?>"><a href="javascript:void(0)" data-tagid="0">所有商品</a><span>|</span></li>
                <li class="<?php if($goods['params']['tagid'] == 1) echo 'curr';?>"><a href="javascript:void(0)" data-tagid="1">待审核</a><span>|</span></li>
                <li class="<?php if($goods['params']['tagid'] == 2) echo 'curr';?>"><a href="javascript:void(0)" data-tagid="2">出售中</a><span>|</span></li>
                <li class="<?php if($goods['params']['tagid'] == 3) echo 'curr';?>"><a href="javascript:void(0)" data-tagid="3">审核退回</a><span>|</span></li>
                <li class="<?php if($goods['params']['tagid'] == 4) echo 'curr';?>"><a href="javascript:void(0)" data-tagid="4">已下架</a><span>|</span></li>
                <li class="<?php if($goods['params']['tagid'] == 5) echo 'curr';?>"><a href="javascript:void(0)" data-tagid="5">已删除</a></li>
            </ul>
        </div>
		<div class="clear"></div>
        <div class="buygoodsearchitem  width950">
            <span class="nameinputmt10">商品名称</span>
            <input type="text" class="nameinput nameinputmt10" name="gname" value="<?= isset($goods['params']['gname']) ? $goods['params']['gname'] : '' ?>"/>
            <span class="ml15 nameinputmt10">发布时间</span>
            <input type="text" class="nameinput closingtime nameinputmt10" style="cursor:pointer" name="sdateline" readonly="readonly" value="<?php  if(!empty($goods['params']['sdateline'])) echo $goods['params']['sdateline']; ?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});"/>
            <span class="lines nameinputmt10">-</span>
            <input type="text" class="nameinput lines closingtime nameinputmt10" style="cursor:pointer" name="edateline" readonly="readonly" value="<?php  if(!empty($goods['params']['edateline'])) echo $goods['params']['edateline']; ?>"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});"/>
            <?php if($goods['params']['tagid'] == 0){ ?>
                <span class="ml15 nameinputmt10">商品状态</span>
                <div class="statusorder-1">
                    <div class="nameinput goodsinput nameinputmt10" id="select" data-status="<?= $goods['params']['status'] ?>">
                    	<i><?= getSelectOption($goods['params']['status']) ?></i>
                    	<div class="statusorderlist statusorderlist33" id="option" style="display:none;" >
                            <ul>
                                <li data-status="0" tip="全部"><a href="javascript:void(0)">全部</a></li>
                                <li data-status="1" tip="待审核"><a href="javascript:void(0)">待审核</a></li>
                                <li data-status="2" tip="出售中"><a href="javascript:void(0)">出售中</a></li>
                                <li data-status="3" tip="审核退回"><a href="javascript:void(0)">审核退回</a></li>
                                <li data-status="4" tip="已下架"><a href="javascript:void(0)">已下架</a></li>
                                <li data-status="5" tip="已删除"><a href="javascript:void(0)">已删除</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php }?>
            <a href="javascript:void(0)" class="goodsordeseach nameinputmt10">商品搜索</a>
        </div>
        <?php if(!empty($goods['list'])){ ?>
        <div class="buygoodslist  width950">
        	<table cellpadding="0" cellspacing="0" class="goodstable width950">
            	<tr>
                    <?php if(showActionButton($goods['params']['tagid'])){ ?>
                        <th width="70">&nbsp;</th>
                    <?php } ?>
                	<th width="340" colspan="2">商品名称</th>
                    <th width="180">发布时间</th>
                    <th width="180">状态</th>
                    <th width="180">操作</th>
                </tr>
                    <?php foreach ($goods['list'] as $good) { ?>
                        <tr>
                            <?php if(showActionButton($goods['params']['tagid'])){ ?>
                                <td><input autocomplete="off" type="checkbox" name="gids" value="<?= $good['gid'] ?>"/></td>
                            <?php } ?>
                        	<td width="100">
        						<img src="<?=$showpath.$good['path'] ?>" class="goodscover" width="80" height="45" />
                            </td>
							<td><p class="goodsint"><?= $good['gname'] ?></p></td>
                            <td><?= date("Y-m-d",$good['dateline']) ?>&nbsp;&nbsp;<?= date("H:i",$good['dateline']) ?></td>
                            <td><?= getGoodsStatus($good['audit'],$good['sale'],$good['del'], $good['gid']) ?></td>
                            <td>
                            	<?= getGoodsAction($good['audit'],$good['sale'],$good['del'], $good['gid']) ?>
                            </td>
                        </tr>
                        <?php if($goods['params']['tagid'] == 3 || $good['audit'] == 2){ ?>
                            <!-- <tr class="bordertop">
                                <td colspan="5">
                                    <div class="returnreason red">退回意见：<?= $good['remark'] ?></div>
                                </td>
                            </tr> -->
                            <input type="hidden" id="<?= 'remark'.$good['gid'] ?>" value="<?= $good['remark'] ?>"/>
                        <?php } ?>
                    <?php }?> 
            </table>
            <?= $goods['pagination'] ?>
			<?php if( showActionButton($goods['params']['tagid']) && !empty($goods['list'])){ ?>
            <div class="buygoodsfoot" style="margin-left:30px">
            	<input autocomplete="off" type="checkbox" id="allchose" />
                <label class="allchose" for="allchose">全选</label>
                <?= showActionButton($goods['params']['tagid']) ?>
            </div>
			<?php } ?>
        </div>
        <div class="clear"></div>
        <?php }elseif(empty($goods['params']['fromseach'])){ ?>
            <div class="buygoodslist nobuygoods">该列表下无订单商品！</div>
        <?php }else{ ?>
            <div class="buygoodslist nobuygoods1"></div>
        <?php } ?>
        
        
    </div>
</div>
<script type="text/javascript">

    // 0 1 2 3 4 5 
    $(".goodsnavml25 li a").click(function(){
        var tagid = $(this).data('tagid');
        location.href = "/mall/goods.html?tagid="+tagid;
    })
    //搜索
    $(".goodsordeseach").click(function(){
        var gname  = $("input[name='gname']").val();
        var sdateline = $("input[name='sdateline']").val();
        var edateline = $("input[name='edateline']").val();
        var status = $("#select").data('status');
        var url = "/mall/goods.html?fromseach=1&tagid=<?= $goods['params']['tagid'] ?>";
        if(gname != ''){
            url += '&gname='+gname;
        }
        if(sdateline != ''){
            url += '&sdateline='+sdateline;
        }
        if(edateline != ''){
            url += '&edateline='+edateline;
        }
        if(status != ''){
            url += '&status='+status;
        }
        location.href = url;
    });
    //操作 edit del up down restore
    $(".editdel").click(function(){
        var action = $(this).data('action');
        var gid = $(this).data('gid');
        if(action == 'edit'){
            location.href = "/mall/goods/edit.html?gid="+gid;
        }else{
            showDialog(gid, action);
        }
    });
    //批量操作
    $(".confirmreceipt").click(function(){
        var action = $(this).data('action');
        var gid = '';
        $("input[name='gids']:checked").each(function(){
            gid += $(this).val() + ',';
        });
        if(gid == ''){
            top.dialog({
                title : "信息提示",
                content : "请勾选需要批量操作的商品",
                okValue : "确定",
                ok : function(){
                },
                width : "400"
        }).showModal();
        }else{
            showDialog(gid, action);
        }
    });
   
    //提示弹框
    function showDialog(gid,action){
        var content = '';
        if(action=='del'){
            content = '是否对商品进行删除?';
        }
        if(action=='up'){
            content = '是否对商品进行上架?';
        }
        if(action=='down'){
            content = '是否对商品进行下架?';
        }
        if(action=='restore'){
            content = '是否对商品进行还原?';      
        }
        if(action=='delSelected'){
            content = '是否对商品进行批量删除?';
            action = 'del';
        }
        if(action=='upSelected'){
            content = '是否对商品进行批量上架?';
            action = 'up';
        }
        if(action=='downSelected'){
            content = '是否对商品进行批量下架?';
            action = 'down';
        }
        top.dialog({
                title : "信息提示",
                content : content,
                okValue : "确定",
                ok : function(){
                    $.post('/mall/goods/operate.html',{
                        action:action,
                        gid:gid
                    },function(data){
                        if(data.status){
							location.href = '/mall/goods.html?tagid=<?=$goods['params']['tagid']?>';
                        }
                    },'json');
                },
                width : "400px"
        }).showModal();
    }
    $(".isell").click(function(){
        //验证用户是否绑定手机
        var hasMobile = <?= empty($user['mobile']) ? 0 : 1 ?>;
        if( ! hasMobile){//无手机号
            top.dialog({
                title : "信息提示",
                content : "您没有绑定手机号,点击确定前往绑定!",
                okValue : "确定",
                ok : function(){
                   top.location.href = '/homev2/safety/index.html';
                },
                cancelValue : "取消",
                cancel : function(){
                    
                },
                width : "400px"
            }).showModal();
            return ;
        }
        //验证学生是否购买课程
        var groupid = <?= $user['groupid'] ?>;
        var hasbuyedcoure = <?= empty($user['hasBuyedCourse']) ? 0 : 1 ?>;
        if(groupid == 6 &&  ! hasbuyedcoure){//学生且没有购买课程
            top.dialog({
                title : "信息提示",
                content : "您没有购买过课程无法发布商品,点击确定前往购买课程!",
                okValue : "确定",
                ok : function(){
                   location.href = "/myroom/college/study.html";
                },
                cancelValue : "取消",
                cancel : function(){
                    
                },
                width : "400px"
            }).showModal();
            return ;
        }
        //发布商品
        location.href = "/mall/goods/release.html";
    })
    function showRemark(gid){
        remark = $("#remark"+gid).val();
         top.dialog({
                title : "退回意见",
                content : remark,
                okValue : "确定",
                ok : function(){
                },
                width : "400px"
            }).showModal();
    }
</script>
<?php $this->display('mall/footer') ?>