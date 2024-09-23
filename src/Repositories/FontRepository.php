<?php
namespace App\Repositories;

use App\Models\Font;
use App\Repositories\Interfaces\FontRepositoryInterface;

class FontRepository implements FontRepositoryInterface
{

    private $filePath,$target_dir;
    
    public function __construct()
    {
        $this->filePath = __DIR__ . '/../../storage/fonts.json';
        $this->target_dir = __DIR__ .'/../../storage/fonts/';
    }

    public function upload(Font $font) : array
    {
        try{
            $target_file = $this->target_dir . $font->getName();
            if (move_uploaded_file($font->getTmpName(), $target_file)) {
                $existingData = $this->getDataFromFile();
                $data = [
                    'fontName' => $font->getName(),
                    'fontUrl' => $target_file
                ];
    
                $existingData[] = $data;
                $this->saveDataToFile($existingData);
                return [
                    'status' => true,
                    'data' => $data
                ];
            }
            return ['status' => false,'message' => 'Error uploading file.'];
        }catch (\Exception $e) {
            return [
                'status' => false,
                'message' =>  $e->getMessage()
            ];
        }
       
    }

    public function delete($fontUrl) : array
    {  
        try{
            if (file_exists($fontUrl)) {
                if (unlink($fontUrl)) {
                    $this->removeFromJson($fontUrl);
                    return [
                        'status' => true,
                        'message' => 'Font deleted successfully.'
                    ];
                }
        
                return [
                    'status' => false,
                    'message' => 'Error deleting font.'
                ];
            }
        
            return [
                'status' => false,
                'message' => 'Font not found.'
            ];

        } catch (\Exception $e) {
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

    private function removeFromJson($fontUrl): bool
    {
        $existingData = $this->getDataFromFile();
        $updatedData = [];
        
        $fontUrl = realpath($fontUrl);

        $fontRemoved = false;

        foreach ($existingData as $font) {
            if (realpath($font['fontUrl']) !== $fontUrl) {
                $updatedData[] = $font;
            } else {
                $fontRemoved = true; 
            }
        }

        if ($fontRemoved) {
            $this->saveDataToFile($updatedData);
        }

        return $fontRemoved;
    }
}
