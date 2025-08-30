<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RumahSakitSeeder extends Seeder {
    public function run() {
        DB::table('rumah_sakit')->insert([
            ['nama_rumah_sakit'=>'RS Baru','alamat'=>'Jl. Mawar 1','email'=>'rs1@mail.com','telepon'=>'0211111','created_at'=>now(),'updated_at'=>now()],
            ['nama_rumah_sakit'=>'RS Lama','alamat'=>'Jl. Melati 2','email'=>'rs2@mail.com','telepon'=>'0212222','created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
