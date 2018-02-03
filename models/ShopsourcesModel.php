<?php
/**
 * 商品模型
 */
class ShopsourcesModel extends CShopModel {
    /**
     * 发布商品
     * @param $parame
     * @return bool
     */
    public function add($parame) {
        if (empty($parame) || !is_array($parame)) {
            return  false;
        }
        return $this->shopdb->insert('shop_goods',$parame);
    }

    /**
     * 根据唯一码获取图片资源
     * @param string $checksumStr 唯一码字符串
     * @return array
     */
    public function getSourcesBychecksum($checksumStr) {
        if(empty($checksumStr)) return false;
        $checksumArr = array_unique(explode(',',$checksumStr));
        $newchecksumStr = '';
        $i = 1;
        foreach($checksumArr as $val) {
            if ($i == 1) {
                $newchecksumStr = '\''.$val.'\'';
            } else {
                $newchecksumStr .= ',\''.$val.'\'';
            }
            $i ++ ;
        }

        $sql = 'select max(sid) as sid,checksum,filepath,filename,newname,filesuffix,filesize,source from shop_sources where checksum in ('.$newchecksumStr.')'.' group by checksum';

        return $this->shopdb->query($sql)->list_array();
    }
}