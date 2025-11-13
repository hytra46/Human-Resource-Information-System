<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class HumanResourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('departments')->insert([
            [
                'name' => 'HR', 
                'description' => 'Departmen Human Resources', 
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'IT', 
                'description' => 'Departmen Information Tech', 
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Sales', 
                'description' => 'Departmen Sales', 
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        DB::table('roles')->insert([
            [
                'title' => 'HR', 
                'description' => 'Handling Team', 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Developer', 
                'description' => 'Handling Codes', 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Sales', 
                'description' => 'Handling Selling', 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        DB::table('employees')->insert([
            [
                'fullname' => $faker->name, 
                'email' => $faker->unique()->safeEmail, 
                'phone_number' => $faker->phoneNumber, 
                'address' => $faker->address, 
                'birth_date' => $faker->dateTimeBetween('-40 years', '-20 years'), 
                'hire_date' => Carbon::now(), 
                'department_id' => 1, 
                'role_id' => 1, 
                'status' => 'active', 
                'salary' => $faker->randomFloat(2, 3000, 6000), 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
                'deleted_at' => null 
            ],
            [
                'fullname' => $faker->name, 
                'email' => $faker->unique()->safeEmail, 
                'phone_number' => $faker->phoneNumber, 
                'address' => $faker->address, 
                'birth_date' => $faker->dateTimeBetween('-40 years', '-20 years'), 
                'hire_date' => Carbon::now(), 
                'department_id' => 1, 
                'role_id' => 1,
                'status' => 'active', 
                'salary' => $faker->randomFloat(2, 3000, 6000), 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(), 
                'deleted_at' => null 
            ]
        ]);

        DB::table('tasks')->insert([
            [
                'title' => $faker->sentence(3), 
                'description' => $faker->paragraph, 
                'assigned_to' => 1, 
                'due_date' => Carbon::parse('2025-11-10'), 
                'status' => 'pending', 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now() 
            ],
            [
                'title' => $faker->sentence(3), 
                'description' => $faker->paragraph, 
                'assigned_to' => 1, 
                'due_date' => Carbon::parse('2025-11-10'), 
                'status' => 'pending', 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now() 
            ]
        ]);

        DB::table('payroll')->insert([
            [
                'employee_id' => 1, 
                'salary' => $faker->randomFloat(2, 3000, 6000), 
                'bonuses' => $faker->randomFloat(2, 3000, 6000), 
                'deductions' => $faker->randomFloat(2, 500, 1000), 
                'net_salary' => $faker->randomFloat(2, 3000, 6000), 
                'pay_date' => Carbon::parse('2025-11-10'), 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now() 
            ],
            [
                'employee_id' => 2, 
                'salary' => $faker->randomFloat(2, 3000, 6000), 
                'bonuses' => $faker->randomFloat(2, 3000, 6000), 
                'deductions' => $faker->randomFloat(2, 500, 1000), 
                'net_salary' => $faker->randomFloat(2, 3000, 6000), 
                'pay_date' => Carbon::parse('2025-11-10'), 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now() 
            ]
        ]);

        DB::table('presences')->insert([
            [
                'employee_id' => 1, 
                'check_in' => Carbon::parse('2025-11-05 09:00:00'), 
                'check_out' => Carbon::parse('2025-11-05 17:00:00'), 
                'date' => Carbon::parse('2025-11-05'), 
                'status' => 'present', 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now() 
            ],
            [
                'employee_id' => 2, 
                'check_in' => Carbon::parse('2025-11-05 09:00:00'), 
                'check_out' => Carbon::parse('2025-11-05 17:00:00'), 
                'date' => Carbon::parse('2025-11-05'), 
                'status' => 'present', 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now() 
            ]
        ]);

        DB::table('leave_requests')->insert([
            [
                'employee_id' => 1, 
                'leave_type' => 'Sick Leave', 
                'start_date' => Carbon::parse('2025-11-05'), 
                'end_date' => Carbon::parse('2025-11-07'), 
                'status' => 'pending', 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now() 
            ],
            [
                'employee_id' => 2, 
                'leave_type' => 'Vacation', 
                'start_date' => Carbon::parse('2025-11-05'), 
                'end_date' => Carbon::parse('2025-11-07'), 
                'status' => 'pending', 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now() 
            ]
        ]);
    }
}
