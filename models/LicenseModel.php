<?php

/**
 * Class LicenseModel  用户许可Model类
 * Author: gl
 * Date: 2018-01-30
 * Description:本类主要是为了实现admin管理后台 ‘软件管理’--‘软件许可’模块的数据操作
 */
class LicenseModel extends CModel
{

    /**
     * 批量添加多个账号
     * @param $param
     * @return array|bool array(123=>array('username'=>'DGSFDF000001','initpwd'=>'FEDSES'),
     *                          323=>array('username'=>'HGFHFH000002','initpwd'=>'WEDFGF'));
     */
    public function addManyUser($param)
    {
        if (empty($param)) {
            return FALSE;
        }
        $newuser = [];
        foreach ($param as $i => $user) {
            $initpwd = $user['initpwd'];
            unset($user['initpwd']);
            $uid = $this->db->insert('ebh_users', $user);
            $newuser[$uid]['username'] = $user['username'];
            $newuser[$uid]['initpwd'] = $initpwd;
        }
        return $newuser;
    }

    /**
     * 用户数量
     * @param array $param
     * @return int
     */
    public function getlicensecount($param)
    {
        $wherearr = array();
        $sql = 'SELECT COUNT(*) count FROM `ebh_users` u  JOIN `ebh_roomusers` r ON r.uid=u.uid LEFT JOIN `ebh_classstudents` cs ON u.uid = cs.uid LEFT JOIN `ebh_classes` c ON cs.classid = c.classid';
        if (!empty($param['username']))
            $wherearr[] = ' (u.username like \'%' . $this->db->escape_str($param['username']) . '%\')';
        if (!empty($wherearr))
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        $count = $this->db->query($sql)->row_array();
        return $count['count'];
    }

    /**
     * 用户许可列表
     * @param $param
     * @return mixed
     */
    public function getlicenselist($param)
    {
        $wherearr = array();
        $sql = 'SELECT u.uid,u.username,c.classname,r.telephone,u.sex,u.realname,u.dateline FROM `ebh_users` u JOIN `ebh_roomusers` r ON r.uid=u.uid LEFT JOIN `ebh_classstudents` cs ON u.uid = cs.uid LEFT JOIN `ebh_classes` c ON cs.classid = c.classid';
        if (!empty($param['username']))
            $wherearr[] = ' (u.username like \'%' . $this->db->escape_str($param['username']) . '%\')';
        if (!empty($wherearr))
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        $sql .= ' ORDER BY u.uid DESC';
        if (!empty($param['limit']))
            $sql .= ' limit ' . $param['limit'];
        return $this->db->query($sql)->list_array();
    }

    /**
     * 查询单个用户信息 主要是账号和初始密码 用于单个导出txt账号加密文件
     * 注：这里查询的telephone实际上存的是admin后台‘软件许可’模块里批量生成账号的原始密码
     * @param $uid 用户id
     * @return array('username'=>'DSFDEW000011','telephone'=>'EWDFGSS');
     */
    public function getonelicense($uid)
    {
        if (empty($uid)) {
            return false;
        }
        $sql = 'SELECT u.uid,u.username,r.telephone FROM `ebh_users` u JOIN `ebh_roomusers` r ON r.uid=u.uid WHERE u.uid =' . $uid;
        return $this->db->query($sql)->row_array();
    }

    /**
     * 获取上次批量生成账号的username数字部分的最大数字 NGNWKQ000002 账号规则暂时是:前面6位是大写字母后面是从000001开始增加
     * @param array ('crid'=>10371,'classid'=>23389);
     * @return array('uid'=>45454,'username'=>'DSFDEW000001','prenum'=>1)
     */
    public function getUsernameNum($param)
    {
        if (empty($param['crid']) || empty($param['classid'])) {
            return false;
        }
        $sql = "SELECT u.uid,u.username FROM `ebh_users` u JOIN `ebh_roomusers` rm ON rm.uid=u.uid JOIN `ebh_classstudents` cs ON u.uid = cs.uid  JOIN `ebh_classes` c ON cs.classid =c.classid WHERE c.classid={$param['classid']} AND rm.crid={$param['crid']} AND LENGTH(u.username)>=12 ORDER BY u.uid DESC limit 1";
        $res = $this->db->query($sql)->row_array();
        $num = 0;
        if ($res) {
            $username = $res['username'];
            $subname = substr($username, 6);
            $num = preg_replace('/^0*/', '', $subname);
            $res['prenum'] = $num;
        }
        return $res;
    }
}
