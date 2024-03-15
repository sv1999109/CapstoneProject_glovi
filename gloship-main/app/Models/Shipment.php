<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    //use HasFactory;
    protected $table = 'shipments';
    protected $primaryKey = 'id';
    protected $fillable = ['code', 'status', 'sender_address_id', 'sender_name', 'sender_phone', 'sender_email', 'sender_country', 'sender_state', 'sender_city', 'sender_address', 'receiver_address_id','receiver_phone', 'receiver_email', 'receiver_name', 'receiver_address', 'receiver_country', 'receiver_state', 'receiver_city', 'current_location', 'delivery_timeline', 'shipping_cost', 'payment_method', 'payment_status', 'total_weight', 'qty', 'from_branch', 'to_branch', 'collection_type', 'delivery_type', 'delivery_agent', 'note', 'postal_sender',  'postal_receiver', 'from_area', 'to_area', 'invoice_id', 'created_by', 'owner_id', 'tax', 'subtotal', 'discount', 'currency'];
    
    public function getDurationForHumansAttribute()
    {
        return date('H:i:s', mktime(0, $this->duration, 0));
    }


}
