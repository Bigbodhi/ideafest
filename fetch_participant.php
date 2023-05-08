<?php
require_once 'config.php';

if (isset($_POST['id'])) {
    $participant_id = $_POST['id'];

    $stmt = $conn->prepare("SELECT id, name, email, photo, description FROM participants WHERE id = ?");
    $stmt->bind_param("i", $participant_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $participant = $result->fetch_assoc();

    echo json_encode($participant);
}
?>
