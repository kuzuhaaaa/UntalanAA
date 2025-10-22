<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>F1 CRUD + Subquery</title>
<style>
/* ===== GENERAL ===== */
body {
    font-family: "Poppins", Arial, sans-serif;
    background: #0d0d0d;
    color: #fff;
    margin: 0;
    padding: 30px 0;
}

/* ===== HEADERS ===== */
h2 {
    text-align: center;
    color: #ff1e00;
    letter-spacing: 1px;
    margin-bottom: 30px;
}

h3 {
    text-align: center;
    color: #ffffff;
    border-bottom: 2px solid #ff1e00;
    display: inline-block;
    padding-bottom: 5px;
    margin-bottom: 15px;
}

/* ===== SECTION CONTAINERS ===== */
section {
    width: 85%;
    margin: 40px auto;
    background: #1a1a1a;
    border-radius: 10px;
    padding: 25px 20px;
    box-shadow: 0 0 20px rgba(255, 30, 0, 0.2);
    transition: transform 0.3s ease;
}

section:hover {
    transform: scale(1.01);
}

/* ===== TABLES ===== */
table {
    width: 100%;
    margin: 20px auto;
    border-collapse: collapse;
    overflow: hidden;
    border-radius: 10px;
}

th, td {
    padding: 12px 10px;
    text-align: center;
}

th {
    background: #ff1e00;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
    letter-spacing: 1px;
}

td {
    background: #262626;
    color: #eee;
    font-size: 14px;
    border-bottom: 1px solid #333;
}

tr:nth-child(even) td {
    background: #1f1f1f;
}

tr:hover td {
    background: #2b2b2b;
}

/* ===== BUTTONS ===== */
a {
    text-decoration: none;
    padding: 7px 14px;
    border-radius: 5px;
    font-weight: 600;
    display: inline-block;
    transition: all 0.3s ease;
}

.add-btn {
    background: #27ae60;
    color: #fff;
}

.add-btn:hover {
    background: #219150;
}

.edit-btn {
    background: #f1c40f;
    color: #111;
}

.edit-btn:hover {
    background: #d4ac0d;
}

.del-btn {
    background: #e74c3c;
    color: #fff;
}

.del-btn:hover {
    background: #c0392b;
}

/* ===== BUTTON ALIGNMENT ===== */
p {
    text-align: center;
}

/* ===== HIGHLIGHT LEADERBOARD ===== */
section:last-of-type {
    border: 2px solid #ff1e00;
    box-shadow: 0 0 25px rgba(255, 30, 0, 0.3);
}

section:last-of-type h3 {
    color: #ffcc00;
    border-bottom: 2px solid #ffcc00;
}

/* ===== SCROLLBAR ===== */
::-webkit-scrollbar {
    width: 10px;
}
::-webkit-scrollbar-track {
    background: #1a1a1a;
}
::-webkit-scrollbar-thumb {
    background: #ff1e00;
    border-radius: 5px;
}
::-webkit-scrollbar-thumb:hover {
    background: #ff4d00;
}

/* ===== MOBILE RESPONSIVE ===== */
@media (max-width: 768px) {
    body { padding: 10px; }
    section { width: 100%; padding: 15px; }
    th, td { font-size: 12px; }
    a { padding: 6px 10px; font-size: 13px; }
}
</style>
</head>
<body>

<h2>🏁 Formula 1 Management (CRUD + Subquery Analytics)</h2>

<!-- === DRIVERS TABLE === -->
<section>
<h3>👨‍✈️ Drivers</h3>
<p align="center"><a href="add_driver.php" class="add-btn">➕ Add Driver</a></p>
<table>
<tr><th>ID</th><th>Name</th><th>Actions</th></tr>
<?php
$drivers = $conn->query("SELECT * FROM drivers");
if ($drivers->num_rows > 0) {
    while($d = $drivers->fetch_assoc()) {
        echo "<tr>
                <td>{$d['id']}</td>
                <td>{$d['name']}</td>
                <td>
                    <a href='edit_driver.php?id={$d['id']}' class='edit-btn'>✏️ Edit</a>
                    <a href='delete_driver.php?id={$d['id']}' class='del-btn' onclick='return confirm(\"Delete this driver?\")'>🗑 Delete</a>
                </td>
              </tr>";
    }
}
?>
</table>
</section>

<!-- === RACES TABLE === -->
<section>
<h3>🏎️ Races</h3>
<p align="center"><a href="add_race.php" class="add-btn">➕ Add Race</a></p>
<table>
<tr><th>ID</th><th>Race Name</th></tr>
<?php
$races = $conn->query("SELECT * FROM races");
if ($races->num_rows > 0) {
    while($r = $races->fetch_assoc()) {
        echo "<tr><td>{$r['id']}</td><td>{$r['race_name']}</td></tr>";
    }
}
?>
</table>
</section>

<!-- === RESULTS TABLE === -->
<section>
<h3>🏆 Results</h3>
<p align="center"><a href="add_result.php" class="add-btn">➕ Add Result</a></p>
<table>
<tr><th>Driver</th><th>Race</th><th>Points</th></tr>
<?php
$results = $conn->query("
    SELECT d.name AS driver, ra.race_name AS race, r.points
    FROM results r
    JOIN drivers d ON r.driver_id = d.id
    JOIN races ra ON r.race_id = ra.id
");
if ($results->num_rows > 0) {
    while($re = $results->fetch_assoc()) {
        echo "<tr>
                <td>{$re['driver']}</td>
                <td>{$re['race']}</td>
                <td>{$re['points']}</td>
              </tr>";
    }
}
?>
</table>
</section>

<!-- === SUBQUERY LEADERBOARD === -->
<section>
<h3>📊 Driver Leaderboard (Using Subquery)</h3>
<table>
<tr><th>Driver</th><th>Total Points</th></tr>
<?php
$leaderboard = $conn->query("
SELECT d.name, COALESCE(SUM(r.points), 0) AS total_points
FROM drivers d
LEFT JOIN results r ON d.id = r.driver_id
GROUP BY d.name
ORDER BY total_points DESC;
");

if ($leaderboard->num_rows > 0) {
    while($l = $leaderboard->fetch_assoc()) {
        echo "<tr><td>{$l['name']}</td><td>{$l['total_points']}</td></tr>";
    }
}
?>
</table>
</section>

</body>
</html>