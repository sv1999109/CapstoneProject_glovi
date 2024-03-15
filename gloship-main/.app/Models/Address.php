<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //use HasFactory;
    protected $table = 'addresses';
    protected $primaryKey = 'id';
    protected $fillable = ['address_type', 'firstname', 'lastname', 'address', 'created_by', 'owner_id', 'area', 'city', 'state', 'country', 'phone', 'email', 'postal', 'object_id'];
}
