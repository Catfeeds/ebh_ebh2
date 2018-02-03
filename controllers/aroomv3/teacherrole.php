<?php
/**
 * 教师权限
 * Created by PhpStorm.
 * User: ycq
 * Date: 2017/7/25
 * Time: 13:33
 */
class teacherroleController extends ARoomV3Controller
{
    public function __construct()
    {
        parent::__construct();
        if (defined('IS_DEBUG') && IS_DEBUG) {
            @ob_end_clean();
            header('Content-Type: application/json; charset=utf-8');
        }
    }

    /**
     * 获取网校基本信息
     */
    public function index()
    {
        $page = intval($this->input->get('page'));
        $pagesize = intval($this->input->get('pagesize'));
        $simple = intval($this->input->get('simple'));
        $ret = $this->apiServer->reSetting()
            ->setService('Role.TeacherRole.index')
            ->addParams('crid', $this->roominfo['crid'])
            ->addParams('page', $page)
            ->addParams('pagesize', $pagesize)
            ->addParams('simple', $simple)
            ->request();
        if (!empty($ret)) {
            array_walk($ret['list'], function(&$item) {
                switch ($item['category']) {
                    case 1:
                        $item['description'] = '教师端权限';
                        break;
                    case 2:
                        $item['description'] = '管理员权限';
                        break;
                }
				$item['permissionArr'] = json_decode($item['permissions'], true);
            });
        }
        $this->renderjson(0, '', $ret);
    }

