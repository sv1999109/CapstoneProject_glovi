<?php

namespace App\Services;


class ShippoService
{
    
    /**
     * Create a shipment using Shippo API
     *
     * @param  array  $shipmentDetails  Array containing shipment details
     * @return mixed                    Shippo shipment response
     */
    public function createShipment(array $shipmentDetails)
    {
        $shipment = shippo('shipment', [
            'address_from' => $shipmentDetails['address_from'],
            'address_to' => $shipmentDetails['address_to'],
            'parcels' => $shipmentDetails['parcels'],
            'async' => false,
        ]);

        return $shipment;
    }

    /**
     * Create a transaction using Shippo API
     *
     * @param  array  $shipmentDetails  Array containing shipment details
     * @return mixed                Shippo transaction response
     */
    public function createTransaction(array $shipmentDetails)
    {
        $shipment = shippo('transaction', [
            'rate' => $shipmentDetails['rate'],
            'async' => false,
        ]);

        return $shipment;
    }

    /**
     * Create a Shippo address using Shippo API
     *
     * @param  array  $addressData  Array of address details
     * @return mixed                Shippo address response
     */
    public function createAddress(array $addressData)
    {
        $address = shippo('address', $addressData);

        return $address;
    }

    /**
     * validate a Shippo address using Shippo API
     *
     * @param  string  $address 
     * @return mixed                Shippo address response
     */
    public function ValidateAddress($addressData)
    {
        $address = shippo('address', $addressData);

        return $address;
    }

    /**
     * Shipment Tracking using Shippo API
     *
     * @param  string  $address 
     * @return mixed                Shippo shipment tracking response
     */
    public function TrackShipment(array $status_params)
    {
        
        $status =  shippo('status', $status_params);

        return $status;
    }
}
