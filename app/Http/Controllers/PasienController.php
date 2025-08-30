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

    public function store(Request $r){
        $r->validate(['nama_pasien'=>'required','rumah_sakit_id'=>'required']);
        $p = Pasien::create($r->only('nama_pasien','alamat','no_telpon','rumah_sakit_id'));
        $p->load('rumahSakit');
        return response()->json($p);
    }

    public function ajaxUpdate(Request $r,$id){
        $p = Pasien::findOrFail($id);
        $p->update($r->only('nama_pasien','alamat','no_telpon','rumah_sakit_id'));
        $p->load('rumahSakit');
        return response()->json($p);
    }

    public function destroy($id){
        Pasien::findOrFail($id)->delete();
        return response()->json(['success'=>true]);
    }

    public function filter($rumah_sakit_id){
        $pasien = Pasien::with('rumahSakit')
            ->when($rumah_sakit_id != 'all', fn($q)=>$q->where('rumah_sakit_id',$rumah_sakit_id))
            ->get();
        return response()->json($pasien);
    }
}
