<?php

use Illuminate\Database\Seeder;
use App\Satker;
use App\User;
class SatkerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nama = 'Pelaksanaan Jalan Nasional';
        $wilayah =['1','2','3','4'];
        $user = User::where('name','=','superadmin')->first()->uuid;
        if ($this->command->confirm('Are you sure to seeding data ?')) {
            foreach ($wilayah as $wil) {
                Satker::firstOrCreate(['nama' => $nama, 'wilayah' => $wil,'created_by' => $user]);
            }
            $this->command->info('Data inserted to database. :)');
        }
    }
}
