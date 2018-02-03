<?php
$this->display('admin/header');
?>
<body>
<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tbody>
		<tr>
		<td><h1 style="width:550px;">网校管理 -  网校列表</h1></td>
		<td class="actions">
			<table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
			<tbody><tr>
			<td class="active"><a href="/admin/classroom.html">浏览网校信息</a></td>
			<td><a href="/admin/classroom/add.html" class="add">添加网校</a></td>
			</tr>
			</tbody></table>
		</td>
		</tr>
	</tbody>
</table>
<form id="ck">
<!-- =================    -->
<table cellspacing="0" cellpadding="0" class="toptable"><tbody><tr><td>        
<select name="catid" id="catid">
        <option value="0">所有分类</option>
        <script>
//    $(function(){
//
//        $.post('/admin/common/getGategoriesList.html',
//                {where:'{"position":"1"}',checked:'',isad:''},
//                function(message){
//                 $("#catid").append(message);   
//                }
//            );
//    });
</script>        <option value="236">所有课件</option><option value="8">学前教育</option><option value="38">┣━智力教育</option><option value="275">┣━┣━脑力提升</option><option value="276">┣━┣━右脑开发</option><option value="277">┣━┣━思维导图</option><option value="278">┣━┣━思维能力</option><option value="279">┣━┣━想象力</option><option value="280">┣━┣━快速阅读</option><option value="281">┣━┣━灵感</option><option value="87">┣━习惯培养</option><option value="282">┣━┣━学习规律</option><option value="283">┣━┣━学习态度</option><option value="284">┣━┣━课前预习</option><option value="285">┣━┣━时间管理</option><option value="88">┣━运动能力</option><option value="286">┣━┣━学坐训练</option><option value="287">┣━┣━爬行训练</option><option value="288">┣━┣━弹跳运动</option><option value="89">┣━兴趣培养</option><option value="289">┣━┣━阅读</option><option value="290">┣━┣━音乐</option><option value="291">┣━┣━算数</option><option value="292">┣━┣━绘画</option><option value="90">┣━游戏玩具</option><option value="293">┣━┣━找动物</option><option value="294">┣━┣━找宝藏</option><option value="295">┣━┣━拼图</option><option value="296">┣━┣━找不同</option><option value="297">┣━语言能力</option><option value="298">┣━┣━语言复述</option><option value="299">┣━┣━场景提问</option><option value="300">┣━┣━学习复述句</option><option value="301">┣━┣━故事情节复述</option><option value="1">小学教育</option><option value="91">┣━语文</option><option value="92">┣━数学</option><option value="11">┣━英语</option><option value="13">┣━科学</option><option value="14">┣━思想品德</option><option value="15">┣━专题</option><option value="17">初中教育</option><option value="20">┣━语文</option><option value="22">┣━数学</option><option value="21">┣━英语</option><option value="233">┣━科学</option><option value="114">┣━政治</option><option value="113">┣━历史与社会</option><option value="112">┣━生物</option><option value="111">┣━化学</option><option value="110">┣━物理</option><option value="109">┣━地理</option><option value="115">┣━专题</option><option value="138">高中教育</option><option value="159">┣━语文</option><option value="160">┣━英语</option><option value="161">┣━数学</option><option value="162">┣━地理</option><option value="163">┣━物理</option><option value="164">┣━化学</option><option value="165">┣━生物</option><option value="166">┣━历史</option><option value="167">┣━政治</option><option value="168">┣━信息技术</option><option value="405">┣━通用技术</option><option value="410">┣━自选综合</option><option value="411">┣━专题</option><option value="4">大学教育</option><option value="169">┣━公共课</option><option value="170">┣━经济</option><option value="171">┣━管理</option><option value="172">┣━理学</option><option value="173">┣━工学</option><option value="174">┣━医学</option><option value="175">┣━法学</option><option value="176">┣━史学</option><option value="177">┣━文学</option><option value="178">┣━教育</option><option value="179">┣━哲学</option><option value="180">┣━农学</option><option value="181">┣━英语四六级</option><option value="182">┣━计算机等级考试</option><option value="5">成人教育</option><option value="186">┣━成人高考</option><option value="187">┣━┣━语文</option><option value="188">┣━┣━数学</option><option value="189">┣━┣━物理化学</option><option value="190">┣━┣━历史地理</option><option value="460">┣━┣━外语</option><option value="519">┣━考研</option><option value="523">┣━┣━政治</option><option value="524">┣━┣━数学</option><option value="525">┣━┣━英语</option><option value="526">┣━┣━专业课</option><option value="520">┣━MBA</option><option value="527">┣━┣━语逻</option><option value="528">┣━┣━数学</option><option value="529">┣━┣━英语</option><option value="521">┣━公务员考试</option><option value="530">┣━┣━行测</option><option value="531">┣━┣━申论</option><option value="532">┣━┣━面试</option><option value="522">┣━专升本</option><option value="533">┣━┣━语文</option><option value="534">┣━┣━数学</option><option value="535">┣━┣━英语</option><option value="536">┣━┣━政治</option><option value="537">┣━┣━专业课</option><option value="6">职业资格</option><option value="191">┣━财会类</option><option value="465">┣━┣━会计师培训</option><option value="466">┣━┣━理财会计师</option><option value="469">┣━┣━财务策划师</option><option value="471">┣━┣━理财规划师</option><option value="192">┣━公务员</option><option value="475">┣━┣━数量关系</option><option value="478">┣━┣━言语理解和表达</option><option value="481">┣━┣━资料分析</option><option value="483">┣━┣━判断推理</option><option value="487">┣━┣━常识判断</option><option value="490">┣━┣━申论</option><option value="193">┣━建筑类</option><option value="495">┣━┣━造价员培训</option><option value="498">┣━┣━施工员培训</option><option value="500">┣━┣━室内设计师</option><option value="501">┣━┣━质量资格</option><option value="502">┣━┣━项目管理</option><option value="194">┣━医药类</option><option value="503">┣━┣━健康管理师</option><option value="504">┣━┣━营养师</option><option value="505">┣━┣━医疗救护师</option><option value="506">┣━┣━康复保健师</option><option value="507">┣━┣━医药营销师</option><option value="508">┣━┣━药剂师</option><option value="195">┣━计算机类</option><option value="509">┣━┣━信息系统项目管理师</option><option value="510">┣━┣━系统分析师</option><option value="511">┣━┣━软件设计师</option><option value="513">┣━┣━系统架构设计师</option><option value="512">┣━┣━网络工程师</option><option value="514">┣━┣━嵌入式系统设计师</option><option value="515">┣━┣━电子商务设计师</option><option value="196">┣━外贸类</option><option value="516">┣━┣━货运代理人</option><option value="517">┣━┣━外贸跟单员</option><option value="518">┣━┣━商务跟单员</option><option value="7">技能培训</option><option value="202">┣━机械电器</option><option value="203">┣━┣━机械常识</option><option value="204">┣━┣━钳工培训</option><option value="205">┣━┣━金相检验</option><option value="206">┣━┣━材料成分检验</option><option value="207">┣━┣━化学检验</option><option value="208">┣━┣━无损检测</option><option value="209">┣━┣━电工</option><option value="313">┣━┣━电焊工</option><option value="322">┣━服装培训</option><option value="323">┣━┣━服装设计师</option><option value="325">┣━┣━服装打版样码</option><option value="327">┣━┣━服装电脑设计</option><option value="330">┣━┣━服装纸样打版</option><option value="333">┣━专业维修</option><option value="335">┣━┣━手机维修</option><option value="338">┣━┣━电脑主板维修</option><option value="340">┣━┣━汽车维修</option><option value="342">┣━┣━打印机维修</option><option value="210">┣━数控和模具</option><option value="316">┣━┣━PLC编程+触摸</option><option value="317">┣━┣━UG模具设计</option><option value="318">┣━┣━工业产品手绘</option><option value="319">┣━┣━CAM、PRO/E</option><option value="343">┣━美容美发</option><option value="344">┣━┣━按摩师</option><option value="345">┣━┣━美容师</option><option value="347">┣━┣━化妆师</option><option value="356">┣━┣━美发</option><option value="357">┣━┣━专业晚装</option><option value="211">┣━烹饪</option><option value="212">┣━┣━中式烹调</option><option value="213">┣━┣━西式面点</option><option value="214">┣━┣━调酒师</option><option value="215">┣━┣━烧腊</option><option value="216">┣━┣━西式烹调</option><option value="365">┣━建筑设计</option><option value="372">┣━┣━建筑渲染</option><option value="374">┣━┣━建筑手绘</option><option value="377">┣━┣━建筑模型</option><option value="380">┣━┣━3D建筑表现</option><option value="366">┣━摄影</option><option value="383">┣━┣━旅游风景摄影</option><option value="386">┣━┣━大众摄影</option><option value="389">┣━┣━广告摄影</option><option value="392">┣━┣━摄影数码后期</option><option value="368">┣━IT培训</option><option value="394">┣━┣━JAVA/J2EE工程师</option><option value="398">┣━┣━软件测试工程师</option><option value="400">┣━┣━嵌入式工程师</option><option value="402">┣━┣━3G-Android</option><option value="406">┣━┣━Oracle培训</option><option value="409">┣━┣━PHP培训</option><option value="304">语言学习</option><option value="412">┣━汉语</option><option value="492">┣━┣━汉语水平考试</option><option value="496">┣━┣━国家职业汉语能力测试</option><option value="497">┣━┣━古汉语等级考试</option><option value="499">┣━┣━普通话考试</option><option value="414">┣━阿拉伯语</option><option value="476">┣━┣━阿拉伯语二级</option><option value="480">┣━┣━三级笔译</option><option value="482">┣━┣━口译</option><option value="485">┣━┣━交替传译</option><option value="415">┣━英语</option><option value="456">┣━┣━少儿英语</option><option value="459">┣━┣━商务英语</option><option value="461">┣━┣━托福雅思</option><option value="464">┣━┣━口语</option><option value="468">┣━┣━剑桥英语</option><option value="470">┣━┣━学术能力评估测试</option><option value="473">┣━┣━大学英语等级测试</option><option value="416">┣━法语</option><option value="450">┣━┣━TEF</option><option value="454">┣━┣━TCF</option><option value="417">┣━俄语</option><option value="441">┣━┣━基础级水平考试</option><option value="443">┣━┣━俄语初级考试</option><option value="445">┣━┣━俄语１—４级水平考试</option><option value="420">┣━西班牙语</option><option value="439">┣━┣━西班牙语等级考试</option><option value="423">┣━日语</option><option value="435">┣━┣━日语等级考试</option><option value="426">┣━韩语</option><option value="428">┣━┣━国际商务韩语等级考试</option><option value="432">┣━┣━商务韩语水平等级考试</option><option value="305">企业管理</option><option value="324">┣━采购管理</option><option value="346">┣━┣━供应商管理</option><option value="348">┣━┣━采购谈判</option><option value="349">┣━┣━采购成本降低</option><option value="350">┣━┣━供应链管理</option><option value="351">┣━┣━物料控制</option><option value="352">┣━┣━物流管理</option><option value="353">┣━┣━供应商选择</option><option value="354">┣━┣━供应商考核</option><option value="355">┣━┣━库存控制</option><option value="326">┣━市场营销</option><option value="358">┣━┣━销售管理</option><option value="359">┣━┣━团队建设</option><option value="360">┣━┣━销售技能</option><option value="361">┣━┣━大客户营销</option><option value="362">┣━┣━外贸操作</option><option value="363">┣━┣━商务谈判</option><option value="364">┣━┣━门店连锁</option><option value="328">┣━人力资源</option><option value="367">┣━┣━薪酬设计</option><option value="369">┣━┣━绩效管理</option><option value="370">┣━┣━招聘面试</option><option value="371">┣━┣━行政工作管理</option><option value="373">┣━┣━人力资源管理</option><option value="375">┣━┣━培训体系管理</option><option value="376">┣━┣━金融危机</option><option value="378">┣━┣━劳动合同法</option><option value="379">┣━┣━职业规划</option><option value="329">┣━生产管理</option><option value="381">┣━┣━品质管理</option><option value="382">┣━┣━精益生产</option><option value="384">┣━┣━研发管理</option><option value="385">┣━┣━车间管理</option><option value="387">┣━┣━项目管理</option><option value="388">┣━┣━产品管理</option><option value="390">┣━┣━IE工业工程</option><option value="391">┣━┣━成本管理</option><option value="393">┣━┣━生产计划与物料管理</option><option value="395">┣━┣━现场管理</option><option value="396">┣━┣━管理技能</option><option value="397">┣━┣━班组管理</option><option value="399">┣━┣━生产维护</option><option value="401">┣━┣━注塑管理</option><option value="403">┣━┣━工厂安全</option><option value="404">┣━┣━质量管理</option><option value="407">┣━┣━ISO系列</option><option value="408">┣━┣━六西格玛</option><option value="331">┣━管理技能</option><option value="418">┣━┣━领导力</option><option value="413">┣━┣━领导技能</option><option value="419">┣━┣━沟通艺术</option><option value="421">┣━┣━赏识管理</option><option value="422">┣━┣━中层管理</option><option value="424">┣━┣━执行力</option><option value="425">┣━┣━细节管理</option><option value="427">┣━┣━企业文化</option><option value="429">┣━┣━流程管理</option><option value="430">┣━┣━授权管理</option><option value="431">┣━┣━公司治理</option><option value="332">┣━职业素质</option><option value="433">┣━┣━商务礼仪</option><option value="434">┣━┣━职业技能</option><option value="436">┣━┣━职业心态</option><option value="437">┣━┣━沟通技能</option><option value="438">┣━┣━职业修养</option><option value="334">┣━销售管理</option><option value="440">┣━┣━电话营销</option><option value="442">┣━┣━客户管理</option><option value="444">┣━┣━销售过程管理</option><option value="446">┣━┣━区域市场管理</option><option value="447">┣━┣━呼叫中心</option><option value="336">┣━客户服务</option><option value="448">┣━┣━团队建设</option><option value="449">┣━┣━客服技能提升</option><option value="451">┣━┣━共赢服务</option><option value="452">┣━┣━投诉处理技巧</option><option value="453">┣━┣━客户忠诚度</option><option value="337">┣━账务管理</option><option value="455">┣━┣━风险管理</option><option value="457">┣━┣━现金管理</option><option value="458">┣━┣━报表分析</option><option value="462">┣━┣━税务筹划</option><option value="463">┣━┣━预算管理</option><option value="467">┣━┣━非财务人员培训</option><option value="339">┣━项目管理</option><option value="472">┣━┣━项目管理流程</option><option value="474">┣━┣━项目风险管理</option><option value="477">┣━┣━项目团队建设</option><option value="479">┣━┣━项目商务与合同制定</option><option value="341">┣━战略管理</option><option value="484">┣━┣━战略规划</option><option value="486">┣━┣━品牌战略</option><option value="488">┣━┣━企业定位</option><option value="489">┣━┣━危机管理</option><option value="491">┣━┣━就按管控</option><option value="493">┣━┣━竞争策略</option><option value="494">┣━┣━资本运营</option><option value="306">生活百科</option><option value="307">┣━饮食健康</option><option value="308">┣━化妆服饰</option><option value="309">┣━运动户外</option><option value="310">┣━电脑网络</option><option value="311">┣━安全急救</option><option value="312">┣━保健养生</option><option value="314">┣━社交礼仪</option><option value="315">┣━家居日用</option><option value="320">┣━孕婴知识</option><option value="321">┣━其他</option><option value="637">┣━┣━专题</option></select>&nbsp;&nbsp;<label>关键字: <input type="text" name="q" id="searchkey" value="" size="20">
</label>
<label>&nbsp;&nbsp;是否存在电视版：
<select name="hastv">
    <option value="">全部</option>
    <option value="1">存在</option>
    <option value="0">不存在</option>
