<?php

ini_set('display_errors', 1); 
error_reporting(E_ALL);




/* -- MySQL connection
      modify values below to reflect your setup -- */
$hostname_cn = "localhost";
$database_cn = "engagedb";
$username_cn = "presentadmin";
$password_cn = "herE843";

$sitetitle = "Company Management Retreat";
/* -- STOP EDITING -- */




$cn = mysql_pconnect($hostname_cn, $username_cn, $password_cn) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db($database_cn, $cn);


// clean input from forms
if (!function_exists("GetSQLValueString")) {
  function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
    if (PHP_VERSION < 6) {
      $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
    }
    $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
    switch ($theType) {
      case "text":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;    
      case "long":
      case "int":
        $theValue = ($theValue != "") ? intval($theValue) : "NULL";
        break;
      case "double":
        $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
        break;
      case "date":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;
      case "defined":
        $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
        break;
      }
      return $theValue;
  }
}


function isZero($val) {
  if ($val == 0) {
    return " zero";
  }
}


function getTopics() {
  $rsTopics = mysql_query("SELECT * FROM ttopics ORDER BY id");
  echo "<h3>Topics</h3>";
  echo "<ul>";
  while($row_rsTopics = mysql_fetch_array($rsTopics)) {  
    echo "<li><a class=\"\" href=\"topic.php?id=".$row_rsTopics['id']."\">".$row_rsTopics['name']."</a></li>";
  }
  echo "</ul>";
}


function getPollResults($pollID) {
  $qAns = "SELECT id AS ansid FROM tanswers WHERE pid='".$pollID."'";
  $rsAns = mysql_query($qAns) or die(mysql_error());

  if (mysql_num_rows($rsAns) == 0) {
    echo "<p class=\"center\">No results, yet.</p>\n";
    echo "<p>&nbsp;</p>\n";
    // exit;
  } else {

    $qYes = "SELECT COUNT(*) AS yes FROM tanswers WHERE pid=".$pollID." AND ans1='Y'";
    $qNo = "SELECT COUNT(*) AS no FROM tanswers WHERE pid=".$pollID." AND ans1='N'";
    $qMaybe = "SELECT COUNT(*) AS maybe FROM tanswers WHERE pid=".$pollID." AND ans1='M'";
    $q_rsPoll = "SELECT * FROM (tpolls LEFT JOIN tanswers ON tanswers.pid = tpolls.pid) WHERE tpolls.pid=".$pollID;
      
    $rsYes = mysql_query($qYes);
    $rsNo = mysql_query($qNo);
    $rsMaybe = mysql_query($qMaybe);
    $rsPoll = mysql_query($q_rsPoll);

    $row_rsYes = mysql_fetch_assoc($rsYes);
    $row_rsNo = mysql_fetch_assoc($rsNo);
    $row_rsMaybe = mysql_fetch_assoc($rsMaybe);
    $row_rsPoll = mysql_fetch_assoc($rsPoll);
    
    $yes = $row_rsYes['yes'];
    $no = $row_rsNo['no'];
    $maybe = $row_rsMaybe['maybe'];
    $yestext = $row_rsPoll['anstext1'];
    $notext = $row_rsPoll['anstext2'];
    $maybetext = $row_rsPoll['anstext3'];
    $votes = array($yes, $no, $maybe);
    $totalvotes = array_sum($votes);
    // -- COUNTS --
    echo "<span class=\"vote-total\"><a href=\"poll-results.php?id=".$pollID."\">".$totalvotes;
    if ($totalvotes == 1) {
      echo " vote</a></span>\n";
    } else {
      echo " votes</a></span>\n";
    } 
    echo "<ul class=\"counts\">\n";
    echo "  <li><span class=\"resnum".isZero($yes)."\">".$yes."</span> - ".$yestext."</li>\n";
    echo "  <li><span class=\"resnum".isZero($no)."\">".$no."</span> - ".$notext."</li>\n";
    echo "  <li><span class=\"resnum".isZero($maybe)."\">".$maybe."</span> - ".$maybetext."</li>\n";
    echo "</ul>\n";
  }

}


function getPolls($topicID) {
  $qry = "SELECT pid, question FROM tpolls WHERE tid = ".$topicID." ORDER BY pid DESC";
  $result = mysql_query($qry);
    
  while($row = mysql_fetch_array($result)) {
    echo "<li class=\"poll-link\"><a href=\"poll.php?id=".$row['pid']."\">".$row['question']."</a><br />";
    getPollResults($row['pid']);
    echo "</li>";
  }
}

?>