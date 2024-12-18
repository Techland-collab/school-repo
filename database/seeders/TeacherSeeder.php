<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Teacher;
use Faker\Factory as Faker;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Insert a teacher into the users table
        $user = User::create([
            'name' => $faker->name,
            'email' =>'teacher@gmail.com' ,
            'password' => Hash::make('12345678'), // Default password
            'role_name' => 'Teacher',
        ]);

        // Insert a related teacher record
        Teacher::create([
            'full_name' => $user->name,
            'user_id' => $user->id,
            'gender' => $faker->randomElement(['Male', 'Female']),
            'experience' => $faker->randomNumber(2), // Example: Years of experience
            'qualification' => $faker->word, // Example: Qualification name
            'date_of_birth' => $faker->date,
            'phone_number' => $faker->phoneNumber,
            'address' => $faker->address,
        ]);
    }
}
