<!DOCTYPE html>
<html lang="en">
<head>
<title>Results</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="stylesheet.css">
</head>
<body>

<div class="header">
  <h1>Database Output</h1>
</div>

<div class="navbar">
  <a href="index.php">Home</a>
  <a href="search.php">Search Database</a>
  <a href="actor.php">Morgan Freeman</a>
  <a href="film.php">Happy Gilmore</a>
  <a href="comment.php">Add Comment</a>
</div>

<div class="row">
  <div class="main">
    <h2>RESULTS</h2>
    <p>
      <?php
        $db = new mysqli('localhost', 'cs143', '', 'cs143');
          if ($db->connect_errno > 0) { 
            die('Unable to connect to database [' . $db->connect_error . ']'); 
          } 
        $query = "SELECT * FROM Actor"; 
        $rs = $db->query($query);
        if (!$rs) {
            $errmsg = $db->error; 
            print "Query failed: $errmsg <br>"; 
            exit(1); 
        }

        $input = $_GET["search"]; 
        print $input;
      ?>
    </p>
  </div>
</div>

</body>
</html>
