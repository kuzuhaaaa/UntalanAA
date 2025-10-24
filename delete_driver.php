<?php
include 'db.php';

$id = $_GET['id'];

$conn->query("DELETE FROM results WHERE driver_id = $id");

$conn->query("DELETE FROM drivers WHERE id = $id");

header("Location: index.php");
exit;
?>
