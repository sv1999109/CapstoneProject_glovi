<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\ShipmentLog;
use App\Models\Branches;
use Illuminate\Http\Request;
use App\Models\ShipmentProviders;
class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
{
    try {
        $data = json_decode($request->getContent(), true);

        $trackingNumber = $data['tracking_number'];
        $status = $data['status'];

        $shipment = Shipment::where('tracking_number', $trackingNumber)->first();

        if ($shipment) {
            $shipment->status = $status;
            $shipment->save();

            // Perform additional actions based on status
            if ($status === 'delivered') {
                // Send email notification
            } else if ($status === 'delayed') {
                // Trigger workflow for delayed shipment
            }
        } else {
            // Log error: Shipment not found for tracking number
        }
    } catch (Exception $e) {
        // Log error
    }

    return response()->json(['message' => 'Webhook data received successfully'], 200);
}


}