<?php
/**
 * @desc 微信控制器   weixin
 * @author eker-huang
 * 接口请求说明:http://www.ebh.net/weixin.html?backurl=http%3a%2f%2fwap.ebh.net%2f
 * backurl 需要urlencode处理
 */
class WeixinController extends CControl{
    private $user = null;
    private $durl = null;
    /**
     * 微信操作主入口
     */
    public function index(){
        $get = $this->input->get();
        $backurl = isset($get['backurl']) ? h($get['backurl']) : 'http://wap.ebh.net/';
        //缓存backurl
        $state = md5('wx_backurl'.$backurl);
        $redis = Ebh::app()->getCache('cache_redis');
        $redis->set($state,$backurl);
        
        $wechatObj = Ebh::app()->lib('WechatCallback');//得到微信扩展类的实例
        $SERVER_NAME = $this->getHostDomainByServer($_SERVER['HTTP_HOST']);
        //独立域名第三方登入
        if(substr($SERVER_NAME, -7) != 'ebh.net' && substr($SERVER_NAME, -11) != 'ebanhui.com') {
            $redirect_uri = urlencode("http://www.ebh.net/weixin/callback.html?fulldomain=".$_SERVER['HTTP_HOST']);
        } else {
            $redirect_uri = urlencode("http://www.ebh.net/weixin/callback.html");
        }
        
        $wechatObj->getAuthCode($state,$redirect_uri);
    }
    
    /**
     * 授权回调页
     */
    public function callback(){
        $get = $this->input->get();
        $code = isset($get['code']) ? h($get['code']) : ''; //获取微信返回的code值
        $state = isset($get['state']) ? h($get['state']) : '';//兼容之前的老版本
        if(empty($code) || empty($state)){
            $uri = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
            log_message('WeChat requests return code error!'."\n 请求url:".$uri);
            //重新发起授权
            $this->index();
           //echo 'WeChat requests return code error!';
           exit;
        }
        //获取微信用户信息
        $wechatObj = Ebh::app()->lib('WechatCallback');//得到微信扩展类的实例
        $wxuser = $wechatObj->getAuthUserInfo($code);
        //log_message(var_export($wxuser,true));
        //var_dump($wxuser);die;
        
        if(empty($wxuser)){
            $uri = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
            log_message('User auth error!'."\n 请求url:".$uri);
            //重新发起授权
            $this->index();
            exit;
        }
        //用户信息入微信表
        $this->filterweixinuser($wxuser);
        
        //判断用户是否已经登录,如果登录的用户,直接绑定到该用户
        $user = Ebh::app()->user->getloginuser();
        if(!empty($user)){
          $this->user = $user;  
        }
        //判断用户是否绑定
        $user = $this->filterweixinbinduser($wxuser);
        
        //用户登录
        $this->dologin();
        //跳转指定地址
        $this->goback($state,$wxuser);
    }
    
    
    /**
     * 从微信自定义菜单跳转到wap端
     * 跳转到
     */
    public function towap(){
        $get = $this->input->get();
        $appconfig = Ebh::app()->getConfig()->load('appsetting');
        $domain = !empty($get['domain']) ? $get['domain'] : $appconfig['demodomain'];
        
        $classroom = $this->model('classroom')->getroomdetailbydomain($domain);
        if(!empty($classroom)){
            //设置网校id和网校名称
            $this->input->setcookie('crid',$classroom['crid'],8640000);
            $this->input->setcookie('crname',$classroom['crname'],8640000);
        }
        $url = "http://wap.ebh.net/";
        header("Location:".$url);
    }
    
    
    
    /**
     * 获取用户信息 写入微信用户信息表
     */
    private function filterweixinuser($userinfo){
        if(empty($userinfo)){
            return false;
        }
        $param = array(
            'openid' => $userinfo['openid'],
            'unionid' => $userinfo['unionid'],
            'nickname' => $userinfo['nickname'],
            'sex' => $userinfo['sex'],
            'province' => $userinfo['province'],
            'city' => $userinfo['city'],
            'country' => $userinfo['country'],
            'headimgurl' => $userinfo['headimgurl'],
            'status' => 0,
            'dateline' => SYSTIME
        );
        $weixinmodel = $this->model('Weixin');
        $result = $weixinmodel->insertWeixinInfo($param);
        return $result;
    }
    
