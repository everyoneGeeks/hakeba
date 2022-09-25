<?php

namespace Database\Seeders;

use App\Models\role;
use Illuminate\Database\Seeder;

class roles_Sedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin', 'secritry', 'mohamy', 'mostshar', 'client', 'company'];
        foreach ($roles as $role){
            role::create([
                'name' => $role
        ]);
        }

    }
}
