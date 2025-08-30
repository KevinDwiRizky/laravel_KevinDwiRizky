<?php

namespace App\Http\Controllers;

use App\Models\RumahSakit;
use Illuminate\Http\Request;

class RumahSakitController extends Controller {
  
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $rumahSakit = RumahSakit::orderBy('id')->get();
        return view('rumah_sakit.index', compact('rumahSakit'));
    }

    public function store(Request $request){
        $request->validate([
            'nama_rumah_sakit' => 'required',
            'email' => 'nullable|email',
            'telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        RumahSakit::create($request->only('nama_rumah_sakit','alamat','email','telepon'));
        return redirect()->route('rumah_sakit.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function ajaxUpdate(Request $request, $id){
        $request->validate([
            'nama_rumah_sakit' => 'required',
            'email' => 'nullable|email',
            'telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        $rs = RumahSakit::findOrFail($id);
        $rs->update($request->only('nama_rumah_sakit','alamat','email','telepon'));

        return redirect()->route('rumah_sakit.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id){
        RumahSakit::findOrFail($id)->delete();
        return response()->json(['success'=>true]);
    }
}
