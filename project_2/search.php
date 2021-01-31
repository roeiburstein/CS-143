<!DOCTYPE html>
<html lang="en">
<head>
<title>Search Database</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="stylesheet.css">

</head>
<body>

<div class="header">
  <h1>Search Database</h1>
</div>

<div class="navbar">
  <a href="index.php">Home</a>
  <a href="search.php" class="active">Search Database</a>
  <a href="actor.php?id=21083">Morgan Freeman</a>
  <a href="film.php?id=1747">Happy Gilmore</a>
  <a href="comment.php?id=1747">Add Comment</a>
</div>

<div class="row">
  <div class="main">
    <h2>Search:</h2>
    <form action="result.php" method="get">
    Search: <input type="text" name="search"><br>
    <input type="submit">
    </form>
  </div>
</div>

</body>
</html>
