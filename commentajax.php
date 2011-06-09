<?php 
include('inc-pre.php');

if($_POST) {
  $now = date("YmdHis");
  $comm = $_POST['comment'];
  $comment = nl2br($comm);
  $ecomment = mysql_real_escape_string($comment);
  $top_id = $_POST['topic_id']; 
  $ajaxins = "INSERT INTO tmessages(id,tid,msg,time) VALUES (NULL,'$top_id','$ecomment','$now')";
  mysql_select_db($database_cn, $cn);
  mysql_query($ajaxins, $cn) or die(mysql_error());
}
?>
<div class="message">
  <p><?php echo $comment; ?></p>
</div>
