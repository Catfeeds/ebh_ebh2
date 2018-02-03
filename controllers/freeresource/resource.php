<?php
/**
 * 资源库控制器
 */
class ResourceController extends CControl{
	protected $data;
    public function __construct() {
        parent::__construct();
        $user = Ebh::app()->user->getloginuser();
        $this->assign('user',$user);
		$this->_init();
    }
	
	public function _init() {
		$this->data['restypeList'] = $this->model('resource')->getrestypeList();//获取资源类型列表
	}
	
    //资源库首页
	public function index() {
		$version_id = $this->uri->uri_attr(0);
		$version_id = empty($version_id) ? 14 : intval($version_id);
		if(!empty($version_id))
		{
		    $version_info = $this->model('resource')->getOneByVersionid($version_id);
			if(empty($version_info))
			{
				show_404();exit;
			}
		}
		
		//面包屑导航
		$navStr = '<a href="/freeresource.html">免费资源</a> > <a href="/freeresource.html">资源库</a> > ' . $version_info['version_name'];
		
		//获取节点数组
		$node_list = array();
		$tree_list = $this->model('resource')->getTreeList($version_id);
		$node_list = $this->formatToNodeList($tree_list);		
		$zNodes = $this->arrayToSimpleJson($node_list);
		
		//设置seo标题关键字描述
		$seoInfo['title'] = $version_info['version_name'] . ' 资源库 免费资源 - e板会';
		$seoInfo['keyword'] = '教学资源,免费课件,教学学案,学习资源,教学视频';
		$tree_name_list = array_reduce($tree_list, create_function('$v,$w', '$v[]=$w["name"];return $v;'));
		$seoInfo['description'] = 'e板会' . $version_info['version_name'] . '免费资源库提'. implode('、', $tree_name_list) .'等相关资源下载。';		
		$this->assign('seoInfo', $seoInfo);
		
		$this->assign('zNodes', $zNodes);
		$this->assign('navStr',$navStr);
		$this->assign('versionInfo', $version_info);
		$this->display('freeresource/resource_index');
	}
	
	//资源列表
    public function showlist() {
		$version_id = intval($this->uri->uri_attr(0));//版本号
		$subject_id = $this->uri->uri_attr(1);//学科ID（string类型，不要转成整形）
		$ext_type = $this->uri->uri_attr(2); //文件后缀类型

		if(!empty($version_id))
		{
		    $version_info = $this->model('resource')->getOneByVersionid($version_id);
			if(empty($version_info))
			{
				show_404();exit;
			}
		}
		
		// 分页
		$param = parsequery();
		$offset = max(0, $param['pagesize'] * ($param['page'] - 1));
		$param['limit'] = $offset . ',' . $param['pagesize'];
		$param['resversionid'] = $version_id;
		$param['ressubjectid'] = $subject_id;
		$param['exttype'] = $ext_type;
		
		$resourceList = $this->model('resource')->getListCached($param);
		foreach ($resourceList as $key => $value)
		{
			//从缓存更新viewnum
			$viewnum = Ebh::app()->lib('Viewnum')->getViewnum('resource', $value['resid']);
			if(!empty($viewnum))
			{
				$resourceList[$key]['viewnum'] = $viewnum;
			}
			//从缓存更新downloadnum
			$downloadnum = $this->model('resource')->getDownloadNumCache($value['resid']);
			if(!empty($downloadnum))
			{
				$resourceList[$key]['downloadnum'] = $downloadnum;
			}
		}
		
		$count = $this->model('resource')->getListCountCached($param);
		$pageStr = show_page($count, 20);
		
		//是否显示搜索输入框
		$showSearchInput = empty($subject_id) ? false : true;
		
		//设置搜索url，搜索后显示结果第一页
		$searchPath = '/' . $this->uri->codepath .'-1-0-0-' . $version_id . '-' . $subject_id . '-' . $ext_type . '.html';

		//设置seo标题关键字描述
		$seoInfo['title'] = $version_info['version_name'] . ' 资源库 免费资源 - e板会';
		$seoInfo['keyword'] = $version_info['version_name'] . ',资源下载,免费资源';
		$seoInfo['description'] = $version_info['version_name'] . '资源下载';
		$this->assign('seoInfo', $seoInfo);
		
		//当统计该版教材下的总数时，直接从version表的count字段获取
		if (!empty($version_id) && empty($subject_id) && empty($ext_type))
		{
			$count = $version_info['resource_count'];
		}
		
		$this->assign('q', $param['q']);
		$this->assign('searchPath', $searchPath);
		$this->assign('topStr', $this->getTopStr($version_id, $subject_id, $count, $ext_type));
		$this->assign('showSearchInput', $showSearchInput);
		$this->assign('offset', $offset);
		$this->assign('pageStr', $pageStr);
		$this->assign('resourceList',$resourceList);
		$this->display('freeresource/resource_showlist');
	}
	
