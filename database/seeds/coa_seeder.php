<?php

use Illuminate\Database\Seeder;

class coa_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		DB::table('chart_of_accounts')->insertGetId([
			'account_code' => '10000',
			'account_title' => 'Asset Accounts',
		]);
		
		DB::table('chart_of_accounts')->insertGetId([
			'account_code' => '11000-12000',
			'account_title' => 'Current Assets',
			
		]);
		
		DB::table('chart_of_accounts')->insertGetId([
			'account_code' => '11100-11180',
			'account_title' => 'Cash and Cash Equivalents',
		]);
		
		DB::table('chart_of_accounts')->insertGetId([
			'account_code' => '11110',
			'account_title' => 'Cash on Hand',
		]);
		
		DB::table('chart_of_accounts')->insertGetId([
			'account_code' => '11120',
			'account_title' => 'Checks & Other Cash Items',
		]);
		
		DB::table('chart_of_accounts')->insertGetId([
			'account_code' => '11130-3',
			'account_title' => 'Cash in Bank- PNB 131313',
		]);
    }
}
