<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('users')->insert([
		    'username' => 'daitd58',
		    'isSuperuser' => 1,
		    'role' => 1,
		    'vnuMail' => 'daitd_58@vnu.edu.vn',
		    'password' => bcrypt('123456'),
	    ]);
    }
}
