<?php
/**
 * 题库控制器
 */
class QuestionController extends CControl{
	protected $data;
    public function __construct() {
        parent::__construct();
        $user = Ebh::app()->user->getloginuser();
        $this->assign('user',$user);
    }
	
    //资源库首页
	public function index() {
		$grade_type = $this->uri->uri_attr(0);
		$grade_id = $this->uri->uri_attr(1);
		$grade_type = empty($grade_type) ? 1 : intval($grade_type);//默认值为小学
		$grade_id = empty($grade_id) ? 0 : intval($grade_id);//默认值为所有年级		

		if (!empty($grade_id))
		{
			$grade_info = $this->model('question')->getOneGrade($grade_id);
			if(empty($grade_info))
			{
				show_404();exit;
			}
			$grade_type = $grade_info['gradetype'];
		}
		
		$this->data['gradetypeList'] = $this->model('question')->getGradeTypeList();//获取年级类型列表(小学|初中|高中)
		if (in_array($grade_type, array_keys($this->data['gradetypeList'])))
		{
			$topNodeName = $this->data['gradetypeList'][$grade_type]['gradetypename'] . '试题';
			$firstGradeId = $this->model('question')->getFirstGradeId($grade_type);
			$defaultMainframeUrl = '/freeresource/question/showlist-1-0-0-0-0-' . $firstGradeId . '-0.html';//Mainframe默认URL
		}
		else
		{
			$topNodeName = '';
			$defaultMainframeUrl = '';
		}
		
		
		//面包屑导航
		$navStr = '<a href="/freeresource.html">免费资源</a> > <a href="/freeresource.html">题库</a> > ' . $topNodeName;

		//获取节点数组
		$node_list = array();
		$grade_list = $this->model('question')->getGradeList($grade_type, $grade_id);
		$subject_list = $this->model('question')->getSubjectList($grade_type);
		$node_list = $this->getInitialNodeList($grade_list, $subject_list);	
		$zNodes = $this->arrayToSimpleJson($node_list);

		//设置seo标题关键字描述
		$seoInfo['title'] = $topNodeName . ' 题库 免费资源 - e板会';
		$seoInfo['keyword'] = $topNodeName . ',免费题库,试题浏览,免费资源';
		$seoInfo['description'] = 'e板会' . $topNodeName . '库提供' . implode('、', array_reduce($subject_list, create_function('$v,$w', '$v[]=$w["subjectname"];return $v;'))) . '等学科的试题浏览。';
		$this->assign('seoInfo', $seoInfo);
		
		$this->assign('zNodes', $zNodes);
		$this->assign('navStr',$navStr);
		$this->assign('topNodeName', $topNodeName);
		$this->assign('defaultMainframeUrl', $defaultMainframeUrl);
		$this->display('freeresource/question_index');
	}
	
