<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
    	Db::table('users')->insetr([
		  'name' => str_random(10),
		  'email' =>str_random(10).@'laravelacademy.org',
		  'password' => bcrypt('secret'),
    	]);

      
    }
}
