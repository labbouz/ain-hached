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
        DB::table('users')->truncate();

        DB::table('users')->insert([
            'name' => 'عبدالمنعم لبوز',
            'email' => 'labbouz@gmail.com',
            'password' => bcrypt('ccxccb01'),
        ]);

        for($i=0; $i<100; $i++) {
            DB::table('users')->insert([
                'name' => str_random(10),
                'email' => str_random(10).'@gmail.com',
                'password' => bcrypt('secret'),
            ]);
        }
    }
}
