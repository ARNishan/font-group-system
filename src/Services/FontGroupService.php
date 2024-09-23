<?php

namespace App\Services;

use App\Models\FontGroup;
use App\Repositories\Interfaces\FontGroupRepositoryInterface;

class FontGroupService
{
    private $repository;

    public function __construct(FontGroupRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createFontGroup(array $data): array
    {
        $fontGroup = new FontGroup($data['groupName'], $data['fonts']);
        return $this->repository->save($fontGroup);
    }
}
