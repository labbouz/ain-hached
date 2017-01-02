<?php

use Illuminate\Database\Seeder;

use App\Secteur;

class SecteursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        //delete conventions table records
        DB::table('conventions')->truncate();

        //delete secteurs table records
        //DB::table('secteurs')->truncate();

        $nombre_conventions = array(null,14,10,5,5,3,3,3,2,2,2,1,1,0);
        for($i=1;$i<=13;$i++) {

            $secteuradedd = Secteur::create([
                'nom_secteur' => trans('secteur.secteur_'.$i),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            /*
             * Insert Convetions
             */

            for($j=1;$j<=$nombre_conventions[$i];$j++) {
                $conventions['secteur_'.$i][] = array('nom_convention'=>trans('secteur.conventions_secteur_'.$i.'.convention_'.$j), 'secteur_id'=>$secteuradedd->id, 'created_at' => date('Y-m-d H:i:s'));
            }
            if($nombre_conventions[$i]>0) {
                DB::table('conventions')->insert( $conventions['secteur_'.$i] );
            }

        }
    }
}
