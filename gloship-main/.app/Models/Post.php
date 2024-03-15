<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $fillable = ['post_title', 'post_slug', 'post_excerpt', 'post_content', 'post_status', 'post_author', 'post_view', 'post_category', 'post_slug', 'post_type', 'post_last_edited', 'post_img'];


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_category')->where('categories.status', 1);
    }

    public function all_categories()
    {
        return $this->belongsToMany(Category::class, 'post_category');
    }

}
