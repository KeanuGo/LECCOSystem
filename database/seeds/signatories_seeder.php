<?php

use Illuminate\Database\Seeder;

class signatories_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('signatories')->insertGetId([
			'name' => 'Princess Kay Senalde',
			'designation' => 'Staff',
		]);
		
		DB::table('signatories')->insertGetId([
			'name' => 'Apple B. Unay',
			'designation' => 'Audit Committee - Chairman',
		]);
		
		DB::table('signatories')->insertGetId([
			'name' => 'Engr. Rommel P. Moron',
			'designation' => 'General Manager',
		]);
    }
}
