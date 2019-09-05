<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*DB::table('users')->getInsertId([
			'name' => 'Jo-sama',
			'email' => 'praise_da_jo777@heaven.com',
			'password' => '$2y$10$qVDrIentO1JTtmZC2NP7dugGmp6Va4sU.YInorvJDvNAtj9YZhhju',
		]);*/
		
		$user = User::create([
            'name' => 'Admin',
            'email' => 'admin@lecco.com',
            'password' => bcrypt('123456'),
        ]);
		
		DB::table('access_rights')->insert([
			'user_id' => $user->id,
			'invoke_rights' => true,
			'users_delete' => true,
			'users_view' => true,
			'users_edit' => true,
			'member_view' => true,
			'member_edit' => true,
			'member_delete' => true,
			'member_create' => true,
			'loans_types_edit' => true,
			'loans_types_view' => true,
			'loans_types_delete' => true,
			'loans_types_create' => true,
			'loans_view' => true,
			'loans_edit' => true,
			'loans_delete' => true,
			'loans_create' => true,
			'shares_edit' => true,
			'shares_view' => true,
			'shares_create' => true,
			'shares_delete' => true,
			'coa_view' => true,
			'coa_create' => true,
			'coa_edit' => true,
			'coa_delete' => true,
			'signatories_view' => true,
			'signatories_create' => true,
			'signatories_edit' => true,
			'signatories_delete' => true,
			'check_voucher_view' => true,
			'check_voucher_create' => true,
			'check_voucher_edit' => true,
			'check_voucher_delete' => true,
		]);
		
		/*DB::table('members')->insertGetId([
			'TIN' => '123',
			'first_name' => 'Jeff',
			'last_name' => 'Sarmen',
			'birthday' => '1998-06-19',
			'age' => 20,
			'gender' => 'male',
			'civil_status' => 'Single',
			'religion' => 'Catholic',
			'highest_educational_attainment' => 'Highschool graduate',
			'no_of_dependents' => 0,
			'residential_address' => 'Tacloban City',
			'employer' => 'n/a',
			'department' => 'n/a',
			'position' => 'n/a',
			'annual_income' => 0,
			'length_of_service(years)' => 0,
			'status_of_employment' => 'n/a',
			'no_of_subscribed_shares' => 0,
			'years_to_fully_pay' => 0,
			'avatar' => 'user.jpg',
			'contact_no' => 'n/a',
			//'status' => 'n/a',
			//'remarks' => 'n/a',
			'date_accepted' => '2018-06-25',
			'BOD_resolution_number' => 'n/a',
			'type_of_membership' => 'n/a'
		]);
		
		DB::table('members')->insertGetId([
			'TIN' => '125',
			'first_name' => 'Keanu',
			'last_name' => 'Go',
			'birthday' => '1998-06-19',
			'age' => 20,
			'gender' => 'male',
			'civil_status' => 'Single',
			'religion' => 'Catholic',
			'highest_educational_attainment' => 'Highschool graduate',
			'no_of_dependents' => 0,
			'residential_address' => 'Tacloban City',
			'employer' => 'n/a',
			'department' => 'n/a',
			'position' => 'n/a',
			'annual_income' => 0,
			'length_of_service(years)' => 0,
			'status_of_employment' => 'n/a',
			'no_of_subscribed_shares' => 0,
			'years_to_fully_pay' => 0,
			'avatar' => 'user.jpg',
			'contact_no' => 'n/a',
			//'status' => 'n/a',
			//'remarks' => 'n/a',
			'date_accepted' => '2018-06-25',
			'BOD_resolution_number' => 'n/a',
			'type_of_membership' => 'n/a'
		]);*/
		
		DB::table('members')->insertGetId([
			'TIN' => '135',
			'first_name' => 'Jethro',
			'last_name' => 'Albano',
			'birthday' => '1998-06-19',
			'age' => 20,
			'gender' => 'male',
			'civil_status' => 'Single',
			'religion' => 'Catholic',
			'highest_educational_attainment' => 'Highschool graduate',
			'no_of_dependents' => 0,
			'residential_address' => 'Tacloban City',
			'employer' => 'n/a',
			'department' => 'n/a',
			'position' => 'n/a',
			'annual_income' => 0,
			'length_of_service(years)' => 0,
			'status_of_employment' => 'n/a',
			'no_of_subscribed_shares' => 0,
			'years_to_fully_pay' => 0,
			'avatar' => 'user.jpg',
			'contact_no' => 'n/a',
			//'status' => 'n/a',
			//'remarks' => 'n/a',
			'date_accepted' => '2018-06-25',
			'BOD_resolution_number' => 'n/a',
			'type_of_membership' => 'n/a'
		]);
    }
}
