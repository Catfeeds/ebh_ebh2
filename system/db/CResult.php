<?php
/**
 * 数据库结果集类
 */
class CResult {
    var $resultobj = NULL;
    public function __construct($obj) {
        $this->resultobj = $obj;
    }

    public function row_array() {
        return $this->_row_array();
    }
    public function list_array($key = '') {
        return $this->_list_array($key);
    }

    /**
     * 返回数据表的单个字段的一维数组数据
     * @param string $field 返回的字段名称,可选参数，为空就默认返回第一个字段的数组
     * @param string $key 作为键的字段名称，可选参数，为空就默认数字键
     * @return mixed
     */
    public function list_field($field = '', $key = '') {
        return $this->_list_field($field, $key);
    }
    public function __destruct() {
        $this->close();
    }
}