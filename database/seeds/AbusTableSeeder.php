<?php

use Illuminate\Database\Seeder;

class AbusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //disable foreign key check for this connection before running seeders
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        //delete Delegations table records
        DB::table('agresseurs')->truncate();

        //delete Delegations table records
        DB::table('endommages')->truncate();

        //delete Delegations table records
        DB::table('abus')->truncate();

        // but I like to explicitly undo what I've done for clarity
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
