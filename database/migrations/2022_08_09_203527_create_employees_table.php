<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {

            $table->id();

            $table->bigInteger('person_id');
            $table->bigInteger('role_id');
            $table->string('work_code');
            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('people');
            $table->foreign('role_id')->references('id')->on('employee_roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
