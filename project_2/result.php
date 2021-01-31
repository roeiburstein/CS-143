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
 <a href="actor.php?id=21083">Morgan Freeman</a>
  <a href="film.php?id=1747">Happy Gilmore</a>
  <a href="comment.php?id=1747">Add Comment</a>
</div>

<div class="row">
  <div class="main">
    <h2>ACTORS</h2>
    <p>
      <?php

        $db = new mysqli('localhost', 'cs143', '', 'cs143');
          if ($db->connect_errno > 0) { 
            die('Unable to connect to database [' . $db->connect_error . ']'); 
          }
        $input_list = explode(" ", $_GET["search"]); 
        $query = "SELECT id, first, last, dob FROM Actor WHERE concat(first, ' ', last) LIKE '%" . implode("%' AND CONCAT(first, ' ', last) LIKE '%", $input_list) . "%';";
        $a = $db->query("$query");

        if (!$a) {
            $errmsg = $a->error; 
            print "Query failed: $errmsg <br>"; 
            exit(1); 
        }
        ?>
        <table>
          <thread>
            <th style="text-align:left">Name</th>
            <th style="text-align:left">Date Of Birth</th>
          </thread>
          <tbody>
            <?php
              while ($row = $a->fetch_assoc()) {
                $id = $row['id'];
                $name = $row['first'] . ' ' . $row['last'];
                $dob = $row['dob'];
                print "<tr>
                        <td><a href='actor.php?id=$id'>$name</a></td> 
                        <td>$dob</td>
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
        $input_list = explode(" ", $_GET["search"]); 
        $query = "SELECT id, title, year FROM Movie WHERE title LIKE '%" . implode("%' AND title LIKE '%", $input_list) . "%';";
        $m = $db->query("$query");

        if (!$m) {
            $errmsg = $m->error; 
            print "Query failed: $errmsg <br>"; 
            exit(1); 
        }
        ?>
        <table>
          <thread>
            <th style="text-align:left">Title</th>
            <th style="text-align:left">Release Year</th>
          </thread>
          <tbody>
            <?php
              while ($row = $m->fetch_assoc()) { 
                $id = $row['id'];
                $title = $row['title'];
                $year = $row['year']; 
                print "<tr>
                        <td><a href='film.php?id=$id'>$title</a></td> 
                        <td>$year</td>
                      </tr>"; 
              }
            ?>
    </p>
    <h2>MOVIES</h2>
  </div>
</div>
</body>
</html>
