<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->string('title')->nullable();
            $table->mediumText('description')->nullable();
            $table->string('file')->nullable();
            $table->integer('budget')->nullable();
            $table->enum('status',['active','pending','closed','done'])->default('active');
            $table->timestamp('delivery_date')->nullable();
            $table->timestamp('start_date')->nullable();
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
        Schema::dropIfExists('jobs');
    }
}
