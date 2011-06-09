<?php 
include('inc-pre.php'); 

mysql_select_db($database_cn, $cn);

$rsTopics = mysql_query("SELECT * FROM ttopics") or die(mysql_error());  

$q_rsPolls = "SELECT * FROM tPolls ORDER BY pid DESC";
$rsPolls = mysql_query($q_rsPolls, $cn) or die(mysql_error());
$row_rsPolls = mysql_fetch_assoc($rsPolls);
$totalRows_rsPolls = mysql_num_rows($rsPolls);

$currentpage = "Dashboard";

include('_top.php');
?>

    <div id="topic-head">
      <h2>Dashboard</h2>
    </div>

    <div class="clear"> </div>

    <div id="main" role="main">

      <div class="content">

        <div id="topic-list">
          <h3>Topics</h3>
          <ul>
            <?php while($row_rsTopics = mysql_fetch_array($rsTopics)) { ?> 
            <li><a class="dark large awesome" href="topic.php?id=<?php echo $row_rsTopics['id']; ?>"><?php echo $row_rsTopics['name']; ?></a></li>
            <?php } ?>
          </ul>
        </div><!-- / #topic-list -->

      </div><!-- / .content -->

    </div><!-- / #main -->

    <div class="side">

      <div id="tools">
        <h3>Tools</h3>
        <ul class="tools">
          <li><a href="topic-add.php" accesskey="t"><div class="icon"><img src="img/icons/08-chat.png" /></div> Create <span class="ak">T</span>opic</a></li>
          <li><a href="poll-add.php" accesskey="p"><div class="icon"><img src="img/icons/117-todo.png" /></div> Create <span class="ak">P</span>oll</a></li>
          
        </ul>
      </div><!-- / #tools -->
      
      <div id="poll-pane">
        <h3>Polls</h3>
        <ul>
          <?php do { ?>
          <li><a href="poll.php?id=<?php echo $row_rsPolls['pid']; ?>"><?php echo $row_rsPolls['question']; ?></a></li>
          <?php } while($row_rsPolls = mysql_fetch_array($rsPolls)); ?>
        </ul>
      </div><!-- / #poll-pane -->
    
    </div><!-- / .side -->

<?php include('_bottom.php'); ?>