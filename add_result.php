<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Add Result</title>
<style>
body { font-family: Arial; background:rgb(0, 0, 0); text-align: center; }
form { background: #fff; padding: 20px; width: 350px; margin: 50px auto; border-radius: 10px; }
select, input { width: 90%; padding: 8px; margin: 5px; }
button { background: #2ecc71; border: none; padding: 10px; color: white; width: 95%; border-radius: 5px; }
</style>
</head>
<body>
<h2>Add Result</h2>
<form method="POST">
    <label>Driver:</label><br>
    <select name="driver_id" required>
        <option value="">-- Select Driver --</option>
        <?php
        $drivers = $conn->query("SELECT * FROM drivers");
        while ($d = $drivers->fetch_assoc()) {
            echo "<option value='{$d['id']}'>{$d['name']}</option>";
        }
        ?>
    </select><br>
    <label>Race:</label><br>
    <select name="race_id" required>
        <option value="">-- Select Race --</option>
        <?php
        $races = $conn->query("SELECT * FROM races");
        while ($r = $races->fetch_assoc()) {
            echo "<option value='{$r['id']}'>{$r['race_name']}</option>";
        }
        ?>
    </select><br>
    <input type="number" name="points" placeholder="Points" required><br>
    <button type="submit" name="save">Save</button>
</form>

<?php
if (isset($_POST['save'])) {
    $driver_id = $_POST['driver_id'];
    $race_id = $_POST['race_id'];
    $points = $_POST['points'];

    $conn->query("INSERT INTO results (driver_id, race_id, points)
                  VALUES ('$driver_id', '$race_id', '$points')");
    header("Location: index.php");
}
?>
</body>
</html>