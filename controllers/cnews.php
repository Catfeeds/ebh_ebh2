<?php
/**
 *门户控制器
 */
class CnewsController extends PortalControl{
	protected $data = array();
	public function index(){
		$portalkey = $this->cache->getcachekey('portal','cnews');
        $portallist = $this->cache->get($portalkey);
        if(empty($portallist)){
			//获取导航菜单
			$menues = $this->_getFormatedMenues();
			//(catid,'best,top,hot',num,hasimg,order);
			$this->_superfetch(9,'-1,2,-1',1,true); //教育资讯
			$this->_superfetch(9,'-1,-1,-1',3); //教育资讯
			$this->_superfetch(13,'-1,2,-1',1,true); //考试资讯
			$this->_superfetch(13,'-1,-1,-1',3); //考试资讯
			$this->_superfetch(20,'-1,2,-1',1,true); //校园之星
			$this->_superfetch(20,'-1,-1,-1',3); //校园之星
			$this->_superfetch(11,'-1,2,-1',1,true); //考试新政
			$this->_superfetch(11,'-1,-1,-1',3); //考试新政
			$this->_superfetch(21,'-1,2,-1',1,true); //校园生活(普通)
			$this->_superfetch(21,'-1,-1,-1',3); //校园生活(普通)
			$this->_superfetch(21,'-1,3,-1',5,true,'scrollpic'); //校园生活(大图)
			$this->_superfetch(23,'-1,2,-1',4,true); //千奇百怪
			$this->_superfetch(23,'-1,-1,-1',4); //千奇百怪
			$this->_superfetch(24,'-1,2,-1',1,true); //丑事爆料
			$this->_superfetch(24,'-1,-1,-1',3); //丑事爆料
			$this->_superfetch(25,'-1,2,-1',1,true); //百科杂谈
			$this->_superfetch(25,'-1,-1,-1',3); //百科杂谈
			$this->_superfetch(36,'-1,2,-1',1,true); //创业故事
			$this->_superfetch(35,'-1,-1,-1',5); //感悟人生
			$this->_superfetch(34,'-1,-1,-1',5); //国学经典
			$this->_superfetch(17,'-1,2,-1',1,true); //状元心声
			$this->_superfetch(18,'-1,2,-1',1,true); //教师风采
			$this->_superfetch(49,'-1,-1,-1',1,true); //E版资讯最新一个
			// $this->_superfetch(0,'3,3,3',1,true,'scrollpic'); //新闻大首页滚动6广告 bth 3,3,3
			//获取通栏广告
			$this->getAds(45,'nav',6);
			$this->getAds(45,'portal_gundong',6);

			$this->getEachNewOne();
			$this->cache->set($portalkey,$this->data,360000);
        }else{
        	$this->data = array_merge($this->data,$portallist);
        }
		$this->_assignAll();
		$this->display('portal/cnews');
	}


	//获取导航菜单
	private function _getFormatedMenues(){
	    $menues = $this->model('pcategories')->getVisibleList();
	    $this->_createCatDb($menues);//将原始分类建成临时数据库供页面使用
	    $menues = $this->_formatMenues($menues);
		$this->data['menues'] = $menues;
	}

	//创建分类数据库
	private function _createCatDb($menues){
		$tmp = array();
		foreach ($menues as $menue) {
			$tmp['id_'.$menue['catid']] = $menue;
			$tmp['code_'.$menue['code']] = $menue;
		}
		$this->data['cdb'] = $tmp;
	}
	//格式化门户分类
	private function _formatMenues($menues = array(),$upid = 0){
        $formatedMenues = array();
        foreach ($menues as $menue) {
        	if(!in_array($menue['catid'],array(8,15,22,33)) && !in_array($menue['upid'],array(8,15,22,33))){
        		continue;
        	}
            if($menue['upid']==$upid){
                $menue['child'] = $this->_formatMenues($menues,$menue['catid']);
                $formatedMenues[] = $menue;
            }
        }
        return $formatedMenues;
    }
    /**
   	 *获取广告通用方法
   	 *
   	 */
   	private function getAds($catid,$code,$num,$upid=0){
   		$padsModel = $this->model('pads');
   		$ads = $padsModel->getCateAds(45,$code,$num,$upid);
   		if(empty($ads)){
   			$ads = array(array('linkurl'=>'','thumb'=>''));
   		}
   		//catid=45的栏目为顶层栏目,是所有顶级分类的父级,广告投放在45栏目则所有栏目均会获取到信息
   		if($code == 'nav'){
			$this->data['ads_nav']= $ads;
   		}else{
   			$this->data['ads_'.$code]= $ads;
   		}
   		
   	}

    //获取指定分类的信息
    private function _superfetch($catid=0,$sbth = "",$num = 5,$hasimg = false,$namespace="",$order=''){
    	$catid = intval($catid);
    	$num = intval($num);
    	list($b,$t,$h) = explode(',', $sbth);
    	$bth = array();
    	if($b != -1){
    		$bth['b'] = $b;
    	}
    	if($t != -1){
    		$bth['t'] = $t;
    	}
    	if($h != -1){
    		$bth['h'] = $h;
    	}
    	$res = $this->model('pitems')->datafetch($catid,$bth,$num,$hasimg,$order);
    	$key = empty($hasimg)?'cat_'.$catid:'cat_img_'.$catid;
    	if(!empty($namespace)){
    		$key = 'cat_'.$namespace.'_'.$catid;
    	}
    	$this->data[$key] = $res;
    }

   /**
	 *获取指定父级栏目下面的最新的一条文章
	 */
	private function getEachNewOne(){
		$upids = array(8,15,33,22);
		$upidname = array('考试','校园','励志','百科');
		$upcode = array('news','school','motivation','lfk');
		$upurl = array('/news.html','/school.html','/motivation.html','/lfk-1-0-0-25.html');
		$eachNewOne = array();
		$pitemsModel = $this->model('pitems');
		foreach ($upids as $upid) {
			$eachNewOne[] = $pitemsModel->getOneInTopCate($upid);
		}
		$this->data['eachNewOne'] = $eachNewOne;
		$this->data['upidname'] = $upidname;
		$this->data['upurl'] = $upurl;
		$this->data['upcode'] = $upcode;
	}
}