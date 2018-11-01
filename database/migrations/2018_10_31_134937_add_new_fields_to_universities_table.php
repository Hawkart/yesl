<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsToUniversitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->integer('score_id');
            $table->integer('ope8_id');
            $table->integer('ope6_id');
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('accreditor')->nullable();
            $table->string('price_calculator_url')->nullable();
            $table->integer('main_campus')->nullable();
            $table->integer('branches')->nullable();
            $table->integer('ownership')->nullable();
            $table->integer('state_fips')->nullable();
            $table->integer('region_id')->nullable();
            $table->decimal('location_lat', 10, 8)->nullable();
            $table->decimal('location_lon', 11, 8)->nullable();
            $table->float('admission_rate_overall')->nullable();
            $table->float('sat_scores_average_overall')->nullable();
            $table->tinyInteger('online_only')->nullable();
            $table->integer('size')->nullable();
            $table->integer('enrollment_all')->nullable();
            $table->integer('operating')->nullable();
            $table->integer('cost_tuition_in_state')->nullable();
            $table->integer('cost_tuition_out_of_state')->nullable();
            $table->float('aid_pell_grant_rate')->nullable();
            $table->float('aid_federal_loan_rate')->nullable();
            $table->integer('demographics_age_entry')->nullable();
            $table->float('demographics_female_share')->nullable();
            $table->float('demographics_married')->nullable();
            $table->integer('10_yrs_after_entry_working_not_enrolled')->nullable();
            $table->integer('10_yrs_after_entry_median')->nullable();
            $table->float('demographics_men')->nullable();
            $table->float('demographics_women')->nullable();
            $table->integer('undergrads_with_pell_grant')->nullable();
            $table->integer('undergrads_non_degree')->nullable();
            $table->integer('grad_students')->nullable();
            $table->string('url')->nullable()->change();
            $table->string('domain')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('universities', function (Blueprint $table) {
            //
        });
    }
}
