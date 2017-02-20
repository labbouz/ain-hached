<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GouvernoratsTableSeeder::class);
        $this->call(DelegationsTableSeeder::class);
        $this->call(SecteursTableSeeder::class);
        $this->call(MovesTableSeeder::class);
        $this->call(StructuresSyndicalesTableSeeder::class);
        $this->call(TypesViolationsTableSeeder::class);
        $this->call(GravitesTableSeeder::class);
        $this->call(ViolationsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
