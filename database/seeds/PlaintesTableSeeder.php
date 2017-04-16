<?php

use Illuminate\Database\Seeder;

class PlaintesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //delete plaintes table records
        DB::table('plaintes')->truncate();
        //insert some dummy records
        DB::table('plaintes')->insert(array(
            array('nom_plainte'=>trans('plainte.plainte_1'), 'created_at' => date('Y-m-d H:i:s')),
            array('nom_plainte'=>trans('plainte.plainte_2'), 'created_at' => date('Y-m-d H:i:s')),
            array('nom_plainte'=>trans('plainte.plainte_3'), 'created_at' => date('Y-m-d H:i:s')),
            array('nom_plainte'=>trans('plainte.plainte_4'), 'created_at' => date('Y-m-d H:i:s')),
            array('nom_plainte'=>trans('plainte.plainte_5'), 'created_at' => date('Y-m-d H:i:s')),
            array('nom_plainte'=>trans('plainte.plainte_6'), 'created_at' => date('Y-m-d H:i:s')),
            array('nom_plainte'=>trans('plainte.plainte_7'), 'created_at' => date('Y-m-d H:i:s')),

        ));
    }
}
