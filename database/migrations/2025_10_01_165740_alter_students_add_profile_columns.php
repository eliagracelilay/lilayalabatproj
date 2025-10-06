<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStudentsAddProfileColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('suffix')->nullable()->after('last_name');
            $table->string('sex', 16)->nullable()->after('suffix');
            $table->date('birthdate')->nullable()->after('sex');
            $table->string('email')->nullable()->after('birthdate');
            $table->string('contact_number')->nullable()->after('email');
            $table->text('address')->nullable()->after('contact_number');

            $table->unsignedBigInteger('course_id')->nullable()->after('department_id');
            $table->unsignedBigInteger('academic_year_id')->nullable()->after('course_id');

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropForeign(['academic_year_id']);
            $table->dropColumn([
                'suffix','sex','birthdate','email','contact_number','address','course_id','academic_year_id'
            ]);
        });
    }
}
