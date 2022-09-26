<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CekResiController extends Controller
{
    public function index()
    {
        return view('cek-resi.index');
    }
}
