<?php

namespace App\Services;

use App\Repositories\Interfaces\FontRepositoryInterface;
use App\Models\Font;
use App\Validators\FontValidator;

class FontService
{
    private $repository;
    private $validator;

    public function __construct(FontRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->validator = new FontValidator();
    }

    public function handleUpload($file): array
    {
        if (!$this->validator->isValid($file)) {
            return ['error' => 'Invalid file type. Only TTF files are allowed.'];
        }

        $font = new Font(basename($file["name"]), $file["tmp_name"]);

        return $this->repository->upload($font);
    }

    public function handleDelete($fontUrl): array
    {
        return $this->repository->delete($fontUrl);
    }
}
