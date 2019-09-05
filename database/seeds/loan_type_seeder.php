<?php

use Illuminate\Database\Seeder;

class loan_type_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loan_types')->insertGetId([
			'Name' => 'Multi-purpose Loan',
			'amount_minimum' => 20000.00,
			'amount_maximum' => 150000.00,
			'payment_period_minimum' => 24,
			'payment_period_maximum' => 24,
			'interest_per_annum' => .175,
		]);
		
		DB::table('loan_types')->insertGetId([
			'Name' => 'Calamity Loan',
			'amount_minimum' => 0.00,
			'amount_maximum' => 35000.00,
			'payment_period_minimum' => 12,
			'payment_period_maximum' => 24,
			'interest_per_annum' => .09,
		]);
		
		DB::table('loan_types')->insertGetId([
			'Name' => 'Medical Loan',
			'amount_minimum' => 0.00,
			'amount_maximum' => 30000.00,
			'payment_period_minimum' => 12,
			'payment_period_maximum' => 12,
			'interest_per_annum' => .01,
		]);
		
		DB::table('loan_types')->insertGetId([
			'Name' => 'Motorcycle Loan',
			'amount_minimum' => 0.00,
			'amount_maximum' => 0.00,
			'payment_period_minimum' => 36,
			'payment_period_maximum' => 36,
			'interest_per_annum' => .175,
		]);
		
		DB::table('loan_types')->insertGetId([
			'Name' => 'Vehicle Loan',
			'amount_minimum' => 200000.00,
			'amount_maximum' => 250000.00,
			'payment_period_minimum' => 60,
			'payment_period_maximum' => 60,
			'interest_per_annum' => .2,
		]);
		
		
		DB::table('loan_types')->insertGetId([
			'Name' => 'Business Loan',
			'amount_minimum' => 0.00,
			'amount_maximum' => 250000.00,
			'payment_period_minimum' => 60,
			'payment_period_maximum' => 62,
			'interest_per_annum' => .1,
		]);
		
		DB::table('loan_types')->insertGetId([
			'Name' => 'Housing Loan',
			'amount_minimum' => 10000.00,
			'amount_maximum' => 150000.00,
			'payment_period_minimum' => 36,
			'payment_period_maximum' => 36,
			'interest_per_annum' => .09,
		]);
		
		DB::table('loan_types')->insertGetId([
			'Name' => 'Educational Loan',
			'amount_minimum' => 5000.00,
			'amount_maximum' => 35000.00,
			'payment_period_minimum' => 12,
			'payment_period_maximum' => 12,
			'interest_per_annum' => .1,
		]);
		
		DB::table('loan_types')->insertGetId([
			'Name' => 'Electronic and Applience Loan',
			'amount_minimum' => 0,
			'amount_maximum' => 50000.00,
			'payment_period_minimum' => 5,
			'payment_period_maximum' => 24,
			'interest_per_annum' => .12,
		]);
    }
}
