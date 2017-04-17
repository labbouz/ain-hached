<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgresseursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agresseurs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('abus_id')->unsigned();
            $table->foreign('abus_id')->references('id')->on('abus');
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('nationalite')->nullable();
            $table->boolean('responsabilite_1')->default(false);
            $table->boolean('responsabilite_2')->default(false);
            $table->boolean('responsabilite_3')->default(false);
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
        Schema::dropIfExists('agresseurs');
    }
}
