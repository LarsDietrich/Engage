<?php 
/* 
 * Poll Display & Response -> Poll Results
 */
include('inc-pre.php'); 

$colname_rsPoll = "-1";
if (isset($_GET['id'])) {
  $colname_rsPoll = $_GET['id'];
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "pollresponse")) {
  if (!isset($_COOKIE["poll" . $colname_rsPoll])) {
    $insSQL = sprintf(
      "INSERT INTO tanswers (pid, ans1) 
      VALUES (%s, %s)",
      GetSQLValueString($_POST['fpid'], "text"),
      GetSQLValueString($_POST['fanswer'], "text")
      );
    
    mysql_select_db($database_cn, $cn);
    $Result1 = mysql_query($insSQL, $cn) or die(mysql_error());
    
    setcookie("bfcopoll" . $colname_rsPoll, 1, time()+259200, "/");
    
    $insertGoTo = "poll-results.php";
    if (isset($_SERVER['QUERY_STRING'])) {
      $insertGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
      $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    
    header(sprintf("Location: %s", $insertGoTo));
  }
}

mysql_select_db($database_cn, $cn);
$q_rsPoll= sprintf("SELECT * FROM (tpolls LEFT JOIN ttopics ON ttopics.id = tpolls.tid) WHERE pid=%s", 
  GetSQLValueString($colname_rsPoll, "int")
  ) or die(mysql_error());
$rsPoll = mysql_query($q_rsPoll, $cn) or die(mysql_error());
$row_rsPoll = mysql_fetch_assoc($rsPoll);

$currentpage = "Take a Poll";

include('_top.php');
?>

    <div id="topic-head">
      <h2><a href="topic.php?id=<?php echo $row_rsPoll['tid']; ?>"><?php echo $row_rsPoll['name']; ?></a></h2>
    </div>

    <div class="clear"> </div>

    <div id="main" role="main">

      <div class="content">
          <a class="navright" href="poll-results.php?id=<?php echo $colname_rsPoll; ?>">Results</a>
        <h3>Poll</h3>
        
        <p class="question">&quot;<?php echo $row_rsPoll['question']; ?>&quot;</p>
        
        <?php if (isset($_COOKIE["bfcopoll" . $colname_rsPoll])) { ?>
          <p class="medium center fail">You have already responded to this poll.</p>
          <p class="center"><a href="index.php">Dashboard</a> &raquo; <a href="topic.php?id=<?php echo $row_rsPoll['tid']; ?>"><strong><?php echo $row_rsPoll['name']; ?></strong> Discussion</a> &raquo; <a href="poll-results.php?id=<?php echo $colname_rsPoll; ?>">Poll Results</a></p>
          <p class="vader"><img src="img/vader.jpg" alt="this is a joke" /></p>
        <?php } else { ?>
          <div class="form-container">
            <form name="fcreatepoll" method="POST" action="<?php echo $editFormAction; ?>">
              <fieldset>
                <legend>Choose one...</legend>
                  <div class="radio-container">
                    <input name="fanswer" type="radio" value="Y" required /> <label><?php echo $row_rsPoll['anstext1']; ?></label><br />
                    <input name="fanswer" type="radio" value="N" required /> <label><?php echo $row_rsPoll['anstext2']; ?></label><br />
                    <input name="fanswer" type="radio" value="M" required /> <label><?php echo $row_rsPoll['anstext3']; ?></label><br />
                  </div>
                <input name="fpid" type="hidden" value="<?php echo $colname_rsPoll; ?>" />
                <input name="MM_insert" type="hidden" value="pollresponse">
              </fieldset>
              <input name="sub" type="submit" class="dark medium awesome" value="Submit">
            </form>
          </div><!-- / .form-container -->
          <p class="center"><a href="index.php">Dashboard</a> &raquo; <a href="topic.php?id=<?php echo $row_rsPoll['tid']; ?>"><strong><?php echo $row_rsPoll['name']; ?></strong> Discussion</a></p>
        <?php } ?>

        

      </div><!-- / .content -->

    </div><!-- / #main -->

    <div class="side">

      <div id="tools">
        <h3>Tools</h3>
        <ul class="tools">
          <li><a href="topic-add.php" accesskey="t"><div class="icon"><img src="img/icons/08-chat.png" /></div> Create <span class="ak">T</span>opic</a></li>
          <li><a href="poll-add.php?id=<?php echo $row_rsPoll['tid']; ?>" accesskey="p"><div class="icon"><img src="img/icons/117-todo.png" /></div> Create <span class="ak">P</span>oll</a></li>
        </ul>
      </div><!-- / #tools -->
    
    </div><!-- / .side -->
<?php include('_bottom.php'); ?>