<?php
require_once "mdie/meekrodb.php";
ini_set('display_errors', '0');
ini_set('max_execution_time', '10000');
ini_set('max_input_time', '10000');
ini_set('max_input_vars', '10000');
?>
<html>
<head>
<script src="jquery.min.js"></script>
<link rel="stylesheet" href="bootstrap/bootstrap.min.css" media="screen">
<link rel="stylesheet" href="jquery-ui.min.css" type="text/css" />
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="-1">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">Welcome</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor02">
    <ul class="navbar-nav mr-auto">

    </ul>
    <form action="history.php" method="get" class="form-inline my-2 my-lg-0">
      <input type='text' name='c' class='auto' placeholder="Search">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Go</button>
  </form>
  </div>
</nav>
<?php 


$step = $_GET["step"];

  if(!$step) {
    $step = 0;
  }

switch ($step) {

// Introduction
  case 0:

    ?>

<h3>
  Preperation
  <small class="text-muted">the basics</small>
</h3>
<p class="lead"><?php


    echo "Firstly, as this is experimental, it takes a little work to setup, but is greatly beneficial.<br />";
    echo "We'll need to: <br /><br />1) Setup MySQL details in 2 places,<br />2) Import SQL files, <br />3) Delete prep.php, <br/>4) Decide which coins to be indexed. ";;
    echo "<br /><br />Very easy ... <hr />Data polled via Coin Gecko<hr />";
    echo "<a href=\"?step=1\">Click for Step 1</a></p>";
    break;
    

  case 1:
    echo "Step 1<hr />";
    echo "In <strong>mdie/connect.php</strong>, <strong>mdie/meekrodb.php</strong>, and <strong>search.php</strong> to enter MySQL details.<br />";
    echo "So you will have wanted to create a user/database specifically for MDIE. (Grant all for the install and then max CREATE, INSERT, SELECT, UPDATE).";
    echo "<br /><br />Step 1 must be complete to complete step 2.";
    echo "<br /><br /><a href=\"?step=2\">Click for Step 2</a>";
    break;

// Importing of SQL files
  case 2:
    //echo "";
    include "importsql.php";
    break;

  case 3:
    echo "Together we made it! Step 3. <hr /><br /><br />";
    echo "Once MDIE is running, a list of coins can be found in www with the name COINLIST.pdf or:<br />";
    echo "https://urcpu.com/coinlist.pdf<br /><br />";
    echo "By default, MDIE starts with around 30 coins to index. Go to \"Coin Management\" to remove coins<br />";
    echo "or add new ones. You want to use the \"slug\" found in the conlist PDF.<br /><br />";
    echo "For example, Bitcoin Silver would be added as <strong>bitcoin-silver</strong><br /><br />";
    echo "MDIE is limited to 100 updates per minute on prices. In theory you could safely poll 90 coins per minute. Time adjustment feature soon.<br /><br />";
    echo "When ready, delete prep.php inside the <strong>www</strong> directory and restart MDIE.<br /><br >";
    echo "Please submit any bugs, contributions, etc on the repo or join my Discord.<br /><br />";
    echo "Thank you for trying Market Data Indexing Engine!";
    break;
}

?>
</body>
</html>
<?php


 ?>
