<!DOCTYPE html>
<html lang="en">
<head>
<title>Actor Results</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="stylesheet.css">
</head>
<body>

<div class="header">
  <h1>Actor Information Page</h1>
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
    <h2>ACTOR INFORMATION:</h2>
    <p>
      <?php

        $db = new mysqli('localhost', 'cs143', '', 'cs143');
          if ($db->connect_errno > 0) { 
            die('Unable to connect to database [' . $db->connect_error . ']'); 
          }
        $actor_id = $_GET["id"];
        $query = "SELECT first, last, sex, dob, dod FROM Actor WHERE id = $actor_id";
        $a = $db->query("$query");

        if (!$a) {
            $errmsg = $a->error; 
            print "Query 1 failed: $errmsg <br>"; 
            exit(1); 
        }
        ?>
        <table>
          <thread>
            <th style="text-align:left">Name</th>
            <th style="text-align:left">Sex</th>
            <th style="text-align:left">Date of Birth</th>
            <th style="text-align:left">Date of Death</th>
          </thread>
          <tbody>
            <?php
              while ($row = $a->fetch_assoc()) {
                $name = $row['first'] . ' ' . $row['last'];
                $sex = $row['sex'];
                $dob = $row['dob'];
                $dod = $row['dod'];
                if(empty($dod)){
                  $dod = "Still Alive";
                }
                print "<tr>
                        <td><a href='actor.php?id=$actor_id'>$name</a></td> 
                        <td>$sex</td>
                        <td>$dob</td>
                        <td>$dod</td>
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
        $query = "SELECT Movie.id, MovieActor.role, Movie.title FROM Actor, MovieActor, Movie WHERE Actor.id = $actor_id AND Actor.id = MovieActor.aid AND Movie.id = MovieActor.mid";
        $m = $db->query("$query");

        if (!$m) {
            $errmsg = $m->error; 
            print "Query 2 failed: $errmsg <br>"; 
            exit(1); 
        }
        ?>
        <table>
          <thread>
            <th style="text-align:left">Role</th>
            <th style="text-align:left">Movie Title</th>
          </thread>
          <tbody>
            <?php
              while ($row = $m->fetch_assoc()) { 

                $id = $row['id'];
                $role = $row['role'];
                $title = $row['title'];
                print "<tr>
                        <td>$role</a></td> 
                        <td><a href='film.php?id=$id'>$title</a></td>
                      </tr>"; 
              }
            ?>
    </p>
    <h2>ACTOR MOVIES AND ROLE:</h2>
  </div>
</div>
</body>
</html>
