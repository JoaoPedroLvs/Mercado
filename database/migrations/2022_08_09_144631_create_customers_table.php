<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {

            $table->id();

            $table->bigInteger('user_id');
            $table->string('address', 300)->nullable();
            $table->string('rg', 11)->unique()->nullable();
            $table->string('cpf', 14)->unique();
            $table->string('phone')->nullable();
            $table->boolean('is_new')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
