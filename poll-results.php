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

mysql_select_db($database_cn, $cn);
$q_rsTopic = sprintf("SELECT name FROM (ttopics LEFT JOIN tpolls ON tpolls.tid = ttopics.id) WHERE tpolls.pid=%s",
  GetSQLValueString($colname_rsPoll, "int")
  );
$q_rsPoll = sprintf("SELECT * FROM (tpolls LEFT JOIN tanswers ON tanswers.pid = tpolls.pid) WHERE tpolls.pid=%s", 
  GetSQLValueString($colname_rsPoll, "int")
  ) or die(mysql_error());
$q_rsYes = sprintf("SELECT COUNT(*) AS yes FROM tanswers WHERE pid=%s AND ans1='Y'", 
  GetSQLValueString($colname_rsPoll, "int")
  );
$q_rsNo = sprintf("SELECT COUNT(*) AS no FROM tanswers WHERE pid=%s AND ans1='N'", 
  GetSQLValueString($colname_rsPoll, "int")
  );
$q_rsMaybe = sprintf("SELECT COUNT(*) AS maybe FROM tanswers WHERE pid=%s AND ans1='M'", 
  GetSQLValueString($colname_rsPoll, "int")
  ); 

$rsTopic = mysql_query($q_rsTopic, $cn) or die(mysql_error());
$rsPoll = mysql_query($q_rsPoll, $cn) or die(mysql_error());
$rsYes = mysql_query($q_rsYes, $cn) or die(mysql_error());
$rsNo = mysql_query($q_rsNo, $cn) or die(mysql_error());
$rsMaybe = mysql_query($q_rsMaybe, $cn) or die(mysql_error());
$row_rsTopic = mysql_fetch_assoc($rsTopic);
$row_rsPoll = mysql_fetch_assoc($rsPoll);
$row_rsYes = mysql_fetch_assoc($rsYes);
$row_rsNo = mysql_fetch_assoc($rsNo);
$row_rsMaybe = mysql_fetch_assoc($rsMaybe);

$currentpage = "Take a Poll";

include('_top.php');
?>

    <div id="topic-head">
      <h2><a href="topic.php?id=<?php echo $row_rsPoll['tid']; ?>"><?php echo $row_rsTopic['name']; ?></a></h2>
    </div>

    <div class="clear"> </div>

    <div id="main" role="main">

      <div class="content">
        
        <h3>Poll</h3>
        
        <p class="question">&quot;<?php echo $row_rsPoll['question']; ?>&quot;</p>
        
        <div id="results">
        <?php getPollResults($row_rsPoll['pid']); ?>
        </div>
        
        <!-- COUNTS 
        <ul class="counts">
          <li <?php if($row_rsYes['yes'] == 0) { 
              echo "class=\"zero\">".$row_rsYes['yes']; 
            } else {
              echo "><strong>".$row_rsYes['yes']."</strong>";
            } ?> - <?php echo $row_rsPoll['anstext1']; ?></li>
          <li <?php if($row_rsNo['no'] == 0) { 
              echo "class=\"zero\">".$row_rsNo['no']; 
            } else {
              echo "><strong>".$row_rsNo['no']."</strong>"; 
            } ?> - <?php echo $row_rsPoll['anstext2']; ?></li>
          <li <?php if($row_rsMaybe['maybe'] == 0) { 
              echo "class=\"zero\">".$row_rsMaybe['maybe']; 
            } else { 
              echo "><strong>".$row_rsMaybe['maybe']."</strong>"; 
            } ?> - <?php echo $row_rsPoll['anstext3']; ?></li>
        </ul> -->
        
        <p class="center"><a href="index.php">Dashboard</a> &raquo; <a href="topic.php?id=<?php echo $row_rsPoll['tid']; ?>"><strong><?php echo $row_rsTopic['name']; ?></strong> Discussion</a></p>

      </div><!-- / .content -->

    </div><!-- / #main -->

    <div class="side">

      <?php include('inc-tools.php'); ?>
      

    
    </div><!-- / .side -->
    
  </div> <!--! end of #container -->

  <div class="clear" style="height: 30px;"> </div>

  <footer>
    <p>Engage was scratch-built by bishless... it needs help.</p>
    <p><img src="img/icons/91-beaker-2.png" alt=""></p>
    <p>Have a great retreat!</p>
  </footer>
    
  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js"></script>
  <script>window.jQuery || document.write("<script src='js/libs/jquery-1.5.1.min.js'>\x3C/script>")</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>
  <!-- end scripts-->

  <script type="text/javascript" >
    $(function() {
    
      setInterval(function() {
        $("#results").load(location.href+"&t="+1*new Date()+" #results>*","");
      }, 3000);
    
      
    });
  </script>

  <!--[if lt IE 7 ]>
    <script src="js/libs/dd_belatedpng.js"></script>
    <script>DD_belatedPNG.fix("img, .png_bg"); // Fix any <img> or .png_bg bg-images. Also, please read goo.gl/mZiyb </script>
  <![endif]-->

</body>
</html>