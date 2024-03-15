<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branches extends Model
{
    use HasFactory;
    protected $table = 'branches';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'address', 'pickup_available', 'city', 'state', 'country', 'status', 'email', 'phone'];
    public function getDurationForHumansAttribute()
    {
        return date('H:i:s', mktime(0, $this->duration, 0));
    }


}
