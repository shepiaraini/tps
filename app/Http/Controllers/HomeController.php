<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function beranda (){
        $datasensor = sensordata::latest()->first();
        return view('beranda',  compact('datasensor'));
        //return view('beranda', ['data' => $datasensor]);
    }

    public function dashboard (){
         $sensordata = sensordata::latest()->first();
         return view('dashboard', ['data' => $sensordata]);

        //return view('dashboard');
    }

    public function grafik (){
        $datasensor = sensordata::latest()->first();
        return view('grafik', compact('datasensor'));

        //$sensor = $datasensor->toArray();
        //$dates = $datasensor->created_at->format('d M Y');

        //return view('grafik', compact('sensor', 'dates'));
        // return view('grafik');
    }

}

// public function datasensor (){
    //     $data_sensor = DB::table('suhu_udara')->get();
    //     $data_sensor = DB::table('suhu_tanah')->get();
    //     $data_sensor = DB::table('ph')->get();
    //     $data_sensor = DB::table('kelembaban')->get();
    //     return view('data-sensor', ['data_sensor'=>$data_sensor]); //compact('data');

        //$data = User::all();
        // [
        //     [
        //         'suhu_udara'       => '28.5',
        //         'suhu_tanah'       => '30.1',
        //         'ph'               => '5.5',
        //         'kelembaban'       => '50 %',
        //     ],

        //     [
        //         'suhu_udara'       => '32',
        //         'suhu_tanah'       => '31.2',
        //         'ph'               => '6',
        //         'kelembaban'       => '40 %',
        //     ],
        // ];
        // return view('data-sensor');
    // }

    // public function hasil (){
    //     return view('hasil');
    // }