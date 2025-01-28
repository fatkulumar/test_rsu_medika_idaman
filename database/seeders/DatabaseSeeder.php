<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\JanjiTemu;
use App\Models\NomorAntrian;
use App\Models\Poli;
use App\Models\Profile;
use App\Models\RekamMedis;
use App\Models\User;
use Carbon\Carbon;
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
        Role::create(['name' => 'pegawai']);
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        $pasien1 = User::create([
            'name' => 'pasien1',
            'email' => 'pasien1@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $pasien1->assignRole('pasien');

        $pasien2 = User::create([
            'name' => 'pasien2',
            'email' => 'pasien2@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $pasien2->assignRole('pasien');

        $dokter = User::create([
            'name' => 'dokter',
            'email' => 'dokter@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $dokter->assignRole('dokter');

        $pegawai = User::create([
            'name' => 'pegawai',
            'email' => 'pegawai@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $pegawai->assignRole('pegawai');

        Profile::create([
            'user_id' => $admin->id,
        ]);

        Profile::create([
            'user_id' => $pasien1->id,
            'hp' => '08123456789',
            'tanggal_lahir' => now(),
            'jenis_kelamin' => 'laki-laki',
            'alamat' => 'kedunggalar',
        ]);

        Profile::create([
            'user_id' => $pasien2->id,
            'hp' => '08123456781',
            'tanggal_lahir' => now(),
            'jenis_kelamin' => 'perempuan',
            'alamat' => 'ngawi',
        ]);

        Profile::create([
            'user_id' => $dokter->id,
        ]);

        Profile::create([
            'user_id' => $pegawai->id,
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
            'user_id' => $pasien1->id,
            'poli_id' => $poli1->id,
            'tanggal_kunjungan' => now(),
            'nomor_antrian' => $nomorAntrian->nomor,
            'status_pasien' => 'baru',
            'status_penanganan' => 'menunggu',
        ]);

        $tanggalDanWaktu = Carbon::now()->format('ymd');
        $nomorRekam = $tanggalDanWaktu.'0001';

        RekamMedis::create([
            'janji_temu_id' => $janjiTemu->id,
            'user_id' => $pasien1->id,
            'keluhan' => "Mual Mual",
            'diagnosa' => 'Herd',
            'tindakan' => 'inpus 1 hari dulu',
            'obat' => 'Promagh',
            'keterangan' => 'Akut',
            'nomor_antrian' => $janjiTemu->nomor_antrian,
            'status_rawat' => 'menginap',
            'nomor_rekam_medis' => $nomorRekam,
        ]);
    }
}
