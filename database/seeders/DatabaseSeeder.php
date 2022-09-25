<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            roles_Sedder::class,
        ]);

        $this->call([
            Accounts_seeder::class,
        ]);
    }
}