	//资源详情
	public function view() {
		$resid = $this->uri->itemid;
		$resource = $this->model('resource')->getOneByResid($resid);		
		if(empty($resource)){
			show_404();
			exit;
		}

		$resource = $this->formatResource($resource);
		
		//浏览数加1
		Ebh::app()->lib('Viewnum')->addViewnum('resource', $resid);
		$viewnum = Ebh::app()->lib('Viewnum')->getViewnum('resource', $resid);
		if(!empty($viewnum))
		{
			$resource['viewnum'] = $viewnum;
		}
		//从缓存更新下载计数
		$downloadnum = $this->model('resource')->getDownloadNumCache($resid);
		if(!empty($downloadnum))
		{
			$resource['downloadnum'] = $downloadnum;
		}
		
		//设置seo标题关键字描述
		$seoInfo['title'] = $resource['title'] . ' - e板会';
		$seoInfo['keyword'] = $resource['title'] . ',' . $resource['restype'] . ',资源库,免费资源';
		$seoInfo['description'] = $resource['title'] . '资源下载';
		$this->assign('seoInfo', $seoInfo);

		$this->assign('hasPreview', $this->hasPreview($resource['resurl']));		
		$this->assign('resource', $resource);
		$this->display('freeresource/resource_view');		
	}
	
	//AJAX返回节点信息
	public function getnodes() {
	    $version_id = intval($this->input->post('versionId'));
	    $parent_id = $this->input->post('id');
	    $tree_deep = intval($this->input->post('lv')) + 1;
		if(!empty($version_id))
		{
		    $version_info = $this->model('resource')->getOneByVersionid($version_id);
			if(empty($version_info))
			{
				echo 'versionId is not valid!';
				exit;
			}
		}
		
		//获取节点数组
		$tree_list = $this->model('resource')->getTreeList($version_id, $tree_deep, $parent_id);
		$node_list = $this->formatToNodeList($tree_list);		
		echo $this->arrayToSimpleJson($node_list);
		
	}
	
