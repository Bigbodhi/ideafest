<?php
session_start();
require_once 'config.php';

// Fetch all participants
$stmt = $conn->prepare("SELECT id, name FROM participants");
$stmt->execute();
$result = $stmt->get_result();
$participants = $result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $audience_scores = $_POST['audience_scores'];
    
    foreach ($audience_scores as $participant_id => $score) {
        $stmt = $conn->prepare("INSERT INTO audience_scores (participant_id, score) VALUES (?, ?)");
        $stmt->bind_param("ii", $participant_id, $score);
        $stmt->execute();
    }

    $success = "Audience scores submitted successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audience Vote</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        <h1 class="text-center mb-4">Audience Vote</h1>
        <form action="audience_vote.php" method="post">
            <?php foreach ($participants as $participant): ?>
                <div class="form-group">
                    <h5><?= $participant['name'] ?></h5>
                    <div class="form-check form-check-inline">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <input class="form-check-input" type="radio" name="audience_scores[<?= $participant['id'] ?>]" id="score-<?= $participant['id'] ?>-<?= $i ?>" value="<?= $i ?>" <?= $i == 1 ? 'checked' : '' ?>>
                            <label class="form-check-label" for="score-<?= $participant['id'] ?>-<?= $i ?>"><?= $i ?> - <?= $i <= 3 ? 'Beginner' : ($i <= 7 ? 'Intermediate' : 'Professional') ?></label>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary btn-block">Submit Votes</button>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