	//显示题目列表,url为showlist-1-0-0-知识点-类型-年级-学科
	public function showlist() {
		$knowledgepoint_id = intval($this->uri->uri_attr(0));//知识点
		$type_id = $this->uri->uri_attr(1); //类型
		$grade_id = $this->uri->uri_attr(2); //年级
		$subject_id = $this->uri->uri_attr(3); //学科
				
		$type_id = empty($type_id) ? 0 : intval($type_id);		
		$grade_id = empty($grade_id) ? 0 : intval($grade_id);		
		$subject_id = empty($subject_id) ? 0 : intval($subject_id);
		
		if (!empty($knowledgepoint_id))
		{
			$knowledgepoint_info = $this->model('question')->getOneKnowledgePoint($knowledgepoint_id);
			$grade_id = $knowledgepoint_info['gradeid'];
			$subject_id = $knowledgepoint_info['subjectid'];
		}		
		
		//分页
		$param = parsequery();
		$param['pagesize'] = 5;
		$offset = max(0, $param['pagesize'] * ($param['page'] - 1));
		$param['limit'] = $offset . ',' . $param['pagesize'];
		$param['knowledgepointid'] = $knowledgepoint_id;
		$param['typeid'] = $type_id;
		$param['gradeid'] = $grade_id;
		$param['subjectid'] = $subject_id;
		
		$questionList = $this->model('question')->getList($param);
		$count = $this->model('question')->getListCountCached($param);
		$pageStr = show_page($count, 5);
		//格式化问题列表
		$questionList = $this->formatQuestionList($questionList, $grade_id);
		
		//生产类型html字符串		
		$top_str = '';
		if (!empty($grade_id) && !empty($subject_id)){
			$top_str = '分类：';
			$question_type_list = $this->model('question')->getQuestionTypeList($grade_id, $subject_id);
			if (!empty($question_type_list) && is_array($question_type_list))
			{
				$top_str .= '<a';
				$top_str .= ($type_id == 0) ? ' class="margle_cur"' : ' class="margle"';
				$top_str .= ' href="/freeresource/question/showlist-1-0-0-' . $knowledgepoint_id . '-0-' . $grade_id . '-' . $subject_id . '.html">全部</a> ';
				foreach ($question_type_list as $value)
				{
					$top_str .= '<a';
					if ($value['questiontypeid'] == $type_id)
					{
						$top_str .= ' class="margle_cur"';
					}
					else
					{
						$top_str .= ' class="margle"';
					}					
					$top_str .= ' href="/freeresource/question/showlist-1-0-0-' . $knowledgepoint_id . '-' . $value['questiontypeid'] . '-' . $grade_id . '-' . $subject_id . '.html">' . $value['title'] . '</a> ';			
				}
			}
		}
		$top_str .= '总计' . $count . '道试题';
		
		//是否显示搜索输入框
		$showSearchInput = empty($knowledgepoint_id) ? false : true;
		
		//设置搜索url，搜索后显示结果第一页
		$searchPath = '/' . $this->uri->codepath .'-1-0-0-' . $knowledgepoint_id . '-' . $type_id . '-' . $grade_id . '-' . $subject_id .'.html';	
		
		//设置seo标题关键字描述
		$seoInfo['title'] = '题库 免费资源 - e板会';
		$seoInfo['keyword'] = '试题,题库,免费资源';
		$seoInfo['description'] = 'e板会题库提供小学、初中、高中试题浏览。';
		$this->assign('seoInfo', $seoInfo);

		$this->assign('q', $param['q']);
		$this->assign('searchPath', $searchPath);
		$this->assign('topStr', $top_str);
		$this->assign('showSearchInput', $showSearchInput);
		$this->assign('pageStr', $pageStr);
		$this->assign('questionList',$questionList);
		$this->display('freeresource/question_showlist');
	}
	
	
	//AJAX返回节点信息,只获取知识点这一级
	public function getnodes() {
	    $grade_id = $this->input->post('gradeId');
	    $subject_id = $this->input->post('subjectId');
		$grade_id = empty($grade_id) ? 0 : intval(str_replace('grade_', '', $grade_id));
		$subject_id = empty($subject_id) ? 0 : intval(str_replace('subject_', '', $subject_id));

		//获取节点数组
		
		//先从缓存读取
		$redis = Ebh::app()->getCache('cache_redis');
		$redis_key = 'grade:' . $grade_id . ':subject:' . $subject_id;
		$simple_json = $redis->hget('questionnodelist', $redis_key);
		//没有缓存则从数据库读取
		if(empty($simple_json))
		{
			$knowledgepoint_list = $this->model('question')->getKnowledgepointList($grade_id, $subject_id);
			$node_list = $this->formatToNodeList($knowledgepoint_list);		
			$simple_json = $this->arrayToSimpleJson($node_list);
			//写入缓存
			$redis->hset('questionnodelist', $redis_key, $simple_json);
		}
		echo $simple_json;
	}
	
