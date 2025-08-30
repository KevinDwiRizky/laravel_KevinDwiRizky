<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PasienSeeder extends Seeder {
    public function run() {
        DB::table('pasien')->insert([
            ['nama_pasien'=>'Budi','alamat'=>'Jl. A','no_telpon'=>'081111','rumah_sakit_id'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['nama_pasien'=>'Ani','alamat'=>'Jl. B','no_telpon'=>'082222','rumah_sakit_id'=>2,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
