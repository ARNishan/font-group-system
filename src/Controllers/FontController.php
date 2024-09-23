<?php
namespace App\Controllers;

use App\Services\FontService;
use Exception;
class FontController
{
    private $fontService;

    public function __construct(FontService $fontService)
    {
        $this->fontService = $fontService;
        
    }

    public function uploadFont($file): array
    {
        try {
            return $this->fontService->handleUpload($file);
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Error uploading font: ' . $e->getMessage()
            ];
        }
    }

    public function deleteFont($fontUrl): array
    {
        try {
            return $this->fontService->handleDelete($fontUrl);
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Error deleting font: ' . $e->getMessage()
            ];
        }
    }
}
