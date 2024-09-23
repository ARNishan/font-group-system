<?php

namespace App\Services;

use App\Models\FontGroup;
use App\Repositories\Interfaces\FontGroupRepositoryInterface;
use Exception;
class FontGroupService
{
    private $repository;

    public function __construct(FontGroupRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createFontGroup(array $data): array
    {
        try{
            $fontGroup = new FontGroup($data['groupName'], $data['fonts']);
            return $this->repository->save($fontGroup);
        }catch (Exception $e) {
            return [
                'status' => false,
                'message' =>  $e->getMessage()
            ];
        }
        
    }
}
