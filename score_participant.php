<?php
session_start();
require_once 'config.php';
//require_once 'score_categories.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], ['admin', 'jury'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $participant_id = $_POST['participant_id'];
    $total_score = 0;
    
    foreach ($_POST['scores'] as $category_scores) {
        
        $total_score += array_sum($category_scores);
    }

    $stmt = $conn->prepare("INSERT INTO scoredata (participant_id, points, details) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $participant_id, $total_score, json_encode($_POST['scores']));
    $stmt->execute();

    $success = "Scores submitted successfully!";
}

$stmt = $conn->prepare("SELECT id, name FROM participants");
$stmt->execute();
$result = $stmt->get_result();
$participants = $result->fetch_all(MYSQLI_ASSOC);

$score_categories = [
    // Add updated score categories and criteria here
    [
        'name' => 'Slide Content',
        'max_points' => 20,
        'criteria' => [
            ['name' => 'Clear and concise content', 'points' => 4],
            ['name' => 'Defined problem and solution', 'points' => 4],
            ['name' => 'Identified target audience and market size', 'points' => 3],
            ['name' => 'Analyzed competition and emphasized unique selling proposition', 'points' => 3],
            ['name' => 'Explained business model and marketing strategy', 'points' => 3],
            ['name' => 'Team qualifications and roles', 'points' => 3]
        ],
    ],
    [
        'name' => 'Design',
        'max_points' => 15,
        'criteria' => [
            ['name' => 'Visually appealing and professional design', 'points' => 4],
            ['name' => 'Consistent font, colors, and graphics', 'points' => 3],
            ['name' => 'Easy to follow layout and well-organized information', 'points' => 4],
            ['name' => 'Relevant and supporting images and graphics', 'points' => 4]
        ],
    ],
    [
        'name' => 'Delivery',
        'max_points' => 25,
        'criteria' => [
            ['name' => 'Clear and confident speaking', 'points' => 10],
            ['name' => 'Appropriate pacing', 'points' => 5],
            ['name' => 'Engages audience and addresses questions and concerns', 'points' => 5],
            ['name' => 'Demonstrates enthusiasm, passion, and knowledge', 'points' => 5]
        ],
    ],
     [
        'name' => 'Overall Impression',
        'max_points' => 40,
        'criteria' => [
            ['name' => 'Clear and compelling value proposition', 'points' => 5],
            ['name' => 'Demonstrates understanding of target market and audience', 'points' => 5],
            ['name' => 'Highlights unique or innovative aspects of idea/business', 'points' => 3],
            ['name' => 'Addresses potential risks and challenges and provides solutions', 'points' => 2],
            ['name' => 'Provides clear and actionable next steps for audience', 'points' => 2],
            ['name' => 'Provides evidence of market demand', 'points' => 2],
            ['name' => 'Includes well-crafted elevator pitch', 'points' => 1]
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Score Participant</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .category-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .category-box {
            width: 48%;
        }
        .bottom-category {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-4">
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        <h1 class="text-center mb-4">Score Participant</h1>
        <form action="score_participant.php" method="post">
            <div class="form-group">
                <label for="participant_id">Participant</label>
                <select name="participant_id" id="participant_id" class="form-control" required>
                    <option value="">Select Participant</option>
                    <?php foreach ($participants as $participant): ?>
                        <option value="<?= $participant['id'] ?>"><?= $participant['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div id="participant-details" style="display: none;">
                <div class="form-group">
                    <img id="participant-photo" src="" alt="Participant Photo" style="width: 100%; max-height: 300px; object-fit: cover;">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <p id="participant-description"></p>
                </div>
                <div class="category-container">
                    <?php for ($i = 0; $i < count($score_categories); $i += 2): ?>
                        <div class="category-box">
                   
                            <h4><?= $score_categories[$i]['name'] ?></h4>
                            <table class="table">
                                <tbody>
                                    <?php foreach ($score_categories[$i]['criteria'] as $index => $criterion): ?>
                                        <tr>
                                            <td><?= $criterion['name'] ?></td>
                                            <td>
                                                <input type="checkbox" name="scores[<?= $i ?>][<?= $index ?>]" value="<?= $criterion['points'] ?>" onclick="this.nextElementSibling.value = this.checked ? this.value : 0;">
                                                <input type="hidden" name="scores[<?= $i ?>][<?= $index ?>]" value="0">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if ($i + 1 < count($score_categories)): ?>
                            <div class="category-box">
                      
                                <h4><?= $score_categories[$i + 1]['name'] ?></h4>
                                <table class="table">
                                    <tbody>
                                        <?php foreach ($score_categories[$i + 1]['criteria'] as $index => $criterion): ?>
                                            <tr>
                                                <td><?= $criterion['name'] ?></td>
                                                <td>
                                                    <input type="checkbox" name="scores[<?= $i + 1 ?>][<?= $index ?>]" value="<?= $criterion['points'] ?>" onclick="this.nextElementSibling.value = this.checked ? this.value : 0;">
                                                    <input type="hidden" name="scores[<?= $i + 1 ?>][<?= $index ?>]" value="0">
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
              
            </div>
            <button type="submit" class="btn btn-primary btn-block">Submit Scores</button>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
  const participantSelector = document.getElementById('participant_id');
const participantDetails = document.getElementById('participant-details');
const participantPhoto = document.getElementById('participant-photo');
const participantDescription = document.getElementById('participant-description');

participantSelector.addEventListener('change', async () => {
    const participantId = participantSelector.value;
    if (participantId === '') {
        participantDetails.style.display = 'none';
        return;
    }

    // Fetch participant details using AJAX
    const response = await fetch(`get_participant_details.php?participant_id=${participantId}`);
    const data = await response.json();

    // Update participant details
    participantPhoto.src = data.photo;
    participantDescription.textContent = data.description;

    // Show participant details
    participantDetails.style.display = 'block';

    // Reset the scores and checkboxes
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const hiddenInputs = document.querySelectorAll('input[type="hidden"]');

    checkboxes.forEach((checkbox) => {
        checkbox.checked = false;
    });

    hiddenInputs.forEach((hiddenInput) => {
        hiddenInput.value = 0;
    });
});

    </script>
</body>
</html>

