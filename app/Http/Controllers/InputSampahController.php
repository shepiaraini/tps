<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InputSampah;

class InputSampahController extends Controller
{
    public function TampilhalamanInputSampah()
    {
        $dtambahsampah = InputSampah::all();

        return view('Halaman2.input-sampah', compact('dtambahsampah'));
    }

  
    public function tampilHalamanTambahDataSampah()
    {


    return view('Halaman2.tambah-sampah');
    }

    public function SimpanDataSampah(Request $request)
    {
        InputSampah::create([
            'id_input_sampah'=> $request->id_input_sampah,
            'ketinggian_sampah'=>$request->ketinggian_sampah,
            'tanggal'=>$request->tanggal,
        ]);

        return redirect('input-sampah');
    }

    
    public function EditInputSampah($id)
    {
        $peg = InputSampah::findorfail($id);
        return view('Halaman2.edit-sampah',compact ('peg'));
    }

    public function UpdateInputSampah(request $request, $id)
    {
        $peg = InputSampah::findorfail($id);
        $peg->update($request->all());
        return redirect('input-sampah')->with('toast_success', 'Data Berhasil Update');
    } 

    public function DeleteInputSampah($id)
    {
        $peg = InputSampah::findorfail($id);
        $peg->delete();
        return back()->with('info', 'Data Berhasil Dihapus');  
    }
}
