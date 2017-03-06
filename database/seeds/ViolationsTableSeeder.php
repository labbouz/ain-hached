<?php

use Illuminate\Database\Seeder;

class ViolationsTableSeeder extends Seeder
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
        DB::table('violations')->truncate();


        $violations = array();

        $gravites_individuelle = array(2,1,2,2,1,2,2,1,2,1,1,1);
        $type_violation_id = DB::table('types_violations')->where('nom_type_violation', trans('violations.type_violation_1'))->value('id');
        $index_gravite=0;
        for($i=1;$i<=12;$i++) {
            $violations['individuelle'][] = array('nom_violation'=>trans('violations.violation_individuelle_'.$i), 'type_violation_id'=>$type_violation_id, 'gravite_id'=>$gravites_individuelle[$index_gravite], 'created_at' => date('Y-m-d H:i:s'));
            $index_gravite++;
        }
        DB::table('violations')->insert( $violations['individuelle'] );

        $gravites_massives = array(2,1,1,1,1,1,2,2,2,1);
        $type_violation_id = DB::table('types_violations')->where('nom_type_violation', trans('violations.type_violation_2'))->value('id');
        $index_gravite=0;
        for($i=1;$i<=10;$i++) {
            $violations['massives'][] = array('nom_violation'=>trans('violations.violation_massives_'.$i), 'type_violation_id'=>$type_violation_id, 'gravite_id'=>$gravites_massives[$index_gravite], 'created_at' => date('Y-m-d H:i:s'));
            $index_gravite++;
        }
        DB::table('violations')->insert( $violations['massives'] );

        // supposed to only apply to a single connection and reset it's self
        // but I like to explicitly undo what I've done for clarity
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
