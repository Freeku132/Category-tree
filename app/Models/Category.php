<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'category_parent' );
    }

    public function allSubCategories()
    {
        return $this->subCategories()->with('allSubCategories')->orderBy('order');
    }

}
