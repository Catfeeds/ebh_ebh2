<?php
/**
 * 画板
 */

class DrawingboardController extends CControl
{
    public function index()
    {
        // $uid  = empty($_GET['uid']) ? 0 : intval($_GET['uid']);  // 提交画板的学生 id
        // $qid  = empty($_GET['qid']) ? 0 : intval($_GET['qid']);  // 回答的题目 id
        // $icid = empty($_GET['icid']) ? 0 : intval($_GET['icid']);// 所属互动的 id
        // $crid = empty($_GET['crid']) ? 0 : intval($_GET['crid']);// 所属网校的 id


        // $this->assign('uid', $uid);
        // $this->assign('qid', $qid);
        // $this->assign('icid', $icid);
        // $this->assign('crid', $crid);
        $imgsrc = $this->input->get('imgsrc');
        $this->assign('imgsrc', $imgsrc);
        $this->display('drawingboard/index');
    }
}