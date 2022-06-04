<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAnswersTable extends Migration
{
    public function up()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('type_id', 'type_fk_6730341')->references('id')->on('types');
            $table->unsignedBigInteger('question_id')->nullable();
            $table->foreign('question_id', 'question_fk_6730346')->references('id')->on('questions');
        });
    }
}