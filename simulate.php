 <?php
 /*
  Author: Akshaya Bhandare 
 Page: Simulation based on seconds added - static for now. Once we connect it with device it will read from the device and display it on screen
 Date Created: 19th April 2025
 */

/* Include this file to connect to db while using queries */ 
include 'includes/db.php';

// Clear measurement table if rows reach 1000 - this to ensure that database is not loadd with records
$totalMeasurements = $pdo->query("SELECT COUNT(*) FROM measurements")->fetchColumn();
if ($totalMeasurements >= 1000) {
    $pdo->exec("DELETE FROM measurements");
}

$modules = $pdo->query("SELECT * FROM modules")->fetchAll(PDO::FETCH_ASSOC);

foreach ($modules as $mod) {
    $value = rand(10, 100);
    $status = rand(0, 5) == 0 ? 'broken' : 'working';

    $pdo->prepare("UPDATE modules SET status = ? WHERE id = ?")->execute([$status, $mod['id']]);

    if ($status === 'working') {
        $pdo->prepare("INSERT INTO measurements (module_id, value) VALUES (?, ?)")
            ->execute([$mod['id'], $value]);
    }
}
?>