	//获得初始zTree节点列表
	public function getInitialNodeList($grade_list, $subject_list) {
		$node_list = array();
		if(!empty($grade_list) && is_array($grade_list))
		{
			foreach ($grade_list as $grade)
			{				
				$node_list[] = array(
					'id' => 'grade_' . $grade['gradeid'],
					'pId' =>  0,
					'name' => $grade['gradename'],
					'level' => 0,
					'isParent' => true,
					'url' => '/freeresource/question/showlist-1-0-0-0-0-' . $grade['gradeid'] . '-0.html',
					'target' => 'mainFrame',
				);
				if(!empty($subject_list) && is_array($subject_list))
				{
					foreach ($subject_list as $subject)
					{
						$node_list[] = array(
						'id' => 'subject_' . $subject['subjectid'],
						'pId' =>  'grade_' . $grade['gradeid'],
						'name' => $subject['subjectname'],
						'level' => 1,
						'isParent' => true,
						'url' => '/freeresource/question/showlist-1-0-0-0-0-'  . $grade['gradeid'] . '-' . $subject['subjectid'] . '.html',
						'target' => 'mainFrame',
						);
					}
				}
			}		
		}
		return $node_list;
	}
	
	// 转换成zTree节点列表
	public function formatToNodeList($knowledgepoint_list)
	{
		$node_list = array();
		if(!empty($knowledgepoint_list) && is_array($knowledgepoint_list))
		{
			foreach($knowledgepoint_list as $value)
			{
				if (empty($value['has_child']))
				{
					$value['isParent'] = false;
				}
				else
				{
					$value['isParent'] = true;
				}
				$node_list[] = array(
					'id' => 'know_' . $value['knowledgepointid'],
					'name' => $value['title'],
					'level' => 2,
					'isParent' => false,
					'url' => '/freeresource/question/showlist-1-0-0-' . $value['knowledgepointid'] . '-0.html',
					'target' => 'mainFrame',
				);
			}
		}
		return $node_list;
		
	}
	
	//输出zTree树的simplejson格式
	public function arrayToSimpleJson($arr) {
		$simpleJson = array();
		foreach($arr as $value)
		{
			$simpleJson[] = is_array($value) ? (object)$value : $value;
		}
		return json_encode($simpleJson);
	}

	//格式化问题列表
	public function formatQuestionList($questionList, $grade_id) {
		$_UP = Ebh::app()->getConfig()->load('upconfig');
		$imgpath = $_UP['hjexam']['showpath'];
		//年级信息
		$grade_info = $this->model('question')->getOneGrade($grade_id);
		//知识点信息
		$knowledgepoint_id_array= $this->getArrayColumn($questionList, 'knowledgepointid');
		$knowledgepoint_array = $this->model('question')->getKnowledgeArray($knowledgepoint_id_array);
		//学科信息
		$subject_array = $this->model('question')->getSubjectArray();
		//问题类型
		$questiontype_id_array= $this->getArrayColumn($questionList, 'typeid');
		$questiontype_array = $this->model('question')->getQuestionTypeArray($questiontype_id_array);
		
		//开始格式化
		foreach ($questionList as $key => $value)
		{
			$questionList[$key]['knowledgepoint']	= $knowledgepoint_array[$value['knowledgepointid']];
			$questionList[$key]['gradename']		= $grade_info['gradename'];
			$questionList[$key]['subjectname']		= $subject_array[$value['subjectid']];
			$questionList[$key]['questiontype']		= $questiontype_array[$value['typeid']];
			$questionList[$key]['question']			= preg_replace('/(<img[^>]+src=\"?)(\/webschool\/st\/)([^>]+\"?[^>]+>)?/i', "\\1$imgpath\\3", $questionList[$key]['question']);
			$questionList[$key]['analysis']			= preg_replace('/(<img[^>]+src=\"?)(\/webschool\/st\/)([^>]+\"?[^>]+>)?/i', "\\1$imgpath\\3", $questionList[$key]['analysis']);
		}	
		return $questionList;
	}
	
	//返回数组中指定的一列
	public function getArrayColumn($input, $column_key=null) {
		$result = array();
		if(!empty($input) && is_array($input) &&(!is_null($column_key)))
		{
			foreach ($input as $value)
			{
				$result[] = isset($value[$column_key]) ? $value[$column_key] : null;
			}
		}
		return array_unique($result);
	}
}