    /**
     * 微信用户绑定处理
     * @param unknown $wxuser
     */
    private function filterweixinbinduser($wxuser){
        //验证用户是否绑定
        //$openid = $wxuser['openid'];
        $unionid = $wxuser['unionid'];//用unionid 查询 兼容所有平台
        
        $bindmodel = $this->model("Bind");
        $checkbind = $bindmodel->checkwxbind($unionid);
        
        if(!empty($this->user)){//已经登录的用户,直接将微信授权绑定到该账号上
            if(!$checkbind){//不存在,直接绑定到该登录用户上
                $cuser = array('uid'=>$this->user['uid']);
                $datas = array('openid'=>$wxuser['openid'],'unionid'=>$unionid,'nickname'=>$wxuser['nickname']);
                $this->dobind('wx', $datas, $cuser);
            }else{
                //先解绑以前绑定的账号
                $wxbinduser = $bindmodel->getwxuserbyopenid($unionid);
                $ck = $bindmodel->doUnbind('wx',$wxbinduser['uid']);
                if($ck){
                    //绑定该登录用户
                    $cuser = array('uid'=>$this->user['uid']);
                    $datas = array('openid'=>$wxuser['openid'],'unionid'=>$unionid,'nickname'=>$wxuser['nickname']);
                    $this->dobind('wx', $datas, $cuser);
                }
            }
        }else{
            if(!$checkbind){//不存在
                //创建账号
                $param = array(
                    'nickname'=>$wxuser['nickname'],
                    'face'=>$wxuser['headimgurl'],
                    'sex'=>$wxuser['sex'],
                    'unionid'=>$wxuser['unionid'],
                    'openid'=>$wxuser['openid'],
                );
                $this->user =  $this->createUser($param, 'wx');
            }else{
                $this->user = $bindmodel->getwxuserbyopenid($unionid);
            }
        }

        
        return $this->user;
    }
    
    /**
     * 用户登录处理
     */
    private function dologin(){
        $user = $this->user;
        header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
        $uid = $user['uid'];
        $pwd = $user['password'];
        $ip = getip();
        $time = SYSTIME;
        //pc端cookie
        //$auth = authcode("$pwd\t$uid", 'ENCODE');
        //wap端登录 单独写cookie
        $auth = authcode("$pwd\t$uid\t$ip\t$time", 'ENCODE');
        $cookietime =  31536000; //如果保存登录状态，则保存1年
        $fulldomain = $this->input->get('fulldomain');
        if ($fulldomain) {
            //微信登入独立域名设置cookie,sso方法
            $ctime = SYSTIME;   //当前时间，主要用于验证此SSO请求是否是已过期的
            $screen = '';
            $ssovalue = $auth.'___'.$user['lastlogintime'].'___'.SYSTIME.'___'.$ip.'___'.'31536000'.'___'.$screen.'___'.$ctime;
            $ssovalue = base64_encode($ssovalue);
            $this->durl = 'http://'.$fulldomain.'/sso.html?k='.$ssovalue;
        } else {
            //非独立域名逻辑
            $this->input->setcookie('auth', $auth, $cookietime);
            $this->input->setcookie('lasttime', $user['lastlogintime'], $cookietime);
            $this->input->setcookie('thistime', SYSTIME, $cookietime);
            $this->input->setcookie('lastip', $user['lastloginip'], $cookietime);
            if($user['groupid'] == 5) { //如果是教师，则添加ak的cookie设置，主要用于学校后台获取权限
                $this->input->setcookie('ak', $auth, $cookietime);
            }
        }
       
    }
    
