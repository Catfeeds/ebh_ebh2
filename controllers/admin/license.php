<?php
/**
 * Created by PhpStorm.
 * LicenseController.php
 * Author: gl
 * Date: 2018/1/25
 * Description:本控制器主要是为了实现后台批量生成用户 并对每个用户的账号和密码进行Des加密 生成txt文件 并合并打包为zip输出到浏览器下载
 * 也可以对单个账号导出为txt加密文件
 * txt加密内容为 如 KFTS4yesabAh6BhSKBv0UQ==&&xumngb4ss6A=   其中“&&”符之前的为账号加密密文 “&&”符之后的为密码加密密文
 */

class LicenseController extends AdminControl
{
    /**
     * 用户列表
     */
    public function index()
    {
        if (!$this->input->get('op')) {
            $this->display('admin/license');
        }
    }

    /**
     * 批量添加账号，并导出为zip包
     * 账号规则如下：
     * 账号前六位是6个大写字母的混合，都是随机的。后面6位为数字序列编排 如：DSFGES000001
     * 密码是6位随机大写字母的混合 如：HKGTFD
     * 姓名为当前年份+5位序号，如：201800001
     */
    public function add()
    {
        if ($this->input->post()) {
            $num = (int)$this->input->post('num');
            if ($num > 0) {
                //1.生成账号 首先查询之前的最后生成的账号如WTTXBI000002 后面的数字 然后在此基础上累加
                $param = array('crid' => 10371, 'classid' => 23389);
                $preuser = $this->model('license')->getUsernameNum($param);
                $prenum = $preuser['prenum'] ? $preuser['prenum'] : 0;
                $userArr = [];
                $newuser = [];
                $userArr = $this->_createUser($num, $prenum);
                //2.将账号插入到用户表
                $newuser = $this->_addUser($userArr);
                //3.将uid等插入到roomusers和classstudents表
                if ($this->_addUserToRoomAndClass($newuser)) {
                    //4.对账号和密码进行des加密操作 并生成txt认证文件
                    if ($userArr) {
                        $date = date('YmdHis');
                        $upconfig = Ebh::app()->getConfig()->load('upconfig');
                        $savepath = $upconfig['license']['savepath'];
                        if (!file_exists($savepath)) {
                            mkdir($savepath, 0777, true);
                        }
                        $liveconfig = Ebh::app()->getConfig()->load('live');
                        $des = Ebh::app()->lib('CryptDes');
                        $des->set($liveconfig['deskey'], $liveconfig['desiv']);
                        $files = [];
                        header("Content-type: text/html; charset=utf-8");
                        $i = 1;
                        foreach ($userArr as $user) {
                            $userDes = $des->encrypt($user['username']) . '&&' . $des->encrypt($user['initpwd']);
                            file_put_contents($savepath . $date . sprintf('%06d', $i + $prenum) . '.lic', $userDes);
                            array_push($files, ['path' => $savepath . $date . sprintf('%06d', $i + $prenum) . '.lic', 'filename' => $date . sprintf('%06d', $i + $prenum) . '.lic']);
                            $i++;
                        }
                        //5.创建zip文件，并在浏览器打包下载
                        $zip = new ZipArchive;
                        $filename = $savepath . $date . '_license.zip';
                        if ($zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                            foreach ($files as $item) {
                                $zip->addFile($item['path'], $item['filename']);
                            }
                            $zip->close();
                        }
                        $downfilename = $date . '_license.zip';
                        //下载文件
                        if (!file_exists($filename)) {
                            echo "文件创建失败";
                            exit ();
                        } else {
                            $file = fopen($filename, "r");
                            Header("Content-type: application/octet-stream");
                            Header("Accept-Ranges: bytes");
                            Header("Accept-Length: " . filesize($filename));
                            Header("Content-Disposition: attachment; filename=" . $downfilename);//下载的文件名
                            echo fread($file, filesize($filename));
                            fclose($file);
                            //删除临时文件
                            $this->_delfile($savepath);
                            exit ();
                        }
                    }
                }
            }
        } else {
            $this->display('admin/license_add');
        }
    }

