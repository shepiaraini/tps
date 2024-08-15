<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\datasensor;
use App\Models\deteksisampah;
use App\Models\tinggiair;
use App\Models\tempatsampah;


class SensorDataController extends Controller
{
    public function tampilhalamansensordata()
     {
         $this->datasensor = new datasensor();
     }

     public function index(){
        $datasensor = datasensor::all();
        $data = [
            'datasensor' => $this->datasensor->allData(),
         ];
        return view('hasil', $data);
     }

}