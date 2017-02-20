<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //delete roles table records
        DB::table('roles')->truncate();
        //insert some dummy records
        DB::table('roles')->insert(array(

            array('name'=>trans('users.role_admin'), 'slug'=>'administrator', 'description'=>trans('users.desc_role_admin'), 'class_color'=>'role_admin', 'created_at' => date('Y-m-d H:i:s')),
            array('name'=>trans('users.role_observateur_regional'), 'slug'=>'observateur_regional', 'description'=>trans('users.desc_role_observateur_regional'), 'class_color'=>'role_observateur_regional', 'created_at' => date('Y-m-d H:i:s')),
            array('name'=>trans('users.role_observateur_secteur'), 'slug'=>'observateur_secteur', 'description'=>trans('users.desc_role_observateur_secteur'), 'class_color'=>'role_observateur_secteur', 'created_at' => date('Y-m-d H:i:s')),
            array('name'=>trans('users.role_observateur'), 'slug'=>'observateur', 'description'=>trans('users.desc_role_observateur'), 'class_color'=>'role_observateur', 'created_at' => date('Y-m-d H:i:s')),

        ));

    }
}
