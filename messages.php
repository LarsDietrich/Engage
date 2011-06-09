<?php 
/*
 * embeddable Message list
 */

/* REMOVE before embedding */
// include('inc-pre.php'); 

$colname_rsMtopic = "-1";
if (isset($_GET['id'])) {
  $colname_rsMtopic = $_GET['id'];
}

$q_rsMsgs = sprintf("SELECT * FROM tmessages WHERE tid=%s ORDER BY time DESC",
  GetSQLValueString($colname_rsMtopic, "int")
  );

mysql_select_db($database_cn, $cn);
$rsMsgs = mysql_query($q_rsMsgs, $cn) or die(mysql_error());
$row_rsMsgs = mysql_fetch_assoc($rsMsgs);
$totalRows_rsMsgs = mysql_num_rows($rsMsgs);


do { ?>
<div class="message">
  <p><?php echo $row_rsMsgs['msg']; ?></p>
  <span class="meta">(<?php echo $row_rsMsgs['tid']."/".$row_rsMsgs['id']; ?>) posted <?php echo $row_rsMsgs['time']; ?></span>  
</div>
<?php } while($row_rsMsgs = mysql_fetch_array($rsMsgs));

?>