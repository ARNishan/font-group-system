<?php

namespace App\Controllers;

use App\Services\FontGroupService;
use App\Validators\FontGroupValidator;

class FontGroupController
{
    private $fontGroupService;

    public function __construct(FontGroupService $fontGroupService)
    {
        $this->fontGroupService = $fontGroupService;
    }

    public function store($data): array 
    {
        // Validate the input
        if (!FontGroupValidator::validate($data)) {
            return ['status' => false, 'message' => 'Invalid request'];
        }
        return $this->fontGroupService->createFontGroup($data);
    }

}
