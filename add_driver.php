<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Add Driver</title>
<style>
body { font-family: Arial; background:rgb(0, 0, 0); text-align: center; }
form { background: #fff; padding: 20px; width: 300px; margin: 50px auto; border-radius: 10px; }
input { width: 90%; padding: 8px; margin: 5px; }
button { background: #2ecc71; border: none; padding: 10px; color: white; width: 95%; border-radius: 5px; }
</style>
</head>
<body>
<h2>Add Driver</h2>
<form method="POST">
    <input type="text" name="name" placeholder="Driver Name" required><br>
    <button type="submit" name="save">Save</button>
</form>
<?php
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $conn->query("INSERT INTO drivers (name) VALUES ('$name')");
    header("Location: index.php");
}
?>
</body>
</html>