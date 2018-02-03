<?php
/**
 * 商品模型
 */
class ShopgoodsModel extends CShopModel {
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
     * 获取商品列表
     * @param int $crid (网校 ID)
     * @param int $uid (用户 ID)
     * @param array $parame (搜索条件参数)
     * @return array
     */
    public function getGoodsList($crid, $uid, $parame = array()) {
        if (empty($crid) || empty($uid)) {
            return false;
        }

        $sql = "select gid,goods_name,cover_img,is_real,is_new,is_audit,is_sale,del,pre_price,score_price,dateline from shop_goods";

        $where = ' where crid = '.intval($crid).' and uid = '.intval($uid);

        if (!empty($parame['tag'])) {
            $tag = intval($parame['tag']);
            $tagsql = "select gid from shop_goods_tags where crid = ".intval($crid).' and tid = '.$tag;
            $gidData = $this->shopdb->query($tagsql)->list_array();
            if(empty($gidData)) return false;
            $gidArr = array();
            foreach($gidData as $gidRow) {
                $gidArr[] = $gidRow['gid'];
            }
            $gidStr = implode(',', $gidArr);
            $where .= ' and gid in ('.$gidStr.')';
        }

        if (isset($parame['is_audit'])) {
            $where .= ' and is_audit = '.$parame['is_audit'];
        }
        if (isset($parame['is_sale'])) {
            $where .= ' and is_sale = '.$parame['is_sale'];
        }
        if (isset($parame['del'])) {
            $where .= ' and del = '.$parame['del'];
        }
        if (!empty($parame['goods_name'])) {
            $where .= ' and goods_name like \'%'.$parame['goods_name'].'%\'';
        }
        if (!empty($parame['start_time']) && !empty($parame['end_time'])) {
            $where .= ' and dateline >= '.$parame['start_time'].' and dateline <= '.$parame['end_time'];
        } elseif (!empty($parame['start_time'])) {
            $where .= ' and dateline >= '.$parame['start_time'];
        } elseif (!empty($parame['end_time'])) {
            $where .= ' and dateline <= '.$parame['end_time'];
        }
        // 商品默认按点击数降序排序
        if (isset($parame['orderby'])) {
            if(is_array($parame['orderby'])) {
                // 先遍历只显示积分或者商品
                foreach($parame['orderby'] as $field=>$descOrAsc) {
                    if ($field == 'pre_price') {
                        $where .= ' and is_real = 1';
                    } else if ($field == 'score_price') {
                        $where .= ' and is_real = 2';
                    }
                }

                // 排序
                $i = 0;
                $where .= ' order by ';
                foreach($parame['orderby'] as $field=>$descOrAsc) {
                    if ($i == 0) {
                        $where .= $field.' '.$descOrAsc;
                    } else {
                        $where .= ','.$field.' '.$descOrAsc;
                    }
                }
            }
        }else { // 默认综合(点击数)排序
            $where .= ' order by gid desc';
        }

        // 分页
        $limit = '';
        if (!empty($parame['pagesize'])) {
            if (!empty($parame['page'])) $start = (intval($parame['page']) - 1) * intval($parame['pagesize']);
            else $start = 0;
            $limit = ' limit '.$start.','.intval($parame['pagesize']);
        }

        // 统计总条数
        $countSql = "select count(1) as count from shop_goods ".$where;
        $countData = $this->shopdb->query($countSql)->row_array();
        $count = empty($countData['count']) ? 0 : $countData['count'];

        $sql .= $where.$limit;
        $goodsData = $this->shopdb->query($sql)->list_array();

        $dataArr['count'] = $count;
        $dataArr['data'] = $goodsData;
        return $dataArr;
    }

    /**
     * 商品单个或批量上架或下架
     * @param int $crid  (网校 ID)
     * @param int $uid (用户 ID)
     * @param string $gids (商品 ID)
     * @param int $sale (上下架状态)
     * @return bool
     */
    public function saletoggle($crid, $uid, $gids, $sale) {
        if(empty($crid) || empty($uid) || empty($gids)) return false;
        if (!in_array($sale, array(0,1))) return false;
        $gidArr = array_unique(explode(',', $gids));
        $gids = implode(',', $gidArr);

        return $this->shopdb->update('shop_goods', array('is_sale'=>$sale, 'del'=>0),'gid in ('.$gids.') and crid = '.intval($crid).' and uid = '.intval($uid));
    }

    /**
     * 商品单个或者批量删除
     * @param int $crid (网校 ID)
     * @param int $uid　(用户 ID)
     * @param int $gids (商品 ID)
     * @param int $del (1 为删除)
     * @return bool
     */
    public function batchdel($crid, $uid, $gids, $del) {
        if(empty($crid) || empty($uid) || empty($gids) || $del != 1) return false;
        $gidArr = array_unique(explode(',', $gids));
        $gids = implode(',', $gidArr);

        return $this->shopdb->update('shop_goods', array('del'=>1), 'gid in('.strval($gids).')'.' and crid = '.intval($crid).' and uid = '.intval($uid));
    }

    /**
     * 商品还原 (由删除状态还原到下架状态)
     * @param int $crid (网校 ID)
     * @param int $uid (用户 ID)
     * @param int $gid (商品 ID)
     * @return bool
     */
    public function restore($crid ,$uid, $gid) {
        if (empty($crid) || empty($uid) || empty($gid)) return false;
        return $this->shopdb->update('shop_goods', array('del'=>0, 'is_sale'=>0), 'crid = '.intval($crid).' and uid = '.$uid.' and gid = '.intval($gid));
    }
}