<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEndommagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endommages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('abus_id')->unsigned();
            $table->foreign('abus_id')->references('id')->on('abus');
            $table->integer('structure_syndicale_id')->unsigned();
            $table->foreign('structure_syndicale_id')->references('id')->on('structures_syndicales');
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('genre')->nullable();
            $table->integer('age')->default(0);
            $table->integer('etat_civile')->default(0);
            $table->integer('nb_enfant')->default(0);
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->boolean('type_contrat')->default(false);
            $table->integer('anciennete')->default(0);
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
        Schema::dropIfExists('endommages');
    }
}
