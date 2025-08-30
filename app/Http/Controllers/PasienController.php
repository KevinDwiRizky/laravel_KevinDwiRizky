<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\RumahSakit;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $pasien = Pasien::with('rumahSakit')->get();
        $rumahSakit = RumahSakit::all();
        return view('pasien.index', compact('pasien','rumahSakit'));
    }

    public function store(Request $request){
        $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'rumah_sakit_id' => 'required|exists:rumah_sakit,id'
        ]);

        $pasien = Pasien::create($request->only('nama_pasien','alamat','no_telpon','rumah_sakit_id'));
        return redirect()->back()->with('success','Pasien berhasil ditambahkan.');
    }

    public function update(Request $request, $id){
        $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'rumah_sakit_id' => 'required|exists:rumah_sakit,id'
        ]);

        $pasien = Pasien::findOrFail($id);
        $pasien->update($request->only('nama_pasien','alamat','no_telpon','rumah_sakit_id'));
        return redirect()->back()->with('success','Pasien berhasil diupdate.');
    }

    public function destroy($id){
        Pasien::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function filter($rumah_sakit_id){
        $pasien = Pasien::with('rumahSakit')
            ->when($rumah_sakit_id != 'all', fn($q)=>$q->where('rumah_sakit_id',$rumah_sakit_id))
            ->get();
        return response()->json($pasien);
    }
}
