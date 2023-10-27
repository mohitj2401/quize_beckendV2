<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        // Permission::delete();
        $roles = [

            ['name' => 'Owner', 'guard_name' => 'web', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Teacher', 'guard_name' => 'web', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'User', 'guard_name' => 'api', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

        ];

        Role::insert($roles);

        $role = Role::where('name', 'Owner')->first();
        $permissions = Permission::get()->pluck('name');

        $role->syncPermissions($permissions);

        $tecaher = Role::where('name', 'Teacher')->first();
        $permissions = Permission::whereIn('name', [
            'View Subject',
            'Create Subject',
            'Edit Subject',
            'Delete Subject',
            'view Quiz',
            'Create Quiz',
            'Edit Quiz',
            'Delete Quiz',
            'Add Question',
        ])->get()->pluck('name');

        $tecaher->syncPermissions($permissions);
    }
}
