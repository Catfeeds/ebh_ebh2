<?php

/**
 * CFolder 课程对应组件，主要用于跟课程权限相关的用户，学生等处理
 */
class CFolder extends CComponent {
	/**
	*根据课程编号获取有课程权限的用户列表
	*/
	public function getUserList($param = array()) {
		//select up.folderid,up.uid,u.username,u.realname,u.sex,u.face from ebh_userpermisions up 
		//join ebh_users u on (up.uid=u.uid)
		//where up.folderid=3327 and up.folderid in (3327,3328) and up.crid=10439 and up.enddate=0 and up.uid not in (1);

		if (empty($param['folderid']) || empty($param['folderids'])) {
			return FALSE;
		}
		$sql = 'select up.folderid,up.uid,u.username,u.realname,u.sex,u.face from ebh_userpermisions up '.
			'join ebh_users u on (up.uid=u.uid) ';
		$wherearr = array();
		if (!empty($param['folderid']))	{//根据课程编号查询
			$wherearr[] = 'up.folderid='.$param['folderid'];
		}
		if (!empty($param['folderids'])) {	//根据课程的字符串组合查询如果 folderid1,folderid2 这种方式
			$wherearr[] = 'up.folderid in ('.$param['folderids'].')';
		}
		if (!empty($param['crid'])) {	//网校crid
			$wherearr[] = 'up.crid='.$param['crid'];
		}
		if (!empty($param['filteruser'])) {	//是否过滤uid，filteruser参数 以userid1,userid2,userid3方式组合
			$wherearr[] = 'up.uid not in ('.$param['filteruser'].')';
		}
		if (!empty($param['filterexpire'])) {	//是否对过期的权限进行过滤
			$wherearr[] = 'enddate>='.SYSTIME;
		}
		$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		if (!empty($param['limit'])) {
			$sql .= ' limit ' . $param['limit'];
		}
		return FALSE;

	}
	/**
	*根据课程编号获取有课程权限的用户列表数
	*/
	public function getUserCount($param = array()) {

	}
}