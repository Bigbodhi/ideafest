<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Fetch all users
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $role, $user_id);
    $stmt->execute();

    $success = "User updated successfully!";
    header('Location: edit_user.php'); // Refresh the page to load updated data
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">Edit User</h1>
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>
                <form action="edit_user.php" method="post">
                    <div class="form-group">
                        <label for="user_id">Select User</label>
                        <select name="user_id" id="user_id" class="form-control" required onchange="loadUserData()">
                            <option value="" disabled selected>Select a user</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['id'] ?>" data-name="<?= $user['name'] ?>"
                                    data-email="<?= $user['email'] ?>" data-role="<?= $user['role'] ?>">
                                    <?= $user['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="admin">Admin</option>
                            <option value="jury">Jury</option>
                            <option value="audience">Audience</option>
                            <option value="participant">Participant</option>
                        </select>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block">Update User</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function loadUserData() {
            const userIdElement = document.getElementById('user_id');
            const selectedOption = userIdElement.options[userIdElement.selectedIndex];
            const name = selectedOption.getAttribute('data-name');
            const email = selectedOption.getAttribute('data-email');
            const role = selectedOption.getAttribute('data-role');

            document.getElementById('name').value = name;
            document.getElementById('email').value = email;
            document.getElementById('role').value = role;
        }
    </script>
</body>
</html>

