
<script type="text/javascript">

$(function() {

    //autocomplete
    $(".auto").autocomplete({
        source: "search.php",
        minLength: 3
    });

});
</script>

<link rel="stylesheet" href="jquery-ui.min.css" type="text/css" />
<script type="text/javascript" src="jquery-ui.min.js"></script>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor02">
    <ul class="navbar-nav mr-auto">
      <!--<li class="nav-item active">
        <a class="nav-link" href="#"> <span class="sr-only">(current)</span></a>
      </li>-->
      <li class="nav-item">
        <a class="nav-link" href="coinlist.php">Management</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="https://github.com/snick512/cryptomarketindexer">Github</a>
      </li>
    </ul>
    <form action="fromsearch.php" method="get" class="form-inline my-2 my-lg-0">
      <input type='text' name='c' class='auto' placeholder="Search">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Go</button>
  </form>
  </div>
</nav>
<br />
<a href="mdie/crawl.php"><button type="button" class="btn btn-outline-secondary">Manual Refresh</button></a>
<a href="mdie/update.php"><button type="button" class="btn btn-outline-danger">Reset Sim</button></a><br />
