<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\JanjiTemu;
use App\Models\NomorAntrian;
use App\Models\Poli;
use App\Models\Profile;
use App\Models\RekamMedis;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'pasien']);
        Role::create(['name' => 'dokter']);
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        $pasien = User::create([
            'name' => 'pasien',
            'email' => 'pasien@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $pasien->assignRole('pasien');

        $dokter = User::create([
            'name' => 'dokter',
            'email' => 'dokter@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $dokter->assignRole('dokter');

        Profile::create([
            'user_id' => $admin->id,
        ]);

        Profile::create([
            'user_id' => $pasien->id,
        ]);

        $poli1 = Poli::create([
            'name' => 'Poli Penyakit Dalam'
        ]);

        Dokter::create([
            'user_id' => $dokter->id,
            'poli_id' => $poli1->id,
            'spesialisasi' => 'Penyakit Dalam',
        ]);

        $poli2 = Poli::create([
            'name' => 'Poli Penyakit Mata'
        ]);

        $nomorAntrian = NomorAntrian::create([
            'nomor' => 1,
        ]);

        $janjiTemu = JanjiTemu::create([
            'user_id' => $pasien->id,
            'poli_id' => $poli1->id,
            'tanggal_kunjungan' => now(),
            'nomor_antrian' => $nomorAntrian->nomor,
            'status_pasien' => 'baru',
            'status_penanganan' => 'menunggu',
        ]);

        RekamMedis::create([
            'janji_temu_id' => $janjiTemu->id,
            'keluhan' => "Mual Mual",
            'diagnosa' => 'Herd',
            'tindakan' => 'inpus 1 hari dulu',
            'obat' => 'Promagh',
            'keterangan' => 'Akut',
            'nomor_antrian' => $janjiTemu->nomor_antrian,
            'status_rawat' => 'menginap',
        ]);


    }
}
