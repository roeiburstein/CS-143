<!DOCTYPE html>
<html lang="en">
<head>
<title>Comment Output</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="stylesheet.css">
</head>
<body>

<div class="header">
  <h1>Comment Output</h1>
</div>

<div class="navbar">
  <a href="index.php">Home</a>
  <a href="search.php">Search Database</a>
  <a href="actor.php?id=21083">Morgan Freeman</a>
  <a href="film.php?id=1747">Happy Gilmore</a>
  <a href="comment.php?id=1747">Add Comment</a>
</div>

<div class="row">
  <div class="main">
    <?php
      $db = new mysqli('localhost', 'cs143', '', 'cs143');
      if ($db->connect_errno > 0) { 
        die('Unable to connect to database [' . $db->connect_error . ']'); 
      }
      $movie_id = $_GET["id"];
      $name = $_POST["name"];
      $rating = $_POST["rating"];
      $comment = $_POST["message"];
      
      $query = "INSERT INTO Review(name, time, mid, rating, comment) VALUES('$name', NOW(), $movie_id, $rating, '$comment')";
      $rs = $db->query($query);
      if (!$rs) {
        $errmsg = $db->error; 
        print "Query failed: $errmsg <br>"; 
        exit(1); 
      }

    ?>
    <h2>Thank you for your review.</h2>
    <br>
    <h3>Summary:</h3>
    <h4>Name: <?php echo $name; ?> </h4>
    <h4>Rating: <?php echo $rating; ?> </h4>
    <h4>Comment: <?php echo $comment; ?> </h4>
    <br>
    <h3><a href="film.php?id=<?php echo $movie_id; ?>">Go back to movie</a></h3>
  </div>
</div>
</body>
</html>
