<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description', 'parent', 'img', 'slug', 'status'];

    public function category_parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function post()
    {
        return $this->belongsToMany(Post::class, 'post_category');
    }
}
