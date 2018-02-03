<?php
/**
 * 商品详细介绍
 */
class ShopgoodsdescModel extends CShopModel {
    /**
     * 添加详细介绍
     * @param $parame
     * @return bool
     */
    public function add($crid, $gid, $title, $desc) {
        if (empty($crid) || empty($gid) || empty($title) || empty($desc)) {
            return  false;
        }
        $inserArr = array(
            'gid'=>intval($gid),
            'crid'=>intval($crid),
            'goods_name'=>strval($title),
            'goods_detail'=>$desc
        );
        return $this->shopdb->insert('shop_goods_detail',$inserArr);
    }
}