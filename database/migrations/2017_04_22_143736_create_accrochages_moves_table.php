<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccrochagesMovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accrochages_moves', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('abu_id')->unsigned();
            $table->foreign('abu_id')->references('id')->on('abus');
            $table->integer('move_id')->unsigned();
            $table->foreign('move_id')->references('id')->on('moves');
            $table->date('date_accrochage')->nullable();
            $table->text('description_accrochage')->nullable();
            $table->string('document')->nullable();
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
        Schema::dropIfExists('accrochages_moves');
    }
}
