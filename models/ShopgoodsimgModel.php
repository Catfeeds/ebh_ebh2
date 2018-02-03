<?php
/**
 * 商品模型
 */
class ShopgoodsimgModel extends CShopModel {
    /**
     * 发布商品
     * @param $parame
     * @return bool
     */
    public function add($crid,$uid,$gid,$sources) {
        if (empty($crid) || empty($uid) || empty($gid) || empty($sources) || !is_array($sources)) {
            return  false;
        }

        $time = time();
        foreach ($sources as $source) {
            $array = array(
                'uid'=>$uid,
                'crid'=>$crid,
                'gid'=>$gid,
                'sourceid' => $source['sid'],
                'checksum'=>$source['checksum'],
                'source'=>$source['source'],
                'url'=>$source['filepath'].'/'.$source['newname'].'.'.$source['filesuffix'],
                'filename'=>$source['newname'],
                'suffix'=>$source['filesuffix'],
                'size'=>'80_80,220_220',
                'filesize'=>$source['filesize'],
                'dateline'=>$time
            );
            $status = $this->shopdb->insert('shop_goods_images',$array);
        }

        return $status;
    }

}