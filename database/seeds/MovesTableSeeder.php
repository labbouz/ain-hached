<?php

use Illuminate\Database\Seeder;

class MovesTableSeeder extends Seeder
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

        //delete moves table records
        DB::table('moves')->truncate();
        //insert some dummy records
        DB::table('moves')->insert(array(
            array('nom_move'=>trans('move.session_de_negociation'), 'created_at' => date('Y-m-d H:i:s')),
            array('nom_move'=>trans('move.travailleurs_reunion'), 'created_at' => date('Y-m-d H:i:s')),
            array('nom_move'=>trans('move.une_protestation'), 'created_at' => date('Y-m-d H:i:s')),
            array('nom_move'=>trans('move.pause_pour_travailler'), 'created_at' => date('Y-m-d H:i:s')),
            array('nom_move'=>trans('move.institution_d_exercice'), 'created_at' => date('Y-m-d H:i:s')),
            array('nom_move'=>trans('move.greve_du_secteur'), 'created_at' => date('Y-m-d H:i:s')),
            array('nom_move'=>trans('move.greve_regionale'), 'created_at' => date('Y-m-d H:i:s')),
            array('nom_move'=>trans('move.une_greve_generale'), 'created_at' => date('Y-m-d H:i:s')),
            array('nom_move'=>trans('move.sit_in'), 'created_at' => date('Y-m-d H:i:s')),
            array('nom_move'=>trans('move.greve_de_la_faim'), 'created_at' => date('Y-m-d H:i:s')),

        ));

        // supposed to only apply to a single connection and reset it's self
        // but I like to explicitly undo what I've done for clarity
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
