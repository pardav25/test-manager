<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToQuestionsTable extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->foreign('subject_id', 'subject_fk_6730298')->references('id')->on('subjects');
            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('type_id', 'type_fk_6730328')->references('id')->on('types');
        });
    }
}