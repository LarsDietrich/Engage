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

include('_top.php');
?>

    <div id="topic-head">
      <h2><?php echo $row_rsTopic['name']; ?></h2>
    </div>

    <div class="clear"> </div>

    <div id="main" role="main">

      <div class="content">

        <div id="discussion-pane">
            <a class="navright" href="topic-p.php?id=<?php echo $colname_rsTopic; ?>">Presenter View</a>
          <h3>Discussion</h3>
          <div id="jqmsgs">
            

            <div class="form-container">
              <form action="#" method="post">
                <fieldset>
                  <legend>Comment</legend>
                  <input type="hidden" id="ftid" value="<?php echo $colname_rsTopic; ?>" /> 
                  <textarea id="fcomment" rows="4" cols="60" tabindex="1"></textarea><br />
                </fieldset>
                <input type="submit" class="dark medium submit awesome" value=" Submit Comment " tabindex="2" />
              </form>
            </div>

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

          <p class="center"><a href="index.php">Dashboard</a></p>

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
    <p>Engage was scratch-built.</p>
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
        $("#update").load(location.href+"&t="+1*new Date()+" #update>*","");
        $("#topic-polls").load(location.href+"&t="+1*new Date()+" #topic-polls>*","");
      }, 2000);
    
      $(".submit").click(function() {

        var comment = $("#fcomment").val();
        var topic_id = $("#ftid").val(); 
        var dataString = {
          'comment': comment,
          'topic_id': topic_id
        };

        if(topic_id=='' || comment=='') {
          alert('Please Give Valid Details');
        } else {
          $("#flash").show();
          $("#flash").fadeIn(200).html('<img src="img/ajax-loader.gif" />Loading Comment...');
          $.ajax({
            type: "POST",
            url: "commentajax.php",
            data: dataString,
            cache: false,
            success: function(html) {
              $("#fcomment").val("");
              $("div#update").prepend(html);
              $("div#update div.message:first").fadeIn("slow");
              $("#flash").hide();
            }
          });
        } return false;
      }); 
    });
  </script>

  <!--[if lt IE 7 ]>
    <script src="js/libs/dd_belatedpng.js"></script>
    <script>DD_belatedPNG.fix("img, .png_bg"); // Fix any <img> or .png_bg bg-images. Also, please read goo.gl/mZiyb </script>
  <![endif]-->

</body>
</html>