<?php

require_once 'FontUploader.php';
require_once 'FontDeleter.php';
require_once 'FontController.php';

$controller = new FontController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['font-file'])) {
        $response = $controller->handleUpload($_FILES['font-file']);
        echo json_encode($response);
    } elseif (isset($_POST['fontUrl'])) {
        $response = $controller->handleDelete($_POST['fontUrl']);
        echo json_encode($response);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}

