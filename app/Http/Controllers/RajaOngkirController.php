<?php

namespace App\Http\Controllers;

use App\Services\RajaOngkirService;
use Illuminate\Http\Request;

class RajaOngkirController extends Controller
{
    protected $rajaOngkir;

    public function __construct(RajaOngkirService $rajaOngkir)
    {
        $this->rajaOngkir = $rajaOngkir;
    }

    public function getProvinces()
    {
        $response = $this->rajaOngkir->getProvinces();
        return response()->json($response);
    }

    public function getCities(Request $request)
    {
        $provinceId = $request->input('province_id');
        $response = $this->rajaOngkir->getCities($provinceId);
        return response()->json($response);
    }

    public function getShippingCost(Request $request)
    {
        $request->validate([
            'origin' => 'required|numeric',
            'destination' => 'required|numeric',
            'weight' => 'required|numeric',
            'courier' => 'required|string',
        ]);

        $response = $this->rajaOngkir->getCost(
            $request->origin,
            $request->destination,
            $request->weight,
            $request->courier
        );

        return response()->json($response);
    }
}
