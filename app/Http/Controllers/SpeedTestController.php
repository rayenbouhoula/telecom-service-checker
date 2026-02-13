<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpeedTestController extends Controller
{
    public function index()
    {
        return view('speedtest.index');
    }
}