    /**
     * 编辑角色
     */
    public function edit() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法访问');
        }
        if ($this->user['uid'] != $this->roominfo['uid']) {
            $this->renderjson(1, '权限不足');
        }
        $rolename = trim($this->input->post('rolename'));
        $catetory = intval($this->input->post('category'));
        if (empty($rolename) || !in_array($catetory, array(1, 2))) {
            $this->renderjson(1, '角色信息填写不完整');
        }
        $role = array(
            'rid' => intval($this->input->post('rid')),
            'rolename' => $rolename,
            'category' => $catetory,
            'crid' => $this->roominfo['crid'],
            'remark' => trim($this->input->post('remark'))
        );
        $limitscope = $this->input->post('limitscope');
        if ($limitscope !== null) {
            $role['limitscope'] = min(1, max(0, intval($limitscope)));
        }
        $permissions = $this->input->post('permissions');
        if (is_array($permissions)) {
            $permissions = array_map('intval', $permissions);
            $permissions = array_filter($permissions, function($item) {
               return $item > 0;
            });
            $role['permissions'] = $permissions;
        }
		if (empty($role['permissions'])) {
			$this->renderjson(1, '角色菜单不能为空');
		}
        $ret = $this->apiServer->reSetting()
            ->setService('Role.TeacherRole.edit')
            ->addParams($role)
            ->request();
        if ($ret === false) {
            $this->renderjson(1, !empty($role['rid']) ? '修改失败' : '添加失败');
        }
        $this->renderjson(0, '', $ret);
    }

    /**
     * 角色详情
     */
    public function detail() {
        $rid = intval($this->input->get('rid'));
        $ret = $this->apiServer->reSetting()
            ->setService('Role.TeacherRole.detail')
            ->addParams('crid', $this->roominfo['crid'])
            ->addParams('rid', $rid)
            ->request();
        if (empty($ret)) {
            $this->renderjson(1, '角色不存在');
        }
        $this->renderjson(0, '', $ret);
    }

    /**
     * 删除角色
     */
    public function remove() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法访问');
        }
        if ($this->user['uid'] != $this->roominfo['uid']) {
            $this->renderjson(1, '权限不足');
        }
        $rid = intval($this->input->post('rid'));
        if ($rid < 1) {
            $this->renderjson(1, '缺少参数');
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Role.TeacherRole.remove')
            ->addParams('rid', $rid)
            ->addParams('crid', $this->roominfo['crid'])
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '删除失败');
        }
        $this->renderjson(0, '删除成功');
    }

    /**
     * 角色下用户列表
     */
    public function users() {
        $rid = intval($this->input->get('rid'));
        if ($rid < 1) {
            $this->renderjson(1, '缺少参数');
        }
        $page = intval($this->input->get('page'));
        $pagesize = intval($this->input->get('pagesize'));
        $k = trim($this->input->get('k'));
        $ret = $this->apiServer->reSetting()
            ->setService('Role.TeacherRole.roleUsers')
            ->addParams('crid', $this->roominfo['crid'])
            ->addParams('page', $page)
            ->addParams('pagesize', $pagesize)
            ->addParams('rid', $rid)
            ->addParams('k', $k)
            ->request();
        $this->renderjson(0, '', $ret);
    }

    /**
     * 设置角色用户
     */
    public function setUser() {
        if (!$this->isPost()) {
            $this->renderjson(1, '非法访问');
        }
        if ($this->user['uid'] != $this->roominfo['uid']) {
            $this->renderjson(1, '权限不足');
        }
        $rid = intval($this->input->post('rid'));
        $tids = $this->input->post('tids');
        if (is_array($tids)) {
            $tids = array_map('intval', $tids);
        } else {
            $tids = array(intval($tids));
        }
        foreach ($tids as $k => $tid) {
            if ($tid == $this->roominfo['uid'] || $tid == $this->user['uid']) {
                unset($tids[$k]);
            }
        }
        if (empty($tids)) {
            $this->renderjson(1, '缺少参数');
        }
        if ($rid < 4) {
            $rid = 1;
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Role.TeacherRole.setUser')
            ->addParams('rid', $rid)
            ->addParams('tids', $tids)
            ->addParams('crid', $this->roominfo['crid'])
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '设置失败');
        }
        $this->renderjson(0, '设置成功', $ret);
    }

    /**
     * 用户模块列表
     */
    public function modules() {
        $rid = intval($this->input->get('rid'));
        $ret = $this->apiServer->reSetting()
            ->setService('Aroomv3.Module.modules')
            ->addParams('crid', $this->roominfo['crid'])
            ->addParams('tor', 1)
            ->request();
        if ($ret === false) {
            $this->renderjson(1, '网校不存在');
        }
        array_walk($ret, function(&$item) {
            $item['available'] = false;
        });
        if ($rid > 0) {
            $params = array(
                'crid' => $this->roominfo['crid'],
                'rid' => $rid
            );
            $detail = $this->apiServer->reSetting()
                ->setService('Role.TeacherRole.detail')
                ->addParams($params)
                ->request();
            if (!empty($detail)) {
                $permissions = json_decode($detail['permissions'], true);
            }
            if (!empty($permissions) && is_array($permissions)) {
                array_walk($ret, function(&$item, $k, $permissions) {
                    if (in_array($item['moduleid'], $permissions)) {
                        $item['available'] = true;
                    }
                }, $permissions);
            }
        }
        $ret = array_values($ret);
        $this->renderjson(0, '', $ret);
    }

    /**
     * 教师面板
     */
    public function teachers() {
        $rid = intval($this->input->get('rid'));
        if ($rid < 1) {
            $this->renderjson(1, '缺少参数');
        }
        $q = trim($this->input->get('q'));
        $params = array(
            'rid' => $rid,
            'crid' => $this->roominfo['crid']
        );
        if (!empty($q)) {
            $params['q'] = $q;
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Role.TeacherRole.teacherListPanel')
            ->addParams($params)
            ->request();
        if (!empty($ret['roleUsers'])) {
            if (!empty($ret['teachers'])) {
                array_walk($ret['teachers'], function(&$teacher, $k, $roleUsers) {
                    $teacher['choose'] = isset($roleUsers[$teacher['uid']]);
                }, $ret['roleUsers']);
            }
            $ret['roleUsers'] = array_values($ret['roleUsers']);
        }
        //过滤掉管理员
        foreach ($ret['teachers'] as $k => $teacher) {
            if ($teacher['uid'] == $this->user['uid'] || $teacher['uid'] == $this->roominfo['uid']) {
                unset($ret['teachers'][$k]);
            }
        }
        $ret['teachers'] = array_values($ret['teachers']);
        //print_r($ret);exit;
        $this->renderjson(0, '', $ret);
    }

    /**
     * 管理员端菜单
     */
    public function menus() {
        $rid = intval($this->input->get('rid'));
        $roomType = Ebh::app()->room->getRoomType();
        $params = array(
            'crid' => $this->roominfo['crid'],
            'roomtype' => $roomType == 'com' ? 1 : 0,
            'rid' => $rid
        );
        $ret = $this->apiServer->reSetting()
            ->setService('Role.TeacherRole.getMenuList')
            ->addParams($params)
            ->request();
        array_walk_recursive($ret, function(&$item, $k) {
            if ($k != 'status') {
                return;
            }
            $item = !empty($item);
        });
		if (!empty($ret)) {
			array_walk($ret, function(&$item) {
				if (empty($item['children'])) {
					return;
				}
				$item['children'] = array_filter($item['children'], function($child) {
					return $child['url'] != 'rolemanage';
				});
				$item['children'] = array_values($item['children']);
			});
			$ret = array_filter($ret, function($m) {
				return $m['url'] != 'rolemanage';
			});
			$ret = array_values($ret);
		}
        $this->renderjson(0, '', $ret);
    }

    /**
     * 获取教师角色
     * @return mixed
     */
    public function getTeacherRole() {
        $tid = intval($this->input->get('tid'));
        if ($tid < 1) {
            $this->renderjson(1, '缺少参数');
        }
        if ($this->roominfo['uid'] == $tid) {
            $this->renderjson(1, '参数错误');
        }
        $ret = $this->apiServer->reSetting()
            ->setService('Role.TeacherRole.getTeacherRole')
            ->addParams('tid', $tid)
            ->addParams('crid', $this->roominfo['crid'])
            ->request();
        $this->renderjson(0, '', $ret);
    }
}
