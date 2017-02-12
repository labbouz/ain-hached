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
        //delete secteurs table records
        DB::table('types_violations')->truncate();
        //insert some dummy records
        DB::table('types_violations')->insert(array(
            array('nom_type_violation'=>trans('violations.type_violation_1'), 'description_type_violation'=>trans('violations.desc_type_violation_1'),'class_color_type_violation'=>'violation-individuel', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_type_violation'=>trans('violations.type_violation_2'), 'description_type_violation'=>trans('violations.desc_type_violation_2'),'class_color_type_violation'=>'violation-collectif', 'created_at' => date('Y-m-d H:i:s')),

        ));
    }
}
