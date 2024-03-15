<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costs extends Model
{
    //use HasFactory;
    protected $table = 'shipping_cost';
    protected $primaryKey = 'id';
    protected $fillable = ['origin_country', 'origin_state', 'destination_country', 'destination_state', 'destination_city', 'destination_area', 'weight_from', 'weight_to', 'amount', 'status', 'currency'];
}
