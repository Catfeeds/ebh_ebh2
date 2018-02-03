<?php
	/**
	*缓存更新控制器
	*/
	class CacheController extends AdminControl{
		public function index(){
			$this->assign('token',createToken());
			$this->assign('formhash',formhash('cache'));
			$this->display('admin/cache');
		}
		/**
		*清除缓存操作处理
		*/
		public function clean() {
			$param = $this->input->post();
			$this->check($param);
			$modulecatidarr = $param['modulecatid'];
			foreach($modulecatidarr as $moduleid) {
				$keyarr = $this->cache->get($moduleid);	//获取模块下的缓存key数组
				if(!empty($keyarr)) {
					$cachekeys = array_keys($keyarr);
					foreach($cachekeys as $cachekey) {
						$this->cache->remove($cachekey);
					}
					$this->cache->remove($moduleid);
				}
			}
			$this->goback();
		}
		/**
		 *操作成功或者失败时的跳转行数,带提示功能
		 */
		private function goback($note='操作成功',$returnurl='/admin/cache.html'){
			$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
			exit;
		}
		/**
		 *检测参数是否合理,防止前台的重复提交和恶意修改js造成的数据格式不对
		 */
		private function check($param){
			if(checkToken($param['token'])===false){
				$this->goback('请勿重复提交!');
			}
			$message = array();
			$message['code'] = true;
			if(empty($param['modulecatid'])){
				$message[] = '未选择任何模块，操作部成功!';
				$message['code'] = false;
			}
			if($message['code']===false){
				$this->goback(implode('<br />',$message));
			}
		}
	}