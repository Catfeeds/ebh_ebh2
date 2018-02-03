<?php
/**
 * 商品标签
 */
class ShopgoodstagModel extends CShopModel {
    // 添加、修改商品标签
    public function add($crid, $uid, $gid, $parame) {

        if(empty($parame) || empty($crid) || empty($uid) || empty($gid)) return false;
        $tagsArr = explode(',', $parame);
        // 删除该商品的标签
        $this->shopdb->delete('shop_goods_tags',array('gid'=>intval($gid)));
        // 添加该商品的标签
        $time = time();
        foreach ($tagsArr as $v) {
            $addArr = array('crid'=>$crid,'uid'=>$uid,'tid'=>$v,'gid'=>$gid,'dateline'=>$time);
            $status = $this->shopdb->insert('shop_goods_tags', $addArr);
            if (empty($status)) {
                return false;
            }
        }

        return true;
    }
}