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
            $table->string('candidate_id')->nullable();
            $table->string('exam_id')->nullable();
            $table->string('question_id')->nullable();
            $table->string('candidate_option')->nullable();
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
        Schema::dropIfExists('candidate_questions');
    }
}
