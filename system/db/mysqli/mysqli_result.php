<?php

/**
 * Description of mysqli_result
 *
 * @author Administrator
 */
class CMysqli_result extends CResult {
    public function _row_array() {
        if(empty($this->resultobj) || !is_object($this->resultobj)) {
            return false;
        }
        $row = $this->resultobj->fetch_array(MYSQLI_ASSOC);
        return $row;
    }
    public function _list_array($key = '') {
        if(empty($this->resultobj) || !is_object($this->resultobj)) {
            return false;
        }
        $resultarr = array();
        if(empty($key)) {
            while($row = $this->resultobj->fetch_array(MYSQLI_ASSOC)) {
                $resultarr[] = $row;
            }
        } else {
            while($row = $this->resultobj->fetch_array(MYSQLI_ASSOC)) {
                $resultarr[$row[$key]] = $row;
            }
        }
        return $resultarr;
    }
    /**
     * 返回数据表的单个字段的一维数组数据
     * @param string $field 返回的字段名称,可选参数，为空就默认返回第一个字段的数组
     * @param string $key 作为键的字段名称，可选参数，为空就默认数字键
     * @return mixed
     */
    public function _list_field($field = '', $key = '') {
        if(empty($this->resultobj) || !is_object($this->resultobj)) {
            return false;
        }
        $ret = array();
        if (!empty($field)) {
            if (!empty($key)) {
                while($row = $this->resultobj->fetch_array(MYSQLI_ASSOC)) {
                    $ret[$row[$key]] = $row[$field];
                }
                return $ret;
            }
            while($row = $this->resultobj->fetch_array(MYSQLI_ASSOC)) {
                $ret[] = $row[$field];
            }
            return $ret;
        }

        while($row = $this->resultobj->fetch_array(MYSQLI_NUM)) {
            $ret[] = $row[0];
        }
        return $ret;
    }
    public function close() {
        if(!empty($this->resultobj) && is_object($this->resultobj)) {
            $this->resultobj->free();
        }
    }
}