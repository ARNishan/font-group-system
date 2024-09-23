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
        try{
            if (!$this->validator->isValid($file)) {
                return ['error' => 'Invalid file type. Only TTF files are allowed.'];
            }
            $font = new Font(basename($file["name"]), $file["tmp_name"]);
            return $this->repository->upload($font);
        }catch (\Exception $e) {
            return [
                'status' => false,
                'message' =>  $e->getMessage()
            ];
        }
        
    }

    public function handleDelete($fontUrl): array
    {
        try{
            return $this->repository->delete($fontUrl);
        }catch (\Exception $e) {
            return [
                'status' => false,
                'message' =>  $e->getMessage()
            ];
        }
        
    }
}
