<?php

use Illuminate\Database\Seeder;

use App\JenisPekerjaan;
use App\User;
class JenisPekerjaanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis = [
            'Jalan',
            'Jembatan',
        ];
        $user = User::where('name','=','superadmin')->first()->uuid;
        if ($this->command->confirm('Are you sure to seeding data ?')) {
            foreach ($jenis as $jen) {
                JenisPekerjaan::firstOrCreate(['nama' => $jen,'created_by' => $user]);
            }
            $this->command->info('Data inserted to database. :)');
        }
    }
}
