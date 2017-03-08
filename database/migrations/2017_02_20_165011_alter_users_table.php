<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nom')->nullable();
            $table->string('prnom')->nullable();
            $table->string('societe', 100)->nullable();
            $table->integer('structure_syndicale_id')->unsigned()->default(0);
            $table->string('phone_number')->nullable();
            $table->string('email2')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('logout')->default(false);
            $table->boolean('active')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
