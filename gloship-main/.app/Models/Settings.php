<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'site_settings';
    protected $fillable = ['site_key', 'value'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
}
