<?php

use Illuminate\Database\Seeder;

class TypesViolationsTableSeeder extends Seeder
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

        //delete secteurs table records
        DB::table('types_violations')->truncate();
        //insert some dummy records
        DB::table('types_violations')->insert(array(
            array('nom_type_violation'=>trans('violations.type_violation_1'), 'description_type_violation'=>trans('violations.desc_type_violation_1'),'class_color_type_violation'=>'violation-individuel', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_type_violation'=>trans('violations.type_violation_2'), 'description_type_violation'=>trans('violations.desc_type_violation_2'),'class_color_type_violation'=>'violation-collectif', 'created_at' => date('Y-m-d H:i:s')),

        ));

        // supposed to only apply to a single connection and reset it's self
        // but I like to explicitly undo what I've done for clarity
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