</select>
</label>
<label>&nbsp;&nbsp;学校类型：
<select name="ctype">
    <option value="">全部</option>
    <option value="0">默认网校</option>
    <option value="1">新注册的普通网校</option>
    <option value="2">新注册的分成网校</option>
</select>
</label>
&nbsp;&nbsp;

<input type="submit" name="selectsubmit" onclick="return _search()" value="查询" class="submit">
</td></tr>
</tbody></table>
<!-- ========================= -->

</form>
<script type="text/javascript">
    function _render(_data){
        $(".moduletbody").html('');
        $.each($(_data),function(k,v){
            $(_renderRow(k,v)).appendTo(".moduletbody");
        });
    }

    var ctype = {'0':'默认网校','1':'新注册普通网校','2':'新注册分成网校'};
    function _renderRow(k,v){
        var row = ['<tr class="tr_module_">'];
        row.push('<th class="sn">'+(k+1)+'</th>');
        row.push('<td class="sn"><input type="checkbox" name="item[]" value="'+v.crid+'" /></td>');
        var url = 'http://'+(v.domain||'www')+'.ebh.net';
        row.push('<td class="crname"><a target="_blank" href="'+url+'">'+v.crname+'</a></td>');
        row.push('<td class="realname">'+v.username+' [ '+(v.realname||v.nickname)+' ]'+'</td>');
        row.push('<td class="domain">'+v.domain+'</td>');
        row.push('<td class="ctype">'+(ctype[v.ctype]||'')+'</td>');
        row.push('<td class="maxnum">'+(v.maxnum || "")+'</td>');
        row.push('<td class="begindate">'+((v.begindate && getformatdate(v.begindate).substr(0,10)) || "" )+'</td>');
        row.push('<td class="enddate">'+((v.enddate && getformatdate(v.enddate).substr(0,10)) || "")+'</td>');
        if(v.status==1){
        	row.push('<td class="status">正常</td>');
        }else{
        	row.push('<td class="status">锁定</td>');
        }
        row.push('<td class="displayorder"><input type="input" width="30" name="displayorder[]" value="'+v.displayorder+'" /></td>');
        row.push('<td class="nowrap" >');
        if(v.upid==0){
            row.push('[<a href="/admin/classroom/add.html?crid='+v.crid+'">添加子网校</a>]');
        }
        if(v.status==1){
        	row.push('[<a href="/admin/classroom/view.html?crid='+v.crid+'">详情</a>] [<a href="/admin/classroom/edit.html?crid='+v.crid+'">编辑</a>] [<a href="#" onclick="return destroy('+v.crid+');">删除</a>] [<a href="#" onclick="return changestatus('+v.crid+',0)">锁定</a>]&nbsp;</td>');
        }else{
        	row.push('[<a href="/admin/classroom/view.html?crid='+v.crid+'">详情</a>] [<a href="/admin/classroom/edit.html?crid='+v.crid+'">编辑</a>] [<a href="#" onclick="return destroy('+v.crid+');">删除</a>] [<a href="#" onclick="return changestatus('+v.crid+',1)">解锁</a>]&nbsp;</td>');
        }
        
        row.push('</tr>');
        return row.join('');
    }
