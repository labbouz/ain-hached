<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
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

        DB::table('role_user')->truncate();
        DB::table('users')->truncate();

        DB::table('users')->insert([
            'name' => 'root',
            'email' => 'root@ain-hached.tn',
            'password' => bcrypt('ccxccb01'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('role_user')->insert([
            'role_id' => 1,
            'user_id' => 1,
            'gouvernorat_id' => 0,
            'secteur_id' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // supposed to only apply to a single connection and reset it's self
        // but I like to explicitly undo what I've done for clarity
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
