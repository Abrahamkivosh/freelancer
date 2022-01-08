<?php

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
        App\User::create([
            'username'=> 'Admin',
            'email'=>'admin@gmail.com',
            'country'=> 'MD',
            'role_id'=>1,
            'email_verified_at'=>now(),
            'password'=>bcrypt("12345678")
        ]);
        // $this->call(CountriesSeeder::class);
    }
}
