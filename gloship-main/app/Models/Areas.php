<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    use HasFactory;
    protected $table = 'areas';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'city_id', 'state_id', 'country_id', 'country_code', 'status'];
}