	//转换成zTree节点列表
	public function formatToNodeList($tree_list) {
		$node_list = array();
		if(!empty($tree_list) && is_array($tree_list))
		{
			foreach($tree_list as $value)
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
					'id' => $value['tree_id'],
					'name' => $value['name'],
					'level' => $value['tree_deep'],
					'isParent' => $value['isParent'],
					'url' => '/freeresource/resource/showlist-1-0-0-' . $value['version_id'] . '-' . $value['tree_id'] . '-0.html',
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
		
	//列表页顶部信息
	public function getTopStr($versionId, $subjectId, $count, $ext_type=0)
	{	
		$str = '分类：';
		$str .= '<a' . $this->getTopStrStyle($ext_type, 0) . ' href="/freeresource/resource/showlist-1-0-0-' . $versionId .'-' . $subjectId .'-' . '0.html">全部</a> ';
		$str .= '<a' . $this->getTopStrStyle($ext_type, 1) . ' href="/freeresource/resource/showlist-1-0-0-' . $versionId .'-' . $subjectId .'-' . '1.html">课件</a> ';
		$str .= '<a' . $this->getTopStrStyle($ext_type, 2) . ' href="/freeresource/resource/showlist-1-0-0-' . $versionId .'-' . $subjectId .'-' . '2.html">教案学案</a> ';
		$str .= '<a' . $this->getTopStrStyle($ext_type, 3) . ' href="/freeresource/resource/showlist-1-0-0-' . $versionId .'-' . $subjectId .'-' . '3.html">动画</a> ';
		$str .= '<a' . $this->getTopStrStyle($ext_type, 4) . ' href="/freeresource/resource/showlist-1-0-0-' . $versionId .'-' . $subjectId .'-' . '4.html">图片</a> ';
		$str .= '<a' . $this->getTopStrStyle($ext_type, 5) . ' href="/freeresource/resource/showlist-1-0-0-' . $versionId .'-' . $subjectId .'-' . '5.html">视频音频</a> ';
		$str .= '<a' . $this->getTopStrStyle($ext_type, 6) . ' href="/freeresource/resource/showlist-1-0-0-' . $versionId .'-' . $subjectId .'-' . '6.html">其他</a> ';
		$str .= '总计' . $count .'个资源';
		return $str;	
	}
	
	public function getTopStrStyle($ext_type, $compare)
	{
		return ($ext_type == $compare) ? ' class="margle_cur"' : ' class="margle"';		
	}	
	//格式化资源
	public function formatResource($resource) {		

		$resource['date'] = date("m-d H:i", $resource['dateline']);
		
		if (!empty($resource['resusertype']))
		{
			$usertype_array = explode('|', $resource['resusertype']);
			foreach ($usertype_array as $key => $value)
			{
				switch ($value)
				{
					case 1:
						$usertype_array[$key] = '教师';
						break;
					case 2:
						$usertype_array[$key] = '学生';
						break;
					case 3:
						$usertype_array[$key] = '家长';
						break;
					default:
						$usertype_array[$key] = '';
				}
			}
			$resource['usertype'] = implode('、', $usertype_array);
		}
		else
		{
			$resource['usertype'] = '';
		}
		
		if (!empty($resource['restypeid']))
		{
			$restype_array = explode('|', $resource['restypeid']);
			foreach ($restype_array as $key =>$value)
			{
				if (!empty($restype_array[$key]))
				{
					$restype_array[$key] = $this->data['restypeList'][$restype_array[$key]];
				}
				else
				{
					$restype_array[$key] = '';
				}
			}
			$resource['restype'] = implode('，', $restype_array);
		}
		else
		{
			$resource['restype'] = '';
		}
		$resource['ressize'] = $this->format_bytes($resource['ressize']);
		
		return $resource;
	}
	
	//计算文件大小，转换成B,KB,MB,GB,TB格式
	public function format_bytes($size) { 
		$units = array(' B', ' KB', ' MB', ' GB', ' TB'); 
		for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024; 
		return round($size, 2) . $units[$i]; 
	}

	public function attach() {
		$attachid = $this->input->get('attachid');	//附件编号
		
		//判断用户是否登录，用户登录后才能下载
		$user = Ebh::app()->user->getloginuser();
		if (empty($user))
		{
			$url = geturl('login') . '?returnurl=' . geturl('freeresource/resource/' . $attachid);
			header("Location:" . $url);
			return;
		}
		
		$resource = $this->model('resource')->getOneByResid($attachid);
		if (!empty($resource))
		{
			$url = $resource['resurl'];
			$name = $resource['title'];
			$pos = strrpos($name, '.');
			if ($pos !== false)
			{
				$name = substr($name, 0, $pos);
			}
			$name = $name . '.' . $resource['resfileext'];
			
			//下载数加1
			$this->model('resource')->incrDownloadNum($attachid);
			getfile('resource', $url, $name, true);//输出下载文件二进制流
		}
		
	}
	
	/**
	 *获取预览题库附件,供题库预览使用
	*/
	public function preview_view(){
		$attachid = intval($this->uri->lastsegment());
		$resource = $this->model('resource')->getOneByResid($attachid);
		$filename = basename($resource['resurl']);
		if ($this->hasPreview($resource['resurl']))
		{
			if (strtolower(substr($filename, -4)) == '.swf')
			{
				//后缀为.swf
				getfile('resource', $resource['resurl'], $filename);
			}
			else
			{
				//后缀为.ppt,供预览的文件后缀为.ppt.swf
		    	getfile('resource', $resource['resurl'] . '.swf', $filename . '.swf');
			}
		}
	}
	
	//判断是否有.swf预览文件
	public function hasPreview($path) {		
		//文件名以file开头，数字加.ppt结尾的
		$filename = basename($path);
		$pattern = '/^file[0-9]+\.ppt$/';
		if (preg_match($pattern, $filename))
		{
			return true;
		}
		elseif (strtolower(substr($filename, -4)) == '.swf')
		{
			return true;
		}
		return false;
	}
}
