<!-- 
 Author: Akshaya Bhandare 
 Page: Module Manager
 Date Created: 19th April 2025
 -->

<!-- Include this file to connect to db while using queries -->
<?php include 'includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Module Manager</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">   <!-- Used external bootstrap link for styling purpose -->
  <script>
    // Function ti handle for actions
    async function handleAction(action, formId = 'moduleForm') {
      const form = document.getElementById(formId);
      const formData = new FormData(form);
      formData.append('action', action);

      const res = await fetch('module_event_handler.php', {
        method: 'POST',
        body: formData
      });

      const msg = await res.text();
      document.getElementById('msg').innerHTML = msg;
      loadTable();
    }

    // Funtion to get the details on click of Edit button
    async function getById(id) {
      const res = await fetch(`module_event_handler.php?action=get&id=${id}`);
      const data = await res.json();

      if (data) {
        document.getElementById('id').value = data.id;
        document.getElementById('name').value = data.name;
        document.getElementById('type').value = data.type;
      }
    }

    // Function to delete the module using Id on click of Delete button
    async function deleteModule(id) {
      if (!confirm("Are you sure you want to delete this module?")) return;

      const res = await fetch('module_event_handler.php', {
        method: 'POST',
        body: new URLSearchParams({ action: 'delete', id })
      });

      const msg = await res.text();
      document.getElementById('msg').innerHTML = msg;
      loadTable();
    }

    // Function to list the table data
    async function loadTable() {
      const res = await fetch('module_event_handler.php?action=table');
      const table = await res.text();
      document.getElementById('moduleTable').innerHTML = table;
    }

    // By default load table when page loads.
    window.onload = loadTable;
  </script>
</head>

<body class="bg-light">
  <div class="container mt-5">
    <h2>Module Manager</h2>

    <div id="msg" class="my-3"></div>

    <form id="moduleForm" class="card p-4 shadow-sm bg-white mb-4">
      <input type="hidden" name="id" id="id">
      <div class="row mb-3">
        <div class="col">
          <label class="form-label">Module Name:</label>
          <input type="text" class="form-control" name="name" id="name" required>
        </div>
        <div class="col">
          <label class="form-label">Module Type:</label>
          <input type="text" class="form-control" name="type" id="type" required>
        </div>
      </div>
      <div class="d-flex gap-2">
        <button type="button" onclick="handleAction('add')" class="btn btn-success">Add</button>
        <button type="button" onclick="handleAction('update')" class="btn btn-warning">Update</button>
      </div>
    </form>

    <div id="moduleTable"></div>
  </div>
</body>

</html>