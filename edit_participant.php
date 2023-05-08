<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$participants = [];
$stmt = $conn->prepare("SELECT id, name, email, photo, description FROM participants");
$stmt->execute();
$result = $stmt->get_result();
$participants = $result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $participant_id = $_POST['participant_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $description = $_POST['description'];
    $photo = $_POST['existing_photo'];

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        if ($photo != '') {
            unlink($photo);
        }
        $photo = 'uploads/' . time() . '_' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
    }

    $stmt = $conn->prepare("UPDATE participants SET name = ?, email = ?, photo = ?, description = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $email, $photo, $description, $participant_id);
    $stmt->execute();

    $success = "Participant updated successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Participant</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">Edit Participant</h1>
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>
                <form action="edit_participant.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="participant_id">Select Participant</label>
                        <select name="participant_id" id="participant_id" class="form-control" required>
                            <option value="">- Select -</option>
                            <?php foreach ($participants as $participant): ?>
                                <option value="<?= $participant['id'] ?>"><?= $participant['name'] ?></option>
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
                        <label for="photo">Photo</label>
                        <input type="file" name="photo" id="photo" class="form-control-file">
                        <input type="hidden" name="existing_photo" id="existing_photo" value="">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
<textarea name="description" id="description" class="form-control" rows="4" required></textarea>
</div>
<button type="submit" class="btn btn-primary btn-block">Update Participant</button>
</form>
</div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
    $('#participant_id').on('change', function () {
    var participantId = $(this).val();
    if (participantId) {
    $.ajax({
    type: 'POST',
    url: 'fetch_participant.php',
    data: 'id=' + participantId,
    dataType: 'json',
    success: function (response) {
    if (response) {
    $('#name').val(response.name);
    $('#email').val(response.email);
    $('#description').val(response.description);
    $('#existing_photo').val(response.photo);
    }
    }
    });
    } else {
    $('#name').val('');
    $('#email').val('');
    $('#description').val('');
    $('#existing_photo').val('');
    }
    });
    });
</script>
</body>
</html>
