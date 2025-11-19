<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Henry Saputra',
            'email' => 'hr@example.com',
            'employee_id' => '1'
        ]);
        User::factory()->create([
            'name' => 'Henry',
            'email' => 'staffit@example.com',
            'employee_id' => '2'
        ]);
        User::factory()->create([
            'name' => 'Saputra',
            'email' => 'staffsales@example.com',
            'employee_id' => '3'
        ]);
    }
}
