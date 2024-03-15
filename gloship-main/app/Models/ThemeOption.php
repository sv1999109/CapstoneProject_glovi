<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemeOption extends Model
{
    use HasFactory;
    protected $table = 'theme_settings';
    protected $primaryKey = 'id';
    protected $fillable = ['config_key', 'value', 'theme'];

}
