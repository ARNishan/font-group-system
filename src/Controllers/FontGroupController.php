<?php

namespace App\Controllers;

use App\Services\FontGroupService;
use App\Validators\FontGroupValidator;
use Exception;
class FontGroupController
{
    private $fontGroupService;

    public function __construct(FontGroupService $fontGroupService)
    {
        $this->fontGroupService = $fontGroupService;
    }

    public function store($data): array 
    {
        try{
            // Validate the input
            if (!FontGroupValidator::validate($data)) {
                return ['status' => false, 'message' => 'Invalid request'];
            }
            return $this->fontGroupService->createFontGroup($data);

        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Error saving font group: ' . $e->getMessage()
            ];
        }
    }

}
