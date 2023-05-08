<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$user_role = $_SESSION['user_role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h1>Welcome to the Competition Dashboard</h1>
                <?php if ($user_role == 'admin'): ?>
                    <p>As an admin, you can add participants, view scores, and manage users.</p>
                <?php elseif ($user_role == 'jury'): ?>
                    <p>As a jury member, you can score participants and view scores.</p>
                <?php elseif ($user_role == 'audience'): ?>
                    <p>As an audience member, you can view scores.</p>
                <?php elseif ($user_role == 'participant'): ?>
                    <p>As a participant, you can view your own scores and ranking.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

