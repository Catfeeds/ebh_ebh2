<tr><th>热门级别</th><td>
<input type="radio" name="hot" value="0" <?php if($data['hot']=='0') echo 'checked=checked' ?> >非热门
<input type="radio" name="hot" value="1" <?php if($data['hot']=='1') echo 'checked=checked' ?> >热门Ⅰ
<input type="radio" name="hot" value="2" <?php if($data['hot']=='2') echo 'checked=checked' ?> >热门Ⅱ
<input type="radio" name="hot" value="3" <?php if($data['hot']=='3') echo 'checked=checked' ?> >热门Ⅲ
</td></tr>                                                                                     
                                
<!--  -->
<tr><th>置顶级别</th><td>
<input type="radio" name="top" value="0" <?php if($data['top']=='0') echo 'checked=checked' ?> >非置顶
<input type="radio" name="top" value="1" <?php if($data['top']=='1') echo 'checked=checked' ?> >置顶Ⅰ
<input type="radio" name="top" value="2" <?php if($data['top']=='2') echo 'checked=checked' ?> >置顶Ⅱ
<input type="radio" name="top" value="3" <?php if($data['top']=='3') echo 'checked=checked' ?> >置顶Ⅲ
</td></tr> 
 
<!--  -->
<tr><th>精华级别</th><td>
<input type="radio" name="best" value="0" <?php if($data['best']=='0') echo 'checked=checked' ?> >非精华
<input type="radio" name="best" value="1" <?php if($data['best']=='1') echo 'checked=checked' ?>>精华Ⅰ
<input type="radio" name="best" value="2" <?php if($data['best']=='2') echo 'checked=checked' ?>>精华Ⅱ
<input type="radio" name="best" value="3" <?php if($data['best']=='3') echo 'checked=checked' ?>>精华Ⅲ
</td></tr>