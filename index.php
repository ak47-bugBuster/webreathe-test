<!-- 
 Author: Akshaya Bhandare 
 Page: Main page to display the dashboard
 Date Created: 19th April 2025
 -->


<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Monitoring Dashboard</title>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Used external charts to show the status of monitoring -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Used external bootstrap link for styling purpose -->
    <script src="assets/js/main.js"></script>
</head>

<body>
    <h2>Module Status Dashboard</h2>
    <!-- Add Module Button -->
    <div style="margin: 15px 0;">
        <a href="module_manager.php"
            style="padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">
            + Add Module
        </a>
    </div>

    <!-- Main Dashboard content -->
    <div class="container-xl">
        <?php
        $modules = $pdo->query("SELECT * FROM modules")->fetchAll(PDO::FETCH_ASSOC);
        $count = 0;

        foreach ($modules as $mod):
            if ($count % 2 === 0)
                // Open new row every 2 modules
                echo '<div class="row">';

            $moduleId = $mod['id'];
            $statusColor = $mod['status'] === 'broken' ? 'red' : 'green';

            // Get last value
            $stmt = $pdo->prepare("SELECT value FROM measurements WHERE module_id = ? ORDER BY timestamp DESC LIMIT 1");
            $stmt->execute([$moduleId]);
            $lastValue = $stmt->fetchColumn() ?? 'N/A';

            // Get last 10 measurements
            $stmt = $pdo->prepare("SELECT value, timestamp FROM measurements WHERE module_id = ? ORDER BY timestamp ASC LIMIT 10");
            $stmt->execute([$moduleId]);
            $measurements = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $labels = array_map(fn($row) => $row['timestamp'], $measurements);
            $values = array_map(fn($row) => $row['value'], $measurements);
            ?>
            <div class="col-md-6">
                <div style="border: 2px solid <?= $statusColor ?>; padding: 10px; margin: 10px;">
                    <h4><?= htmlspecialchars($mod['name']) ?> (<?= htmlspecialchars($mod['type']) ?>)</h4>
                    <p>Status: <?= htmlspecialchars($mod['status']) ?></p>
                    <p>Last Value: <?= $lastValue ?></p>

                    <canvas id="chart<?= $moduleId ?>" height="100"></canvas>
                    <script>
                        new Chart(document.getElementById('chart<?= $moduleId ?>'), {
                            type: 'line',
                            data: {
                                labels: <?= json_encode($labels) ?>,
                                datasets: [{
                                    label: 'Values',
                                    data: <?= json_encode($values) ?>,
                                    borderColor: 'blue',
                                    fill: false
                                }]
                            }
                        });
                    </script>
                </div>
            </div>
            <?php
            $count++;
            // Close row after 2 modules
            if ($count % 2 === 0)
                echo '</div>';
        endforeach;
        // Close the last row if the number of modules is odd
        if ($count % 2 !== 0)
            echo '</div>';
        ?>
    </div>
</body>

</html>