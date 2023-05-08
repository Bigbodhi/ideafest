<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'audience') {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $participant_id = $_POST['participant_id'];
    $user_id = $_SESSION['user_id'];
    $vote_date = date('Y-m-d');

    $stmt = $conn->prepare("SELECT * FROM audience_votes WHERE user_id = ? AND participant_id = ? AND vote_date = ?");
    $stmt->bind_param("iis", $user_id,$participant_id, $vote_date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "You have already voted today!";
    } else {
        $stmt = $conn->prepare("INSERT INTO audience_votes (participant_id, user_id, vote_date) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $participant_id, $user_id, $vote_date);
        $stmt->execute();
        $success = "Your vote has been submitted!";
    }
}

$stmt = $conn->prepare("SELECT id, name FROM participants");
$stmt->execute();
$result = $stmt->get_result();
$participants = $result->fetch_all(MYSQLI_ASSOC);
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
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <h1 class="text-center mb-4">Audience Vote</h1>
        <form action="audience_vote.php" method="post">
            <div class="form-group">
                <label for="participant_id">Participant</label>
                <select name="participant_id" id="participant_id" class="form-control" required>
                    <option value="">Select Participant</option>
                    <?php foreach ($participants as $participant): ?>
                        <option value="<?= $participant['id'] ?>"><?= $participant['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            </div>
            <div id="score-options-container"></div>
            <button type="submit" class="btn btn-primary btn-block">Submit Vote</button>
        </form>
        
    </div>
   

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        const participantSelector = document.getElementById('participant_id');

        const scoreOptionsContainer = document.getElementById('score-options-container');

        participantSelector.addEventListener('change', async () => {
            const participantId = participantSelector.value;
            if (participantId === '') {
                participantDetails.style.display = 'none';
                return;
            }

            // Fetch participant details using AJAX
            const response = await fetch(`get_participant_details.php?participant_id=${participantId}`);
            const data = await response.json();


            // Load score options
            const scoreOptions = await fetch('get_score_options.php');
            const scoreOptionsHTML = await scoreOptions.text();
            scoreOptionsContainer.innerHTML = scoreOptionsHTML;

            // Show participant details
            participantDetails.style.display = 'block';
        });

        // Reset the scores and checkboxes
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        const hiddenInputs = document.querySelectorAll('input[type="hidden"]');

        checkboxes.forEach((checkbox) => {
            checkbox.checked = false;
        });

        hiddenInputs.forEach((hiddenInput) => {
            hiddenInput.value = 0;
        });
    </script>
</body>
</html>

