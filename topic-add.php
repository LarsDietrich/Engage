<?php 
/* 
 * Create New Topic
 */
include('inc-pre.php'); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "createthis")) {
  $insSQL = sprintf(
    "INSERT INTO tTopics (id, name) VALUES (NULL, %s)",
    GetSQLValueString($_POST['fname'], "text")
    );
  
  mysql_select_db($database_cn, $cn);
  $Result1 = mysql_query($insSQL, $cn) or die(mysql_error());
  
  $insertGoTo = "index.php";
  // $insertGoTo = "topic.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&id=" : "?id=";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  
  header(sprintf("Location: %s", $insertGoTo));
}

$currentpage = "Create Topic";

include('_top.php');
?>

    <div id="topic-head">
      <h2>Create Topic</h2>
    </div>

    <div class="clear"> </div>

    <div id="main" role="main">

      <div class="content">

        <div id="discussion-pane">
        <h3><div class="icon"><img src="img/icons/08-chat.png" /></div> Create a new Topic of discussion</h3>

        <div class="form-container">  
          <form name="fcreatetopic" method="POST" action="<?php echo $editFormAction; ?>">
            <fieldset>
              <input name="fname" type="text" size="50" placeholder="Enter your desired topic name" tabindex="1" required>
              <input name="MM_insert" type="hidden" value="createthis">
              <input name="sub" type="submit" class="dark medium awesome" value=" Create " tabindex="2">
            </fieldset>
          </form>
        </div>

        <p class="center"><a href="index.php">Dashboard</a></p>

        </div><!-- / #discussion-pane -->

      </div><!-- / .content -->

    </div><!-- / #main -->



<?php include('_bottom.php'); ?>