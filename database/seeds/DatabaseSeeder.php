<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
		$this->call(coa_seeder::class);
		$this->call(loan_type_seeder::class);
		$this->call(UserSeeder::class);
    }
}
