<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\user_role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Accounts_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make(12345678)
        ]);

        user_role::create([
            'user_id' => $admin->id,
            'role_id' => 1
        ]);
    }
}
