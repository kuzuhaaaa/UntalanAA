<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Driver</title>
<style>
body { font-family: Arial; background:rgb(0, 0, 0); text-align: center; }
form { background: #fff; padding: 20px; width: 300px; margin: 50px auto; border-radius: 10px; }
input { width: 90%; padding: 8px; margin: 5px; }
button { background: #f1c40f; border: none; padding: 10px; color: black; width: 95%; border-radius: 5px; }
</style>
</head>
<body>
<h2>Edit Driver</h2>

<?php
// Get driver ID from URL
$id = $_GET['id'];

// Fetch current driver data
$result = $conn->query("SELECT * FROM drivers WHERE id = $id");
$row = $result->fetch_assoc();
?>

<form method="POST">
    <input type="text" name="name" value="<?php echo $row['name']; ?>" required><br>
    <button type="submit" name="update">Update</button>
</form>

<?php
if (isset($_POST['update'])) {
    $name = $_POST['name'];

    $sql = "UPDATE drivers SET name='$name' WHERE id=$id";

    if ($conn->query($sql)) {
        echo "<p style='color:green;'>✅ Driver updated successfully!</p>";
        header("Refresh:1; url=index.php");
    } else {
        echo "<p style='color:red;'>❌ Error updating record: " . $conn->error . "</p>";
    }
}
?>
</body>
</html>