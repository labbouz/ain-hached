<?php

use Illuminate\Database\Seeder;

class GravitesTableSeeder extends Seeder
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

        //delete gravites table records
        DB::table('gravites')->truncate();
        //insert some dummy records
        DB::table('gravites')->insert(array(
            array('nom_gravite'=>trans('violations.nom_gravite_1'), 'description_gravite'=>trans('violations.desc_gravite_1'),'class_color_gravite'=>'gravite-warning', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gravite'=>trans('violations.nom_gravite_2'), 'description_gravite'=>trans('violations.desc_gravite_2'),'class_color_gravite'=>'gravite-danger', 'created_at' => date('Y-m-d H:i:s')),

        ));

        // supposed to only apply to a single connection and reset it's self
        // but I like to explicitly undo what I've done for clarity
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
