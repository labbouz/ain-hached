<?php

use Illuminate\Database\Seeder;

class MediasTableSeeder extends Seeder
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
        DB::table('medias')->truncate();

        DB::table('medias')->insert(array(

            array('nom_media'=>trans('media.move_media_local'), 'categorie_media_id'=>1, 'created_at' => date('Y-m-d H:i:s')),
            array('nom_media'=>trans('media.move_media_regional'), 'categorie_media_id'=>1, 'created_at' => date('Y-m-d H:i:s')),
            array('nom_media'=>trans('media.move_media_secteurs'), 'categorie_media_id'=>1, 'created_at' => date('Y-m-d H:i:s')),
            array('nom_media'=>trans('media.move_media_national'), 'categorie_media_id'=>1, 'created_at' => date('Y-m-d H:i:s')),

            array('nom_media'=>trans('media.move_media_local'), 'categorie_media_id'=>2, 'created_at' => date('Y-m-d H:i:s')),
            array('nom_media'=>trans('media.move_media_regional'), 'categorie_media_id'=>2, 'created_at' => date('Y-m-d H:i:s')),
            array('nom_media'=>trans('media.move_media_central'), 'categorie_media_id'=>2, 'created_at' => date('Y-m-d H:i:s')),

            array('nom_media'=>trans('media.move_media_visible'), 'categorie_media_id'=>3, 'created_at' => date('Y-m-d H:i:s')),
            array('nom_media'=>trans('media.move_media_audible'), 'categorie_media_id'=>3, 'created_at' => date('Y-m-d H:i:s')),
            array('nom_media'=>trans('media.move_media_ecrit'), 'categorie_media_id'=>3, 'created_at' => date('Y-m-d H:i:s')),

            array('nom_media'=>trans('media.move_media_associations'), 'categorie_media_id'=>4, 'created_at' => date('Y-m-d H:i:s')),
            array('nom_media'=>trans('media.move_media_organisations'), 'categorie_media_id'=>4, 'created_at' => date('Y-m-d H:i:s')),
            array('nom_media'=>trans('media.move_media_parties'), 'categorie_media_id'=>4, 'created_at' => date('Y-m-d H:i:s')),

         ));

        // supposed to only apply to a single connection and reset it's self
        // but I like to explicitly undo what I've done for clarity
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
