  <?php  $qtype=array('A'=>'单选题','B'=>'多选题','C'=>'填空题','D'=>'判断题','E'=>'文字题','H'=>'主观题','X'=>'答题卡','XTL'=>'听力题','XWX'=>'完形填空','XYD'=>'阅读理解','XZH'=>'组合题'); ?>
  <tr>
    <th>错误知识点</th>
    <th>题型</th>
    <th>题目总数</th>
    <th>错题数</th>
    <th>错题率</th>
  </tr>
  <?php foreach ($datapackage as $fenxi) { $i=0 ;?>
    <?php foreach ($fenxi['datas'] as $k=>$efenxi) {
        $falserat = $efenxi['falsenum']/$efenxi['totalnum'] * 100;
        $falserat = sprintf("%.2f",$falserat);
    ?>
    <tr>
      <?php if($i==0){$i=1;?>
      <td rowspan="<?=count($fenxi['datas'])?>"><?=$fenxi['chaptername']?></td>
      <?php }?>
      <td><?=!empty($qtype[$k])?$qtype[$k]:''?></td>
      <td><?=$efenxi['totalnum']?></td>
      <td><?=$efenxi['falsenum']?></td>
      <td><?=$falserat?>%</td>
    </tr>
    <?php }?>
  <?php }?>
