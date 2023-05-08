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
    <title>IdeaFest</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom color design for IdeaFest */
        .navbar {
            background-color: #1a3c6b;
        }
        .navbar-brand,
        .nav-link {
            color: #ffffff;
        }
        .nav-link:hover {
            color: #ffffff;
            opacity: 0.8;
        }
        .dropdown-menu {
            background-color: #1a3c6b;
        }
        .dropdown-item {
            color: #ffffff;
        }
        .dropdown-item:hover {
            color: #ffffff;
            background-color: #2b4e88;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3E%3Cpath stroke='rgba(255, 140, 0, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <!-- The rest of the navbar.php code remains the same -->

        <a class="navbar-brand" href="#">IdeaFest</a>
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

