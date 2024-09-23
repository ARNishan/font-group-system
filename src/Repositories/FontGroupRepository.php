<?php
namespace App\Repositories;

use App\Models\FontGroup;
use App\Repositories\Interfaces\FontGroupRepositoryInterface;

class FontGroupRepository implements FontGroupRepositoryInterface
{
    private $filePath;

    public function __construct()
    {
        $this->filePath = __DIR__ . '/../../storage/font_groups.json';
    }

    public function save(FontGroup $fontGroup): array
    {
        try{
            $existingData = $this->getDataFromFile();   
            $existingData[] = [
                'group_name' => $fontGroup->group_name,
                'fonts' => $fontGroup->fonts,
                'font_count' => $fontGroup->font_count
            ];
            return $this->saveDataToFile($existingData);
        }catch (\Exception $e) {
            return [
                'status' => false,
                'message' =>  $e->getMessage()
            ];
        }
        
    }

    private function getDataFromFile(): array
    {
        if (!file_exists($this->filePath)) {
            return [];
        }
        $fileContents = file_get_contents($this->filePath);
        return json_decode($fileContents, true) ?? [];
    }

    private function saveDataToFile(array $data): array
    {
        try{
            $jsonData = json_encode($data, JSON_PRETTY_PRINT);
            if(file_put_contents($this->filePath, $jsonData)){
                return ['status' => true,'message' => 'Font group created successfully'];
            }
            return ['status' => false,'message' => 'Failed to create font group'];

        }catch (\Exception $e) {
            return [
                'status' => false,
                'message' =>  $e->getMessage()
            ];
        }
        
    }
}
