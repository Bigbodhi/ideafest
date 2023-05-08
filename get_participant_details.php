<?php
header('Content-Type: application/json');
require_once 'config.php';

$participant_id = isset($_GET['participant_id']) ? $_GET['participant_id'] : 0;

$stmt = $conn->prepare("SELECT * FROM participants WHERE id = ?");
$stmt->bind_param("i", $participant_id);
$stmt->execute();

$result = $stmt->get_result();
$participant = $result->fetch_assoc();

echo json_encode($participant);
