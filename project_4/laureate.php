<?php
$id = intval($_GET['id']);

header('Content-Type: application/json');
$filter = ['id' => strval($id)];
$options = ["projection" => ['_id' => 0]];
$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

$query = new MongoDB\Driver\Query($filter, $options);
$rows = $mng->executeQuery("nobel.laureates", $query);
$laureate = current($rows->toArray());
echo json_encode($laureate, JSON_PRETTY_PRINT);
?>