    /**
     * 跳转处理
     */
    private function goback($state,$wxuser=null){
        $backurl = '/';
        $redis = Ebh::app()->getCache('cache_redis');
        if(!empty($state)){
            $backurl = $redis->get($state);
            if(!empty($backurl)){
                $backurl = urldecode($backurl);
                if ($this->durl && $backurl) {
                    //独立域名跳转到之前的登入页面做sso操作
                    $backurl = 'http://wap.ebh.net/login/callback.html?backurl='.$backurl.'&durl='.$this->durl;  
                }
            }
        }
        
        //支付操作 需要传递wxopenid
        if(stripos($backurl,'ibuy')!==FALSE){
            $backurl.="&wxopenid=".$wxuser['openid'];
        }
        
        header("Location:$backurl");
        exit;
    }
    
    
    /**
     * 创建新用户
     */
    private function  createUser($param,$type){
        $sex = 0;//性别 0男  1女
        $openid = $param['openid'];
        $unionid = @ $param['unionid'];
        $nickname = $param['nickname'];
        $face = !empty($param['face']) ? $param['face'] : '';
        
        $data = array();
        if($type == 'qq'){
            $data['qqopid'] = $openid;
        }elseif($type == 'wx'){
            $data['wxunionid'] = $unionid;
            $data['wxopid'] = $openid;
            $data['sex'] = $param['sex'];
        }elseif($type=='sina'){
            $data['sinaopid'] = $openid;
            $data['sex'] = $param['sex'];
        }
        $mima = $this->generateStr(6);//后六位 为密码
        $username = $type.rand(1000,9999).$mima;
        $password = $mima;
        $data['username'] = $username;
        $data['mpassword'] = md5($password);
        $data['realname'] = shortstr($nickname,50);//昵称 存在 姓名字段
        $data['dateline'] = SYSTIME;
        
        $member = $this->model("Member");
        $uid = $member->addmember($data);
        if($uid>0){
            $cuser = array('uid'=>$uid);
            $datas = array('openid'=>$openid,'unionid'=>$unionid,'nickname'=>$nickname);
            $this->dobind($type, $datas, $cuser);
        }
        //处理微信头像,生成缩略图并更新用户数据库
        if($uid>0 && !empty($face)){
            $encodeuid =  authcode($uid,'ENCODE');
            $_UP = Ebh::app()->getConfig()->load('upconfig');
            if(!empty($_UP['avatar']['wxnotify'])){
                $wxnotify = $_UP['avatar']['wxnotify'];
                $res = do_post($wxnotify, array('uid'=>$encodeuid, 'face'=>$face), false);
                if(!empty($res->msg) && !empty($res->status) && $res->status== -1){
                    log_message($res->msg);
                }
            }
        }
        $user = array('uid'=>$uid,
            'realname'=>$data['realname'],
            'sex'=>$data['sex'],
            'username'=>$username,
            'passwrod'=>$password,
            'openid'=>$openid,
            'unionid'=>$unionid,
            'lastlogintime'=>SYSTIME,
            'lastloginip'=>getip(),
            'groupid'=>6,
            'password'=>$data['mpassword']
        );
        
        //注册用户后续处理
        $this->afterCreateUser($user);
        //将注册信息记录到日志
        $this->afterUserRegister($user);
        
        return $user;
    }
    
    /**
     * 用户注册后将注册信息记录到日志
     */
    public function afterUserRegister($user){
        $appconfig = Ebh::app()->getConfig()->load('appsetting');
        $democrid = $appconfig['democrid'];
        $democlassid = $appconfig['democlassid'];
        
        $logdata = array();
        $logdata['uid'] = $user['uid'];
        $logdata['othertype'] = 2;
        $logdata['crid'] = $democrid; 
        $logdata['logtype'] = 6;  //6网校注册方式的创建用户
        $registerloglib = Ebh::app()->lib('RegisterLog');
        $registerloglib->addOneRegisterLog($logdata);
        
        return TRUE;
    }
    
