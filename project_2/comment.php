<!DOCTYPE html>
<html lang="en">
<head>
<title>Review</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="stylesheet.css">
</head>
<body>

<div class="header">
  <h1>Add Review</h1>
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
      $query = "SELECT Movie.title FROM Movie WHERE Movie.id = $movie_id";
      $a = $db->query("$query");

      if (!$a) {
          $errmsg = $a->error; 
          print "Query 1 failed: $errmsg <br>"; 
          exit(1); 
      }

      while ($row = $a->fetch_assoc()) {
        $title = $row['title'];
      }
    ?>
    <h2>Add review to <?php echo $title; ?>:</h2>
    <form action="comment_output.php?id=<?php echo $movie_id; ?>" method="POST">
      <p>Name:</p> <input type="text" name="name" value="Anonymous">
      <p>Rating:</p>
      <select name="rating">
        <option value=1>1</option>
        <option value=2>2</option>
        <option value=3>3</option>
        <option value=4>4</option>
        <option value=5>5</option>
      </select>
      <p>Comment:</p><textarea name="message" rows="6" cols="25"></textarea><br />
      <input type="submit" value="Send"><input type="reset" value="Clear">
    </form>
  </div>
</div>
</body>
</html>
