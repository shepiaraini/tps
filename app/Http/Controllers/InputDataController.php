<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InputData;


class InputDataController extends Controller
{
    public function TampilhalamanInput()
    {
        $dtambah = InputData::all();

        return view('Halaman2.input', compact('dtambah'));
    }

  
    public function tampilHalamanTambahData()
    {


    return view('Halaman2.tambahdata');
    }

    public function SimpanData(Request $request)
    {
        InputData::create([
            'id_input_data'=> $request->id_input_data,
            'ketinggian_air'=>$request->ketinggian_air,
            'tanggal'=>$request->tanggal,
        ]);

        return redirect('input');
    }

    
    public function EditInput($id)
    {
        $peg = InputData::findorfail($id);
        return view('Halaman2.edit-input',compact ('peg'));
    }

    public function UpdateInput(request $request, $id)
    {
        $peg = InputData::findorfail($id);
        $peg->update($request->all());
        return redirect('input')->with('toast_success', 'Data Berhasil Update');
    } 

    public function DeleteInput($id)
    {
        $peg = InputData::findorfail($id);
        $peg->delete();
        return back()->with('info', 'Data Berhasil Dihapus');  
    }


//////////////////////////////////////////////////////////////////////////////////////////////
//SAMPAH
//////////////////////////////////////////////////////////////////////////////////////////

   
}