    /**
     * 创建用户 指定到默认网校 默认班级 同步sns数据等
     */
    public function afterCreateUser($user){
        $appconfig = Ebh::app()->getConfig()->load('appsetting');
        $democrid = $appconfig['democrid'];
        $democlassid = $appconfig['democlassid'];
        
        //添加用户到教室
        $param['crid'] = $democrid;
        $param['uid'] = $user['uid'];
        $param['cnname'] = $user['realname'];
        $param['sex'] = $user['sex'];
        $roomuser = $this->model('roomuser');
        $roomuser->insert($param);
        
        //添加用户到网校
        $param['classid'] = $democlassid;
        $classes = $this->model('classes');
        $classes->addclassstudent($param);
        
        //更新SNS的学校学生、班级学生缓存
        Ebh::app()->lib('XNums')->add('user');
        $snslib = Ebh::app()->lib('Sns');
        $snslib->updateClassUserCache(array('classid'=>$democlassid,'uid'=>$user['uid']));
        $snslib->updateRoomUserCache(array('crid'=>$democrid,'uid'=>$user['uid']));
        
        //调用SNS同步接口，类型为4用户网校操作
        $snslib->do_sync($user['uid'], 4);
        
        return TRUE;
    }
    
    
    /**
     * 绑定处理
     * 对应 ebh_binds表
     * $type qq,wx,sina
     * $data 对应的开发平台昵称openid nickname等
     */
    private function dobind($type,$data,$user){
        $retflag = false;
        $bdmodel = $this->model("Bind");
        $umodel = $this->model("User");
        if($type=='qq'){//QQ
            $bdata =array(
                'uid'=>$user['uid'],
                'is_qq'=>1,
                'qq_str'=>json_encode(
                    array(
                        'qq'=>'',
                        'uid'=>$user['uid'],
                        'openid'=>	$data['openid'],
                        'nickname'=>$data['nickname'],
                        'dateline'=>SYSTIME
                    )
                    )
            );
            //log_message(var_export($bdata,true));
            $retflag = $bdmodel->doBind($bdata,$user['uid']);
            
            //更新主表qqopid字段
            if(!empty($retflag)){
                $udata = array(
                    'qqopid'=>$data['openid'],
                );
                $umodel->update($udata,$user['uid']);
            }
        }elseif($type=='wx'){//微信
            $bdata =array(
                'uid'=>$user['uid'],
                'is_wx'=>1,
                'wx_str'=>json_encode(
                    array(
                        'wx'=>'',
                        'uid'=>$user['uid'],
                        'openid'=>$data['openid'],
                        'unionid'=>$data['unionid'],
                        'nickname'=>$data['nickname'],
                        'dateline'=>SYSTIME,
                        'from'=>'gzh'
                    )
                    )
            );
            $retflag = $bdmodel->doBind($bdata,$user['uid']);
            
            //更新主表wxopenid字段
            if(!empty($retflag)){
                $udata = array(
                    'wxunionid'=>$data['unionid'],
                    'wxopid'=>$data['openid']//这个要注意下 公众号过来的是 wxopid这个字段 @eker 2016年5月18日10:41:21
                );
                $umodel->update($udata,$user['uid']);
            }
            
        }elseif($type=='sina'){//微博
            $bdata =array(
                'uid'=>$user['uid'],
                'is_weibo'=>1,
                'weibo_str'=>json_encode(
                    array(
                        'weibo'=>'',
                        'uid'=>$user['uid'],
                        'sinaopid'=>$data['openid'],
                        'nickname'=>$data['nickname'],
                        'dateline'=>SYSTIME
                    )
                    )
            );
            $retflag = $bdmodel->doBind($bdata,$user['uid']);
            
            //更新主表wxopenid字段
            if(!empty($retflag)){
                $udata = array(
                    'sinaopid'=>$data['openid'],
                );
                $umodel->update($udata,$user['uid']);
            }
        }
        
        return $retflag;
    }
    /**
     * 生成随机字符串
     * @param number $length
     * @return string
     */
    private function generateStr( $length = 8 ) {
        // 密码字符集，可任意添加你需要的字符
        $chars = '0123456789';
        
        $str = '';
        for ( $i = 0; $i < $length; $i++ )
        {
            $str .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        
        return $str;
    }
    
    /*
    *获取当前的以及域名，如 wl.sy.ebanhui.com 那就为 ebanhui.com sy.ebh.net 则为ebh.net
    */
    function getHostDomainByServer($server_name) {
        $slist = explode('.',$server_name);
        if(empty($slist) || count($slist) < 2)
            return "";
        $seglen = count($slist);
        if(is_numeric($slist[$seglen-1]))
            return "";
        $host = $slist[$seglen - 2].'.'.$slist[$seglen-1];
        return strtolower($host);
    }
}