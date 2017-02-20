<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViolationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('violations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom_violation');
            $table->text('description_violation')->nullable();
            $table->integer('type_violation_id')->unsigned();
            $table->foreign('type_violation_id')->references('id')->on('types_violations');
            $table->integer('gravite_id')->unsigned();
            $table->foreign('gravite_id')->references('id')->on('gravites');
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
        Schema::dropIfExists('violations');
    }
}
