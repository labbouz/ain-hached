<?php

use Illuminate\Database\Seeder;

class GouvernoratsTableSeeder extends Seeder
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

        //delete gouvernorats table records
        DB::table('gouvernorats')->truncate();

        $gouvernorats = array(
            array('nom_gouvernorat'=>trans('gouvernorats.Ariana'), 'permission_slug'=>'ariana', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Beja'), 'permission_slug'=>'beja', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Ben_Arous'), 'permission_slug'=>'ben_arous', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Bizerte'), 'permission_slug'=>'bizerte', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Gabes'), 'permission_slug'=>'gabes', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Gafsa'), 'permission_slug'=>'gafsa', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Jendouba'), 'permission_slug'=>'jendouba', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Kairouan'), 'permission_slug'=>'kairouan', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Kasserine'), 'permission_slug'=>'kasserine', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Kebili'), 'permission_slug'=>'kebili', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.La_Manouba'), 'permission_slug'=>'la_manouba', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Le_Kef'), 'permission_slug'=>'le_kef', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Mahdia'), 'permission_slug'=>'mahdia', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Medenine'), 'permission_slug'=>'medenine', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Monastir'), 'permission_slug'=>'monastir', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Nabeul'), 'permission_slug'=>'nabeul', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Sfax'), 'permission_slug'=>'sfax', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Sidi_Bouzid'), 'permission_slug'=>'sidi_bouzid', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Siliana'), 'permission_slug'=>'siliana', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Sousse'), 'permission_slug'=>'sousse', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Tataouine'), 'permission_slug'=>'tataouine', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Tozeur'), 'permission_slug'=>'tozeur', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Tunis'), 'permission_slug'=>'tunis', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_gouvernorat'=>trans('gouvernorats.Zaghouan'), 'permission_slug'=>'zaghouan', 'created_at' => date('Y-m-d H:i:s')),

        );

        DB::table('gouvernorats')->insert($gouvernorats);

        // supposed to only apply to a single connection and reset it's self
        // but I like to explicitly undo what I've done for clarity
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
