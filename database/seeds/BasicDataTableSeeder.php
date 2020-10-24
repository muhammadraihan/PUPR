<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Jabatan;
use App\JenisPekerjaan;
use App\Satker;

class BasicDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('name','=','superadmin')->first()->uuid;
        $jabatans = [
            'Kasatker',
            'PPK',
        ];
        $jenis_pekerjaan = [
            'Jalan',
            'Jembatan',
        ];
        $nama_satker = 'Pelaksanaan Jalan Nasional';
        $wilayah_satker =['1','2','3','4'];

        if ($this->command->confirm('Seed data jabatan? [y|N]', true)) {
            $this->command->getOutput()->createProgressBar(count($jabatans));
            $this->command->getOutput()->progressStart();
            foreach ($jabatans as $jabatan) {
                Jabatan::firstOrCreate(['nama' => $jabatan,'created_by' => $user]);
                $this->command->getOutput()->progressAdvance();
            }
            $this->command->getOutput()->progressFinish();
            $this->command->info('Data Jabatan inserted to database');
        }

        if ($this->command->confirm('Seed data jenis pekerjaan? [y|N]', true)) {
            $this->command->getOutput()->createProgressBar(count($jenis_pekerjaan));
            $this->command->getOutput()->progressStart();
            foreach ($jenis_pekerjaan as $jenis) {
                JenisPekerjaan::firstOrCreate(['nama' => $jenis,'created_by' => $user]);
                $this->command->getOutput()->progressAdvance();
            }
            $this->command->getOutput()->progressFinish();
            $this->command->info('Data Jenis Pekerjaan inserted to database');
        }

        if ($this->command->confirm('Seed data satker? [y|N]',true)) {
            $this->command->getOutput()->createProgressBar(count($wilayah_satker));
            $this->command->getOutput()->progressStart();
            foreach ($wilayah_satker as $wil) {
                Satker::firstOrCreate(['nama' => $nama_satker, 'wilayah' => $wil,'created_by' => $user]);
            }
            $this->command->getOutput()->progressFinish();
            $this->command->info('Data Satker inserted to database');
        }
    }
}
