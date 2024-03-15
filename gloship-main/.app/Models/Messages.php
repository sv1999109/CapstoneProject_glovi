<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;

    protected $table = 'messages';
    protected $primaryKey = 'id';
    protected $fillable = ['subject', 'message', 'message_type', 'status', 'sender', 'userid', 'url', 'status', 'status', 'reference_id'];
}
