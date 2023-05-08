<?php
$nav_links = [
    'admin' => [
        [
            'title' => 'Users',
            'submenu' => [
                ['url' => 'create_user.php', 'title' => 'Add User'],
                ['url' => 'edit_user.php', 'title' => 'Edit User']
            ]
        ],
        [
            'title' => 'Participants',
            'submenu' => [
                ['url' => 'add_participant.php', 'title' => 'Add Participant'],
                ['url' => 'edit_participant.php', 'title' => 'Edit Participant']
            ]
        ],
        ['url' => 'score_participant.php', 'title' => 'Score Participant'],
        ['url' => 'view_scores.php', 'title' => 'View Scores'],
        ['url' => 'logout.php', 'title' => 'Logout'],
    ],
    'jury' => [
        ['url' => 'score_participant.php', 'title' => 'Score Participant'],
        ['url' => 'logout.php', 'title' => 'Logout'],
    ],
    'audience' => [
        ['url' => 'audience_vote.php', 'title' => 'Vote'],
        ['url' => 'logout.php', 'title' => 'Logout'],
    ],
    'participant' => [
        ['url' => 'logout.php', 'title' => 'Logout'],
    ],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Competition Scoring System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Competition Scoring</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user_role'])): ?>
                    <?php foreach ($nav_links[$_SESSION['user_role']] as $nav_link): ?>
                        <?php if (isset($nav_link['submenu'])): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?= $nav_link['title'] ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <?php foreach ($nav_link['submenu'] as $submenu_item): ?>
                                        <a class="dropdown-item" href="<?= $submenu_item['url'] ?>"><?= $submenu_item['title'] ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= $nav_link['url'] ?>"><?= $nav_link['title'] ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

