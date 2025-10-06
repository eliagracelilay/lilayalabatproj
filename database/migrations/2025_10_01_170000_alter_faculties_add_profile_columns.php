<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFacultiesAddProfileColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faculties', function (Blueprint $table) {
            $table->string('suffix')->nullable()->after('last_name');
            $table->string('sex', 16)->nullable()->after('suffix');
            $table->string('email')->nullable()->after('sex');
            $table->string('contact_number')->nullable()->after('email');
            $table->text('address')->nullable()->after('contact_number');
            $table->string('position')->nullable()->after('department_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faculties', function (Blueprint $table) {
            $table->dropColumn(['suffix','sex','email','contact_number','address','position']);
        });
    }
}
