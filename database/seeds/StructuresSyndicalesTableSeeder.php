<?php

use Illuminate\Database\Seeder;

class StructuresSyndicalesTableSeeder extends Seeder
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

        //delete Structures Syndicales table records
        DB::table('structures_syndicales')->truncate();
        //insert some dummy records
        DB::table('structures_syndicales')->insert(array(
            array('type_structure_syndicale'=>trans('syndicale.TypeStructureSyndicale_1'), 'created_at' => date('Y-m-d H:i:s')),
            array('type_structure_syndicale'=>trans('syndicale.TypeStructureSyndicale_2'), 'created_at' => date('Y-m-d H:i:s')),
            array('type_structure_syndicale'=>trans('syndicale.TypeStructureSyndicale_3'), 'created_at' => date('Y-m-d H:i:s')),
            array('type_structure_syndicale'=>trans('syndicale.TypeStructureSyndicale_4'), 'created_at' => date('Y-m-d H:i:s')),
            array('type_structure_syndicale'=>trans('syndicale.TypeStructureSyndicale_5'), 'created_at' => date('Y-m-d H:i:s')),
            array('type_structure_syndicale'=>trans('syndicale.TypeStructureSyndicale_6'), 'created_at' => date('Y-m-d H:i:s')),
            array('type_structure_syndicale'=>trans('syndicale.TypeStructureSyndicale_7'), 'created_at' => date('Y-m-d H:i:s')),
            array('type_structure_syndicale'=>trans('syndicale.TypeStructureSyndicale_8'), 'created_at' => date('Y-m-d H:i:s')),
            array('type_structure_syndicale'=>trans('syndicale.TypeStructureSyndicale_9'), 'created_at' => date('Y-m-d H:i:s')),
            array('type_structure_syndicale'=>trans('syndicale.TypeStructureSyndicale_10'), 'created_at' => date('Y-m-d H:i:s')),
            array('type_structure_syndicale'=>trans('syndicale.TypeStructureSyndicale_11'), 'created_at' => date('Y-m-d H:i:s')),
            array('type_structure_syndicale'=>trans('syndicale.TypeStructureSyndicale_12'), 'created_at' => date('Y-m-d H:i:s')),

        ));

        // but I like to explicitly undo what I've done for clarity
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
