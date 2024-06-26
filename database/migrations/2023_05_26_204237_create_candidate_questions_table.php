<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('candidate_id')->nullable();
            $table->integer('question_id')->nullable();
            $table->string('candidate_option')->nullable();
            $table->integer('candidate_is_correct')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // $table->foreign('candidate_id')->references('id')->on('candidates')->onDelete('cascade');
            // $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidate_questions');
    }
}
