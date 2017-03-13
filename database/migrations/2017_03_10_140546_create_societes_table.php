<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocietesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('societes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom_societe');
            $table->string('nom_marque');
            $table->date('date_cration_societe')->nullable();
            $table->integer('type_societe_id')->unsigned();
            $table->foreign('type_societe_id')->references('id')->on('types_societes');
            $table->integer('delegation_id')->unsigned();
            $table->foreign('delegation_id')->references('id')->on('delegations');
            $table->integer('secteur_id')->unsigned();
            $table->foreign('secteur_id')->references('id')->on('secteurs');
            $table->boolean('accord_de_fondation')->default(false);
            $table->boolean('convention_cadre_commun')->default(true);
            $table->integer('convention_id')->unsigned()->default(0);
            $table->integer('nombre_travailleurs_cdi')->default(0);
            $table->integer('nombre_travailleurs_cdd')->default(0);
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
        Schema::dropIfExists('societes');
    }
}
