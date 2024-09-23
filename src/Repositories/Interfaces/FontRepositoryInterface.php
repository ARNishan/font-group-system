<?php
namespace App\Repositories\Interfaces;

use App\Models\Font;

interface FontRepositoryInterface
{
    public function upload(Font $font):array;
    public function delete($fontUrl):array;
}
