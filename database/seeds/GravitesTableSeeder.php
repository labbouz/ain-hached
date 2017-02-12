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
        //delete gravites table records
        DB::table('gravites')->truncate();
        //insert some dummy records
        DB::table('gravites')->insert(array(
            array('nom_gravite'=>trans('violations.nom_gravite_1'), 'description_gravite'=>trans('violations.desc_gravite_1'),'class_color_gravite'=>'label-warning', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gravite'=>trans('violations.nom_gravite_2'), 'description_gravite'=>trans('violations.desc_gravite_2'),'class_color_gravite'=>'label-danger', 'created_at' => date('Y-m-d H:i:s')),

        ));
    }
}
