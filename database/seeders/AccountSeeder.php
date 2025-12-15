<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'user_type' => 'admin',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        Admin::updateOrCreate(
            ['email' => 'mrbc@kaelco.com.ph'],
            [
                'name' => 'Admin User',
                'email' => 'mrbc@kaelco.com.ph',
                'user_type' => 'admin',
                'email_verified_at' => now(),
                'password' => Hash::make('kaelco@novu'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        Admin::updateOrCreate(
            ['email' => 'isd@kaelco.com.ph'],
            [
                'name' => 'Admin User',
                'email' => 'isd@kaelco.com.ph',
                'user_type' => 'admin',
                'email_verified_at' => now(),
                'password' => Hash::make('kaelco@novu'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        Admin::updateOrCreate(
            ['email' => 'bobick.moreno@kaelco.com.ph'],
            [
                'name' => 'Admin User',
                'email' => 'bobick.moreno@kaelco.com.ph',
                'user_type' => 'admin',
                'email_verified_at' => now(),
                'password' => Hash::make('kaelco@novu'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        Admin::updateOrCreate(
            ['email' => 'kaelcodev@gmail.com'],
            [
                'name' => 'Admin User',
                'email' => 'kaelcodev@gmail.com',
                'user_type' => 'admin',
                'email_verified_at' => now(),
                'password' => Hash::make('kaelco@novu'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        Admin::updateOrCreate(
            ['email' => 'cashier@gmail.com'],
            [
                'name' => 'Cashier User',
                'email' => 'cashier@gmail.com',
                'user_type' => 'cashier',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        Admin::updateOrCreate(
            ['email' => 'technician@gmail.com'],
            [
                'name' => 'Technician User',
                'email' => 'technician@gmail.com',
                'user_type' => 'technician',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        Admin::updateOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin User',
                'email' => 'superadmin@gmail.com',
                'user_type' => 'super_admin',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

    }
}
