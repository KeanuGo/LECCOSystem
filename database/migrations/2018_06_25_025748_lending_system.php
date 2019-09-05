<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LendingSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function( Blueprint $table ){
			$table->increments('id');
			$table->string('TIN');
			$table->string('first_name');
			$table->string('last_name');
			$table->date('birthday');
			$table->unsignedInteger('age');
			$table->string('gender');
			$table->string('civil_status');
			$table->string('religion');
			$table->string('highest_educational_attainment');
			$table->unsignedInteger('no_of_dependents');
			$table->string('residential_address');
			$table->string('employer');
			$table->string('department');
			$table->string('position');
			$table->decimal('annual_income');
			$table->unsignedInteger('length_of_service(years)');
			$table->string('status_of_employment');
			$table->unsignedInteger('no_of_subscribed_shares');
			$table->unsignedInteger('years_to_fully_pay');
			$table->string('avatar');
			$table->string('contact_no');
			//$table->string('status');
			//$table->string('remarks');
			$table->date('date_accepted');
			$table->string('BOD_resolution_number');
			$table->string('type_of_membership');
			$table->timestamps();
		});
		
		
		Schema::create('loan_types', function (Blueprint $table){
			$table->increments('id');
			$table->string('name');
			$table->float('interest_per_annum');
			$table->decimal('amount_minimum');
			$table->decimal('amount_maximum');
			$table->unsignedInteger('payment_period_minimum');
			$table->unsignedInteger('payment_period_maximum');
			$table->timestamps();
			$table->unique('name');
		});
		
		Schema::create('loans', function (Blueprint $table){
			$table->increments('id');
			$table->unsignedInteger('member_id');
			$table->string('loan_type');
			$table->decimal('amount');
			$table->decimal('total_interest');
			$table->decimal('total_loan_receivable');
			$table->unsignedInteger('term');
			$table->float('interest_per_annum');
			$table->date('start_of_payment');
			//$table->string('status');
			$table->string('remarks');
			$table->timestamps();
			//$table->foreign('member_id')->references('id')->on('members');
			$table->foreign('loan_type')->references('name')->on('loan_types')->onUpdate('cascade');
		});
		
		Schema::create('payrolls', function (Blueprint $table){
			$table->unsignedInteger('loan_id');
			$table->boolean('semi_monthly_payroll_1');
			$table->boolean('semi_monthly_payroll_2');
			$table->boolean('RA\LP');
			$table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
		});
		
		Schema::create('payroll_deductions', function (Blueprint $table){
			$table->unsignedInteger('loan_id');
			$table->string('payroll');
			$table->unsignedInteger('payment_no');
			$table->date('expected_date_of_payment');
			$table->date('month_year_applied')->nullable();
			$table->decimal('penalty_interest')->default(0.0);
			$table->decimal('periodic_payment');
			$table->decimal('total_paid_balance')->nullable();
			$table->text('remarks')->nullable();
			$table->timestamps();
			$table->unique(['loan_id', 'payroll', 'payment_no']);
			$table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
		});
		
		Schema::create('shares', function (Blueprint $table){
			$table->increments('id');
			$table->unsignedInteger('member_id');
			$table->unsignedInteger('total');
			$table->decimal('price');
			$table->decimal('amount');
			$table->timestamps();
			//$table->foreign('member_id')->references('id')->on('members');
		});
		
		Schema::create('access_rights', function (Blueprint $table){
			$table->unsignedInteger('user_id');
			$table->boolean('users_view')->default(false);
			$table->boolean('users_edit')->default(false);
			$table->boolean('users_delete')->default(false);
			$table->boolean('invoke_rights')->default(false);
			$table->boolean('member_view')->default(true);
			$table->boolean('member_delete')->default(false);
			$table->boolean('member_edit')->default(false);
			$table->boolean('member_create')->default(false);
			$table->boolean('loans_types_view')->default(true);
			$table->boolean('loans_types_edit')->default(false);
			$table->boolean('loans_types_delete')->default(false);
			$table->boolean('loans_types_create')->default(false);
			$table->boolean('loans_view')->default(true);
			$table->boolean('loans_delete')->default(false);
			$table->boolean('loans_edit')->default(false);
			$table->boolean('loans_create')->default(false);
			$table->boolean('shares_view')->default(true);
			$table->boolean('shares_delete')->default(false);
			$table->boolean('shares_create')->default(false);
			$table->boolean('shares_edit')->default(false);
			$table->boolean('coa_view')->default(true);
			$table->boolean('coa_delete')->default(false);
			$table->boolean('coa_create')->default(false);
			$table->boolean('coa_edit')->default(false);
			$table->boolean('signatories_view')->default(true);
			$table->boolean('signatories_delete')->default(false);
			$table->boolean('signatories_create')->default(false);
			$table->boolean('signatories_edit')->default(false);
			$table->boolean('check_voucher_view')->default(true);
			$table->boolean('check_voucher_delete')->default(false);
			$table->boolean('check_voucher_create')->default(false);
			$table->boolean('check_voucher_edit')->default(false);
			$table->timestamps();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
		
		Schema::create('chart_of_accounts', function (Blueprint $table){
			$table->increments('id');
			$table->string('account_title');
			$table->string('account_code');
			$table->unique('account_code');
		});
		
		Schema::create('signatories', function (Blueprint $table){
			$table->increments('id');
			$table->string('name');
			$table->string('designation');
		});
		
		Schema::create('check_voucher', function (Blueprint $table){
			$table->bigInteger('cv_no');
			$table->string('payee');
			$table->date('date_disbursed')->nullable();
			$table->string('check_no');
			$table->string('description');
			$table->string('attachment')->nullable();
			$table->timestamps();
			$table->unique('cv_no');
		});
		
		//DB::unprepared('ALTER TABLE check_voucher DROP PRIMARY KEY');
		
		Schema::create('cv_entries', function (Blueprint $table){
			$table->unsignedBigInteger('id');
			$table->string('account_code');
			$table->decimal('debit');
			$table->decimal('credit');
			$table->foreign('id')->references('cv_no')->on('check_voucher')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('account_code')->references('account_code')->on('chart_of_accounts')->onUpdate('cascade');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('cv_entries');
		Schema::dropIfExists('check_voucher');
		
		Schema::dropIfExists('signatories');
		
		Schema::dropIfExists('chart_of_accounts');
        Schema::dropIfExists('access_rights');
        Schema::dropIfExists('shares');
        Schema::dropIfExists('payroll_deductions');
        Schema::dropIfExists('payrolls');
        Schema::dropIfExists('loans');
        Schema::dropIfExists('loan_types');
        Schema::dropIfExists('members');
    }
}
