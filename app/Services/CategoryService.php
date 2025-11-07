<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function storeCategory($data)
    {
        return Category::create($data);
    }

}