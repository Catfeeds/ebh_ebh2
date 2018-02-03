<?php $this->display('shop/plate/headernew');?>
<style type="text/css">
body {background:#fff;}
.mui-table-view:after {height:0px;}
.mui-table-view .mui-media-object {border-radius:100%;margin:0;}
.mui-table-view.mui-grid-view .mui-table-view-cell .mui-media-object {width:78px;height:78px;}
.mui-table-view.mui-grid-view {padding:0 0 20px 0;}
.mui-table-view.mui-grid-view .mui-table-view-cell {margin:5% 0 0 5%;;border:solid 1px #e3e3e3;padding:0;border-radius:4px;}
.mui-table-view.mui-grid-view .mui-table-view-cell>a:not(.mui-btn) {margin:10px;}
.mui-col-xs-5 {width:42.5%;}
.mui-table-view:before {height:0px;}
</style>
<div>
	<h5 style="height:36px;line-height:36px;text-indent:10px;">所有教师</h5>
	<ul class="mui-table-view mui-grid-view mui-scroll" id="content-panel">
        <?php if (!empty($masters)) {
            foreach ($masters as $master) { ?>
                <li class="mui-table-view-cell mui-media mui-col-xs-5">
                    <a href="/master/<?=$master['tid']?>.html">
                        <img class="mui-media-object" src="<?=getavater((array) $master, '120_120')?>">
                        <div class="mui-media-body"><?=!empty($master['realname']) ? $master['realname'] : $master['username']?></div>
                        <div class="mui-media-body"><?=$master['professionaltitle']?></div>
                    </a>
                </li>
            <?php }
        } ?>
	</ul>
	<p id="showNoData" style="text-align:center;display:none;">没有更多啦！</p>
</div>

<script type="text/javascript">
		var page = 1;
		var allAdd = 0;
		$(window).scroll(function () {
			var scrollTop = $(this).scrollTop();
			var scrollHeight = $(document).height();
			var windowHeight = $(this).height();
			if (scrollTop + windowHeight == scrollHeight) {
			pullupRefresh();
		  //此处是滚动条到底部时候触发的事件，在这里写要加载的数据，或者是拉动滚动条的操作

		//var page = Number($("#redgiftNextPage").attr('currentpage')) + 1;
		//redgiftList(page);
		//$("#redgiftNextPage").attr('currentpage', page + 1);

			}
		});
    mui.init({
        pullRefresh: {
            container: '#pullrefresh',
            up: {
                contentrefresh: '正在加载...',
                callback: pullupRefresh
            }
        }
    });
    /**
     * 上拉加载具体业务实现
     */
    function pullupRefresh() {
    	if(allAdd) {
    		return false;
    	}
        $.ajax({
            url: '/shop/school/masterlist.html',
            type: 'get',
            data: { 'page': ++page, 'isAjax': 1 },
            dataType: 'json',
            success: function(ret) {
                if (ret) {
                    var len = ret.length;
                    var htmlfrage = [];
                    for(var i = 0; i < len; i++) {
                        var master = ret[i];
                        htmlfrage.push('<li class="mui-table-view-cell mui-media mui-col-xs-5">'+
                            '<a href="/shop/school/master/'+master.tid+'.html">' +
                            '<img class="mui-media-object" src="'+master.face+'">' +
                            '<div class="mui-media-body">'+(master.realname || master.username)+'</div>' +
                            '<div class="mui-media-body">'+master.professionaltitle+'</div>' +
                            '</a>' +
                            '</li>');
                        htmlfrage.push('</ul>');
                    }
                    $("#content-panel").append(htmlfrage.join(''));
                    if (len == 0)
					{
						allAdd = 1;
						$('#showNoData').show();
					}
                }
				
                //mui('#pullrefresh').pullRefresh().endPullupToRefresh(!ret || ret.length == 0);
            }
        });
    }
</script>

<?php $this->display('shop/plate/footers');?>