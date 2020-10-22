<?php

use Illuminate\Database\Seeder;

use App\Permission;
use App\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed the module permissions
        $permissions = Permission::modulePermission();
        $role = Role::where('name','superadmin')->first();
        // Confirm roles needed
        if ($this->command->confirm('Seed module permission? [y|N]', true)) {

            foreach ($permissions as $perms) {
                Permission::firstOrCreate(['name' => $perms]);
            }
            $this->command->info('Module Permissions added.');
            $this->command->info('Granted all the permissions to superadmin');
            $role->syncPermissions(Permission::all());
            $this->command->info('Superadmin granted all the permissions');
        }
    }
}
