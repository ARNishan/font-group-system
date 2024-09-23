<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\FontController;
use App\Repositories\FontRepository;
use App\Services\FontService;
use App\Controllers\FontGroupController;
use App\Repositories\FontGroupRepository;
use App\Services\FontGroupService;

// Initialize the controllers with their dependencies
$fontRepository = new FontRepository(); 
$fontService = new FontService($fontRepository);
$fontController = new FontController($fontService);

$fontGroupRepository = new FontGroupRepository();
$fontGroupService = new FontGroupService($fontGroupRepository);
$fontGroupController = new FontGroupController($fontGroupService);

$input = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');
// Route 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['font-file'])) {
        // Handle font file upload
        $response = $fontController->uploadFont($_FILES['font-file']);
        echo json_encode($response);

    } elseif (isset($input['fontUrl'])) {
        // Handle font deletion
        $response = $fontController->deleteFont($input['fontUrl']);
        echo json_encode($response);

    } elseif (isset($input['groupName']) && isset($input['fonts'])) {
        $data = [
            'groupName' => $input['groupName'] ?? null,
            'fonts' => $input['fonts'] ?? []
        ];
        $response = $fontGroupController->store($data);
        echo json_encode($response);

    } else {
        echo json_encode(['error' => 'Invalid POST request parameters.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