    /**
     * 删除文件
     * @param $filepath
     */
    private function _delfile($filepath)
    {
        if ($handle = opendir($filepath)) {
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != "..") {
                    if (is_dir($filepath . '/' . $item)) {
                        $this->_delfile($filepath . '/' . $item);
                    } else {
                        unlink($filepath . '/' . $item);
                    }
                }
            }
            closedir($handle);
            rmdir($filepath);
        }
    }

    /**
     * @param $num
     * @return array|bool array(array('username'=>'f8Tqs7000001','password'=>gdsgf3,...),
     *                          array('username'=>'f8Tqs7000002','password'=>gdsgfd,...)
     *                          )
     */
    private function _createUser($num, $prenum = 0)
    {
        if (empty($num) || $num <= 0) {
            return false;
        }
        $year = date('Y', SYSTIME);
        $userArr = array();
        for ($i = 1; $i <= $num; $i++) {
            $userArr[$i]['username'] = getrandom(6) . sprintf('%06d', $i + $prenum);
            $userArr[$i]['initpwd'] = getrandom(6);
            $userArr[$i]['password'] = md5($userArr[$i]['initpwd']);
            $userArr[$i]['groupid'] = 6;
            $userArr[$i]['status'] = 1;
            $userArr[$i]['dateline'] = SYSTIME;
            $userArr[$i]['realname'] = $year . sprintf('%05d', $i + $prenum);
        }
        return $userArr;
    }

    /**
     * 将创建的账号插入到user表
     * @param $userArr
     * @return array(32332=>array('username'=>'dsfds2000001','initpwd'=>'fdsfds'))
     */
    private function _addUser($userArr)
    {
        if (empty($userArr)) {
            return false;
        }
        $newuser = [];
        $user = $this->model('license');
        $newuser = $user->addManyUser($userArr);//插入用户表
        return $newuser;
    }

    /**
     * 将uid分别插入到roomusers表和classstudents表里
     * 暂时固定crid=10371 classid=23389
     * @param $uidArr
     * @return bool
     */
    private function _addUserToRoomAndClass($userArr)
    {
        if (empty($userArr)) {
            return false;
        }
        //组装数据
        $roomusers = [];
        $classstudents = [];
        foreach ($userArr as $uid => $user) {
            $roomusers[$uid]['crid'] = 10371;
            $roomusers[$uid]['uid'] = $uid;
            $roomusers[$uid]['telephone'] = $user['initpwd'];
            $classstudents[$uid]['uid'] = $uid;
            $classstudents[$uid]['classid'] = 23389;
        };
        //插入roomuser表 和 classstudents表
        $bool1 = ($this->model('roomuser')->addManyRoomUser($roomusers)) ? true : false;
        $bool2 = ($this->model('classes')->addManyClassStudents($classstudents)) ? true : false;
        return ($bool1 && $bool2) ? true : false;
    }

    /**
     * 查询 ajax
     */
    public function getListAjax()
    {
        $param = $this->input->post();
        $pageNumber = empty($param['pageNumber']) ? 1 : intval($param['pageNumber']);
        $pageSize = empty($param['pageSize']) ? 20 : intval($param['pageSize']);
        $offset = max(0, ($pageNumber - 1) * $pageSize);
        parse_str($param['query'], $queryArr);;
        $queryArr['limit'] = $offset . ',' . $pageSize;
        $queryArr['crid'] = 10371;
        $licenseModel = $this->model('license');
        $total = $licenseModel->getlicensecount($queryArr);
        $userlist = $licenseModel->getlicenselist($queryArr);
        array_unshift($userlist, array('total' => $total));
        echo json_encode($userlist);
    }

    /**
     * 单个许可证的导出
     */
    public function oneExport()
    {
        $uid = $this->input->get('uid');
        if (empty($uid) || $uid <= 0) {
            exit();
        }
        $param = array('crid' => 10371, 'classid' => 23389);
        $preuser = $this->model('license')->getUsernameNum($param);
        $preuid = $preuser['uid'];
        $prenum = $preuser['prenum'] ? $preuser['prenum'] : 0;
        $user = $this->model('license')->getonelicense($uid);
        $username = $user['username'];
        $initpwd = $user['telephone'];
        $upconfig = Ebh::app()->getConfig()->load('upconfig');
        $savepath = $upconfig['license']['savepath'];
        if (!file_exists($savepath)) {
            mkdir($savepath, 0777, true);
        }
        //定义文件后缀序号
        $date = date('YmdHis');
        $suffixfilename = $date . sprintf('%06d', rand(1, 999999)) . '.lic';
        if ($user['uid'] <= $preuid) {
            $suffixnum = $prenum - ($preuid - $uid);
            if ($suffixnum >= 1) {
                $suffixfilename = $date . sprintf('%06d', $suffixnum) . '.lic';
            } else {
                $suffixfilename = $date . sprintf('%06d', rand(1, 999999)) . '.lic';
            }
        } else {
            $suffixfilename = $date . sprintf('%06d', rand(1, 999999)) . '.lic';
        }
        $liveconfig = Ebh::app()->getConfig()->load('live');
        $des = Ebh::app()->lib('CryptDes');
        $des->set($liveconfig['deskey'], $liveconfig['desiv']);
        $userDes = $des->encrypt($username) . '&&' . $des->encrypt($initpwd);
        $filename = $savepath . $suffixfilename;
        header("Content-type: text/html; charset=utf-8");
        file_put_contents($filename, $userDes);
        //下载文件
        if (!file_exists($filename)) {
            echo "文件创建失败";
            exit ();
        } else {
            $file = fopen($filename, "r");
            Header("Content-type: application/octet-stream");
            Header("Accept-Ranges: bytes");
            Header("Accept-Length: " . filesize($filename));
            Header("Content-Disposition: attachment; filename=" . $suffixfilename);//下载的文件名
            //读取文件内容并直接输出到浏览器
            echo fread($file, filesize($filename));
            fclose($file);
            //删除临时文件
            $this->_delfile($savepath);
            exit ();
        }
    }


}