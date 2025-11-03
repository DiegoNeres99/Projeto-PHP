<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    // Campos que podem ser preenchidos em massa
    protected $fillable = ['name', 'stock', 'status'];
}
