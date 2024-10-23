<?php
session_start();
header('Content-Type: application/json');

echo json_encode([
    'session_status' => session_status(),
    'session_id' => session_id(),
    'login_id' => isset($_SESSION['login_id']) ? $_SESSION['login_id'] : null,
    'id' => isset($_SESSION['id']) ? $_SESSION['id'] : null,
    'name' => isset($_SESSION['name']) ? $_SESSION['name'] : null
]);
?>