</script>
<table cellspacing="0" cellpadding="0" width="100%"  class="listtable">
<tr>
<th>序号</th>
<th>选择</th>
<th fieldname="i.crname">网校名</th>
<th fieldname="i.nickname">教师名</th>
<th fieldname="i.domain">域名</th>
<th filedname="i.ctype">网校类型</th>
<th fieldname="i.maxnum" width="10%">网校容量</th>
<th fieldname="i.begindate" width="10%">开始时间</th>
<th fieldname="i.enddate" width="10%">结束时间</th>
<th fieldname="i.status" width="5%">状态</th>
<th fieldname="i.displayorder" width="5%">排序</th>
<th>操作</th>
</tr>
<tbody class="moduletbody">

</tbody>
</table>

<table cellspacing="0" cellpadding="0" width="100%" class="btmtable">
<tbody><tr><th width="12%">批量操作</th><th>
<input id="chkall" type="checkbox" name="chkall"><label for="chkall">全选</label>
<input id="noop" name="optype" type="radio" value="0" checked=""><label for="noop">不操作</label>
</th></tr>
</tbody></table>
<div id="pp"></div>
<div class="buttons">
<input type="submit" name="crsubmit" value="提交保存" class="submit">
<input type="reset" name="listreset" value="重置">
</div>
<script type="text/javascript">
$(function(){
    // $(".pagination-page-list").trigger('change');
	$(".pagination").hide();
});
function _search(){
	if($.trim($("#searchkey").val()) == "") {
		alert("请输入网校名称或者域名进行查询。");
		return false;
	}
   $('#pp').pagination({pageNumber:1});
   $(".pagination-page-list").trigger('change');
   return false;
}
$('#pp').pagination({
    pageSize:50,
    onSelectPage:function(pageNumber, pageSize){
        var query = $('#ck').serialize();
        $.post("/admin/classroom/getListAjax.html",
            {query:query,pageNumber:pageNumber,pageSize:pageSize},
            function(message){
                message = JSON.parse(message);
                $('#pp').pagination('refresh',message.shift());
                 _render(message);
                $(".pagination-num").parent().next().html('<span style="padding-right:6px;">页</span>');
				$(".pagination-last").hide();
                $(".pagination-info").hide();
            }
            );
        return false;
    }
});
function destroy(crid){
    if (crid){
        $.messager.confirm('确认','确定要删除该网校么？',function(r){
            if (r){
                $.post('/admin/classroom/del.html',{crid:crid},function(result){
                    if (result.success){
						$.messager.show({ 
							timeout:2000,
                            title: '成功',
                            msg: '删除成功'
                        });
						$('.pagination-page-list').trigger('change');
                    } else {
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                           });
                       }
                        },'json');
            }
        });
    }
    return false;
}
		
function dosearch(){
	$.get('<?php echo geturl('admin/classroom/getlist');?>',{'param[q]':$("#search-input").val()},function(data){
		var data = eval(data);
		data.pop();
		_render(data);
	}
	);
}
function changestatus(crid,status){
    if (crid){
        $.post('<?php echo geturl('admin/classroom/editclassroom');?>',
			{crid:crid,status:status},
			function(result){
                    if (result>0){
					
                       $('.pagination-page-list').trigger('change');
                    } else {
                        $.messager.show({    // show error message
                            title: 'Error',
                            msg: result
                        });
                    }
            });
    }
    return false;
}
$("#chkall").click(function(){
    $("input[name='item[]']").prop('checked',$("#chkall").prop('checked'));
});
</script>
    
</body>
<?php
$this->display('admin/footer');
?>