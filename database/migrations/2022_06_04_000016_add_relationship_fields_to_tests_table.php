<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTestsTable extends Migration
{
    public function up()
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->foreign('subject_id', 'subject_fk_6730469')->references('id')->on('subjects');
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->foreign('creator_id', 'creator_fk_6730487')->references('id')->on('users');
        });
    }
}