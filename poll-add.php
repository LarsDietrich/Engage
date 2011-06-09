<?php 
/* 
 * Create New Poll
 */
include('inc-pre.php'); 

$colname_rsTopic = "-1";
if (isset($_GET['id'])) {
  $colname_rsTopic = $_GET['id'];
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "createthis")) {
  $insSQL = sprintf(
    "INSERT INTO tPolls (pid, tid, question, anstext1, anstext2, anstext3) 
    VALUES (NULL, %s, %s, %s, %s, %s)",
    GetSQLValueString($_POST['ftid'], "int"),
    GetSQLValueString($_POST['fquestion'], "text"),
    GetSQLValueString($_POST['fanstext1'], "text"),
    GetSQLValueString($_POST['fanstext2'], "text"),
    GetSQLValueString($_POST['fanstext3'], "text")
    );
  
  mysql_select_db($database_cn, $cn);
  $Result1 = mysql_query($insSQL, $cn) or die(mysql_error());
  
  $insertGoTo = "topic.php?id=".$_POST['ftid'];
  // if (isset($_SERVER['QUERY_STRING'])) {
  //   $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
  //  $insertGoTo .= $_SERVER['QUERY_STRING'];
  // } else {
  //  $insertGoTo .= "?id=".$_POST['ftid'];
  // }  
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_cn, $cn);
$q_rsTopics = mysql_query("SELECT * FROM ttopics") or die(mysql_error());
$row_rsTopics = mysql_fetch_assoc($q_rsTopics);
// $totalRows_rsTopics = mysql_num_rows($q_rsTopics);

$currentpage = "Create Poll";

include('_top.php');
?>

    <div id="topic-head">
      <h2>Create Poll</h2>
    </div>

    <div class="clear"> </div>

    <div id="main" role="main">

      <div class="content">
        
        <h3>Create Poll</h3>
        
        <div class="form-container">
          <form name="fcreatepoll" method="POST" action="<?php echo $editFormAction; ?>">
            <fieldset>
              <legend>Poll Setup</legend>
              <div class="fieldgroup">
                <label for="ttopic">Create poll for Topic: <select name="ftid" tabindex="1">
                  <?php do { ?>
                    <option value="<?php echo $row_rsTopics['id']?>" <?php if (!(strcmp($row_rsTopics['id'], $colname_rsTopic))) {echo "selected=\"selected\"";} ?>>
                      <?php echo $row_rsTopics['name']?>
                    </option>
                  <?php } while ($row_rsTopics = mysql_fetch_assoc($q_rsTopics)); ?>
                </select></label>
              </div>
              <div class="fieldgroup">
                <label for="fquestion">Question: <textarea name="fquestion" rows="4" cols="55" placeholder="Enter your desired poll question" tabindex="20" required></textarea></label>
              </div>
              <div class="fieldgroup">
                <label for="fanstext1">Answer #1: <input name="fanstext1" type="text" value="Yes" size="50" tabindex="30"></label><br />
                <label for="fanstext2">Answer #2: <input name="fanstext2" type="text" value="No" size="50" tabindex="40"></label><br />
                <label for="fanstext3">Answer #3: <input name="fanstext3" type="text" value="Maybe" size="50" tabindex="50"></label><br />
              </div>

              <input name="MM_insert" type="hidden" value="createthis">
              
            </fieldset>
            
            <input name="sub" type="submit" class="dark medium awesome" value=" Create Poll " tabindex="60">
              
          </form>
        </div><!-- / .form-container -->

        <p class="center"><a href="index.php">Dashboard</a></p>

      </div><!-- / .content -->

    </div><!-- / #main -->


<?php include('_bottom.php'); ?>