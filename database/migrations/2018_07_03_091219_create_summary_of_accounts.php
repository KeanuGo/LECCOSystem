<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSummaryOfAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(
			"create view summary_of_accounts as (select cv_entries.*,
				SUBSTRING(cv_entries.account_code, 0, case CHARINDEX('-', cv_entries.account_code) when 0 then len(chart_of_accounts.account_code)+1 else CHARINDEX('-', cv_entries.account_code) end ) AS [gen_account_code],
				SUBSTRING(cv_entries.account_code,0, case (CHARINDEX('-', REVERSE(cv_entries.account_code)) + CHARINDEX('-', cv_entries.account_code) - 1) when len(chart_of_accounts.account_code) then len(chart_of_accounts.account_code)+1 else case CHARINDEX('-', cv_entries.account_code) when 0 then 0 else len(cv_entries.account_code) - CHARINDEX('-', REVERSE(cv_entries.account_code)) + 1 end end ) AS [sub_group],
				chart_of_accounts.account_title,
				SUBSTRING(chart_of_accounts.account_title, 0, case CHARINDEX('-', chart_of_accounts.account_title) when 0 then len(chart_of_accounts.account_title)+1 else CHARINDEX('-', chart_of_accounts.account_title) end ) AS [gen_accounts_title],
				SUBSTRING(chart_of_accounts.account_title,0, case (CHARINDEX('-', REVERSE(chart_of_accounts.account_title)) + CHARINDEX('-', chart_of_accounts.account_title) - 1) when len(chart_of_accounts.account_title) then len(chart_of_accounts.account_title)+1 else case CHARINDEX('-', chart_of_accounts.account_title) when 0 then 0 else len(chart_of_accounts.account_title) - CHARINDEX('-', REVERSE(chart_of_accounts.account_title)) + 1 end end ) AS [sub_group_title]
			from cv_entries
			join chart_of_accounts on chart_of_accounts.account_code = cv_entries.account_code)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("drop view summary_of_accounts;");
    }
}
