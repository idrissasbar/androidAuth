<?php

use Illuminate\Database\Seeder;
use \Illuminate\Database\Eloquent\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        
       // $this->call(UsersTableSeeder::class);
        factory(App\User::class, 10)->create();
        factory(App\Child::class, 80)->create();
        
    }
}
