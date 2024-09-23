<?php
namespace App\Repositories\Interfaces;

use App\Models\FontGroup;

interface FontGroupRepositoryInterface
{
    public function save(FontGroup $fontGroup): array;
}
