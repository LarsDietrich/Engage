<?php 
include('inc-pre.php'); 

$colname_rsTopic = "-1";
if (isset($_GET['id'])) {
  $colname_rsTopic = $_GET['id'];
}

$q_rsTopic = sprintf("SELECT name FROM ttopics WHERE id=%s LIMIT 1",
  GetSQLValueString($colname_rsTopic, "int")
  );
$q_rsPolls = sprintf("SELECT * FROM tPolls WHERE tid=%s", 
  GetSQLValueString($colname_rsTopic, "int")
  );
  
 
mysql_select_db($database_cn, $cn);
$rsTopic = mysql_query($q_rsTopic, $cn) or die(mysql_error());
$rsPolls = mysql_query($q_rsPolls, $cn) or die(mysql_error());
$row_rsTopic = mysql_fetch_assoc($rsTopic);
$row_rsPolls = mysql_fetch_assoc($rsPolls);
$totalRows_rsPolls = mysql_num_rows($rsPolls);

$currentpage = "Topic: ".$row_rsTopic['name'];
?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <title><?php echo $sitetitle; ?> : presentus</title>
  <meta name="description" content="a webapp enabling collaborative presentations via live audience feedback">
  <meta name="author" content="Daniel Bishop">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- <meta http-equiv="REFRESH" content="5"> -->

  <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">


  <!-- CSS: implied media="all" -->
  <link rel="stylesheet" href="css/style.css?v=2">

  <!-- Uncomment if you are specifically targeting less enabled mobile browsers
  <link rel="stylesheet" media="handheld" href="css/handheld.css?v=2">  -->

  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="js/libs/modernizr-1.7.min.js"></script>

</head>

<body>


  
  <header>
    <h1><a href="index.php"><?php echo $sitetitle; ?></a></h1>
  </header>
  
  <div id="container">
    
    <div id="topic-head">
      <h2><?php echo $row_rsTopic['name']; ?></h2>
    </div>

    <div class="clear"> </div>

    <div id="main" role="main">

      <div class="content">

        <div id="discussion-pane">
            <a class="navright" href="topic.php?id=<?php echo $colname_rsTopic; ?>">Audience View</a>
          <h3>Discussion</h3>
          <div id="jqmsgs">
            

            <div id="flash"></div>
            <div id="update" class="timeline">
            <?php
            //include('config.php');
            //$post_id value comes from the POSTS table
            $sql=mysql_query("SELECT * FROM tmessages WHERE tid='$colname_rsTopic' ORDER BY id DESC");
            while ($row=mysql_fetch_array($sql)) { $comment_dis=$row['msg']; ?>
              <div class="message">
                <p><?php echo $comment_dis; ?></p>
              </div>
            <?php } ?>
            </div>


          </div>
        </div><!-- / #discussion-pane -->

      </div><!-- / .content -->

    </div><!-- / #main -->

    <div class="side">
      
      <div id="tools">
        <h3>Tools</h3>
        <ul class="tools">
          <li><a href="topic-add.php" accesskey="t"><div class="icon"><img src="img/icons/08-chat.png" /></div> Create <span class="ak">T</span>opic</a></li>
          <li><a href="poll-add.php?id=<?php echo $colname_rsTopic; ?>" accesskey="p"><div class="icon"><img src="img/icons/117-todo.png" /></div> Create <span class="ak">P</span>oll</a></li> 
        </ul>
      </div><!-- / #tools -->
      
      <div id="poll-pane">
        
        
        <h3>Polls</h3>
        
        <ul id="topic-polls">
          <?php getPolls($colname_rsTopic); ?>
          
        </ul>

      </div><!-- / #poll-pane -->
      
    </div><!-- / .side -->
    
  </div> <!--! end of #container -->

  <div class="clear" style="height: 30px;"> </div>

  <footer>
    <p>Engage was scratch-built... it needs help.</p>
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
    
      // update message list every 2 seconds
      setInterval(function() {
        $("#update").load(location.href+"&t="+1*new Date()+" #update>*","");
      }, 2000);
      // update poll results every 5 seconds
      setInterval(function() {
        $("#topic-polls").load(location.href+"&t="+1*new Date()+" #topic-polls>*","");
      }, 5000);
      
    });
  </script>

  <!--[if lt IE 7 ]>
    <script src="js/libs/dd_belatedpng.js"></script>
    <script>DD_belatedPNG.fix("img, .png_bg"); // Fix any <img> or .png_bg bg-images. Also, please read goo.gl/mZiyb </script>
  <![endif]-->

</body>
</html>