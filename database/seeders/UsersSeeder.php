<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if ($this->command->confirm('truncate first ?')) {
            User::truncate();
        }

        $data = [
            [
                'name' => 'Rizky Hajar',
                'username' => 'riskihajar',
                'email' => 'riskihajar@deka.dev',
                'email_verified_at' => now(),
                'password' => bcrypt('qweasdzxc123'),
            ],
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'admin@varianiaga.com',
                'email_verified_at' => now(),
                'password' => bcrypt('qweasdzxc123'),
            ],
        ];

        foreach ($data as $item) {
            User::firstOrCreate($item);
        }

    }
}
