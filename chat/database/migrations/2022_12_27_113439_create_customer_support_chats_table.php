<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerSupportChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_support_chats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sender_id')->nullable();
            $table->bigInteger('send_to')->nullable();
            $table->text('message')->nullable();
            $table->string('send_by')->nullable();    //user,provider or admin
            $table->string('date');
            $table->string('time');
            $table->string('seen')->default(0);
            $table->string('seen_date')->nullable();
            $table->string('seen_time')->nullable();
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
        Schema::dropIfExists('customer_support_chats');
    }
}
