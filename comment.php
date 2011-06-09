
<div >
  <form action="#" method="post">
    <input type="hidden" id="ftid" value="<?php echo $colname_rsTopic; ?>" /> 
    <textarea id="fcomment"></textarea><br />
    <input type="submit" class="submit" value=" Submit Comment " />
  </form>
</div>
<div id="flash"></div>
<ol id="update" class="timeline">
<?php
//include('config.php');
//$post_id value comes from the POSTS table
$sql=mysql_query("SELECT * FROM tmessages WHERE tid='$colname_rsTopic' ORDER BY id DESC");
while($row=mysql_fetch_array($sql)) {
  $comment_dis=$row['msg'];
  ?>
  <li class="box"><?php echo $comment_dis; ?></li>
<?php } ?>
</ol>
