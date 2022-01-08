<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->nullable()->references('id')->on('jobs');
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->mediumText('proposal_text')->nullable();
            $table->boolean('accepted')->default(false);
            $table->enum('status',['started','delivered','waiting'])->default('waiting');
            $table->integer('bid')->nullable();
            $table->timestamp('delivery_date')->nullable();
            $table->string('delivery_file')->nullable();
            $table->text('delivery_comments')->nullable();
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
        Schema::dropIfExists('job_proposals');
    }
}
