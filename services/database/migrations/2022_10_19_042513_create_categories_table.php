<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->bigInteger('days');
            $table->string('end_time')->nullable();
            $table->bigInteger('minimum')->nullable();
            $table->bigInteger('maximum')->nullable();
            $table->bigInteger('less_assign')->nullable();
            $table->bigInteger('location')->nullable();
            $table->bigInteger('last_assign')->nullable();
            $table->bigInteger('maximum_rating')->nullable();
            $table->enum('status', ['Active','InActive'])->default('Active');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
