<!DOCTYPE html>
<html lang="en">
<head>
<title>Film Results</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="stylesheet.css">
</head>
<body>

<div class="header">
  <h1>Film Information Page</h1>
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
    <h2>MOVIE INFORMATION:</h2>
    <p>
      <?php

        $db = new mysqli('localhost', 'cs143', '', 'cs143');
          if ($db->connect_errno > 0) { 
            die('Unable to connect to database [' . $db->connect_error . ']'); 
          }
        $movie_id = $_GET["id"];
        $query = "SELECT Movie.id, Movie.title, Movie.company, Movie.rating, GROUP_CONCAT(DISTINCT MovieGenre.genre SEPARATOR ', ') AS genre FROM Movie, MovieGenre WHERE Movie.id = $movie_id AND Movie.id = MovieGenre.mid GROUP BY Movie.id";
        $a = $db->query("$query");

        if (!$a) {
            $errmsg = $a->error; 
            print "Query 1 failed: $errmsg <br>"; 
            exit(1); 
        }
        ?>
        <table>
          <thread>
            <th style="text-align:left">Title</th>
            <th style="text-align:left">Production Company</th>
            <th style="text-align:left">MPAA Rating</th>
            <th style="text-align:left">Genre</th>
          </thread>
          <tbody>
            <?php
              while ($row = $a->fetch_assoc()) {
                $id = $row['id'];
                $title = $row['title'];
                $company = $row['company'];
                $rating = $row['rating'];
                $genre = $row['genre'];
                if(empty($dod)){
                  $dod = "Still Alive";
                }
                print "<tr>
                        <td><a href='film.php?id=$id'>$title</a></td> 
                        <td>$company</td>
                        <td>$rating</td>
                        <td>$genre</td>
                      </tr>";
              }
            ?>
          </tbody>
    </p>
    <p>
      <?php

        $db = new mysqli('localhost', 'cs143', '', 'cs143');
          if ($db->connect_errno > 0) { 
            die('Unable to connect to database [' . $db->connect_error . ']'); 
          }
        $actor_id = $_GET["id"];
        $query = "SELECT Actor.id, Actor.first, Actor.last, MovieActor.role FROM Actor, MovieActor, Movie WHERE Movie.id = $movie_id AND Actor.id = MovieActor.aid AND Movie.id = MovieActor.mid";
        $m = $db->query("$query");

        if (!$m) {
            $errmsg = $m->error; 
            print "Query 2 failed: $errmsg <br>"; 
            exit(1); 
        }
        ?>
        <table>
          <thread>
            <th style="text-align:left">Name</th>
            <th style="text-align:left">Role</th>
          </thread>
          <tbody>
            <?php
              while ($row = $m->fetch_assoc()) { 
                $id = $row['id'];
                $name = $row['first'] . ' ' . $row['last'];
                $role = $row['role'];
                print "<tr>
                        <td><a href='actor.php?id=$id'>$name</a></td> 
                        <td>$role</td>
                      </tr>"; 
              }
            ?>
    </p>
    <h2>ACTORS IN MOVIE:</h2>
    <p>
      <?php

        $db = new mysqli('localhost', 'cs143', '', 'cs143');
          if ($db->connect_errno > 0) { 
            die('Unable to connect to database [' . $db->connect_error . ']'); 
          }
        $query = "SELECT AVG(rating) AS r FROM Review WHERE mid = $movie_id";
        $d = $db->query("$query");

        if (!$d) {
            $errmsg = $d->error; 
            print "Query 3 failed: $errmsg <br>"; 
            exit(1); 
        }
        ?>
        <table>
          <thread>
            <th style="text-align:left">Rating</th>
          </thread>
          <tbody>
            <?php
              while ($row = $d->fetch_assoc()) { 
                $rating = $row['r'];
              }
              print "<tr>
                        <td>$rating</td> 
                    </tr>"; 
            ?>
    </p>
    <h3>AVERAGE RATING:</h3>
    <p>
      <?php

        $db = new mysqli('localhost', 'cs143', '', 'cs143');
          if ($db->connect_errno > 0) { 
            die('Unable to connect to database [' . $db->connect_error . ']'); 
          }
        $query = "SELECT name, time, rating, comment FROM Review WHERE mid = $movie_id";
        $c = $db->query("$query");

        if (!$c) {
            $errmsg = $c->error; 
            print "Query 4 failed: $errmsg <br>"; 
            exit(1); 
        }
        ?>
        <table>
          <thread>
            <th style="text-align:left">Name</th>
            <th style="text-align:left">Time</th>
            <th style="text-align:left">Rating</th>
            <th style="text-align:left">Comment</th>
          </thread>
          <tbody>
            <?php
              while ($row = $c->fetch_assoc()) { 
                $name = $row['name'];
                $time = $row['time'];
                $rating = $row['rating'];
                $comment = $row['comment'];
                print "<tr>
                        <td>$name</td> 
                        <td>$time</td>
                        <td>$rating</td> 
                        <td>$comment</td>
                      </tr>"; 
              }
            ?>
    </p>
    <h2><a href="comment.php?id=<?php echo $movie_id; ?>">Add a Review</a></h2>
    <h2>REVIEWS:</h2>
  </div>
</div>
</body>
</html>
