<?php
// UserSeeder.php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test Applicant',
            'user_code' => 'v123456',
            'email' => 'applicant@example.com',
            'password' => bcrypt('password'),
            'user_type' => 'applicant'
        ]);

        User::factory()->create([
            'name' => 'Test Admin',
            'user_code' => 'e123456',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'user_type' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'Test Manager',
            'user_code' => 'm123456',
            'email' => 'manager@example.com',
            'password' => bcrypt('password'),
            'user_type' => 'manager'
        ]);
    }
}
