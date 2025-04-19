<?php
/* 
 Author: Akshaya Bhandare 
 Page: Module Event Handler - ADD, UPDATE, DELETE, GET BY ID and LISTING
 Date Created: 19th April 2025
 */

/* Include this file to connect to db while using queries */
include 'includes/db.php';

// defines the action requested by the form
$action = $_REQUEST['action'] ?? '';

// based on the action select the case
switch ($action) {
    case 'add':
        $stmt = $pdo->prepare("INSERT INTO modules (name, type, status) VALUES (?, ?, 'working')");
        $stmt->execute([$_POST['name'], $_POST['type']]);
        echo "<div class='alert alert-success'>Module added successfully!</div>";
        break;

    case 'update':
        $stmt = $pdo->prepare("UPDATE modules SET name = ?, type = ? WHERE id = ?");
        $stmt->execute([$_POST['name'], $_POST['type'], $_POST['id']]);
        echo "<div class='alert alert-warning'>Module updated successfully!</div>";
        break;

    case 'delete':
        // Delete from measurements first - due to foriegn key check
        $stmt = $pdo->prepare("DELETE FROM measurements WHERE module_id = ?");
        $stmt->execute([$_POST['id']]);

        // Then delete from modules
        $stmt = $pdo->prepare("DELETE FROM modules WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        echo "<div class='alert alert-danger'>Module deleted!</div>";
        break;

    case 'get':
        $stmt = $pdo->prepare("SELECT * FROM modules WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        break;

    case 'table':
        $modules = $pdo->query("SELECT * FROM modules ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
        echo "<table class='table table-bordered table-striped'>
                <thead class='table-dark'>
                  <tr>
                    <th>ID</th><th>Name</th><th>Type</th><th>Status</th><th>Actions</th>
                  </tr>
                </thead>
                <tbody>";
        foreach ($modules as $m) {
            echo "<tr>
                    <td>{$m['id']}</td>
                    <td>{$m['name']}</td>
                    <td>{$m['type']}</td>
                    <td><span class='badge bg-" . ($m['status'] == 'broken' ? "danger" : "success") . "'>{$m['status']}</span></td>
                    <td>
                        <button class='btn btn-sm btn-info' onclick='getById({$m['id']})'>Edit</button>
                        <button class='btn btn-sm btn-danger' onclick='deleteModule({$m['id']})'>Delete</button>
                    </td>
                  </tr>";
        }
        echo "</tbody></table>";
        break;

    default:
        echo "<div class='alert alert-info'>No valid action provided.</div>";
        break;
}
?>