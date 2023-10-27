<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $user = User::create([
            'name' => 'Owner',
            'usertype_id' => 1,
            'api_token' => '',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('password@123')
        ]);
        // Log::info($user);
        $user->assignRole('Owner');

        $teacher = User::create([
            'name' => 'Teacher',
            'usertype_id' => 2,
            'api_token' => '',
            'email' => 'teacher@gmail.com',
            'password' => Hash::make('password@123')
        ]);
        // Log::info($teacher);
        $teacher->assignRole('Teacher');
    }
}
