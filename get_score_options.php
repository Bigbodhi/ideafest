<?php
$score_categories = [
    [
        'name' => 'Slide Content',
        'criteria' => [
            ['name' => 'Beginner', 'points' => 1],
            ['name' => 'Intermediate', 'points' => 2],
            ['name' => 'Advanced', 'points' => 3],
            ['name' => 'Professional', 'points' => 4],
        ],
    ],
    [
        'name' => 'Presentation Design',
        'criteria' => [
            ['name' => 'Beginner', 'points' => 1],
            ['name' => 'Intermediate', 'points' => 2],
            ['name' => 'Advanced', 'points' => 3],
            ['name' => 'Professional', 'points' => 4],
        ],
    ],
    [
        'name' => 'Idea Delivery',
        'criteria' => [
            ['name' => 'Beginner', 'points' => 1],
            ['name' => 'Intermediate', 'points' => 2],
            ['name' => 'Advanced', 'points' => 3],
            ['name' => 'Professional', 'points' => 4],
        ],
    ],
    //
    [
        'name' => 'Overall Impressions',
        'criteria' => [
            ['name' => 'Beginner', 'points' => 1],
            ['name' => 'Intermediate', 'points' => 2],
            ['name' => 'Advanced', 'points' => 3],
            ['name' => 'Professional', 'points' => 4],
        ],
    ],
    //
    // Add more categories as needed
];
?>
<div class="container mt-4">
    <div class="category-container">
        <?php foreach ($score_categories as $index => $category): ?>
            <div class="category-box">
                <h4><?= $category['name'] ?></h4>
                <table class="table">
                    <tbody>
                        <?php foreach ($category['criteria'] as $criterionIndex => $criterion): ?>
                            <tr>
                                <td><?= $criterion['name'] ?></td>
                                <td>
                                    <input type="radio" name="scores[<?= $index ?>]" value="<?= $criterion['points'] ?>" required>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    </div>
</div>
