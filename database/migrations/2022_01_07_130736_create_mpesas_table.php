<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMpesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpesas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('user_id');
            $table->string('merchantRequestID')->nullable();
            $table->text('result')->nullable();
            $table->string('checkoutRequestID');
            $table->integer('resultCode')->nullable();
            $table->integer('responseCode')->nullable();
            $table->string('resultDesc')->nullable();
            $table->string('responseDescription')->nullable();
            $table->string('customerMessage')->nullable();
            $table->string('mpesaReceiptNumber')->nullable();
            $table->string('phoneNumber')->nullable();
            $table->float('amount')->nullable();
            $table->float('balance')->nullable();
            $table->boolean('active')->default(true);
            $table->dateTime('transactionDate')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mpesas');
    }
}
