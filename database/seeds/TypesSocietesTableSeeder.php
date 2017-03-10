<?php

use Illuminate\Database\Seeder;

class TypesSocietesTableSeeder extends Seeder
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

        //delete types_societes table records
        DB::table('types_societes')->truncate();

        DB::table('types_societes')->insert(array(
            array('nom_type_societe'=>trans('societe.type_societe_1'), 'created_at' => date('Y-m-d H:i:s')),
            array('nom_type_societe'=>trans('societe.type_societe_2'), 'created_at' => date('Y-m-d H:i:s')),
            array('nom_type_societe'=>trans('societe.type_societe_3'), 'created_at' => date('Y-m-d H:i:s')),
            array('nom_type_societe'=>trans('societe.type_societe_4'), 'created_at' => date('Y-m-d H:i:s')),
        ));

        // supposed to only apply to a single connection and reset it's self
        // but I like to explicitly undo what I've done for clarity
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
