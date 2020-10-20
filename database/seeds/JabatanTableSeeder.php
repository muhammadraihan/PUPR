<?php

use Illuminate\Database\Seeder;

use App\Jabatan;
use Illuminate\Support\Facades\Auth;
use App\User;
class JabatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jabatans = [
            'Kasatker',
            'PPK',
        ];
        $user = User::where('name','=','superadmin')->first()->uuid;
        // dd($user);
        if ($this->command->confirm('Are you sure to seeding data ?')) {
            foreach ($jabatans as $jabatan) {
                Jabatan::firstOrCreate(['nama' => $jabatan,'created_by' => $user]);
            }
            $this->command->info('Data inserted to database. :)');
        }
    }
}
