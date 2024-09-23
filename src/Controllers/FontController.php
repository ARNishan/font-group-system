<?php
namespace App\Controllers;

use App\Services\FontService;

class FontController
{
    private $fontService;

    public function __construct(FontService $fontService)
    {
        $this->fontService = $fontService;
    }

    public function uploadFont($file): array
    {
        return $this->fontService->handleUpload($file);
    }

    public function deleteFont($fontUrl): array
    {
        return $this->fontService->handleDelete($fontUrl);
    }
}
