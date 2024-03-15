<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;
    protected $table = 'post_category';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description', 'img', 'slug'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_category');
    }

}
