<?php

namespace App\Http\Controllers;

use App\City;
use App\Province;
use Illuminate\Http\Request;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class CheckOngkirController extends Controller
{
    public function index()
    {
        $provinces = Province::pluck('name', 'province_id');
        return view('ongkir', compact('provinces'));
    }
    public function getCities($id)
    {
        $city = City::where('province_id', $id)->pluck('name', 'city_id');
        return response()->json($city);
    }

    public function checkOngkir(Request $request)
    {
        $cost = RajaOngkir::ongkosKirim([
            'origin' =>  $request->city_origin, // id kota kabupaten
            'destination' => $request->city_destination, //id kota tujuan
            'weight' => $request->weight,
            'courier' => $request->courier
        ])->get();

        return response()->json($cost);
    }
}
