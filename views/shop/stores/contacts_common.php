<div class="main" style="width:980px;padding:0;">
<div class="topkuang" style="margin-top: 0px;"></div>
<div class="zixun">
<div class="lefbian">
<ul>
<?php $catepath = $this->uri->path; 
?>
<li><p><a <?= $catepath=='contacts' ?'style="color: #9a9b9d;"':'style="color: #3D3D3D;"'?> href="<?= geturl('contacts')?>">联系方式</a></p></li>
<li><p><a <?= $catepath=='contacts/about' ?'style="color: #9a9b9d;"':'style="color: #3D3D3D;"'?> href="<?= geturl('contacts/about')?>">关于我们</a></p></li>
<li><p><a <?= $catepath=='contacts/join' ?'style="color: #9a9b9d;"':'style="color: #3D3D3D;"'?> href="<?= geturl('contacts/join')?>">加盟合作</a></p></li>
<li><p><a <?= $catepath=='contacts/copy' ?'style="color: #9a9b9d;"':'style="color: #3D3D3D;"'?> href="<?= geturl('contacts/copy')?>">版权说明</a></p></li>
<li><p><a <?= $catepath=='contacts/payment' ?'style="color: #9a9b9d;"':'style="color: #3D3D3D;"'?> href="<?= geturl('contacts/payment')?>">付款方式</a></p></li>
</ul>
</div>
