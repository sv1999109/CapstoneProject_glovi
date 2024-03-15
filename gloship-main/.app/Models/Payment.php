<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payments';
    protected $fillable = ['payment_id', 'payer_id', 'payer_email', 'amount', 'currency', 'payment_status', 'gateway', 'owner_id',];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
}
