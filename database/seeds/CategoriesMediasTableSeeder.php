<?php

use Illuminate\Database\Seeder;

class CategoriesMediasTableSeeder extends Seeder
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
        DB::table('categories_medias')->truncate();
        //insert some dummy records
        DB::table('categories_medias')->insert(array(
            array('nom_categorie_media'=>trans('media.nom_categorie_1'),'class_color_categorie_media'=>'categorie-media-1', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_categorie_media'=>trans('media.nom_categorie_2'),'class_color_categorie_media'=>'categorie-media-2', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_categorie_media'=>trans('media.nom_categorie_3'),'class_color_categorie_media'=>'categorie-media-3', 'created_at' => date('Y-m-d H:i:s')),
            array('nom_categorie_media'=>trans('media.nom_categorie_4'),'class_color_categorie_media'=>'categorie-media-4', 'created_at' => date('Y-m-d H:i:s')),

        ));

        // supposed to only apply to a single connection and reset it's self
        // but I like to explicitly undo what I've done for clarity
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
