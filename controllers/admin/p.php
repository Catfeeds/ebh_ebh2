	<div id="pp"></div> 
	<script>
	//说明:queryData会原封不动传到服务器端;服务器端用$_POST['queryData']['params']接收queryData的值;服务端必须返回:{total:300,pagenumber:22,pagesize:10,queryData:xxxxx}作为json返回结果集的第一个元素，其中total是从服务器端动态读取的,其它三个参数就是js传过去的参数,只要原封不动地返回就好了
	function mypage(queryData,resetPageNumber){
					var p = {};
					$('#tab').datagrid({
						queryParams:{params:{pagenumber:1,pagesize:5,queryData:queryData}},
					 	rownumbers:false,
					 	striped:true,
					 	loadMsg:'加载中,请稍等...',
					 	onLoadSuccess:function(data){
					 		p.params = (data['rows']).shift();
					 		if(resetPageNumber){
					 			p.params.pagenumber = 1;
					 			resetPageNumber=0;
					 		}
					 		
					 		$('#tab').datagrid('deleteRow',0);
					 		page();
					 		
					 	}
					});
					
					function page(){
						$('#pp').pagination({
							total:p.params.total,
							pageSize:p.params.pagesize,
							pageNumber:p.params.pagenumber,
							pageList:[5,10,15],
							onSelectPage:reload,
							onChangePageSize:reload

					});

					}
					function reload(pageNumber, pageSize){
						p.params.pagenumber = pageNumber;
						p.params.pagesize = pageSize;
						$('#tab').datagrid('reload',p);
					}
				}
</script>