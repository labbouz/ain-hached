<?php

use Illuminate\Database\Seeder;

class DelegationsTableSeeder extends Seeder
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

        //delete Delegations table records
        DB::table('delegations')->truncate();
        //insert some dummy records

        $delegations = array();

        // Ariana
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Ariana'))->value('id');
        for($i=1;$i<=7;$i++) {
            $delegations['Ariana'][] = array('nom_delegation'=>trans('delegations.Ariana_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Ariana'] ); // 7

        // Beja
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Beja'))->value('id');
        for($i=1;$i<=9;$i++) {
            $delegations['Beja'][] = array('nom_delegation'=>trans('delegations.Beja_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Beja'] ); // 9

        // Ben_Arous
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Ben_Arous'))->value('id');
        for($i=1;$i<=12;$i++) {
            $delegations['Ben_Arous'][] = array('nom_delegation'=>trans('delegations.Ben_Arous_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Ben_Arous'] ); // 12

        // Bizerte
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Bizerte'))->value('id');
        for($i=1;$i<=14;$i++) {
            $delegations['Bizerte'][] = array('nom_delegation'=>trans('delegations.Bizerte_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Bizerte'] ); // 14

        // Gabes
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Gabes'))->value('id');
        for($i=1;$i<=10;$i++) {
            $delegations['Gabes'][] = array('nom_delegation'=>trans('delegations.Gabes_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Gabes'] ); // 10

        // Gafsa
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Gafsa'))->value('id');
        for($i=1;$i<=11;$i++) {
            $delegations['Gafsa'][] = array('nom_delegation'=>trans('delegations.Gafsa_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Gafsa'] ); // 11

        // Jendouba
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Jendouba'))->value('id');
        for($i=1;$i<=9;$i++) {
            $delegations['Jendouba'][] = array('nom_delegation'=>trans('delegations.Jendouba_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Jendouba'] ); // 9

        // Kairouan
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Kairouan'))->value('id');
        for($i=1;$i<=11;$i++) {
            $delegations['Kairouan'][] = array('nom_delegation'=>trans('delegations.Kairouan_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Kairouan'] ); // 11

        // Kasserine
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Kasserine'))->value('id');
        for($i=1;$i<=13;$i++) {
            $delegations['Kasserine'][] = array('nom_delegation'=>trans('delegations.Kasserine_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Kasserine'] ); // 13

        // Kebili
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Kebili'))->value('id');
        for($i=1;$i<=6;$i++) {
            $delegations['Kebili'][] = array('nom_delegation'=>trans('delegations.Kebili_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Kebili'] ); // 6

        // La_Manouba
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.La_Manouba'))->value('id');
        for($i=1;$i<=8;$i++) {
            $delegations['La_Manouba'][] = array('nom_delegation'=>trans('delegations.La_Manouba_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['La_Manouba'] ); // 8

        // Le_Kef
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Le_Kef'))->value('id');
        for($i=1;$i<=11;$i++) {
            $delegations['Le_Kef'][] = array('nom_delegation'=>trans('delegations.Le_Kef_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Le_Kef'] ); // 11

        // Mahdia
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Mahdia'))->value('id');
        for($i=1;$i<=11;$i++) {
            $delegations['Mahdia'][] = array('nom_delegation'=>trans('delegations.Mahdia_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Mahdia'] ); // 11

        // Medenine
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Medenine'))->value('id');
        for($i=1;$i<=9;$i++) {
            $delegations['Medenine'][] = array('nom_delegation'=>trans('delegations.Medenine_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Medenine'] ); // 9

        // Monastir
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Monastir'))->value('id');
        for($i=1;$i<=13;$i++) {
            $delegations['Monastir'][] = array('nom_delegation'=>trans('delegations.Monastir_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Monastir'] ); // 13

        // Nabeul
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Nabeul'))->value('id');
        for($i=1;$i<=16;$i++) {
            $delegations['Nabeul'][] = array('nom_delegation'=>trans('delegations.Nabeul_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Nabeul'] ); // 16

        // Sfax
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Sfax'))->value('id');
        for($i=1;$i<=15;$i++) {
            $delegations['Sfax'][] = array('nom_delegation'=>trans('delegations.Sfax_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Sfax'] ); // 15

        // Sidi_Bouzid
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Sidi_Bouzid'))->value('id');
        for($i=1;$i<=12;$i++) {
            $delegations['Sidi_Bouzid'][] = array('nom_delegation'=>trans('delegations.Sidi_Bouzid_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Sidi_Bouzid'] ); // 12

        // Siliana
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Siliana'))->value('id');
        for($i=1;$i<=11;$i++) {
            $delegations['Siliana'][] = array('nom_delegation'=>trans('delegations.Siliana_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Siliana'] ); // 11

        // Sousse
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Sousse'))->value('id');
        for($i=1;$i<=16;$i++) {
            $delegations['Sousse'][] = array('nom_delegation'=>trans('delegations.Sousse_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Sousse'] ); // 16

        // Tataouine
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Tataouine'))->value('id');
        for($i=1;$i<=7;$i++) {
            $delegations['Tataouine'][] = array('nom_delegation'=>trans('delegations.Tataouine_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Tataouine'] ); // 7

        // Tozeur
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Tozeur'))->value('id');
        for($i=1;$i<=5;$i++) {
            $delegations['Tozeur'][] = array('nom_delegation'=>trans('delegations.Tozeur_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Tozeur'] ); // 5

        // Tunis
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Tunis'))->value('id');
        for($i=1;$i<=21;$i++) {
            $delegations['Tunis'][] = array('nom_delegation'=>trans('delegations.Tunis_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Tunis'] ); // 21

        // Zaghouan
        $gouvernorat_id = DB::table('gouvernorats')->where('nom_gouvernorat', trans('gouvernorats.Zaghouan'))->value('id');
        for($i=1;$i<=6;$i++) {
            $delegations['Zaghouan'][] = array('nom_delegation'=>trans('delegations.Zaghouan_'.$i), 'gouvernorat_id'=>$gouvernorat_id, 'created_at' => date('Y-m-d H:i:s'));
        }
        DB::table('delegations')->insert( $delegations['Zaghouan'] ); // 6

        // supposed to only apply to a single connection and reset it's self
        // but I like to explicitly undo what I've done for clarity
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
